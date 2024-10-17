<?php

function ifood_load() {
	wp_register_script('ifood-script', get_template_directory_uri() . '/assets/js/scripts.js',array( 'jquery' ), '1.0.2', true );
	wp_enqueue_script('ifood-script');

	wp_register_style('ifood-style', get_template_directory_uri() . '/style.css', [], '1.0.0', false);
	wp_enqueue_style('ifood-style');
}

add_action('wp_enqueue_scripts', 'ifood_load');

// // Ocultando a Admin Bar
add_filter('show_admin_bar', '__return_false');

function theme_setup(){
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'theme_setup' );


//Criando Post Types
function create_post_type() {
    register_post_type( 'comercios',
        array(
            'labels' => array(
                'name' => 'Comércios',
                'singular_name' => 'Comércio',
            ),
            'public' => true,
            'has_archive' => true,
            'menu_position' => 14,
            'menu_icon' => 'dashicons-store',
            'supports' => array( 'title', 'editor' ),
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'comercios'),
            'taxonomies' => array( 'categorias_comercio' )
        )
    );    

    register_taxonomy(
      'categorias_comercio',
      'comercios',
      array(
        'labels' => array(
          'name' => "Categorias",
          'singular_name' => "Categoria",
          'all_items' => "Todas as Categorias",
          'edit_item' => "Editar categoria",
          'update_item' => "Atualizar categoria",
          'add_new_item' => "Adicionar categoria",
        ),
        'hierarchical' => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'categorias_comercio'),
      )
    );

    register_post_type( 'planos',
        array(
            'labels' => array(
                'name' => 'Planos',
                'singular_name' => 'Plano',
            ),
            'public' => true,
            'has_archive' => false,
            'menu_position' => 15,
            'menu_icon' => 'dashicons-products',
            'supports' => array( 'title', 'editor' ),
            'show_in_rest' => true,
            'rewrite' => false,
        )
    );

    register_post_type( 'eventos',
        array(
            'labels' => array(
                'name' => 'Eventos',
                'singular_name' => 'Evento',
            ),
            'public' => true,
            'has_archive' => false,
            'menu_position' => 16,
            'menu_icon' => 'dashicons-schedule',
            'supports' => array( 'title', 'editor' ),
            'show_in_rest' => true,
            'rewrite' => false,
        )
    );

    flush_rewrite_rules();
}

add_action( 'init', 'create_post_type' );	

function tn_custom_excerpt_length( $length ) {
	return 18;
}
add_filter( 'excerpt_length', 'tn_custom_excerpt_length', 999 );

add_action( 'wp_enqueue_scripts', 'sl_enqueue_scripts' );
function sl_enqueue_scripts() {
  wp_enqueue_script( 'simple-likes-public-js', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '0.5', false );
  wp_localize_script( 'scripts-js', 'simpleLikes', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'like' => __( 'Like', 'YourThemeTextDomain' ),
    'unlike' => __( 'Unlike', 'YourThemeTextDomain' )
  ) ); 
}

add_action( 'wp_ajax_nopriv_process_simple_like', 'process_simple_like' );
add_action( 'wp_ajax_process_simple_like', 'process_simple_like' );
function process_simple_like() {
  // Security
  $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
  if ( !wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
    exit( __( 'Not permitted', 'YourThemeTextDomain' ) );
  }
  // Test if javascript is disabled
  $disabled = ( isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] == true ) ? true : false;
  // Test if this is a comment
  $is_comment = ( isset( $_REQUEST['is_comment'] ) && $_REQUEST['is_comment'] == 1 ) ? 1 : 0;
  // Base variables
  $post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';
  $result = array();
  $post_users = NULL;
  $like_count = 0;
  // Get plugin options
  if ( $post_id != '' ) {
    $count = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_comment_like_count", true ) : get_post_meta( $post_id, "_post_like_count", true ); // like count
    $count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
    if ( !already_liked( $post_id, $is_comment ) ) { // Like the post
      if ( is_user_logged_in() ) { // user is logged in
        $user_id = get_current_user_id();
        $post_users = post_user_likes( $user_id, $post_id, $is_comment );
        if ( $is_comment == 1 ) {
          // Update User & Comment
          $user_like_count = get_user_option( "_comment_like_count", $user_id );
          $user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
          update_user_option( $user_id, "_comment_like_count", ++$user_like_count );
          if ( $post_users ) {
            update_comment_meta( $post_id, "_user_comment_liked", $post_users );
          }
        } else {
          // Update User & Post
          $user_like_count = get_user_option( "_user_like_count", $user_id );
          $user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
          update_user_option( $user_id, "_user_like_count", ++$user_like_count );
          if ( $post_users ) {
            update_post_meta( $post_id, "_user_liked", $post_users );
          }
        }
      } else { // user is anonymous
        $user_ip = sl_get_ip();
        $post_users = post_ip_likes( $user_ip, $post_id, $is_comment );
        // Update Post
        if ( $post_users ) {
          if ( $is_comment == 1 ) {
            update_comment_meta( $post_id, "_user_comment_IP", $post_users );
          } else { 
            update_post_meta( $post_id, "_user_IP", $post_users );
          }
        }
      }
      $like_count = ++$count;
      $response['status'] = "liked";
      $response['icon'] = get_liked_icon();
    } else { // Unlike the post
      if ( is_user_logged_in() ) { // user is logged in
        $user_id = get_current_user_id();
        $post_users = post_user_likes( $user_id, $post_id, $is_comment );
        // Update User
        if ( $is_comment == 1 ) {
          $user_like_count = get_user_option( "_comment_like_count", $user_id );
          $user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
          if ( $user_like_count > 0 ) {
            update_user_option( $user_id, "_comment_like_count", --$user_like_count );
          }
        } else {
          $user_like_count = get_user_option( "_user_like_count", $user_id );
          $user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
          if ( $user_like_count > 0 ) {
            update_user_option( $user_id, '_user_like_count', --$user_like_count );
          }
        }
        // Update Post
        if ( $post_users ) {  
          $uid_key = array_search( $user_id, $post_users );
          unset( $post_users[$uid_key] );
          if ( $is_comment == 1 ) {
            update_comment_meta( $post_id, "_user_comment_liked", $post_users );
          } else { 
            update_post_meta( $post_id, "_user_liked", $post_users );
          }
        }
      } else { // user is anonymous
        $user_ip = sl_get_ip();
        $post_users = post_ip_likes( $user_ip, $post_id, $is_comment );
        // Update Post
        if ( $post_users ) {
          $uip_key = array_search( $user_ip, $post_users );
          unset( $post_users[$uip_key] );
          if ( $is_comment == 1 ) {
            update_comment_meta( $post_id, "_user_comment_IP", $post_users );
          } else { 
            update_post_meta( $post_id, "_user_IP", $post_users );
          }
        }
      }
      $like_count = ( $count > 0 ) ? --$count : 0; // Prevent negative number
      $response['status'] = "unliked";
      $response['icon'] = get_unliked_icon();
    }
    if ( $is_comment == 1 ) {
      update_comment_meta( $post_id, "_comment_like_count", $like_count );
      update_comment_meta( $post_id, "_comment_like_modified", date( 'Y-m-d H:i:s' ) );
    } else { 
      update_post_meta( $post_id, "_post_like_count", $like_count );
      update_post_meta( $post_id, "_post_like_modified", date( 'Y-m-d H:i:s' ) );
    }
    $response['count'] = get_like_count( $like_count );
    $response['testing'] = $is_comment;
    if ( $disabled == true ) {
      if ( $is_comment == 1 ) {
        wp_redirect( get_permalink( get_the_ID() ) );
        exit();
      } else {
        wp_redirect( get_permalink( $post_id ) );
        exit();
      }
    } else {
      wp_send_json( $response );
    }
  }
}

/**
 * Utility to test if the post is already liked
 * @since    0.5
 */
function already_liked( $post_id, $is_comment ) {
  $post_users = NULL;
  $user_id = NULL;
  if ( is_user_logged_in() ) { // user is logged in
    $user_id = get_current_user_id();
    $post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
    if ( count( $post_meta_users ) != 0 ) {
      $post_users = $post_meta_users[0];
    }
  } else { // user is anonymous
    $user_id = sl_get_ip();
    $post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" ); 
    if ( count( $post_meta_users ) != 0 ) { // meta exists, set up values
      $post_users = $post_meta_users[0];
    }
  }
  if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
    return true;
  } else {
    return false;
  }
} // already_liked()

