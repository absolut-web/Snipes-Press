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
            $post_categories = wp_get_post_categories( get_the_ID() );


            if ( $post_categories[0] != '3' && $post_categories[0] != '16') : ?>
                <div class="section section--content-meta">
                    <?php
                    snipes_press_posted_on();
                    ?>
                </div>
            <?php endif; ?>

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

    <?php
    $category_layout  = get_field( 'category_layout', get_queried_object() );
    $read_more        = 'Read More';
    $custom_read_more = get_field( 'category_read_more', get_queried_object() );
    if ( $custom_read_more ) {
        $read_more = $custom_read_more;
    }

    if ( $category_layout === 'tile' ): ?>

        <article
                id="post-<?php the_ID(); ?>" <?php post_class( 'article-archive article-archive--tile tile-item' ); ?> >
            <?php if ( has_post_thumbnail() ):
                the_post_thumbnail( 'medium_large', array( 'class' => 'tile-item__image' ) );
            else:
                echo header_placeholder_image( 'tile-item__image' );
            endif; ?>
            <?php the_title( '<h2 class="tile-item__title">', '</h2>' ); ?>
            <a aria-label="Read more about <?php echo get_the_title(); ?>" class="tile-item__link button-look"
               href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php echo $read_more; ?></a>
        </article>

    <?php else : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'article-archive' ); ?> >
            <div class="article-archive__image list-image">
                <a aria-label="Read more about <?php echo get_the_title(); ?>" class="list-image__link"
                   href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                    <?php if ( has_post_thumbnail() ):
                        the_post_thumbnail( 'medium_large', array( 'class' => 'list-image__image' ) );
                    else:
                        echo header_placeholder_image( 'list-image__image' );
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
                    <?php if ( get_field( 'sub_title' ) ): ?>
                        <span class="list-content__subtitle"><?php echo snipes_upper_lowercase_filter(get_field( 'sub_title' )) ?></span>
                    <?php endif; ?>
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
                <a aria-label="Read more about <?php echo get_the_title(); ?>" class="list-content__link button-look"
                   href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php echo $read_more; ?></a>
            </div>
        </article>
    <?php endif; ?>
<?php endif; ?>
