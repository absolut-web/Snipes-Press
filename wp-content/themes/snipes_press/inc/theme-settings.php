<?php
/**
 * Allow SVG
 */
function custom_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

add_filter( 'upload_mimes', 'custom_mime_types' );


/**
 * Remove H4, H5, and other extraneous styles from the visual editor (Default: p,address,pre,h1,h2,h3,h4,h5,h6)
 */

function customize_mce_styles( $init ) {
    $init['block_formats'] = "Paragraph=p; h1=h1; h2=h2; h3=h3 h4=h4";

    return $init;
}

add_filter( 'tiny_mce_before_init', 'customize_mce_styles' );


/**
 * Custom MCE Classes
 */
function custom_mce_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );

    return $buttons;
}

add_filter( 'mce_buttons_2', 'custom_mce_buttons' );

function add_formats( $init_array ) {
    $style_formats               = array(
        array(
            'title'   => 'Button-link',
            'block'   => '',
            'classes' => 'button-look',
            'wrapper' => false
        ),

        array(
            'title'   => 'Enumeration',
            'block'   => 'span',
            'classes' => 'enumeration',
            'wrapper' => true
        )

    );
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;
}

add_filter( 'tiny_mce_before_init', 'add_formats' );


/**
 * Add Sub Menu Classes to Primary
 */
function add_primary_menu_classes( $classes, $args, $depth ) {
    if ( 'primary' == $args->theme_location && $depth == 0 ) {
        $classes[] = 'sub-menu--second-level';
    }
    if ( 'primary' == $args->theme_location && $depth == 1 ) {
        $classes[] = 'sub-menu--third-level';
    }

    return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'add_primary_menu_classes', 10, 3 );


/**
 * Add Sub Menu Classes for Footer
 */
function add_footer_menu_classes( $classes, $args, $depth ) {
    if ( 'footer' == $args->theme_location && $depth == 0 ) {
        $classes[] = 'sub-menu--second-level';
    }
    if ( 'primary' == $args->theme_location && $depth == 1 ) {
        $classes[] = 'sub-menu--third-level';
    }

    return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'add_footer_menu_classes', 10, 3 );


/**
 * Add Span to Sub Menu in Primary
 */
function add_primary_menu_spans( $item_output, $item, $depth, $args ) {
    if ( 'primary' == $args->theme_location && $depth == 0 ) {
        if ( in_array( 'menu-item-has-children', $item->classes ) ) {
            $item_output .= '<button aria-label="Sub Navigation" type="button" class="nav-menu__expand"><svg class="nav-menu__expand-icon" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16"><path d="M8.503,12.506L8.503,12.506c-0.202,0-0.396-0.08-0.539-0.224L1.483,5.799c-0.298-0.298-0.298-0.781,0-1.078c0.297-0.297,0.78-0.297,1.077,0l5.943,5.944l5.944-5.944c0.298-0.297,0.779-0.297,1.077,0c0.298,0.298,0.298,0.78,0,1.078l-6.482,6.483C8.899,12.426,8.706,12.506,8.503,12.506z"></path></svg></button>';
        }
    }

    return $item_output;
}

add_filter( 'walker_nav_menu_start_el', 'add_primary_menu_spans', 10, 4 );


/**
 * Disable the emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 *
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }

    return $urls;
}

/**
 * Placeholder
 */

function header_placeholder_image( $image_class = 'article-header__image' ): string {
    return '<picture>
            <source srcset=" ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash.webp 1920w,
             ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-300x169.webp 300w,
             ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-1024x576.webp 1024w,
             ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-768x432.webp 768w,
             ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-1536x864.webp 1536w"
                    sizes="(max-width: 1920px) 100vw, 1920px" type="image/webp">
            <img width="1920" height="1080"
                 src=" ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash.jpg"
                 class="' . $image_class . ' wp-post-image webpexpress-processed" alt="" loading="lazy"
                 srcset=" ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash.jpg 1920w,
                  ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-300x169.jpg 300w,
                  ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-1024x576.jpg 1024w,
                  ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-768x432.jpg 768w,
                  ' . wp_get_upload_dir()['baseurl'] . '/2022/01/max-van-den-oetelaar-uymG7UVPXpI-unsplash-1536x864.jpg 1536w"
                 sizes="(max-width: 1920px) 100vw, 1920px">
        </picture>';
}


/**
 * Add Backend Styles
 */
function add_backend_style() {
    echo '<style>.wp-block {max-width: 1400px;} .button-link{display: inline-block; padding: 10px; background:#df3f0d; }</style>';
}

add_action( 'admin_head', 'add_backend_style' );


/**
 * Trim Content Text
 */
function trim_content( $content ) {
    if ( is_archive() || is_search() ) {
        $content = preg_replace( "/<h1(.*)>(.*)<\/h1>/", "", $content );
        $content = ( strlen( $content ) <= 180 ) ? $content : wp_html_excerpt( $content, 180 ) . '...';
    }

    return $content;
}

add_filter( 'the_content', 'trim_content' );


/**
 * Remove Category Prefix
 */
function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }

    return $title;
}

add_filter( 'get_the_archive_title', 'prefix_category_title' );

/**
 * Query Latest posts
 */