/**
 * Output the like button
 * @since    0.5
 */
function get_simple_likes_button( $post_id, $is_comment = NULL ) {
  $is_comment = ( NULL == $is_comment ) ? 0 : 1;
  $output = '';
  $nonce = wp_create_nonce( 'simple-likes-nonce' ); // Security
  if ( $is_comment == 1 ) {
    $post_id_class = esc_attr( ' sl-comment-button-' . $post_id );
    $comment_class = esc_attr( ' sl-comment' );
    $like_count = get_comment_meta( $post_id, "_comment_like_count", true );
    $like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
  } else {
    $post_id_class = esc_attr( ' sl-button-' . $post_id );
    $comment_class = esc_attr( '' );
    $like_count = get_post_meta( $post_id, "_post_like_count", true );
    $like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
  }
  $count = get_like_count( $like_count );
  $icon_empty = get_unliked_icon();
  $icon_full = get_liked_icon();
  // Loader
  $loader = '<span id="sl-loader"></span>';
  // Liked/Unliked Variables
  if ( already_liked( $post_id, $is_comment ) ) {
    $class = esc_attr( ' liked' );
    $title = __( 'Unlike', 'YourThemeTextDomain' );
    $icon = $icon_full;
  } else {
    $class = '';
    $title = __( 'Like', 'YourThemeTextDomain' );
    $icon = $icon_empty;
  }
  $output = '<span class="sl-wrapper"><a href="' . admin_url( 'admin-ajax.php?action=process_simple_like' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true' ) . '" class="sl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</span>';
  return $output;
} // get_simple_likes_button()

/**
 * Processes shortcode to manually add the button to posts
 * @since    0.5
 */
add_shortcode( 'jmliker', 'sl_shortcode' );
function sl_shortcode() {
  return get_simple_likes_button( get_the_ID(), 0 );
} // shortcode()

/**
 * Utility retrieves post meta user likes (user id array), 
 * then adds new user id to retrieved array
 * @since    0.5
 */
function post_user_likes( $user_id, $post_id, $is_comment ) {
  $post_users = '';
  $post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
  if ( count( $post_meta_users ) != 0 ) {
    $post_users = $post_meta_users[0];
  }
  if ( !is_array( $post_users ) ) {
    $post_users = array();
  }
  if ( !in_array( $user_id, $post_users ) ) {
    $post_users['user-' . $user_id] = $user_id;
  }
  return $post_users;
} // post_user_likes()

/**
 * Utility retrieves post meta ip likes (ip array), 
 * then adds new ip to retrieved array
 * @since    0.5
 */
function post_ip_likes( $user_ip, $post_id, $is_comment ) {
  $post_users = '';
  $post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
  // Retrieve post information
  if ( count( $post_meta_users ) != 0 ) {
    $post_users = $post_meta_users[0];
  }
  if ( !is_array( $post_users ) ) {
    $post_users = array();
  }
  if ( !in_array( $user_ip, $post_users ) ) {
    $post_users['ip-' . $user_ip] = $user_ip;
  }
  return $post_users;
} // post_ip_likes()

/**
 * Utility to retrieve IP address
 * @since    0.5
 */
function sl_get_ip() {
  if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
  }
  $ip = filter_var( $ip, FILTER_VALIDATE_IP );
  $ip = ( $ip === false ) ? '0.0.0.0' : $ip;
  return $ip;
} // sl_get_ip()

/**
 * Utility returns the button icon for "like" action
 * @since    0.5
 */
function get_liked_icon() {
  /* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart"></i> */
  $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="31.922" height="27.148" viewBox="0 0 31.922 27.148">
  <path id="Caminho_2051" data-name="Caminho 2051" d="M15.959,29.52a1,1,0,0,1-.6-.2L14.936,29C13,27.56,3.253,20.158,1.161,16.245A9.664,9.664,0,0,1,4.277,3.585,7.907,7.907,0,0,1,8.454,2.372a8.247,8.247,0,0,1,6.6,3.421l.908,1.212.916-1.227a8.231,8.231,0,0,1,6.574-3.406,7.951,7.951,0,0,1,4.2,1.214,9.676,9.676,0,0,1,3.118,12.66C28.667,20.154,18.917,27.559,16.984,29l-.427.318a1,1,0,0,1-.6.2M8.448,4.372a5.9,5.9,0,0,0-3.111.908A7.64,7.64,0,0,0,2.924,15.3c1.36,2.545,7.5,7.82,13.035,11.972C21.5,23.118,27.639,17.841,29,15.3A7.647,7.647,0,0,0,26.588,5.284l0,0a5.917,5.917,0,0,0-3.128-.909A6.223,6.223,0,0,0,18.49,6.96L16.761,9.273a1,1,0,0,1-1.6,0l-1.721-2.3a6.24,6.24,0,0,0-4.99-2.6" transform="translate(0 -2.372)" fill="#FF0000"/>
</svg>';
  return $icon;
} // get_liked_icon()

/**
 * Utility returns the button icon for "unlike" action
 * @since    0.5
 */
function get_unliked_icon() {
  /* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart-o"></i> */
  $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="31.922" height="27.148" viewBox="0 0 31.922 27.148">
  <path id="Caminho_2051" data-name="Caminho 2051" d="M15.959,29.52a1,1,0,0,1-.6-.2L14.936,29C13,27.56,3.253,20.158,1.161,16.245A9.664,9.664,0,0,1,4.277,3.585,7.907,7.907,0,0,1,8.454,2.372a8.247,8.247,0,0,1,6.6,3.421l.908,1.212.916-1.227a8.231,8.231,0,0,1,6.574-3.406,7.951,7.951,0,0,1,4.2,1.214,9.676,9.676,0,0,1,3.118,12.66C28.667,20.154,18.917,27.559,16.984,29l-.427.318a1,1,0,0,1-.6.2M8.448,4.372a5.9,5.9,0,0,0-3.111.908A7.64,7.64,0,0,0,2.924,15.3c1.36,2.545,7.5,7.82,13.035,11.972C21.5,23.118,27.639,17.841,29,15.3A7.647,7.647,0,0,0,26.588,5.284l0,0a5.917,5.917,0,0,0-3.128-.909A6.223,6.223,0,0,0,18.49,6.96L16.761,9.273a1,1,0,0,1-1.6,0l-1.721-2.3a6.24,6.24,0,0,0-4.99-2.6" transform="translate(0 -2.372)" fill="#707171"/>
</svg>';
  return $icon;
} // get_unliked_icon()

/**
 * Utility function to format the button count,
 * appending "K" if one thousand or greater,
 * "M" if one million or greater,
 * and "B" if one billion or greater (unlikely).
 * $precision = how many decimal points to display (1.25K)
 * @since    0.5
 */
function sl_format_count( $number ) {
  $precision = 2;
  if ( $number >= 1000 && $number < 1000000 ) {
    $formatted = number_format( $number/1000, $precision ).'K';
  } else if ( $number >= 1000000 && $number < 1000000000 ) {
    $formatted = number_format( $number/1000000, $precision ).'M';
  } else if ( $number >= 1000000000 ) {
    $formatted = number_format( $number/1000000000, $precision ).'B';
  } else {
    $formatted = $number; // Number is less than 1000
  }
  $formatted = str_replace( '.00', '', $formatted );
  return $formatted;
} // sl_format_count()

/**
 * Utility retrieves count plus count options, 
 * returns appropriate format based on options
 * @since    0.5
 */
function get_like_count( $like_count ) {
  $like_text = __( '', 'YourThemeTextDomain' );
  if ( is_numeric( $like_count ) && $like_count > 0 ) { 
    $number = sl_format_count( $like_count );
  } else {
    $number = $like_text;
  }
  $count = '<span class="sl-count">' . $number . '</span>';
  return $count;
} // get_like_count()

