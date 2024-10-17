<?php
/**
 * Template Name: Planos
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
$check = '<img src="/wp-content/themes/GuiaServicos/assets/images/check.png">';
$not = '<img src="/wp-content/themes/GuiaServicos/assets/images/not.png">';

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

?>
<main class="internas">
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

    <section class="planos">
        <div class="container">
            <div class="row">
                <div class="carousel-planos">
                    <?php
                        $loop = new WP_Query(
                            array(
                                'post_type' => 'planos',
                                'orderby' => 'post_date',
                                'order' => 'ASC',
                                'posts_per_page' => 3,
                                'meta_query' => array(
                                    array(
                                        'key' => 'plano_ativo',
                                        'compare' => '=',
                                        'value' => 1,
                                        'type' => 'numeric',
                                    )
                                )
                            )
                        );
                        while ($loop->have_posts()) : $loop->the_post();
                    ?>

                        <div class="col-md-4 item-plano">
                            <div class="plano">
                                <div class="header-plano">
                                    <h2><?php the_title(); ?></h2>
                                    <p class="valor">R$ <?php echo the_field('valor'); ?> / mês</p>
                                    <p class="descricao">(<?php echo the_field('descricao_periodo'); ?>)</p>
                                </div>
                                <div class="content-plano">
                                    <?php 
                                        $caracteristicas = get_field('caracteristicas');
                                        foreach($caracteristicas as $caract){
                                    ?>
                                            <p>
                                                <?php echo $caract['active'] == 1 ? $check : $not; ?>
                                                <?php echo $caract['texto'] ?>
                                            </p>

                                    <?php
                                        }
                                    ?>
                                </div>

                                <div class="link-plano">
                                    <a href="/cadastro/?plano=<?php echo the_ID(); ?>">
                                        Quero anunciar
                                    </a>
                                </div>                            
                            </div>
                        </div>

                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div> 
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>