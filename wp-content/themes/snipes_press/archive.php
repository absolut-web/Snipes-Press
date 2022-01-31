<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snipes_press
 */

get_header();
?>
    <main id="primary" class="site-main">
        <?php
        if ( have_posts() ) :
            get_template_part( 'template-parts/post-header' );
        ?>
        <div class="section section--archive">
            <?php while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content', get_post_type() );
        endwhile;
            the_posts_navigation();
            echo '</div>';
        else :
            get_template_part( 'template-parts/content', 'none' );
        endif; ?>
    </main>
<?php
get_footer();