// User Profile List
add_action( 'show_user_profile', 'show_user_likes' );
add_action( 'edit_user_profile', 'show_user_likes' );
function show_user_likes( $user ) { ?>        
  <table class="form-table">
    <tr>
      <th><label for="user_likes"><?php _e( 'You Like:', 'YourThemeTextDomain' ); ?></label></th>
      <td>
      <?php
      $types = get_post_types( array( 'public' => true ) );
      $args = array(
        'numberposts' => -1,
        'post_type' => $types,
        'meta_query' => array (
        array (
          'key' => '_user_liked',
          'value' => $user->ID,
          'compare' => 'LIKE'
        )
        ) );    
      $sep = '';
      $like_query = new WP_Query( $args );
      if ( $like_query->have_posts() ) : ?>
      <p>
      <?php while ( $like_query->have_posts() ) : $like_query->the_post(); 
      echo $sep; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
      <?php
      $sep = ' &middot; ';
      endwhile; 
      ?>
      </p>
      <?php else : ?>
      <p><?php _e( 'You do not like anything yet.', 'YourThemeTextDomain' ); ?></p>
      <?php 
      endif; 
      wp_reset_postdata(); 
      ?>
      </td>
    </tr>
  </table>
<?php }

function get_read_later($postid){

  $reading = $_COOKIE["reading"];
  $postsRead = json_decode(stripslashes($reading));

  if(isset($postsRead) && in_array($postid, $postsRead)){
    $output = '<a href="/conteudos-salvos/"><img src="'. get_template_directory_uri(). '/assets/images/salvar-post-hover.png"></a>';
  }else{
    $output = '<a href="' . admin_url( 'admin-ajax.php?action=process_read_later' . '&post_id=' . $postid . '&disabled=true').'"><img src="'. get_template_directory_uri(). '/assets/images/share/curtir_share_salvar_tempo-03.png"></a>'; 
  }

  return $output; 
}

add_action( 'wp_ajax_nopriv_process_read_later', 'process_read_later' );
add_action( 'wp_ajax_process_read_later', 'process_read_later' );

function process_read_later() {
  $post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';

  $posts = array();
  $reading = $_COOKIE['reading']; 
  $postsRead = json_decode(stripslashes($reading));

  if(!$reading){
    array_push($posts, $post_id);
    $posts = json_encode($posts);
    setcookie('reading', $posts, strtotime( '+30 days' ), '/');
  }else{
    array_push($postsRead, $post_id);
    $postsRead = json_encode($postsRead);
    setcookie('reading', $postsRead, strtotime( '+30 days' ), '/');
  }

  wp_redirect(get_permalink($post_id)); exit();
}

// Add menu item for draft posts
function add_all_clicks_menu() {
    // $page_title, $menu_title, $capability, $menu_slug, $callback_function
    add_menu_page(__('Clear Cache'), __('Clear Cache'), 'read', 'invoke.php');
}
add_action('admin_menu', 'add_all_clicks_menu');

function remove_css_js_version( $src ) {
    if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'remove_css_js_version', 9999 );
add_filter( 'script_loader_src', 'remove_css_js_version', 9999 );

add_action('rest_api_init', function () {
    register_rest_route('custom-api/v1', '/register/', array(
        'methods' => 'POST',
        'callback' => 'register_data',
        'permission_callback' => '__return_true',
    ));
});

function register_data(WP_REST_Request $request) {
    global $wpdb;

    // Pegue os dados do corpo da requisição
    $corporate_reason = sanitize_text_field($request->get_param('corporate_reason'));
    $cnpj = sanitize_text_field($request->get_param('cnpj'));
    $name = sanitize_text_field($request->get_param('name'));
    $cpf = sanitize_text_field($request->get_param('cpf'));
    $phone = sanitize_text_field($request->get_param('phone'));
    $email = sanitize_email($request->get_param('email'));
    $password = wp_hash_password($request->get_param('password')); // Hash da senha
    $name_card = sanitize_text_field($request->get_param('name_card'));
    $number_card = sanitize_text_field($request->get_param('number_card'));
    $validate_card = sanitize_text_field($request->get_param('validate_card'));
    $ccv_card = sanitize_text_field($request->get_param('ccv_card'));
    $status = sanitize_text_field($request->get_param('status'));
    $business = sanitize_text_field($request->get_param('business'));
    $plan = sanitize_text_field($request->get_param('plan'));

    $encrypted_number_card = encrypt_data($number_card);
    $encrypted_validate_card = encrypt_data($validate_card);
    $encrypted_ccv_card = encrypt_data($ccv_card);

    // Nome da tabela
    $table_name = $wpdb->prefix . 'register_business';

    // Verifique se o CNPJ já está cadastrado
    $cnpj_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE cnpj = %s", $cnpj));
    if ($cnpj_exists) {
        return new WP_REST_Response('Erro: CNPJ já cadastrado.', 400);
    }

    // Verifique se o CPF já está cadastrado
    $cpf_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE cpf = %s", $cpf));
    if ($cpf_exists) {
        return new WP_REST_Response('Erro: CPF já cadastrado.', 400);
    }

    // Verifique se o e-mail já está cadastrado
    $email_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE email = %s", $email));
    if ($email_exists) {
        return new WP_REST_Response('Erro: E-mail já cadastrado.', 400);
    }

    // Insira os dados na tabela
    $result = $wpdb->insert($table_name, array(
        'corporate_reason' => $corporate_reason,
        'cnpj' => $cnpj,
        'name' => $name,
        'cpf' => $cpf,
        'phone' => $phone,
        'email' => $email,
        'password' => $password,
        'name_card' => $name_card,
        'number_card' => $encrypted_number_card,
        'validate_card' => $encrypted_validate_card,
        'ccv_card' => $encrypted_ccv_card,
        'status' => $status,
        'business' => $business,
        'plan' => $plan,
    ));

    // Verifique se a inserção foi bem-sucedida
    if ($result) {
        // Disparo do e-mail de confirmação
        $to = $email;
        $subject = 'Cadastro realizado com sucesso';
        $message = 'Cadastro realizado com sucesso. Acesse o site e finalize o cadastro da sua empresa.';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail($to, $subject, $message, $headers);

        return new WP_REST_Response('Cadastro realizado com sucesso!', 200);
    } else {
        return new WP_REST_Response('Erro ao realizar cadastro.', 500);
    }
}

add_action('admin_menu', 'custom_register_menu');

function custom_register_menu() {
    add_menu_page(
        'Lista de Cadastros', // Título da página
        'Cadastros', // Título do menu
        'manage_options', // Capacidade (somente administradores)
        'cadastros', // Slug da página
        'list_cadastros_page', // Função que renderiza a página
        'dashicons-list-view', // Ícone do menu
        13 // Posição no menu
    );
}

