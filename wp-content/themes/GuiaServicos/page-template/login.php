<?php
/**
 * Template Name: Login
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
                </div>
            </div>
        </div>
    </section>  

    <section class="contato">
        <div class="container">
            <form id="form-cadastro" class="center">
                <div class="formulario-cadastro login">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <input type="text" name="email" id="email" class="required" placeholder="E-mail">
                            <p class="error error-email">Campo e-mail é obrigatório.</p>
                            <input type="password" name="password" class="password" id="password" class="required" placeholder="Senha">
                            <p class="error">Campo senha é obrigatório.</p>

                            <div class="forgot-password">
                                <a id="forgot-password-link">Esqueci minha senha</a>
                            </div>
                            <input type="button" name="btn-enviar" class="btn-yw" value="Acessar" onclick="Login();">         

                            <p id="form-error">Login ou senha inválidos!</p>
                        </div>
                    </div>
                </div>
            </form>            

            <form id="form-resend" class="center">
                <div class="formulario-cadastro login">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <div id="forgot-password-box">
                                <h4>Recuperar Senha</h4>
                                <input type="email" id="recover-email" placeholder="Digite seu e-mail">
                                <div id="message"></div>
                                <button id="send-password-reset" class="btn-yw">Enviar nova senha</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<?php get_footer(); ?>