<?php

/**
 * Template Name: Todos os Comércios
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

$texto = 'Resultados para: ';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = sanitize_text_field($_GET['search']);

    // 1. Buscar termos de tags que correspondem ao termo de busca
    $tag_ids = array();
    $tags = get_terms(array(
        'taxonomy' => 'post_tag',
        'hide_empty' => false,
        'search' => $search_query,
    ));

    if (!is_wp_error($tags) && !empty($tags)) {
        $tag_ids = wp_list_pluck($tags, 'term_id');
    }

    // 2. Buscar termos de categorias que correspondem ao termo de busca
    $category_ids = array();
    $categories = get_terms(array(
        'taxonomy' => 'categorias_comercio',
        'hide_empty' => false,
        'search' => $search_query,
    ));

    if (!is_wp_error($categories) && !empty($categories)) {
        $category_ids = wp_list_pluck($categories, 'term_id');
    }

    // 3. Verifica se houve resultados válidos nas tags ou categorias
    if (empty($tag_ids) && empty($category_ids)) {
        // Se não houver resultados, sugere um termo corrigido
        $suggested_term = suggest_correct_term($search_query);

        // Se o termo sugerido for diferente, exibe a sugestão e altera a busca
        if ($suggested_term && $suggested_term !== $search_query) {
            $texto = 'Você quis dizer: ';
            $search_query = $suggested_term;

            // Realiza a busca novamente com o termo sugerido
            $tags = get_terms(array(
                'taxonomy' => 'post_tag',
                'hide_empty' => false,
                'search' => $search_query,
            ));

            if (!is_wp_error($tags) && !empty($tags)) {
                $tag_ids = wp_list_pluck($tags, 'term_id');
            }

            $categories = get_terms(array(
                'taxonomy' => 'categorias_comercio',
                'hide_empty' => false,
                'search' => $search_query,
            ));

            if (!is_wp_error($categories) && !empty($categories)) {
                $category_ids = wp_list_pluck($categories, 'term_id');
            }
        }
    }

    $tax_query = array('relation' => 'OR');
    if (!empty($tag_ids)) {
        $tax_query[] = array(
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $tag_ids,
            'operator' => 'IN',
        );
    }

    if (!empty($category_ids)) {
        $tax_query[] = array(
            'taxonomy' => 'categorias_comercio',
            'field'    => 'term_id',
            'terms'    => $category_ids,
            'operator' => 'IN',
        );
    }

    if (!empty($tax_query) && count($tax_query) > 1) {
        $args = array(
            'post_type'      => 'comercios',
            'posts_per_page' => -1,
            'orderby'        => 'post_date',
            'order'          => 'DESC',
            'tax_query'      => $tax_query,
        );
    } else {
        $args = array(
            'post_type'      => 'comercios',
            'posts_per_page' => -1,
            'orderby'        => 'post_date',
            'order'          => 'DESC',
            's'              => $search_query,
        );
    }
} else {
    $args = array(
        'post_type'      => 'comercios',
        'posts_per_page' => -1,
        'orderby'        => 'post_date',
        'order'          => 'DESC',
    );
}

$banner_destaque = get_field('imagem');
$banner_mobile = get_field('imagem_mobile');

if ($banner_destaque) {
    $banner = $banner_destaque;
}else{
    $banner = '/wp-content/themes/GuiaServicos/assets/images/banner-padrao.jpg';
}

if ($banner_mobile) {
    $banner_mob = $banner_mobile;
}else{
    $banner_mob = '/wp-content/themes/GuiaServicos/assets/images/banner-padrao.jpg';
}

get_header();

?>
<?php if (have_posts()) : ?>

    <main class="internas comercios">
        <section class="banner">
            <div class="img-banner mob" style="background-image: url(<?php echo $banner_mob; ?>)">
                <div class="content-banner">
                    <p class="title"><?php the_field('titulo'); ?></p>
                </div>
            </div>
            <div class="img-banner desk" style="background-image: url(<?php echo $banner; ?>)">
                <div class="content-banner">
                    <p class="title"><?php the_field('titulo'); ?></p>
                </div>
            </div>  
        </section> 

        <section class="infos-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-11 offset-1">
                        <div class="breadcrumb">
                            <a href="/">Home ></a>
                            <?php if (get_field('breadcrumb')) { ?>
                                <a href="<?php the_field('breadcrumb'); ?><?php the_field('titulo_pagina'); ?>"></a>
                            <?php } ?>
                            <?php the_title(); ?>
                        </div>
                    </div>
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

        <section class="mais-lidas">
            <div class="container">
                <div class="row">
                    <div class="col-md-11 offset-1">
                        <?php 
                            if(!$search_query){ ?>
                                <p class="title">Comércios em destaque</p>
                        <?php
                            }else{
                        ?>
                                <p class="title"><?php echo $texto.$search_query; ?></p>
                        <?php   
                            }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="carousel-comercios">
                            <?php                                
                                $loop = new WP_Query($args);

                                while ($loop->have_posts()) : $loop->the_post();


                                    $terms = get_the_terms($id, 'categorias_comercio');

                                    $tags = get_the_terms($id, 'post_tag');

                                    $tag_principal_id = false;
                                    $tag_obj = false;
                                    $tag_principal_id = get_field('tag_principal');
                                    if($tag_principal_id){
                                        $tag_obj = get_term($tag_principal_id, 'post_tag');
                                    }
                        
                                    foreach($terms as $terma){
                                        $class = $terma->slug;
                                        $categoria = $terma->name;    
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
                                                <div class="whatsapp-comp">
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
                                endwhile;
                                wp_reset_postdata(); 
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="vantagens">
        <div class="container">
            <div class="row">
                <div class="col-md-12 offset-md-1">
                    <p class="title">Categorias</p>
                    <p class="subtitle">Escolha a categoria que deseja buscar</p>
                </div>

                <div class="col-md-12">
                    <div class="row offset-md-1">
                        <?php
                            $categorias = get_field('categorias');
                            foreach ($categorias as $item) {
                                
                                if ($item['link']) { ?>
                                    
                                    <div class="col-md-3 col-6 item-vantagens mb-2">
                                        <a href="<?php echo $item['link']; ?>">
                                            <img class="rounded" src="<?php echo $item['icone']; ?>">
                                            <p>
                                                <?php 
                                                    echo $item['titulo']; 
                                                    $quantidade_posts = contar_posts_por_categoria($item['titulo']);
                                                ?>
                                                <br/><small>+1500 resultados</small>        
                                                <!-- <br/><small>+<?php echo $quantidade_posts; ?> resultados</small> -->
                                            </p>
                                        </a>
                                    </div>
                                    
                                <?php } ?>

                                <?php $countIcons++; ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
    </section>
    </main>
<?php endif; ?>

<?php get_footer(); ?>