function list_cadastros_page() {
    global $wpdb;

    // Nome da tabela
    $table_name = $wpdb->prefix . 'register_business';

    // Recupera todos os cadastros
    $cadastros = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Lista de Cadastros</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr>';
    echo '<th>ID</th>';
    echo '<th>Razão Social</th>';
    echo '<th>CNPJ</th>';
    echo '<th>Nome</th>';
    echo '<th>CPF</th>';
    echo '<th>Telefone</th>';
    echo '<th>E-mail</th>';
    echo '<th>Ações</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    // Exibe os cadastros
    foreach ($cadastros as $cadastro) {
        echo '<tr>';
        echo '<td>' . $cadastro->id . '</td>';
        echo '<td>' . esc_html($cadastro->corporate_reason) . '</td>';
        echo '<td>' . esc_html($cadastro->cnpj) . '</td>';
        echo '<td>' . esc_html($cadastro->name) . '</td>';
        echo '<td>' . esc_html($cadastro->cpf) . '</td>';
        echo '<td>' . esc_html($cadastro->phone) . '</td>';
        echo '<td>' . esc_html($cadastro->email) . '</td>';
        echo '<td><a href="admin.php?page=edit_cadastro&id=' . $cadastro->id . '">Editar</a></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

add_action('admin_menu', 'custom_register_edit_menu');

function custom_register_edit_menu() {
    add_submenu_page(
        null, // Não exibe no menu, apenas uma página de edição acessada via URL
        'Editar Cadastro', 
        'Editar Cadastro', 
        'manage_options', 
        'edit_cadastro', 
        'edit_cadastro_page'
    );
}

function edit_cadastro_page() {
    global $wpdb;

    // Recupera o ID do cadastro via GET
    $cadastro_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Nome da tabela
    $table_name = $wpdb->prefix . 'register_business';

    // Recupera os dados do cadastro pelo ID
    $cadastro = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $cadastro_id));

    if ($cadastro) {
        // Se o formulário for enviado, atualiza os dados
        if (isset($_POST['update_cadastro'])) {
            $corporate_reason = sanitize_text_field($_POST['corporate_reason']);
            $cnpj = sanitize_text_field($_POST['cnpj']);
            $name = sanitize_text_field($_POST['name']);
            $cpf = sanitize_text_field($_POST['cpf']);
            $phone = sanitize_text_field($_POST['phone']);
            $email = sanitize_email($_POST['email']);
            $status = sanitize_text_field($_POST['status']);
            $business = intval($_POST['business']);
            $plan = intval($_POST['plan']);
            $password = $cadastro->password; // Mantém a senha atual por padrão

            // Atualiza a senha se um novo valor for informado
            if (!empty($_POST['password'])) {
                $password = wp_hash_password($_POST['password']);
            }

            // Atualiza o cadastro no banco de dados
            $wpdb->update(
                $table_name,
                array(
                    'corporate_reason' => $corporate_reason,
                    'cnpj' => $cnpj,
                    'name' => $name,
                    'cpf' => $cpf,
                    'phone' => $phone,
                    'email' => $email,
                    'password' => $password, // Atualiza a senha se necessário
                    'status' => $status,
                    'business' => $business,
                    'plan' => $plan,
                ),
                array('id' => $cadastro_id)
            );

            echo '<div class="updated"><p>Cadastro atualizado com sucesso!</p></div>';
        }

        // Recupera os comércios para o select
        $comercios = get_posts(array(
            'post_type' => 'comercios',
            'posts_per_page' => -1
        ));

        $planos = get_posts(array(
            'post_type' => 'planos',
            'posts_per_page' => -1
        ));

        // Formulário de edição
        echo '<div class="wrap">';
        echo '<h1>Editar Cadastro</h1>';
        echo '<form method="POST">';
        echo '<table class="form-table">';
        echo '<tr><th>Razão Social</th><td><input type="text" name="corporate_reason" value="' . esc_attr($cadastro->corporate_reason) . '" required></td></tr>';
        echo '<tr><th>CNPJ</th><td><input type="text" name="cnpj" value="' . esc_attr($cadastro->cnpj) . '" required></td></tr>';
        echo '<tr><th>Nome</th><td><input type="text" name="name" value="' . esc_attr($cadastro->name) . '" required></td></tr>';
        echo '<tr><th>CPF</th><td><input type="text" name="cpf" value="' . esc_attr($cadastro->cpf) . '" required></td></tr>';
        echo '<tr><th>Telefone</th><td><input type="text" name="phone" value="' . esc_attr($cadastro->phone) . '" required></td></tr>';
        echo '<tr><th>E-mail</th><td><input type="email" name="email" value="' . esc_attr($cadastro->email) . '" required></td></tr>';
        
        // Campo para senha (opcional)
        echo '<tr><th>Senha</th><td><input type="password" name="password" placeholder="Deixe em branco para não alterar"></td></tr>';

        // Select para Status
        echo '<tr><th>Status</th><td>';
        echo '<select name="status">';
        echo '<option value="active"' . selected($cadastro->status, 'active', false) . '>Ativo</option>';
        echo '<option value="inactive"' . selected($cadastro->status, 'inactive', false) . '>Inativo</option>';
        echo '<option value="free"' . selected($cadastro->status, 'free', false) . '>Gratuito</option>';
        echo '</select>';
        echo '</td></tr>';

        // Select para Business (Comércios)
        echo '<tr><th>Comércios</th><td>';
        echo '<select name="business" required>';
        echo '<option value="">Selecione um comércio</option>';
        foreach ($comercios as $comercio) {
            echo '<option value="' . esc_attr($comercio->ID) . '"' . selected($cadastro->business, $comercio->ID, false) . '>' . esc_html($comercio->post_title) . '</option>';
        }
        echo '</select>';
        echo '</td></tr>';

        // Select para Planos
        echo '<tr><th>Planos</th><td>';
        echo '<select name="plan" required>';
        echo '<option value="">Selecione um plano</option>';
        foreach ($planos as $plano) {
            echo '<option value="' . esc_attr($plano->ID) . '"' . selected($cadastro->plan, $plano->ID, false) . '>' . esc_html($plano->post_title) . '</option>';
        }
        echo '</select>';
        echo '</td></tr>';

        echo '</table>';
        echo '<input type="submit" name="update_cadastro" value="Atualizar Cadastro" class="button button-primary">';
        echo '</form>';
        echo '</div>';
    } else {
        echo '<div class="error"><p>Cadastro não encontrado.</p></div>';
    }
}

add_action('admin_menu', 'custom_register_add_menu');

function custom_register_add_menu() {
    add_submenu_page(
        'cadastros', // Slug do menu principal (pai)
        'Adicionar Cadastro', // Título da página
        'Adicionar Cadastro', // Título do submenu
        'manage_options', // Capacidade
        'add_cadastro', // Slug do submenu
        'add_cadastro_page' // Função que renderiza o formulário
    );
}

function add_cadastro_page() {
    global $wpdb;

    // Nome da tabela
    $table_name = $wpdb->prefix . 'register_business';

    // Verifica se o formulário foi enviado
    if (isset($_POST['insert_cadastro'])) {
        $corporate_reason = sanitize_text_field($_POST['corporate_reason']);
        $cnpj = sanitize_text_field($_POST['cnpj']);
        $name = sanitize_text_field($_POST['name']);
        $cpf = sanitize_text_field($_POST['cpf']);
        $phone = sanitize_text_field($_POST['phone']);
        $email = sanitize_email($_POST['email']);
        $password = wp_hash_password($_POST['password']);
        $status = sanitize_text_field($_POST['status']);
        $business = intval($_POST['business']);
        $plan = intval($_POST['plan']);

        // Verificar se o e-mail, CPF ou CNPJ já existem na tabela
        $email_exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE email = %s", $email));
        $cpf_exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE cpf = %s", $cpf));
        $cnpj_exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE cnpj = %s", $cnpj));

        if ($email_exists > 0) {
            echo '<div class="error"><p>Este e-mail já está cadastrado.</p></div>';
        } elseif ($cpf_exists > 0) {
            echo '<div class="error"><p>Este CPF já está cadastrado.</p></div>';
        } elseif ($cnpj_exists > 0) {
            echo '<div class="error"><p>Este CNPJ já está cadastrado.</p></div>';
        } else {
            // Se nenhum dos valores já existir, insere o novo cadastro no banco de dados
            $wpdb->insert(
                $table_name,
                array(
                    'corporate_reason' => $corporate_reason,
                    'cnpj' => $cnpj,
                    'name' => $name,
                    'cpf' => $cpf,
                    'phone' => $phone,
                    'email' => $email,
                    'password' => $password,
                    'status' => $status,
                    'business' => $business,
                    'plan' => $plan,
                )
            );

            echo '<div class="updated"><p>Cadastro inserido com sucesso!</p></div>';
        }
    }

    // Recupera os comércios para o select
    $comercios = get_posts(array(
        'post_type' => 'comercios',
        'posts_per_page' => -1
    ));

    $planos = get_posts(array(
        'post_type' => 'planos',
        'posts_per_page' => -1
    ));

    // Formulário de inserção
    echo '<div class="wrap">';
    echo '<h1>Adicionar Novo Cadastro</h1>';
    echo '<form method="POST">';
    echo '<table class="form-table">';
    echo '<tr><th>Razão Social</th><td><input type="text" name="corporate_reason" required></td></tr>';
    echo '<tr><th>CNPJ</th><td><input type="text" name="cnpj" required></td></tr>';
    echo '<tr><th>Nome</th><td><input type="text" name="name" required></td></tr>';
    echo '<tr><th>CPF</th><td><input type="text" name="cpf" required></td></tr>';
    echo '<tr><th>Telefone</th><td><input type="text" name="phone" required></td></tr>';
    echo '<tr><th>E-mail</th><td><input type="email" name="email" required></td></tr>';
    echo '<tr><th>Senha</th><td><input type="password" name="password" required></td></tr>';

    // Select para Status
    echo '<tr><th>Status</th><td>';
    echo '<select name="status">';
    echo '<option value="active">Ativo</option>';
    echo '<option value="inactive">Inativo</option>';
    echo '<option value="free">Gratuito</option>';
    echo '</select>';
    echo '</td></tr>';

    // Select para Business (Comércios)
    echo '<tr><th>Business</th><td>';
    echo '<select name="business" required>';
    echo '<option value="">Selecione um comércio</option>';
    foreach ($comercios as $comercio) {
        echo '<option value="' . esc_attr($comercio->ID) . '">' . esc_html($comercio->post_title) . '</option>';
    }
    echo '</select>';
    echo '</td></tr>';

    // Select para Planos
    echo '<tr><th>Planos</th><td>';
    echo '<select name="plan" required>';
    echo '<option value="">Selecione um plano</option>';
    foreach ($planos as $plano) {
        echo '<option value="' . esc_attr($plano->ID) . '">' . esc_html($plano->post_title) . '</option>';
    }
    echo '</select>';
    echo '</td></tr>';

    echo '</table>';
    echo '<input type="submit" name="insert_cadastro" value="Adicionar Cadastro" class="button button-primary">';
    echo '</form>';
    echo '</div>';
}

