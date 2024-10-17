<?php if (have_posts()) : ?>

    <main class="internas">
        <section class="banner">
            <div class="img-banner" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/banner-padrao.jpg)">
                <div class="content-banner">
                    <p class="title"><?php echo $category->name; ?></p>
                </div>
            </div>
        </section>

        <section class="infos-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-11 offset-1">
                        <div class="breadcrumb">
                            <a href="/">Home ></a>
                            <?php if (get_field('breadcrumb')) { ?>
                                <a href="<?php the_field('breadcrumb'); ?>"><?php the_field('titulo_pagina'); ?></a>
                            <?php } ?>
                            <?php echo $category->name; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-1">
                        <p class="title">Seu portal de informações de Alphaville e região!</p>
                        <div class="content-second">
                            Confira todas as novidades da região em um único lugar! 
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mais-lidas">
            <div class="container">
                <div class="row">
                    <div class="col-md-11 offset-1">
                        <p class="title">Mais lidas</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="carousel-posts">
                            <?php
                            $loop = new WP_Query(
                                array(
                                    'post_type' => 'post',
                                    'orderby' => 'post_date',
                                    'order' => 'DESC',
                                    'posts_per_page' => 8,
                                    'cat' => $category->term_id,
                                    'meta_query' => array(
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
                                foreach ($categories as $cat) {
                                    $slug = $cat->slug;
                                    $name = $cat->name;
                                }
                            ?>

                                <div class="posts-cell">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        $img = get_the_post_thumbnail_url();
                                    }
                                    ?>
                                    <div class="image-post" style='background-image: url("<?php echo $img; ?>");'>
                                    </div>

                                    <div class="comparts">
                                        <div class="like">
                                            <?php echo get_simple_likes_button(get_the_ID()); ?>
                                        </div>
                                        <div class="salvar-post">
                                            <?php echo get_read_later(get_the_ID()); ?>
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
                                        <div class="time">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/share/curtir_share_salvar_tempo-10.png"><?php the_field('tempo'); ?> min
                                        </div>
                                    </div>

                                    <a href="<?php the_permalink(); ?>">
                                        <div class="categories <?php echo $slug; ?>">
                                            <?php echo $name; ?>
                                        </div>

                                        <div class="title-post">
                                            <?php the_title(); ?>
                                        </div>

                                        <div class="content-post">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </a>
                                </div>

                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="todas-noticias">
            <div class="container">
                <div class="row">
                    <div class="col-md-11 offset-1">
                        <p class="title">Últimas notícias</p>
                    </div>
                </div>

                <div class="row posts posts-interno">
                    <div class="col-md-10 offset-1">
                        <?php
                        $loop = new WP_Query(
                            array(
                                'post_type' => 'post',
                                'orderby' => 'post_date',
                                'order' => 'DESC',
                                'posts_per_page' => 12,
                                'cat' => $category->term_id
                            )
                        );
                        while ($loop->have_posts()) : $loop->the_post();

                            $categories = get_the_category();
                            foreach ($categories as $cat) {
                                $slug = $cat->slug;
                                $name = $cat->name;
                            }
                        ?>

                            <div class="post">
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
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
                                        </div>
                                    </div>
                                </a>
                            </div>

                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php endif; ?>