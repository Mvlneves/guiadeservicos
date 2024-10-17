<?php
/**
 * Template Name: Eventos
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

get_header(); 

$banner_destaque = get_field('imagem');
$banner_mobile = get_field('imagem_mobile');
if ($banner_destaque) {
    $banner = $banner_destaque;
}else{
    $banner = '/wp-content/themes/GuiaServicos/assets/images/banner-padrao.jpg';
}

if ($banner_mobile) {
    $mobile = $banner_mobile;
}else{
    $mobile = '/wp-content/themes/GuiaServicos/assets/images/banner-padrao.jpg';
}

?>
<main class="internas">
    <section class="banner">
        <div class="img-banner mob" style="background-image: url(<?php echo $mobile; ?>)">
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
                <div class="col-md-12">
                    <div class="breadcrumb">
                        <a href="/">Home ></a>
                        <?php if(get_field('breadcrumb')){ ?>
                            <a href="<?php the_field('breadcrumb'); ?><?php the_field('titulo_pagina'); ?>"></a>
                        <?php } ?>
                        <?php the_title(); ?>
                    </div>

                    <h1>
                        <?php the_title(); ?>
                    </h1>

                    <?php the_field('conteudo_secundario'); ?>
                </div>
            </div>
        </div>
    </section> 

    <section class="page-eventos">
        <div class="container">
            <div class="row"> 
                <?php
                    $loop = new WP_Query(
                        array(
                            'post_type' => 'eventos',
                            'orderby' => 'data_inicio',
                            'order' => 'ASC',
                            'posts_per_page' => -1                            
                        )
                    );
                    while ($loop->have_posts()) : $loop->the_post();
                ?>

                    <div class="col-md-4 item-evento">
                        <div class="evento">
                            <div class="header-evento">
                                <img src="<?php echo get_field('imagem'); ?>">
                                <h2><?php the_title(); ?></h2>
                            </div>
                            <div class="content-evento">
                                <p><?php echo get_field('descricao'); ?></p>
                                <p><img src="/wp-content/themes/GuiaServicos/assets/images/evento-date.png">
                                    <?php echo get_field('data_inicio'); ?>

                                    <?php 
                                        if(get_field('data_fim')){
                                            echo ' à '.get_field('data_fim');
                                        }
                                    ?>
                                </p>
                                <p><img src="/wp-content/themes/GuiaServicos/assets/images/evento-clock.png">
                                <?php echo get_field('hora'); ?></p>
                                <p><img src="/wp-content/themes/GuiaServicos/assets/images/evento-pin.png"><?php echo get_field('local'); ?></p>
                            </div>

                            <div class="link-evento">
                                <a target="_blank" href="<?php echo get_field('link'); ?>">
                                    Saiba mais
                                </a>
                            </div>                            
                        </div>
                    </div>

                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>