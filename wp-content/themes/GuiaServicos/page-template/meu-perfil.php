<?php
/**
 * Template Name: Meu Perfil
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

session_start();

if (!isset($_SESSION['user_id'])) {
    wp_redirect(home_url());
    exit;
}

$user_data = $_SESSION['user_data'];

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

    <section id="dados">
        <div class="container">
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

    <section id="meu-perfil">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <ul class="nav flex-column nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" id="first-item">
                            <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">Dados Pessoais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#senha" role="tab" aria-controls="password" aria-selected="false">Alterar Senha</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">Meu comércio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Dados de Pagamento</a>
                        </li>
                    </ul>

                    <a class="logout" href="/wp-json/custom/v1/logout/"><span>x</span> Sair</a>
                </div>

                <!-- Conteúdo -->
                <div class="col-md-9">
                    <div class="tab-content" id="profileContent">
                        <!-- Formulário de Dados Pessoais -->
                        <div class="tab-pane show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                            <h2>Dados Pessoais</h2>
                            <form id="form-personal">
                                <div class="form-group">
                                    <label for="corporate_reason">Razão Social</label>
                                    <input type="text" class="form-control required" id="corporate_reason" name="corporate_reason" value="<?php echo esc_attr($user_data['corporate_reason']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo esc_attr($user_data['name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Telefone</label>
                                    <input type="text" class="form-control telefone required" id="phone" name="phone" value="<?php echo esc_attr($user_data['phone']); ?>">
                                </div>
                                <button type="button" class="btn btn-primary btn-yw" onclick="updatePersonal()">Atualizar Dados</button>

                                <div id="personal-sucess" class="message sucess">Dados atualizados com sucesso!</div>
                                <div id="personal-error" class="message error-message">Não foi possível atualizar seus dados!</div>
                            </form>
                        </div>

                        <!-- Formulário de Alteração de Senha -->
                        <div class="tab-pane " id="senha" role="tabpanel" aria-labelledby="password-tab">
                            <h2>Alterar Senha</h2>
                            <form id="form-password">
                                <div class="form-group">
                                    <label for="password">Nova Senha</label>
                                    <input type="password" class="form-control required" id="password" name="password">
                                    <span class="error-senha error" style="display:none;">As senhas não coincidem</span>
                                </div>
                                <div class="form-group">
                                    <label for="repassword">Confirme a Senha</label>
                                    <input type="password" class="form-control required" id="repassword" name="repassword">
                                </div>
                                <button type="button" class="btn btn-primary btn-yw" onclick="updatePassword()">Atualizar Senha</button>
                                <div id="password-sucess" class="message sucess">Senha atualizada com sucesso!</div>
                                <div id="password-error" class="message error-message">Não foi possível atualizar sua senha!</div>
                            </form>
                        </div>

                        <!-- Formulário de Dados de Pagamento -->
                        <div class="tab-pane" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                            <h2>Dados de pagamento</h2>
                            <form id="form-payment">
                                <div class="form-group">
                                    <label for="name_card">Nome no Cartão</label>
                                    <input type="text" class="form-control required" id="name_card" name="name_card">
                                </div>
                                <div class="form-group">
                                    <label for="number_card">Número do Cartão</label>
                                    <input type="text" class="form-control required number_card" id="number_card" name="number_card">
                                </div>
                                <div class="form-group">
                                    <label for="validate_card">Validade</label>
                                    <input type="text" class="form-control required validate_card" id="validate_card" name="validate_card">
                                </div>
                                <div class="form-group">
                                    <label for="ccv_card">CCV</label>
                                    <input type="text" class="form-control required ccv_card" id="ccv_card" name="ccv_card">
                                </div>
                                <button type="button" class="btn btn-primary btn-yw" onclick="updatePayment()">Atualizar Dados de Pagamento</button>
                                <div id="payment-sucess" class="message sucess">Dados de pagamento atualizados com sucesso!</div>
                                <div id="payment-error" class="message error-message">Não foi possível atualizar seus dados de pagamento!</div>
                            </form>
                        </div>
                        <div class="tab-pane" id="business" role="tabpanel" aria-labelledby="business-tab">
                            <div class="container">
                                <h2>Editar Comércio</h2>
                                <a target="_blank" id="link_comercio">Ver meu comércio</a>
                                <form id="form-comercio" enctype="multipart/form-data">
                                    <!-- Sobre -->
                                    <h3>Sobre</h3>
                                    <div class="form-group">
                                        <label for="nome">Nome do Comércio</label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <textarea class="form-control" id="descricao" name="descricao"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="caracteristicas">Características</label>
                                        <textarea class="form-control" id="caracteristicas" name="caracteristicas"></textarea>
                                    </div>

                                    <!-- Imagens -->
                                    <h3>Imagens</h3>
                                    <div class="form-group">
                                        <label for="banner_destaque">Banner Destaque</label>
                                        <input type="file" class="form-control-file" id="banner_destaque" name="banner_destaque">
                                        <img id="banner_destaque_preview" src="" alt="Banner Destaque" style="max-width: 30%; height: auto;">
                                    </div>
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        <input type="file" class="form-control-file" id="logo" name="logo">
                                        <img id="logo_preview" src="" alt="Logo" style="max-width: 30%; height: auto;">
                                    </div>
                                    <div class="form-group">
                                        <label for="imagem_lista">Imagem Lista</label>
                                        <input type="file" class="form-control-file" id="imagem_lista" name="imagem_lista">
                                        <img id="imagem_lista_preview" src="" alt="Imagem Lista" style="max-width: 30%; height: auto;">
                                    </div>
                                    <!-- Galeria de Fotos -->
                                    <h3>Galeria de Fotos</h3>
                                    <div id="galeria-container">
                                    </div>
                                    <button type="button" class="btn btn-secondary" id="add-galeria-btn">Adicionar Imagem</button>

                                    <!-- Contatos -->
                                    <h3>Contatos</h3>
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" class="form-control cep" id="cep" name="cep">
                                    </div>
                                    <div class="form-group">
                                        <label for="endereco_completo">Endereço Completo</label>
                                        <textarea class="form-control" id="endereco_completo" name="endereco_completo"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefone">Telefone</label>
                                        <input type="text" class="form-control telefone" id="telefone" name="telefone">
                                    </div>
                                    <div class="form-group">
                                        <label for="whatsapp">WhatsApp</label>
                                        <input type="text" class="form-control whatsapp" id="whatsapp" name="whatsapp">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="link_facebook">Link Facebook</label>
                                        <input type="url" class="form-control" id="link_facebook" name="link_facebook">
                                    </div>
                                    <div class="form-group">
                                        <label for="link_instagram">Link Instagram</label>
                                        <input type="url" class="form-control" id="link_instagram" name="link_instagram">
                                    </div>
                                    <div class="form-group">
                                        <label for="site">Site</label>
                                        <input type="url" class="form-control" id="site" name="site">
                                    </div>

                                    <!-- Horário de Funcionamento -->
                                    <h3>Horário de Funcionamento</h3>
                                    <div id="horarios-container">
                                        <!-- Os horários serão adicionados dinamicamente aqui -->
                                    </div>
                                    <button type="button" class="btn btn-secondary" id="add-horario-btn">Adicionar Horário</button>

                                    <!-- Taxonomia -->
                                    <h3>Taxonomia</h3>
                                    <div class="form-group">
                                        <label for="categoria">Categoria</label>
                                        <select class="form-control" id="categoria" name="categoria[]" multiple>
                                            <!-- As opções serão carregadas dinamicamente -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tags">Tags</label>
                                        <select class="form-control" id="tags" name="tags[]" multiple>
                                            <!-- As opções serão carregadas dinamicamente -->
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-yw">Salvar Alterações</button>
                                    <div id="business-sucess" class="message sucess">Dados atualizados com sucesso!</div>
                                    <div id="business-error" class="message error-message">Não foi possível atualizar seus dados!</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>