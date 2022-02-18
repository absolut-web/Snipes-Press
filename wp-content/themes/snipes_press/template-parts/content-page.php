<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snipes_press
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>

    <?php get_template_part( 'template-parts/post-header' ); ?>


    <div class="article__content">
        <?php
        the_content();

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'snipes_press' ),
                'after'  => '</div>',
            )
        );
        ?>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