function enqueue_custom_admin_scripts($hook) {
    // Verifica se estamos na página do admin onde os campos ACF estão sendo usados
    if ($hook != 'post-new.php' && $hook != 'post.php') {
        return;
    }

    // Enfileira o jQuery
    wp_enqueue_script('jquery');

    // Enfileira o jQuery Mask Plugin para máscara de telefone
    wp_enqueue_script('jquery-mask', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js', array('jquery'));

    // Adiciona um script personalizado para aplicar máscaras e limitar caracteres
    wp_add_inline_script('jquery-mask', "
        jQuery(document).ready(function($) {
            // Aplica a máscara de telefone nos campos ACF específicos
            $('input[name=\"acf[field_66cd29f04d750]\"]').mask('(00) 00000-0000');
            $('input[name=\"acf[field_66cd29e84d74f]\"]').mask('(00) 00000-0000');
            $('input[name=\"acf[field_66e4a0d3428b0]\"]').mask('00000-000');

            // Função para limitar caracteres em campos ACF
            function limitACFContent(selector, maxLength) {
                $(document).on('input', selector, function() {
                    var content = $(this).val();
                    if (content.length > maxLength) {
                        $(this).val(content.substr(0, maxLength));
                    }
                    // Exibir o contador de caracteres restantes
                    var remaining = maxLength - content.length;
                    $(this).siblings('.char-count').text(remaining + ' caracteres restantes.');
                });
            }

            // Adiciona limite de caracteres nos campos ACF especificados
            limitACFContent('textarea[name=\"acf[field_66cd1cfbb1c7e]\"]', 500); // Limite de 500 caracteres
            limitACFContent('textarea[name=\"acf[field_66cd1d36b1c7f]\"]', 500); // Limite de 1000 caracteres

            // Adiciona um contador de caracteres abaixo dos campos de texto
            $('textarea[name=\"acf[field_66cd1cfbb1c7e]\"]').after('<div class=\"char-count\" style=\"margin-top:5px;color:#555;\"></div>');
            $('textarea[name=\"acf[field_66cd1d36b1c7f]\"]').after('<div class=\"char-count\" style=\"margin-top:5px;color:#555;\"></div>');

            // Atualiza o contador ao carregar a página
            $('textarea[name=\"acf[field_66cd1cfbb1c7e]\"]').trigger('input');
            $('textarea[name=\"acf[field_66cd1d36b1c7f]\"]').trigger('input');

            // Função para preencher os campos após a consulta do CEP
            function preencherCampos(dados) {
                if (!dados.erro) {
                    $('textarea[name=\"acf[field_66cd1e05bc8f6]\"]').val(dados.logradouro + ', ' + dados.bairro + ', ' + dados.localidade + ' - ' + dados.uf);
                }
            }

            // Evento para detectar quando o campo de CEP perde o foco
            $('input[name=\"acf[field_66e4a7ae8cc38]\"]').on('blur', function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep.length == 8) {
                    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(dados) {
                        preencherCampos(dados);
                    });
                }
            });
        });
    ");
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_scripts');

function populate_acf_tag_principal_field($field) {
    // Limpa as escolhas existentes
    $field['choices'] = array();

    // Obtém todas as tags disponíveis
    $tags = get_terms(array(
        'taxonomy' => 'post_tag',
        'hide_empty' => false,
    ));

    // Verifica se há tags e preenche o campo select
    if (!is_wp_error($tags) && !empty($tags)) {
        foreach ($tags as $tag) {
            $field['choices'][$tag->term_id] = $tag->name; // ID da tag como chave, nome da tag como valor
        }
    }

    return $field;
}
add_filter('acf/load_field/name=tag_principal', 'populate_acf_tag_principal_field');

function custom_login_api() {
    register_rest_route('custom/v1', '/login/', array(
        'methods' => 'POST',
        'callback' => 'custom_login_callback',
        'permission_callback' => '__return_true',
    ));
}

add_action('rest_api_init', 'custom_login_api');

function custom_login_callback(WP_REST_Request $request) {
    global $wpdb;
    session_start(); // Inicia a sessão PHP

    $table_name = $wpdb->prefix . 'register_business';
    
    // Recupera os dados da requisição
    $email = sanitize_text_field($request->get_param('email'));
    $password = sanitize_text_field($request->get_param('password'));

    if (empty($email) || empty($password)) {
        return new WP_REST_Response('E-mail e senha são obrigatórios.', 400);
    }

    // Busca o usuário no banco de dados
    $user = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE email = %s", $email
    ));

    if (!$user) {
        return new WP_REST_Response('Usuário não encontrado.', 404);
    }

    // Verifica se a senha é válida
    if (!wp_check_password($password, $user->password)) {
        return new WP_REST_Response('Senha incorreta.', 401);
    }

    // Gera um token de autenticação
    $token = bin2hex(random_bytes(32)); // Gera um token seguro

    // Armazena o token com o ID do usuário em um transiente que expira em 1 hora
    set_transient('user_token_' . $token, $user->id, HOUR_IN_SECONDS);

    // Armazena os dados do usuário na sessão PHP
    $_SESSION['user_id'] = $user->id;
    $_SESSION['token'] = $token;
    $_SESSION['user_data'] = [
        'id' => $user->id,
        'corporate_reason' => $user->corporate_reason,
        'cnpj' => $user->cnpj,
        'name' => $user->name,
        'cpf' => $user->cpf,
        'phone' => $user->phone,
        'email' => $user->email,
        'status' => $user->status,
        'business' => $user->business,
        'name_card' => $user->name_card,
        'number_card' => $user->number_card,
        'validate_card' => $user->validate_card,
        'ccv_card' => $user->ccv_card,
    ];

    return new WP_REST_Response([
        'message' => 'Login realizado com sucesso.',
        'user_data' => $_SESSION['user_data'],
        'token' => $token
    ], 200);
}

function check_login() {
    session_start();

    if(is_page('area-logada') && $_SESSION['user_id']){
        wp_redirect('/meu-perfil');
        exit;
    }

    if (!is_page('meu-perfil')) {
        return;
    }

    if (!isset($_SESSION['user_id'])) {
        wp_redirect(home_url());
        exit;
    }
}

add_action('template_redirect', 'check_login');

function custom_logout_api() {
    register_rest_route('custom/v1', '/logout/', array(
        'methods' => 'GET',
        'callback' => 'custom_logout_callback',
        'permission_callback' => '__return_true',
    ));
}

add_action('rest_api_init', 'custom_logout_api');

function custom_logout_callback() {
    session_start();
    session_destroy();

    wp_redirect(home_url());
    exit();
}