function query_latest_posts( $posts_title, $posts_cat_id, $posts_number = 3, $posts_style = 'regular' ): string {

    $args = array(
        'cat'            => $posts_cat_id,
        'orderby'        => 'post_date',
        'order'          => 'DESC',
        'posts_per_page' => $posts_number,
        'post_status'    => 'publish'
    );

    $posts_title = $posts_title ? strip_tags( $posts_title, '<span>' ) : 'Latest <span class="colorize-orange">posts</span>';
    $posts_title = '<h2 class="post-block__title">' . $posts_title . '</h2>';

    $modifier = $posts_style === 'regular' ? 'regular' : 'overlay';

    $category_link = $posts_style === 'regular' ? '<a class="post-block__link button-look" href="' . get_category_link( $posts_cat_id ) . '" rel="category tag">Find out more</a>' : '';

    $post = '';

    $the_query = new WP_Query( $args );
    if ( ! $the_query->have_posts() ) {
        return '';
    } else {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $post_content = apply_filters( 'the_content', get_the_content() );
            $post_content = preg_replace( "/<h1(.*)>(.*)<\/h1>/", "", $post_content );
            $post_content = ( strlen( $post_content ) <= 100 ) ? $post_content : wp_html_excerpt( $post_content, 100 ) . '...';

            $post_image = has_post_thumbnail() ? get_the_post_thumbnail( '', 'medium_large', array( 'class' => 'latest-post__image latest-post__image--' . $modifier ) ) : header_placeholder_image( 'latest-post__image latest-post__image--' . $modifier );

            if ( $posts_style === 'regular' ):
                $post .= '<article class="post-list__item latest-post latest-post--regular">';
                $post .= '<a aria-label="Read more about ' . get_the_title() . '" class="latest-post__image-link" href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">' . $post_image . '</a>';
                $post .= '<h3 class="latest-post__title">' . get_the_title() . '</h3>';
                $post .= '<p class="latest-post__excerpt">' . $post_content . '</p>';
                $post .= '<a aria-label="Read more about ' . get_the_title() . '" class="latest-post__link" href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">Read More</a>';
            else:
                $post .= '<article class="post-list__item latest-post latest-post--overlay">';
                $post .= $post_image;
                $post .= '<h3 class="latest-post__title latest-post__title--overlay">' . get_the_title() . '</h3>';
                $post .= '<a aria-label="Read more about ' . get_the_title() . '" class="latest-post__link latest-post__link--overlay button-look colorize-orange" href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">Read More</a>';
            endif;
            $post .= '</article>';

        }

    }
    wp_reset_postdata();

    return '<div class="post-block">' . $posts_title . '<div class="post-list post-list--' . $modifier . ' "> ' . $post . '</div>' . $category_link . '</div>';
}

/**
 * Section Styles (Only for layout-block.php)
 */

function add_section_styles(): string {

    $class = '';

    if ( get_row_layout() === 'column_full' ):
        $class .= 'section';
    elseif ( get_row_layout() === 'column_half' ):
        $class .= 'section section--half';
    elseif ( get_row_layout() === 'column_third' ):
        $class .= 'section section--third';
    elseif ( get_row_layout() === 'column_sidebar' ):
        $class .= 'section section--sidebar';
    else:
        $class .= 'section';
    endif;

    //$class .= get_sub_field( 'layout_settings_full_width' ) ? ' section--full-width' : '';
    $class .= get_sub_field( 'layout_settings_background_image' ) ? ' section--background-image' : '';

    $width = get_sub_field( 'layout_settings_section_width' );

    if ( $width === 'small' ):
        $class .= ' section--small';
    elseif ( $width === 'full' ):
        $class .= ' section--full-width';
    endif;

    $styles = '';
    if ( have_rows( 'layout_settings_padding' ) ):
        while ( have_rows( 'layout_settings_padding' ) ) : the_row();

            $padding_top    = get_sub_field( 'padding_top' );
            $padding_right  = get_sub_field( 'padding_right' );
            $padding_bottom = get_sub_field( 'padding_bottom' );
            $padding_left   = get_sub_field( 'padding_left' );

            $styles .= $padding_top ? 'padding-top:' . $padding_top / 16 . 'rem; ' : '';
            $styles .= $padding_right ? 'padding-right:' . $padding_right / 16 . 'rem; ' : '';
            $styles .= $padding_bottom ? 'padding-bottom:' . $padding_bottom / 16 . 'rem; ' : '';
            $styles .= $padding_left ? 'padding-left:' . $padding_left / 16 . 'rem; ' : '';

        endwhile;
    endif;
    if ( have_rows( 'layout_settings_margin' ) ):
        while ( have_rows( 'layout_settings_margin' ) ) : the_row();

            $margin_top    = get_sub_field( 'margin_top' );
            $margin_right  = get_sub_field( 'margin_right' );
            $margin_bottom = get_sub_field( 'margin_bottom' );
            $margin_left   = get_sub_field( 'margin_left' );

            $styles .= $margin_top ? 'margin-top:' . $margin_top / 16 . 'rem; ' : '';
            $styles .= $margin_right ? 'margin-right:' . $margin_right / 16 . 'rem; ' : '';
            $styles .= $margin_bottom ? 'margin-bottom:' . $margin_bottom / 16 . 'rem; ' : '';
            $styles .= $margin_left ? 'margin-left:' . $margin_left / 16 . 'rem; ' : '';

        endwhile;
    endif;

    if ( $styles !== '' ):
        $styles = 'style="' . $styles . '"';
    endif;

    return 'class="' . $class . '"' . $styles;
}
