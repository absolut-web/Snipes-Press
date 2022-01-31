<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snipes_press
 */

?>



<?php if ( is_singular() ) : ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'article-single' ); ?> >
        <?php get_template_part( 'template-parts/post-header' ); ?>
        <div class="article__content entry-content">
            <?php
            the_content(
                sprintf(
                    wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'snipes_press' ),
                        array( 'span' => array( 'class' => array(), ), ) ),
                    wp_kses_post( get_the_title() )
                )
            );
            ?>
        </div>
    </article>
<?php else : ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'article-archive' ); ?> >
        <div class="article-archive__image list-image">
            <a aria-label="Read more about <?php echo get_the_title(); ?>" class="list-image__link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
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
                    <?php
                    snipes_press_posted_on();
                    ?>
                </div>
                <?php the_title( '<h2 class="list-content__title">', '</h2>' ); ?>
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
            <a aria-label="Read more about <?php echo get_the_title(); ?>" class="list-content__link button-look" href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark">Read
                More</a>
        </div>
    </article>
<?php endif; ?>
