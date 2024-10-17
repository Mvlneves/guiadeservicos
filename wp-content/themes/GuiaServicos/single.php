<?php
/**
 * The template for displaying sinlge posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

	get_header();

	$category = get_queried_object();
    $banner_mobile = get_field('banner_mobile');

    if ($banner_mobile) {
        $banner = $banner_mobile;
    }else{
        $banner = get_the_post_thumbnail_url();
    }
?>
<style>
    #like-dislike {
        display: none;
    }
</style>
<main class="internas post">
    <section class="banner">
        <div class="img-banner desk" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>)">
        </div>
        <div class="img-banner mob">
            <img src="<?php echo $banner; ?>">
        </div>
    </section> 

    <section class="infos-page">
        <div class="container">
            <div class="row">
                <div class="col-md-11 offset-md-1">
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
                    <div class="breadcrumb">
                        <a href="/">Home ></a>
                        <?php if(get_field('breadcrumb')){ ?>
                            <a href="<?php the_field('breadcrumb'); ?>"><?php the_field('titulo_pagina'); ?></a>
                        <?php } ?>
                        <?php the_title(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>   

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <p class="title title-post"><?php the_title(); ?></p>
                    <div class="content-second">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>    

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-1">
                    <?php 
                        $categories = get_the_category();
                        
                        foreach ( $categories as $cat ) {
                            $slug = $cat->slug;
                            $name = $cat->name;
                        }                          
                    ?>
                    <div class="categories <?php echo $slug; ?>">
                        <?php echo $name; ?>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                    <div class="access">
                        <div class="down-text" data-text="0"> 
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/a-.png">
                        </div>
                        <div class="up-text" data-text="2">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/a_mais.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="comparts interna-compart">
                        <div class="compartilhar">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/share/curtir_share_salvar_tempo-07.png"> 
                            <span>Compartilhe:</span>
                        </div>
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
    </section>     

    <section class="content-page" id="content-post">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div id="text-post">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>             

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="comparts interna-compart">
                        <div class="compartilhar">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/share/curtir_share_salvar_tempo-07.png"> 
                            <span>Compartilhe:</span>
                        </div>
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
    </section>  

    <section class="relacionadas">
        <div class="container">
            <div class="row">
                <div class="col-md-11 offset-md-1">
                    <p class="title">Notícias relacionadas</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 offset-md-1">
                        <?php 
                            $loop = new WP_Query(array('post_type' => 'post',
                                        'orderby' => 'post_date',
                                        'order' => 'DESC',
                                        'posts_per_page' => 3,
                                        'meta_query'=> array(
                                                array(
                                                'key' => 'post_oculto',
                                                'compare' => '=',
                                                'value' => 0,
                                                'type' => 'numeric',
                                                )
                                            )
                                        )
                                      );
                            while ($loop->have_posts()) : $loop->the_post();

                            $categories = get_the_category();
                            foreach ( $categories as $cat ) {
                                $slug = $cat->slug;
                                $name = $cat->name;
                            }                     
                        ?>

                        <div class="post">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                    if ( has_post_thumbnail() ) {
                                        $img = get_the_post_thumbnail_url();
                                    }
                                ?> 
                                <div class="image-post desk" style='background-image: url("<?php echo $img; ?>");'>
                                </div>

                                <div class="image-post mob">
                                     <img src="<?php the_field('banner_mobile'); ?>">
                                </div>

                                <div class="content-post">
                                    <div class="categories <?php echo $slug; ?>">
                                        <?php echo $name; ?>
                                    </div>

                                    <div class="title-post">
                                        <?php the_title(); ?>
                                    </div>
                                </div>
                            </a>
                        </div>                       

                        <?php endwhile; wp_reset_postdata(); ?>

                        <a href="/noticias/" class="all-posts">Veja todas as notícias →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>   
</main>

<?php get_footer(); ?>
