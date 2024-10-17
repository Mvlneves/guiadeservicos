<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$category = get_queried_object();
if($category->taxonomy == 'categorias_comercio'){
    include(locate_template('archive-comercios.php'));
}else{
    include(locate_template('archive-posts.php'));
}

?>

<?php get_footer(); ?>