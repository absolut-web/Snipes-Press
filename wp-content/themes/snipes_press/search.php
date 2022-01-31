<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package snipes_press
 */

get_header();
?>
    <main id="primary" class="site-main">
        <?php if ( have_posts() ) : ?>
            <?php get_template_part( 'template-parts/post-header' ); ?>
            <div class="section section--full-width section--search">
                <?php get_search_form(); ?>
            </div>
            <div class="section">
                <?php while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', 'search' );
                endwhile;
                the_posts_navigation(); ?>
            </div>
        <?php else :
            get_template_part( 'template-parts/content', 'none' );
        endif;
        ?>
    </main>
<?php
get_footer();