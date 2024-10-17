<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="google-site-verification" content="NpbVFTpvvLAJs8nxZOjvnYVZTY433RUETo7Mm8tFnAw" />
  <title><?php wp_title('|'); ?></title>

  <link rel="canonical" href="<?php the_permalink(); ?>"/> 
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.png" />

  <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
        <![endif]-->  

  <!-- CSS -->
  <?php 
    wp_head(); 
    $id = get_the_ID();
  ?>

    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css"></noscript>
  
  <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/css/animate.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/animate.css"></noscript>  
  
</head>
<body <?php body_class(); ?>>
<header class="main_header">
      <div class="container container-header">
            
          <div class="header-col-logo">
              <h1 class="fontzero">Guia de Serviços Alphaville</h1>
              <a href="/">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" alt="">
              </a>
          </div>

          <div class="mobile-nav-button">
                <div class="mobile-nav-button__line"></div>
                <div class="mobile-nav-button__line"></div>
                <div class="mobile-nav-button__line"></div>
          </div>

          <div class="header-col-menu">
            <nav class="mobile-menu-three">   
                <ul>
                  <li class="<?php if($id == '5089'){ echo 'active';} ?>"> <a href="/quem-somos/">Sobre</a> </li>
                  <li class="<?php if($id == '5038'){ echo 'active';} ?>"> <a href="/todos-comercios/">Comércios</a> </li>
                  <li class="<?php if($id == '9724'){ echo 'active';} ?>"> <a href="/seja-um-anunciante/">Seja um anunciante</a> </li>
                  <li class="<?php if($id == '5797'){ echo 'active';} ?>">  <a href="/fale-conosco/">Fale Conosco</a> </li>
                  <li class="anunciante <?php if($id == '5502'){ echo 'active';} ?>"><a href="/area-logada/">Área do anunciante</a> </li>
                </ul>
            </nav>
      </div>
      <div class="clear"></div>
</header>

<!-- <div id="modal-direcao">
  <div class="content-modal">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/times-solid.svg" onClick="Fechar();">
    <h3>Queremos trazer conteúdos direcionados a você.</h3>
    <h4>Para isso, você poderia responder essas perguntas?</h4>
    <div class="box-w">
      <div class="box-inline">
        <div class="tipo_acesso" id="tipo_acesso">
          <div class="box">
              <form name="form_tipo_acesso" id="form_tipo_acesso">
                <p>Você é entregador parceiro iFood?</p>
                <input id="local" type="button" class="aceito2" name="aceito" onclick="AcceptTipoacesso();" value="Sim">
                <input type="hidden" id="tipo_acesso_v" name="tipo_acesso_v">
                <input type="button" class="naoaceito2" name="naoaceito" onclick="NoAcceptTipoacesso();" value="Não">
              </form>
          </div>
        </div>
      </div>
      <div class="box-inline">
        <div class="location" id="location">
          <div class="box">
              <form name="form_location" id="form_location">
                <p>Permitir acesso a localização</p>
                <p><span>A sua localização é importante para mostrarmos a você os conteúdos mais relevantes.</span></p>
                <input id="local" type="button" class="aceito" name="aceito" onclick="AcceptLocation();" value="Sim">
                <input type="hidden" id="latitude" class="lat" name="latitude">
                <input type="hidden" id="longitude" class="long" name="longitude">
                <input type="button" class="naoaceito" name="naoaceito" onclick="NoAcceptLocation();" value="Não">
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->