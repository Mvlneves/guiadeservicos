<?php
/**
 * Template Name: Fale Conosco
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

    <section class="contato">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Deixe seu recado!</h2>
                    <div class="formulario-contato">
                        <form id="form-contato" class="center">
                            <select class="required" aria-required="true" aria-invalid="false" name="assunto">
                                <option value="">Assunto *</option>
                                <option value="Quero anunciar">Quero anunciar</option>
                                <option value="Dica de pauta">Dica de pauta</option>
                                <option value="Sugestão">Sugestão</option>
                                <option value="Outros assuntos">Outros assuntos</option>
                            </select>
                            <p class="error">Por favor, selecione um assunto.</p>
                            <input type="text" name="nome" id="nome" class="required" placeholder="Nome">
                            <p class="error">Campo nome é obrigatório.</p>
                            
                            <input type="text" name="email" id="email" class="required" placeholder="E-mail">
                            <p class="error error-email">Campo e-mail é obrigatório.</p>
                            
                            <input type="text" name="telefone" id="telefone" class="required telefone" placeholder="Telefone">
                            <p class="error error-telefone">Campo telefone é obrigatório.</p>
                            
                            <textarea name="mensagem" id="mensagem" class="required" placeholder="Mensagem"></textarea>
                            <p class="error">Por favor, digite uma mensagem.</p>
                            <input type="button" name="btn-enviar" class="btn-yw" value="Enviar" onclick="EnviaEmail();">
                        </form>
                        <div id="sucesso">
                            <p class="center">Mensagem enviada com sucesso.</p> 
                            <p class="center">Em breve retornamos o contato.</p> 
                            <p class="center">Obrigada!</p>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="dados_contato">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?php the_field('dados_contato'); ?>
                </div>

                <div class="col-md-8">
                    <iframe id="map-google" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3659.3184673899723!2d-46.855835!3d-23.485036!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94cf024f162e15f1%3A0x455e24310deaa885!2sAv.%20Copacabana%2C%20177%20-%20Empresarial%2018%20do%20Forte%2C%20Barueri%20-%20SP%2C%2013104-082%2C%20Brasil!5e0!3m2!1spt-BR!2sus!4v1725496053844!5m2!1spt-BR!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>