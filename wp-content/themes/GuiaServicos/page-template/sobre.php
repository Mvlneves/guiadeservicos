<?php
/**
 * Template Name: Sobre Nós
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
                </div>
            </div>
        </div>
    </section>  

    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-md-6 book-img">
                    <img src="<?php the_field('imagem_destaque'); ?>" alt="imagemdicas">
                </div>
                <div class="col-md-6 book-delivery">
                    <p class="subtitle"><?php the_field('conteudo_secundario'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="equipe">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Nosso time</h2>
                </div>
            </div>

            <div class="row">
                <?php 
                    $equipe = get_field('equipe');
                    foreach($equipe as $eqp){ ?>
                        <div class="col-md-4">
                            <div class="item">
                                <img src="<?php echo $eqp['imagem'] ?>">
                                <p class="nome"><?php echo $eqp['nome'] ?></p>
                                <p class="funcao"><?php echo $eqp['funcao'] ?></p>
                                <p class="conteudo"><?php echo $eqp['conteudo'] ?></p>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>