function encrypt_data($data) {
    $encryption_key = 'AlPh4v1LL3GU1@!2024#'; // Chave secreta
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt_data($data) {
    $encryption_key = 'AlPh4v1LL3GU1@!2024#'; // Mesma chave usada na criptografia
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

function verify_user_token($token) {
    // Recupera o ID do usuário associado ao token
    $user_id = get_transient('user_token_' . $token);
    return $user_id ? intval($user_id) : false;
}

function custom_update_personal_api(WP_REST_Request $request) {
    global $wpdb;

    if (!session_id()) {
        session_start();
    }

    // Recupera o user_id da request
    $user_id = $request->get_param('user_id');

    $table_name = $wpdb->prefix . 'register_business';

    // Recupera e sanitiza os dados da requisição
    $corporate_reason = sanitize_text_field($request->get_param('corporate_reason'));
    $name = sanitize_text_field($request->get_param('name'));
    $phone = sanitize_text_field($request->get_param('phone'));

    // Prepara os dados para atualização
    $updated_data = [
        'corporate_reason' => $corporate_reason,
        'name' => $name,
        'phone' => $phone,
    ];

    // Atualiza os dados do usuário no banco de dados
    $updated = $wpdb->update(
        $table_name,
        $updated_data,
        ['id' => $user_id]
    );

    if ($updated === false) {
        return new WP_REST_Response('Erro ao atualizar os dados.', 500);
    }

    // Fetch the updated user data
    $updated_user = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id)
    );

    // Update the session data
    $_SESSION['user_data']['corporate_reason'] = $updated_user->corporate_reason;
    $_SESSION['user_data']['name'] = $updated_user->name;
    $_SESSION['user_data']['phone'] = $updated_user->phone;

    return new WP_REST_Response('Dados atualizados com sucesso.', 200);
}

// Atualiza senha
function custom_update_password_api(WP_REST_Request $request) {
    global $wpdb;
    
    // Inicia a sessão PHP
    if (!session_id()) {
        session_start();
    }

    // Verifica se o usuário está logado e se o ID está na sessão
    if (!isset($_SESSION['user_id'])) {
        return new WP_REST_Response('Usuário não está logado.', 401);
    }

    $user_id = $_SESSION['user_id'];

    // Recebe e sanitiza a nova senha
    $password = sanitize_text_field($request->get_param('password'));

    if (empty($password)) {
        return new WP_REST_Response('A senha não pode estar vazia.', 400);
    }

    // Gera o hash da nova senha
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    if ($password_hashed === false) {
        return new WP_REST_Response('Erro ao gerar o hash da senha.', 500);
    }

    // Tenta atualizar a senha no banco de dados
    $updated = $wpdb->update(
        $wpdb->prefix . 'register_business',
        ['password' => $password_hashed],
        ['id' => $user_id]
    );

    if ($updated === false) {
        // Retorna uma mensagem de erro se a atualização falhar
        return new WP_REST_Response('Erro ao atualizar a senha no banco de dados.', 500);
    }

    return new WP_REST_Response('Senha atualizada com sucesso.', 200);
}

// Atualiza dados de pagamento
function custom_update_payment_api(WP_REST_Request $request) {
    global $wpdb;
    session_start();
    
    $user_id = $_SESSION['user_id'];
    $name_card = sanitize_text_field($request->get_param('name_card'));
    $number_card = encrypt_data(sanitize_text_field($request->get_param('number_card')));
    $validate_card = encrypt_data(sanitize_text_field($request->get_param('validate_card')));
    $ccv_card = encrypt_data(sanitize_text_field($request->get_param('ccv_card')));

    $wpdb->update(
        $wpdb->prefix . 'register_business',
        [
            'name_card' => $name_card,
            'number_card' => $number_card,
            'validate_card' => $validate_card,
            'ccv_card' => $ccv_card,
        ],
        ['id' => $user_id]
    );

    return new WP_REST_Response('Dados de pagamento atualizados com sucesso.', 200);
}

function custom_get_payment_data(WP_REST_Request $request) {
    global $wpdb;
    
    // Inicia a sessão PHP para obter o ID do usuário
    if (!session_id()) {
        session_start();
    }

    // Verifica se o usuário está logado e se o ID está na sessão
    if (!isset($_SESSION['user_id'])) {
        return new WP_REST_Response('Usuário não está logado.', 401);
    }

    $user_id = $_SESSION['user_id'];
    
    // Busca os dados de pagamento no banco de dados
    $table_name = $wpdb->prefix . 'register_business'; // Ajuste o nome da tabela conforme necessário
    $payment_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id));

    if (!$payment_data) {
        return new WP_REST_Response('Dados de pagamento não encontrados.', 404);
    }

    // Descriptografa os dados de pagamento (ajuste conforme seu método de criptografia)
    $card_number = decrypt_data($payment_data->number_card); // Função de descriptografia que você deve ter implementado
    $card_cvv = decrypt_data($payment_data->ccv_card); // Também descriptografa o CVV se necessário
    $card_validate = decrypt_data($payment_data->validate_card); // Também descriptografa o CVV se necessário

    // Mostra apenas os 4 últimos dígitos do número do cartão
    $card_number_masked = '**** **** **** ' . substr($card_number, -4);

    // Retorna os dados para preencher o formulário
    return new WP_REST_Response([
        'name_card'      => $payment_data->name_card,
        'number_card'    => $card_number_masked,
        'validate_card'  => $card_validate,
        'ccv_card'       => $card_cvv,  // Opcional, pode não querer retornar isso
    ], 200);
}

function register_custom_user_update_routes() {
    // Rota para atualizar dados pessoais
    register_rest_route('custom/v1', '/update-user/personal', [
        'methods' => 'POST',
        'callback' => 'custom_update_personal_api',
        'permission_callback' => 'custom_permission_callback',
    ]);

    // Rota para atualizar senha
    register_rest_route('custom/v1', '/update-user/password', [
        'methods' => 'POST',
        'callback' => 'custom_update_password_api',
        'permission_callback' => 'custom_permission_callback',
    ]);

    // Rota para atualizar dados de pagamento
    register_rest_route('custom/v1', '/update-user/payment', [
        'methods' => 'POST',
        'callback' => 'custom_update_payment_api',
        'permission_callback' => 'custom_permission_callback',
    ]);

    // Rota para atualizar dados de pagamento
    register_rest_route('custom/v1', '/payment/get', [
        'methods' => 'GET',
        'callback' => 'custom_get_payment_data',
        'permission_callback' => 'custom_permission_callback',
    ]);    
}
add_action('rest_api_init', 'register_custom_user_update_routes');

function custom_permission_callback(WP_REST_Request $request) {
    // Recupera o token do cabeçalho Authorization
    $auth_header = $request->get_header('Authorization');

    if (empty($auth_header) || strpos($auth_header, 'Bearer ') !== 0) {
        return new WP_Error('rest_forbidden', 'Token não fornecido.', array('status' => 401));
    }

    // Extrai o token do cabeçalho
    $token = substr($auth_header, 7);

    // Verifica o token
    $user_id = verify_user_token($token);

    if (!$user_id) {
        return new WP_Error('rest_invalid_token', 'Token inválido ou expirado.', array('status' => 401));
    }

    // Armazena o user_id na request para uso posterior
    $request->set_param('user_id', $user_id);

    return true;
}

