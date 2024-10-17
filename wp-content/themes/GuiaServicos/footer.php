<footer class="main_footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2>Guia de Serviços Alphaville</h2>
            </div>
            <div class="col-sm-6 text-right center-mobile">
                <a href="/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" alt="" width="250">
                </a>
            </div>            
        </div> 

        <div class="row">
            <div class="col-sm-3 line-top">
                <p>Institucional</p>
                <ul>
                  <li class="<?php if($id == '5089'){ echo 'active';} ?>"> <a href="/quem-somos/">Sobre</a> </li>
                  <li><a href="/politica-de-privacidade/">Política de Privacidade</a></li>
                  <li><a href="/politica-de-cookies/">Política de Cookies</a></li>
                  <li class="<?php if($id == '5797'){ echo 'active';} ?>">  <a href="/fale-conosco/">Fale Conosco</a> </li>
                </ul>    
            </div>
            <div class="col-sm-3 line-top">
                <p>Comércios</p>
                <ul>
                  <li class="<?php if($id == '5038'){ echo 'active';} ?>"> <a href="/todos-comercios/">Todos os comércios</a> </li>
                  <li class="<?php if($id == '9724'){ echo 'active';} ?>"> <a href="/seja-um-anunciante/">Seja um anunciante</a> </li>                    
                </ul>

                <p>Notícias e Eventos</p>
                <ul>
                  <li class="<?php if($id == '5514'){ echo 'active';} ?>"> <a href="/noticias/">Blog</a> </li>
                  <li class="<?php if($id == '5062'){ echo 'active';} ?>"> <a href="/eventos">Eventos</a> </li>
                </ul>
            </div>  
            <div class="col-sm-3 line-top">                
                <div class="redes-sociais">
                    <a href="#" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-facebook.png" alt="facebookicon" width="25" height="25">
                    </a>
                    <a href="#" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-instagram.png" alt="instagramicon" width="25" height="25">
                    </a>
                    <a href="#" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-twitter.png" alt="twittericon" width="25" height="25">
                    </a>
                    <a href="#" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-linkedin.png" alt="linkedinicon" width="25" height="25">
                    </a>
                </div>
            </div>                       
        </div>

        <div class="row">
            <div class="col-sm-12 line-top">
                <p class="copyright">©<?php echo date('Y'); ?> Guia de Serviços Alphaville. Notícias e dicas de produtos e serviços em Alphaville, Tamboré, Barueri, Santana de Parnaíba, São Paulo, Brasil. <br /> Todos os direitos reservados. :)</p>
            </div>
        </div>
    </div>
</footer>   

<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/css/flickity.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/flickity.min.css"></noscript>


<!-- scripts -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/wow.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/analytics.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.mask.min.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/flickity.pkgd.min.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/tinymce/tinymce.min.js" defer></script>

<?php wp_footer(); ?>


</body>
</html>