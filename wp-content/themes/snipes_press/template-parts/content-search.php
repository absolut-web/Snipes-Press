<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snipes_press
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-archive' ); ?> >
    <div class="article-archive__image list-image">
        <a class="list-image__link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
            <?php if ( has_post_thumbnail() ):
                the_post_thumbnail( 'medium_large', array( 'class' => 'list-image__image' ) );
            else:
                echo header_placeholder_image('list-image__image');
            endif; ?>
        </a>
    </div>
    <div class="article-archive__content list-content">
        <header class="list-content__header">
            <div class="list-content__meta ">
                <?php snipes_press_posted_on(); echo ' '; snipes_press_entry_footer(); ?>
            </div>
            <?php the_title( '<h2 class="list-content__title"><a href="'.esc_url( get_permalink() ).'" rel="bookmark">', '</a></h2>' ); ?>
        </header>
        <p class="list-content__excerpt">
            <?php
            the_content(
                sprintf(
                    wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'snipes_press' ),
                        array( 'span' => array( 'class' => array(), ), ) ),
                    wp_kses_post( get_the_title() )
                )
            );
            ?>
        </p>
    </div>
</article>



