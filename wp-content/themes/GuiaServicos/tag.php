<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$tag = get_queried_object();

get_header();

?>

<main class="internas comercios">
    <section class="banner">
        <div class="img-banner" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/banner-padrao.jpg)">
            <div class="content-banner">
                <p class="title"><?php echo $tag->name; ?></p>
            </div>
        </div>
    </section>

    <section id="busca">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form role="search" method="get" id="form-open" class="search-form" action="/todos-comercios/">
                        <input type="text" placeholder="Digite o que você procura" name="search" id="main-search">
                        <button type="submit" class="search-submit">
                            <img class="icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/search-white.svg" alt="iconlupa" width="25" height="25.64">
                        </button>
                    </form>
                </div>
            </div>
    </section>

    <section class="infos-page">
        <div class="container">
            <div class="row">
                <div class="col-md-11 offset-1">
                    <div class="breadcrumb">
                        <a href="/">Home ></a>
                        <?php if ($tag->slug) { ?>
                            <a href="<?php echo $tag->slug; ?>"><?php echo $tag->name; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-1">
                    <p class="title">Confira todos os comércios de: <br /><?php echo $tag->name; ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="mais-lidas">
        <div class="container">
            <div class="row">
                <div class="col-md-11 offset-1">
                    <p class="title">Comércios em destaque</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="carousel-comercios">
                        <?php
                        $tag_id = $tag->term_id;

                        $acf_query = new WP_Query(
                            array(
                                'post_type'      => 'comercios',
                                'posts_per_page' => -1,
                                'meta_query'     => array(
                                    array(
                                        'key'     => 'tag_principal',
                                        'value'   => $tag_id,
                                        'compare' => '='
                                    )
                                )
                            )
                        );

                        $tax_query = new WP_Query(
                            array(
                                'post_type'      => 'comercios',
                                'posts_per_page' => -1,
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'post_tag',
                                        'field'    => 'term_id',
                                        'terms'    => $tag_id,
                                        'operator' => 'IN'
                                    )
                                )
                            )
                        );

                        $merged_posts = array_merge($acf_query->posts, $tax_query->posts);
                        $unique_posts = array_unique($merged_posts, SORT_REGULAR);

                        if (!empty($unique_posts)) {
                            foreach ($unique_posts as $post) {
                                setup_postdata($post);
                                $post_id = $post->ID;

                                $terms = get_the_terms($post_id, 'categorias_comercio');
                                $tags = get_the_terms($post_id, 'post_tag');

                                $tag_principal_id = get_field('tag_principal', $post_id);
                                $tag_obj = false;
                                if ($tag_principal_id) {
                                    $tag_obj = get_term($tag_principal_id, 'post_tag');
                                }

                                if (!empty($terms)) {
                                    foreach ($terms as $terma) {
                                        $class = esc_attr($terma->slug);
                                        $categoria = esc_html($terma->name);
                                    }
                                }
                            ?>

                            <div class="comercio">
                                <?php 
                                    if(get_field('imagem_lista')){
                                        $image = get_field('imagem_lista');
                                    }else{
                                        $image = '/wp-content/themes/GuiaServicos/assets/images/guia.webp';
                                    }
                                ?>
                                <div class="image-post" style='background-image: url("<?php echo $image; ?>");'>
                                </div>

                                <div class="comparts">
                                    <div class="like">
                                        <?php 
                                            echo get_simple_likes_button(get_the_ID()); 
                                        ?>
                                    </div>
                                    <div class="compartilhar">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/share/curtir_share_salvar_tempo-07.png">

                                        <div id="compartilhar-aberto">
                                            <div class="whatsapp">
                                                <a href="https://api.whatsapp.com/send?text=<?php echo the_permalink(); ?>" target="blank">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/whatsapp.svg" alt="iconwhatsapp" width="34" height="34">
                                                </a>
                                            </div>
                                            <div class="facebook">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo the_permalink(); ?>" target="blank">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/facebook.svg" alt="facebook" width="" height="">
                                                </a>
                                            </div>
                                            <div class="twitter">
                                                <a href="https://twitter.com/intent/tweet?url=<?php echo the_permalink(); ?>" target="blank">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/twitter.svg" alt="twitter" width="" height="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="categories <?php echo $class; ?>">
                                    <?php 
                                        echo '<a href="/categorias_comercio/'.$class.'"><span>'.$categoria.'</span></a>';
                                    ?>
                                </div>

                                <div class="tags">
                                    <?php 

                                        if ($tag_obj != false) {
                                            echo '<a href="' . get_term_link($tag_obj) . '"><span>' . $tag_obj->name . '</span></a>';
                                        }

                                        foreach($tags as $tag){                                            
                                            echo '<a href="/tag/'.$tag->slug.'"><span>'.$tag->name.'</span></a>';
                                        }
                                    ?>
                                </div>

                                <div class="title-post">
                                    <?php the_title(); ?>
                                </div>

                                <div class="content-post">
                                    <?php 
                                        the_field('descricao');                                         
                                    ?>                                        
                                </div>

                                <?php if(get_field('whatsapp')){ 
                                        $numero_limpo = preg_replace('/\D+/', '', get_field('whatsapp'));
                                        $numero_completo = '55' . $numero_limpo;
                                        $link_whatsapp = "https://wa.me/" . $numero_completo;
                                    ?>
                                        <div class="whatsapp-phone">
                                            <a href="<?php echo $link_whatsapp; ?>" target="_blank">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/whatsapp.svg" alt="iconwhatsapp"> 
                                                <span><?php the_field('whatsapp'); ?></span>
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <?php if(get_field('endereco_completo')){ ?>
                                        <div class="endereco">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/map-marker-alt-solid.svg" alt="iconwhatsapp"> 
                                            <span><?php the_field('endereco_completo'); ?></span>
                                        </div>
                                    <?php } ?>

                                <div class="btn-more">
                                    <a href="<?php the_permalink(); ?>">Saiba mais</a>
                                </div>
                            </div>

                        <?php 
                                }
                            }
                            wp_reset_postdata(); 
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>