<?php

/**
 * Template Name: Home
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

get_header(); ?>
<main class="">
    <section class="banner-destaque">
        <div class="carousel-banner-home">
            <?php
            $carrossel_home = get_field('banner');
            foreach ($carrossel_home as $item) { ?>
                <div class="banners-cell">
                    <?php if ($item['video'] == 1) { ?>
                        <div class="banner desk" style="background-image: url(<?php echo $item['imagem_destaque']; ?>);">
                            <div class="play-video" data-video="<?php echo $item['link']; ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg">
                            </div>
                            <div class="content-banner">
                                <p class="title"><?php echo $item['titulo']; ?></p>
                                <p class="subtitle"><?php echo $item['subtitulo']; ?></p>
                            </div>
                        </div>
                        <div class="banner mob" style="background-image: url(<?php echo $item['imagem_destaque_mobile']; ?>);">
                            <div class="play-video" data-video="<?php echo $item['link']; ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg">
                            </div>
                            <div class="content-banner">
                                <p class="title"><?php echo $item['titulo']; ?></p>
                                <p class="subtitle"><?php echo $item['subtitulo']; ?></p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <a href="<?php echo $item['link']; ?>">
                            <div class="banner desk" style="background-image: url(<?php echo $item['imagem_destaque']; ?>);">
                                <div class="content-banner">
                                    <p class="title"><?php echo $item['titulo']; ?></p>
                                    <p class="subtitle"><?php echo $item['subtitulo']; ?></p>
                                </div>
                            </div>
                            <div class="banner mob" style="background-image: url(<?php echo $item['imagem_destaque_mobile']; ?>);">
                                <div class="content-banner">
                                    <p class="title"><?php echo $item['titulo']; ?></p>
                                    <p class="subtitle"><?php echo $item['subtitulo']; ?></p>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            <?php }
            ?>
        </div>
    </section>

    <section id="busca">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-sm-12">
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
                <div class="col-md-11 offset-md-1">
                    <p class="title">Comércios em destaque</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="carousel-posts">
                        <?php
                            $loop = new WP_Query(
                                array(
                                    'post_type' => 'comercios',
                                    'orderby' => 'post_date',
                                    'order' => 'DESC',
                                    'posts_per_page' => 8,
                                    'orderby' => 'meta_value',
                                )
                            );

                            while ($loop->have_posts()) : $loop->the_post();

                                $terms = get_the_terms($id, 'categorias_comercio');

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

                                $tags = get_the_terms($id, 'post_tag');
                        ?>

                            <div class="posts-cell">
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
                                                <?php echo $item['titulo']; ?>
                                                <br/><small>+1500 resultados</small>        
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

    <section class="todas-noticias">
        <div class="container">
            <div class="row">
                <div class="col-md-11 offset-md-1">
                    <p class="title">Últimas notícias</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-11 offset-md-1">
                    <div>
                        <a href="/category/gastronomia/" class="category-link gastronomia">Gastronomia</a>
                        <a href="/category/eventos/" class="category-link eventos">Eventos</a>
                        <a href="/category/noticias/" class="category-link noticias">Notícias</a>
                        <a href="/category/saude/" class="category-link saude">Saúde</a>
                    </div>
                </div>
            </div>

            <div class="row posts">
                <div class="col-md-11 offset-md-1">
                    <?php
                    $loop = new WP_Query(
                        array(
                            'post_type' => 'post',
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                            'posts_per_page' => 8,
                            'meta_query' => array(
                                array(
                                    'key' => 'post_oculto',
                                    'compare' => '=',
                                    'value' => 0,
                                    'type' => 'numeric',
                                )
                            )
                        )
                    );
                    while ($loop->have_posts()) : $loop->the_post();

                        $categories = get_the_category();
                        foreach ($categories as $cat) {
                            $slug = $cat->slug;
                            $name = $cat->name;
                        }
                    ?>

                        <div class="post">
                            <?php
                            if (has_post_thumbnail()) {
                                $img = get_the_post_thumbnail_url();
                            }
                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <div class="image-post" style='background-image: url("<?php echo $img; ?>");'>
                                </div>

                                <div class="content-post">
                                    <div class="categories <?php echo $slug; ?>">
                                        <?php echo $name; ?>
                                    </div>

                                    <div class="title-post">
                                        <?php the_title(); ?>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="dicas">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-12 book-img">
                    <img src="<?php the_field('imagem_dicas'); ?>" alt="imagemdicas">
                </div>
                <div class="col-lg-6 col-xs-12 book-delivery">
                    <p class="title"><?php the_field('titulo_dicas'); ?></p>
                    <p class="subtitle"><?php the_field('conteudo_dicas'); ?></p>
                    <a href="<?php the_field('link_dicas'); ?>" target="_blank">Saiba Mais</a>
                </div>
            </div>
        </div>
    </section>

    <div class="modal" id="modal-video">
        <div class="modal-content">
            <img class="modal-background close-modal" src="<?php echo get_template_directory_uri(); ?>/assets/images/close-modal.svg" alt="closemodal" width="47" height="47">
            <div class="col-md-12">
                <iframe id="video-frame" width="100%" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>