function custom_create_comercio(WP_REST_Request $request) {
    $user_id = $request->get_param('user_id');

    global $wpdb;
    $table_name = $wpdb->prefix . 'register_business'; // Atualizamos para gsa_register_business

    // Verifica se o usuário existe
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id));

    if (!$user) {
        return new WP_REST_Response('Usuário não encontrado.', 404);
    }

    // Verifica se o usuário já possui um comércio
    if ($user->business != 0) {
        return new WP_REST_Response('Usuário já possui um comércio.', 400);
    }

    // Recolhe os dados do request
    $comercio_data = $request->get_params();

    // Cria um novo post do tipo 'comercios'
    $post_id = wp_insert_post([
        'post_title'   => sanitize_text_field($comercio_data['nome']),
        'post_type'    => 'comercios',
        'post_status'  => 'publish',
        'post_content' => '', // Deixe vazio se estiver usando campos ACF
        'post_author'  => $user_id,
    ]);

    if (is_wp_error($post_id)) {
        return new WP_REST_Response('Erro ao criar o comércio.', 500);
    }

    // Atualiza campos ACF
    update_field('descricao', wp_kses_post($comercio_data['descricao']), $post_id);
    update_field('caracteristicas', wp_kses_post($comercio_data['caracteristicas']), $post_id);
    update_field('cep', sanitize_text_field($comercio_data['cep']), $post_id);
    update_field('endereco_completo', sanitize_text_field($comercio_data['endereco_completo']), $post_id);
    update_field('telefone', sanitize_text_field($comercio_data['telefone']), $post_id);
    update_field('whatsapp', sanitize_text_field($comercio_data['whatsapp']), $post_id);
    update_field('email', sanitize_email($comercio_data['email']), $post_id);
    update_field('link_facebook', esc_url_raw($comercio_data['link_facebook']), $post_id);
    update_field('link_instagram', esc_url_raw($comercio_data['link_instagram']), $post_id);
    update_field('site', esc_url_raw($comercio_data['site']), $post_id);
    update_field('status', sanitize_text_field($comercio_data['status']), $post_id);

    // Atualizar Categorias (Taxonomia)
    if (!empty($comercio_data['categoria'])) {
        $categoria_ids = array_map('intval', $comercio_data['categoria']); // Certifique-se de que os IDs sejam inteiros
        wp_set_object_terms($post_id, $categoria_ids, 'categorias_comercio');
    }

    // Atualizar Tags (Taxonomia)
    if (!empty($comercio_data['tags'])) {
        $tag_ids = array_map('intval', $comercio_data['tags']);
        wp_set_object_terms($post_id, $tag_ids, 'post_tag');
    }

    // Upload e atualização de imagens (banner_destaque, logo, imagem_lista)
    if (!empty($_FILES['banner_destaque'])) {
        $banner_destaque_id = handle_file_upload($_FILES['banner_destaque']);
        if ($banner_destaque_id) {
            update_field('banner_destaque', $banner_destaque_id, $post_id);
        }
    }

    if (!empty($_FILES['logo'])) {
        $logo_id = handle_file_upload($_FILES['logo']);
        if ($logo_id) {
            update_field('logo', $logo_id, $post_id);
        }
    }

    if (!empty($_FILES['imagem_lista'])) {
        $imagem_lista_id = handle_file_upload($_FILES['imagem_lista']);
        if ($imagem_lista_id) {
            update_field('imagem_lista', $imagem_lista_id, $post_id);
        }
    }

    // Atualizar Galeria de Imagens (Repetidor)
    if (!empty($_FILES['galeria_fotos'])) {
        $galeria_data = [];
        foreach ($_FILES['galeria_fotos']['name'] as $key => $value) {
            if ($_FILES['galeria_fotos']['name'][$key]) {
                $file = [
                    'name'     => $_FILES['galeria_fotos']['name'][$key],
                    'type'     => $_FILES['galeria_fotos']['type'][$key],
                    'tmp_name' => $_FILES['galeria_fotos']['tmp_name'][$key],
                    'error'    => $_FILES['galeria_fotos']['error'][$key],
                    'size'     => $_FILES['galeria_fotos']['size'][$key]
                ];

                $attach_id = handle_file_upload($file);
                if ($attach_id) {
                    $galeria_data[] = ['foto' => $attach_id];
                }
            }
        }

        if (!empty($galeria_data)) {
            update_field('galeria', $galeria_data, $post_id);
        }
    }

    // Atualizar Horários de Funcionamento (Repetidor)
    if (!empty($comercio_data['horarios'])) {
        $horarios_data = [];
        foreach ($comercio_data['horarios'] as $horario) {
            $horarios_data[] = [
                'dia'     => sanitize_text_field($horario['dia']),
                'horario' => sanitize_text_field($horario['horario']),
            ];
        }
        update_field('horarios', $horarios_data, $post_id);
    }

    // Atualiza o campo 'business' na tabela gsa_register_business
    $wpdb->update(
        $table_name,
        ['business' => $post_id],
        ['id' => $user_id]
    );

    // Atualiza a sessão para refletir o novo comércio criado
    session_start();
    $_SESSION['user_data']['business'] = $post_id;

    return new WP_REST_Response(['message' => 'Comércio criado com sucesso.', 'comercio_id' => $post_id], 200);
}

function custom_update_comercio(WP_REST_Request $request) {
    $user_id = $request->get_param('user_id');

    global $wpdb;
    $table_name = $wpdb->prefix . 'register_business';

    // Get user's business ID
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id));

    if (!$user) {
        return new WP_REST_Response('Usuário não encontrado.', 404);
    }

    if ($user->business == 0) {
        custom_create_comercio($request);
        return new WP_REST_Response('Comércio criado com sucesso.', 200);
    }

    $post_id = $user->business;

    // Atualizar o título do post
    $title = sanitize_text_field($request->get_param('nome'));
    $post_data = [
        'ID'         => $post_id,
        'post_title' => $title,
    ];

    // Atualiza o post no banco de dados
    wp_update_post($post_data);

    // Atualizar campos personalizados (ACF)
    update_field('descricao', wp_kses_post($request->get_param('descricao')), $post_id);
    update_field('caracteristicas', wp_kses_post($request->get_param('caracteristicas')), $post_id);
    update_field('cep', sanitize_text_field($request->get_param('cep')), $post_id);
    update_field('endereco_completo', sanitize_text_field($request->get_param('endereco_completo')), $post_id);
    update_field('telefone', sanitize_text_field($request->get_param('telefone')), $post_id);
    update_field('whatsapp', sanitize_text_field($request->get_param('whatsapp')), $post_id);
    update_field('email', sanitize_email($request->get_param('email')), $post_id);
    update_field('link_facebook', esc_url_raw($request->get_param('link_facebook')), $post_id);
    update_field('link_instagram', esc_url_raw($request->get_param('link_instagram')), $post_id);
    update_field('site', esc_url_raw($request->get_param('site')), $post_id);
    update_field('status', sanitize_text_field($request->get_param('status')), $post_id);

    $categoria_ids = $request->get_param('categoria');
    if (!empty($categoria_ids)) {
        wp_set_object_terms($post_id, $categoria_ids, 'categorias_comercio');
    }

    // Atualizar Tags (usando IDs)
    $tag_ids = $request->get_param('tags');
    if (!empty($tag_ids) && is_array($tag_ids)) {
        $tag_ids = array_map('intval', $tag_ids);
        wp_set_object_terms($post_id, $tag_ids, 'post_tag', false);
    }

    // Atualizar Categorias (usando IDs)
    $categoria_ids = $request->get_param('categoria');
    if (!empty($categoria_ids) && is_array($categoria_ids)) {
        $categoria_ids = array_map('intval', $categoria_ids);
        wp_set_object_terms($post_id, $categoria_ids, 'categorias_comercio', false);
    }

    if (!empty($_FILES['logo'])) {
        $logo_id = handle_file_upload($_FILES['logo']);
        if ($logo_id) {
            update_field('logo', $logo_id, $post_id);
        }
    }

    if (!empty($_FILES['imagem_lista'])) {
        $imagem_lista_id = handle_file_upload($_FILES['imagem_lista']);
        if ($imagem_lista_id) {
            update_field('imagem_lista', $imagem_lista_id, $post_id);
        }
    }

    // Atualizar Galeria de Imagens (Repetidor)
    if (!empty($_FILES['galeria_fotos'])) {
        $galeria_data = [];
        foreach ($_FILES['galeria_fotos']['name'] as $key => $value) {
            if ($_FILES['galeria_fotos']['name'][$key]) {
                $file = [
                    'name'     => $_FILES['galeria_fotos']['name'][$key],
                    'type'     => $_FILES['galeria_fotos']['type'][$key],
                    'tmp_name' => $_FILES['galeria_fotos']['tmp_name'][$key],
                    'error'    => $_FILES['galeria_fotos']['error'][$key],
                    'size'     => $_FILES['galeria_fotos']['size'][$key]
                ];

                $attach_id = handle_file_upload($file);
                if ($attach_id) {
                    $galeria_data[] = ['foto' => $attach_id];
                }
            }
        }

        if (!empty($galeria_data)) {
            update_field('galeria', $galeria_data, $post_id);
        }
    }

    // Atualizar Horários de Funcionamento (Repetidor)
    $horarios_dia = $request->get_param('horarios_dia');
    $horarios_horario = $request->get_param('horarios_horario');

    if ($horarios_dia && $horarios_horario && is_array($horarios_dia)) {
        $horarios_data = [];
        foreach ($horarios_dia as $index => $dia) {
            $horarios_data[] = [
                'dia'     => sanitize_text_field($dia),
                'horario' => sanitize_text_field($horarios_horario[$index])
            ];
        }
        update_field('horarios', $horarios_data, $post_id);
    }

    return new WP_REST_Response('Comércio atualizado com sucesso.', 200);
}

