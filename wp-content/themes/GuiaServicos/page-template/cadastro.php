<?php
/**
 * Template Name: Cadastro
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

$plano = filter_input(INPUT_GET, 'plano', FILTER_SANITIZE_STRING);

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

                    <?php the_field('conteudo_secundario'); ?>
                </div>
            </div>
        </div>
    </section>  

    <section class="contato">
        <div class="container">
            <form id="form-cadastro" class="center">
                <div class="formulario-cadastro">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Dados pessoais</h2>
                            <input type="text" name="corporate_reason" id="corporate_reason" class="required" placeholder="Razão Social">
                            <p class="error">Campo razão social é obrigatório.</p>

                            <input type="text" name="cnpj" id="cnpj" class="required cnpj" placeholder="CNPJ">
                            <p class="error">Campo CNPJ é obrigatório.</p>

                            <input type="text" name="name" id="name" class="required" placeholder="Nome do responsável">
                            <p class="error">Campo nome é obrigatório.</p>

                            <input type="text" name="cpf" id="cpf" class="required cpf" placeholder="CPF">
                            <p class="error">Campo CPF é obrigatório.</p>
                            
                            <input type="text" name="email" id="email" class="required" placeholder="E-mail">
                            <p class="error error-email">Campo e-mail é obrigatório.</p>
                            
                            <input type="text" name="phone" id="phone" class="telefone required" placeholder="Telefone">
                            <p class="error error-telefone">Campo telefone é obrigatório.</p>

                            <input type="password" name="password" class="password" id="password" class="required" placeholder="Senha">
                            <input type="password" name="repassword" class="repassword" id="repassword" class="required" placeholder="Confirmar Senha">
                            <p class="error">Campo senha é obrigatório.</p>
                            <p class="error-senha">As senhas devem ser iguais</p>           
                        </div>
                        <div class="col-md-4">
                            <h2>Dados de pagamento</h2>
                            <input type="text" name="name_card" id="name_card" class="required" placeholder="Nome impresso no cartão">
                            <p class="error">Campo nome é obrigatório.</p>
                            
                            <input type="text" name="number_card" id="number_card"  class="required number_card" placeholder="Número do cartão">
                            <p class="error">Campo número do cartão é obrigatório.</p>
                            
                            <input type="text" name="validate_card" id="validate_card" class="required validate_card" placeholder="Validade">
                            <p class="error">Campo validade é obrigatório.</p>

                            <input type="text" name="ccv_card" id="ccv_card" class="required ccv_card" placeholder="Código de segurança">
                            <p class="error">Campo código de segurança é obrigatório.</p>
                        </div>

                        <div class="col-md-4">
                            <h2>Plano selecionado</h2>
                            <?php
                                $loop = new WP_Query(
                                    array(
                                        'post_type' => 'planos',
                                        'p' => $plano
                                    )
                                );
                                while ($loop->have_posts()) : $loop->the_post();
                            ?>

                                <div class="plano">
                                    <div class="header-plano">
                                        <h2><?php the_title(); ?></h2>
                                        <p class="valor">R$ <?php echo the_field('valor'); ?> / mês</p>
                                        <p class="descricao">(<?php echo the_field('descricao_periodo'); ?>)</p>
                                    </div>

                                    <input type="hidden" name="plan" value="<?php echo the_ID(); ?>">
                                    <input type="hidden" name="status" value="active">
                                    <input type="button" name="btn-enviar" class="btn-yw" value="Finalizar o cadastro" onclick="Cadastro();">
                                    <p class="error exists">Não foi possível realizar seu cadastro, entre em contato conosco!</p>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata(); ?>

                        </div>
                    </div>
                </div>
            </form>

            <div id="sucesso">
                <p class="center">Cadastro realizado com sucesso.</p> 
                <p class="center">Acesse a área do anunciante e cadastre o seu negócio!</p>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>