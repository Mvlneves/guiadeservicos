<?php
/**
 * The template for displaying sinlge posts - Comércios
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

	get_header();

    $banner_destaque = get_field('banner_destaque');

    if ($banner_destaque) {
        $banner = $banner_destaque;
    }else{
        $banner = '/wp-content/themes/GuiaServicos/assets/images/banner-padrao.jpg';
    }

    $tag_principal_id = get_field('tag_principal');
    if($tag_principal_id){
        $tag_obj = get_term($tag_principal_id, 'post_tag');
    }
?>

<main class="internas post comercio">
    <section class="banner">
        <div class="img-banner" style="background-image: url(<?php echo $banner; ?>)">
            <div class="overlay"></div>
            <div class="container title-comercio">
                <h2><?php the_title(); ?></h2>
                <?php 
                    $terms = get_the_terms($id, 'categorias_comercio');

                    $tags = get_the_terms($id, 'post_tag');      
                    foreach ($tags as $tag) {
                        $tagName = $tag->name;
                    }

                    
                    foreach($terms as $terma){
                        $class .= $terma->slug.' ';
                        $categoria .= $terma->name.' ';    
                    } 
                ?>
                <p><?php echo $categoria .' - '.$tag_obj->name; ?></p>
            </div>
        </div>        
    </section> 

    <section class="infos-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="comparts">
                        <div class="like">
                            <?php echo get_simple_likes_button( get_the_ID() ); ?>
                        </div>
                        <div class="compartilhar">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/share/curtir_share_salvar_tempo-07.png">

                            <div id="compartilhar-aberto">
                                <div class="whatsapp">
                                    <a href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>" target="blank">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/whatsapp.svg">
                                    </a>
                                </div>           
                                <div class="facebook">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="blank">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/facebook.svg">
                                    </a>
                                </div>  
                                <div class="twitter">
                                    <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="blank">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/twitter.svg">
                                    </a>
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>   

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="title title-post"><?php the_title(); ?></p>
                    <div class="tags-comercio">
                        <?php 
                            if ($tag_obj) {
                                echo '<a href="' . get_term_link($tag_obj) . '"><span>' . $tag_obj->name . '</span></a>';
                            }

                            foreach($tags as $tag){                                            
                                echo '<a href="/tag/'.$tag->slug.'"><span>'.$tag->name.'</span></a>';
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <?php if(get_field('logo')){ ?>
                        <img class="logo-comercio" src="<?php the_field('logo'); ?>">
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>    

    <section class="content-page item-comercio">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="image_lista">
                        <?php 
                            if(get_field('imagem_lista')){
                                $image = get_field('imagem_lista');
                            }else{
                                $image = '/wp-content/themes/GuiaServicos/assets/images/guia.webp';
                            }
                        ?>
                        <img src="<?php echo $image; ?>">                        
                    </div>
                    <div class="nome">
                        <h2><?php the_title(); ?></h2>
                    </div>
                    <?php if(get_field('whatsapp')){ 
                        $numero_limpo = preg_replace('/\D+/', '', get_field('whatsapp'));
                        $numero_completo = '55' . $numero_limpo;
                        $link_whatsapp = "https://wa.me/" . $numero_completo;
                    ?>
                        <div class="whatsapp-phone">
                            <a href="<?php echo $link_whatsapp; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-whatsapp.png" alt=""> 
                                <span><?php the_field('whatsapp'); ?></span>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if(get_field('telefone')){ 
                        $numero_limpo = preg_replace('/\D+/', '', get_field('telefone'));
                        $link_telefone = "tel:" . $numero_limpo;
                    ?>
                        <div class="phone">
                            <a href="<?php echo $link_telefone; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-phone.png" alt=""> 
                                <span><?php the_field('telefone'); ?></span>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if(get_field('endereco_completo')){ ?>
                        <div class="endereco">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-pin.png" alt=""> 
                            <span><?php the_field('endereco_completo'); ?></span>
                        </div>
                    <?php } ?>

                    <?php if(get_field('email')){ ?>
                        <div class="email">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-email.png" alt=""> 
                            <span><?php the_field('email'); ?></span>
                        </div>
                    <?php } ?>

                    <div class="redes-sociais">
                        <?php if(get_field('link_facebook')){ ?>
                            <a target="_blank" href="<?php the_field('link_facebook'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-facebook.png" alt="">
                            </a>
                        <?php } ?>
                        <?php if(get_field('link_instagram')){ ?>
                            <a target="_blank" href="<?php the_field('link_instagram'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-instagram.png" alt="">
                            </a>
                        <?php } ?>
                        <?php if(get_field('link_twitter')){ ?>
                            <a target="_blank" href="<?php the_field('link_twitter'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-twitter.png" alt="">
                            </a>
                        <?php } ?>
                        <?php if(get_field('link_linkedin')){ ?>
                            <a target="_blank" href="<?php the_field('link_linkedin'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-linkedin.png" alt="">
                            </a>
                        <?php } ?>
                        <?php if(get_field('site')){ ?>
                            <a target="_blank" href="<?php the_field('site'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/com-site.png" alt="">
                            </a>
                        <?php } ?>
                    </div>

                    <div class="horarios">
                        <h3>Horário de funcionamento</h3>
                        <table>
                        <?php 
                            $horarios = get_field('horarios');
                            foreach($horarios as $horario){ ?>
                                <tr><td><?php echo $horario['dia'].': </td><td>'. $horario['horario'];  ?></td><tr>
                        <?php
                            }
                        ?>
                        </table>
                    </div>
                </div>
                <div class="col-md-8">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-sobre" onClick="AlterTab('sobre')";>Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-fotos" onClick="AlterTab('fotos')";>Fotos</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane active" id="sobre">                            
                            <p><?php the_field('descricao'); ?></p>

                            <h3>Características</h3>
                            <p><?php the_field('caracteristicas'); ?></p>
                        </div>
                        <div class="tab-pane" id="fotos">
                            <div class="carousel-fotos row">
                            <?php 
                                $galeria = get_field('galeria');
                                foreach($galeria as $gal){ ?>
                                    <!-- <div class="carousel-cell"> -->
                                    <div class="col-md-6 fotos">
                                        <img src="<?php echo $gal['foto']; ?>">
                                    </div>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  
   
</main>

<?php get_footer(); ?>