function handle_file_upload($file) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Verifica se o upload ocorreu sem erros
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    // Realiza o upload da imagem para o diretório de uploads do WordPress
    $upload = wp_handle_upload($file, ['test_form' => false]);

    // Verifica se o upload foi bem-sucedido
    if (isset($upload['file'])) {
        $file_type = wp_check_filetype($upload['file']);
        $attachment = [
            'post_mime_type' => $file_type['type'],
            'post_title' => sanitize_file_name($upload['file']),
            'post_content' => '',
            'post_status' => 'inherit'
        ];

        // Insere a imagem na biblioteca de mídia
        $attachment_id = wp_insert_attachment($attachment, $upload['file']);

        // Gera metadados para o anexo (miniaturas, etc.)
        $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attach_data);

        return $attachment_id;
    }

    return false;
}

function custom_get_comercio(WP_REST_Request $request) {
    $user_id = $request->get_param('user_id');

    global $wpdb;
    $table_name = $wpdb->prefix . 'register_business';

    // Obter o ID do comércio do usuário
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id));

    if (!$user) {
        return new WP_REST_Response('Usuário não encontrado.', 404);
    }

    if ($user->business == 0) {
        return new WP_REST_Response('Usuário não possui um comércio.', 404);
    }

    $post_id = $user->business;

    // Obter os dados do comércio
    $comercio = get_post($post_id);

    if (!$comercio) {
        return new WP_REST_Response('Comércio não encontrado.', 404);
    }

    $categorias = wp_get_object_terms($post_id, 'categorias_comercio', ['fields' => 'all']);
    $categoria_data = [];
    if (!is_wp_error($categorias)) {
        foreach ($categorias as $categoria) {
            $categoria_data[] = $categoria->term_id;
        }
    }
    $tag_ids = wp_get_object_terms($post_id, 'post_tag', ['fields' => 'ids']);

    $galeria = get_field('galeria', $post_id);
    $galeria_urls = [];

    if ($galeria) {
        foreach ($galeria as $item) {
            $foto_id = $item['foto'];
            if ($foto_id) {
                $galeria_urls[] = $foto_id;
            }
        }
    }    

    $comercio_data = [
        'nome' => $comercio->post_title,
        'permalink' => get_permalink($post_id),
        'descricao' => get_field('descricao', $post_id),
        'caracteristicas' => get_field('caracteristicas', $post_id),
        'banner_destaque_url' => get_field('banner_destaque', $post_id),
        'logo_url' => get_field('logo', $post_id),
        'imagem_lista_url' => get_field('imagem_lista', $post_id),
        'cep' => get_field('cep', $post_id),
        'endereco_completo' => get_field('endereco_completo', $post_id),
        'telefone' => get_field('telefone', $post_id),
        'whatsapp' => get_field('whatsapp', $post_id),
        'email' => get_field('email', $post_id),
        'link_facebook' => get_field('link_facebook', $post_id),
        'link_instagram' => get_field('link_instagram', $post_id),
        'site' => get_field('site', $post_id),
        'status' => get_field('status', $post_id),
        'horarios' => get_field('horarios', $post_id),
        'categoria_ids' => $categoria_data,
        'tag_ids' => $tag_ids,
        'galeria' => $galeria_urls,
    ];

    return new WP_REST_Response(['comercio_data' => $comercio_data], 200);
}

function register_custom_business() {
    register_rest_route('custom/v1', '/comercio/create', [
        'methods' => 'POST',
        'callback' => 'custom_create_comercio',
        'permission_callback' => 'custom_permission_callback',
    ]);

    register_rest_route('custom/v1', '/comercio/update', [
        'methods' => 'POST',
        'callback' => 'custom_update_comercio',
        'permission_callback' => 'custom_permission_callback',
    ]);

    register_rest_route('custom/v1', '/comercio/get', [
        'methods' => 'GET',
        'callback' => 'custom_get_comercio',
        'permission_callback' => 'custom_permission_callback',
    ]);    
}

add_action('rest_api_init', 'register_custom_business');

function suggest_correct_term($search_query) {
    $all_tags = get_terms(array(
        'taxonomy' => 'post_tag',
        'hide_empty' => false,
    ));

    $all_categories = get_terms(array(
        'taxonomy' => 'categorias_comercio',
        'hide_empty' => false,
    ));

    $all_terms = array_merge($all_tags, $all_categories);

    $closest_term = null;
    $highest_similarity = 0;
    $levenshtein_limit = 4;

    foreach ($all_terms as $term) {
        $term_name = $term->name;

        $lev_distance = levenshtein($search_query, $term_name);

        similar_text($search_query, $term_name, $similarity_percentage);

        if ($lev_distance <= $levenshtein_limit && $similarity_percentage > 70) {
            if ($similarity_percentage > $highest_similarity) {
                $closest_term = $term_name;
                $highest_similarity = $similarity_percentage;
            }
        }
    }

    return $closest_term;
}

use PHPMailer\PHPMailer\PHPMailer;

function custom_forgot_password(WP_REST_Request $request) {
    global $wpdb;

    $email = sanitize_email($request->get_param('email'));

    if (empty($email)) {
        return new WP_REST_Response('E-mail é obrigatório.', 400);
    }

    $user = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}register_business WHERE email = %s", $email
    ));

    if (!$user) {
        return new WP_REST_Response('E-mail não encontrado.', 404);
    }

    $new_password = wp_generate_password(12, true);

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $wpdb->update(
        $wpdb->prefix . 'register_business',
        ['password' => $hashed_password],
        ['email' => $email]
    );

    $subject = 'Sua nova senha foi gerada';

    $message = '
    <html>
    <head>
      <title>Recuperação de Senha</title>
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 100%;
            height: auto;
        }
        .email-body {
            padding: 20px;
        }
        .email-body h1 {
            font-size: 24px;
            color: #333;
        }
        .email-body p {
            font-size: 16px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
      </style>
    </head>
    <body>
      <div class="email-container">
        <div class="header">
          <img src="https://homologacao.guiadeservicosalphaville.com.br/wp-content/themes/GuiaServicos/assets/images/header-email.jpg" alt="Header">
        </div>
        <div class="email-body">
          <h1>Recuperação de Senha</h1>
          <p>Olá,</p>
          <p>Uma nova senha foi gerada para sua conta: <strong>' . $new_password . '</strong></p>
          <p>Por favor, faça login e altere sua senha por uma de sua escolha.</p>
          <a href="https://homologacao.guiadeservicosalphaville.com.br/" class="button">Acessar o site</a>
        </div>
      </div>
    </body>
    </html>
    ';
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Guia de Serviços <guia@alpharredores.com.br>'
    );

    try {
        $mail_sent = wp_mail($email, $subject, nl2br($message), $headers);

        if ($mail_sent) {
            error_log("E-mail enviado com sucesso para {$email}");
            return new WP_REST_Response('E-mail com nova senha enviado.', 200);
        } else {
            throw new Exception("Erro ao enviar o e-mail.");
        }
    } catch (Exception $e) {
        global $phpmailer;
        if (isset($phpmailer) && is_a($phpmailer, 'PHPMailer\PHPMailer\PHPMailer')) {
            error_log("Erro de SMTP: " . $phpmailer->ErrorInfo);
        } else {
            error_log("Erro desconhecido ao enviar o e-mail.");
        }

        return new WP_REST_Response('Erro ao enviar o e-mail.', 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/forgot-password', array(
        'methods' => 'POST',
        'callback' => 'custom_forgot_password',
    ));
});

add_action('phpmailer_init', 'configurar_smtp');

function configurar_smtp(PHPMailer $phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.gmail.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465;
    $phpmailer->Username   = 'guia@alpharredores.com.br';
    $phpmailer->Password   = 'AlphRed6762!';
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->From       = 'guia@alpharredores.com.br';
    $phpmailer->FromName   = 'Guia de Serviços';

    error_log('Função configurar_smtp foi chamada com sucesso.');
}

function contar_posts_por_categoria($category_name) {
    $category = get_category_by_slug($category_name);

    if ($category) {
        $category_id = $category->term_id;

        $args = array(
            'category' => $category_id,
            'post_type' => 'post',
            'posts_per_page' => -1,
            'fields' => 'ids'
        );

        $posts = get_posts($args);

        return count($posts);
    } else {
        return 0;
    }
}
