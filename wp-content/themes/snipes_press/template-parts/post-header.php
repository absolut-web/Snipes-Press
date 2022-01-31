<?php $post_title = get_field( 'post_title' ); ?>

<header class="article__header article-header <?php echo is_singular() && $post_title ? 'article-header--no-title' : '';?>">
    <?php if ( is_singular() ):

        if ( ! $post_title ):
            the_title( '<span class="article-header__title">', '</span>' );
        endif;
        if ( has_post_thumbnail() ):
            the_post_thumbnail( 'full', array( 'class' => 'article-header__image' ) );
        else:
            echo header_placeholder_image('article-header__image');
        endif;
        if ( get_post_type() === 'post' ) : ?>
        <?php endif;

    elseif ( is_404() ): ?>

        <h1 class="article-header__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'snipes_press' ); ?></h1>
        <?php echo header_placeholder_image('article-header__image');

    elseif ( is_search() ): ?>

        <h1 class="article-header__title"><?php printf( esc_html__( 'Search Results for: %s', 'snipes_press' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        <?php echo header_placeholder_image('article-header__image');

    elseif ( is_archive() ): ?>

        <?php
        the_archive_title( '<h1 class="article-header__title">', '</h1>' );
        the_archive_description( '<div class="article-header__description">', '</div>' );
        $category_image = get_field( 'category_image', get_queried_object() );
        if ( $category_image ):
            echo wp_get_attachment_image( $category_image, 'full', '', array( 'class' => 'article-header__image' ) );
        else:
            echo header_placeholder_image('article-header__image');
        endif;

    else: ?>

        <h1 class="article-header__title"><?php esc_html_e( 'Nothing Found', 'snipes_press' ); ?></h1>
        <?php echo header_placeholder_image('article-header__image');

    endif; ?>
</header>