<?php
/**
 * The template for displaying 404 page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

	get_header();
?>

<main class="internas error">
    <section class="404">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-error" src="<?php echo get_template_directory_uri(); ?>/assets/images/404.png">
                </div>
                <div class="col-md-6">
                    <p class="title">Erro 404</p>
                    <p class="subtitle">OPS!</p>
                    <p class="content">A página que você procura não foi encontrada. Que tal fazer uma nova busca?</p>
                    <form role="search" method="get" id="form-open" class="search-form" action="/">
                        <input type="text" placeholder="Digite o que você procura" name="s" id="main-search">
                        <button type="submit" class="search-submit">
                            <img class="icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/search-white.svg" alt="">
                        </button>
                    </form>                
                    <a href="/">Quero voltar para a página inicial</a>      
                </div>
            </div>
        </div>
    </section>    
</main>

<?php get_footer(); ?>
