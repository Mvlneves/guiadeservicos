<?php
/**
 * The template for displaying search page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

    get_header();
?>

<?php 
    $s = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING); 
    $count=0;
?>

<main class="internas resultado">
    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <p class="title-results">Resultados encontrados</p>
                </div>
            </div>
        </div>
    </section>  

    <?php 
        $index=0;
        $loop = new WP_Query(array('post_type' => 'page',
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    's' => $s,
                    'meta_query' => array(
                            array(
                                'key' => 'pagina_oculta',
                                'compare' => '=',
                                'value' => 0,
                                'type' => 'numeric',
                            ) 
                        )
                    )
                  );
        while ($loop->have_posts()) : $loop->the_post();
    ?> 
    <?php 
        $index++;
        $count++;
    ?>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php $resultado_page = $index; ?>

    <?php if ($resultado_page > 0) { ?>
    <section class="todas-noticias conteudos-salvos">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <p class="title">Conteúdos</p>
                </div>
            </div>
            <div class="row posts">
                <div class="col-md-6 offset-md-1">
                        <?php 
                            $loop = new WP_Query(array('post_type' => 'page',
                                        'orderby' => 'post_date',
                                        'order' => 'DESC',
                                        's' => $s,
                                        'meta_query' => array(
                                                array(
                                                    'key' => 'pagina_oculta',
                                                    'compare' => '=',
                                                    'value' => 0,
                                                    'type' => 'numeric',
                                                ) 
                                            )
                                        )
                                      );
                            while ($loop->have_posts()) : $loop->the_post();                     
                        ?>   

                        <div class="post">
                            <a href="<?php the_permalink(); ?>">
                                <div class="image-post" style="background-image: url('<?php the_field('imagem'); ?>');">
                                </div>

                                <div class="content-post">
                                    <div class="title-post">
                                        <?php the_title(); ?>
                                        <p class="data"><?php echo get_the_date(); ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>  

                    <?php endwhile; wp_reset_postdata(); ?>
                </div>  
            </div>   
        </div>
    </section>    
    <?php } ?>

     <?php 
        $index=0;
        $loop = new WP_Query(array('post_type' => 'post',
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    's' => $s,
                    'meta_query' => array(
                        array(
                            'key' => 'post_oculto',
                            'compare' => '=',
                            'value' => 0,
                            'type' => 'numeric',
                        ) 
                    ))
                  );
        while ($loop->have_posts()) : $loop->the_post();                     
        $categories = get_the_category();
        
        foreach ( $categories as $cat ) {
            $slug = $cat->slug;
            $name = $cat->name;
        }                                 
    ?>   
    <?php 
        $index++;
        $count++;
    ?>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php $resultado_noticia = $index; ?>
    <?php if ($resultado_noticia > 0) { ?>
    <section class="todas-noticias conteudos-salvos">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <p class="title">Notícias</p>
                </div>
            </div>
            <div class="row posts">
                <div class="col-md-6 offset-md-1">
                        <?php 
                            $loop = new WP_Query(array('post_type' => 'post',
                                        'orderby' => 'post_date',
                                        'order' => 'DESC',
                                        's' => $s,
                                        'meta_query' => array(
                                            array(
                                                'key' => 'post_oculto',
                                                'compare' => '=',
                                                'value' => 0,
                                                'type' => 'numeric',
                                            ) 
                                        ))
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
                                <div class="image-post" style='background-image: url("<?php echo $img; ?>");'>
                                </div>

                                <div class="content-post">
                                    <div class="categories <?php echo $slug; ?>">
                                        <?php echo $name; ?>
                                    </div>                                    
                                    <div class="title-post">
                                        <?php the_title(); ?>
                                        <p class="data"><?php echo get_the_date(); ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>  

                    <?php endwhile; wp_reset_postdata(); ?>
                </div>  
            </div>   
        </div>
    </section> 
    <?php } ?>

    <?php if($count == 0){ ?>
    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-md-5 offset-md-1">
                    <form role="search" method="get" id="form-open" class="search-form" action="/">
                        <p class="text-bottom">Não encontrou o que procurava? Tente outra palavra.</p>
                        <input type="text" placeholder="Digite o que você procura" name="s" id="main-search">
                        <button type="submit" class="search-submit">
                            <img class="icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/search-white.svg" alt="">
                        </button>
                    </form>   
                </div>
            </div>
        </div>
    </section>  
    <?php } ?>
</main>

<?php get_footer(); ?>