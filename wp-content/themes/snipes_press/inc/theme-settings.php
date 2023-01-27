<?php
/**
 * Cookies
 */
$cookie_consent           = htmlspecialchars( $_COOKIE["CookieConsent"] );
$cookie_consent_array     = explode( ",", $cookie_consent );
$cookie_consent_marketing = false;

foreach ( $cookie_consent_array as &$value ) {
    if ( str_contains( $value, 'marketing:true' ) ) {
        $cookie_consent_marketing = true;
    }
}


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
            'block'   => 'a',
            'classes' => 'button-look',
            'wrapper' => true
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


// Wrap YouTube videos
function vnmFunctionality_embedWrapper( $html, $url, $attr, $post_id ) {
    global $cookie_consent_marketing;
    $cookie_text = 'Dieser Inhalt wird durch YouTube bereitgestellt. <a href="javascript: Cookiebot.renew()">Erneuern oder ändern Sie Ihre Cookie-Einwilligung</a>.';

    if ( ICL_LANGUAGE_CODE === 'en' ) {
        $cookie_text = 'This content is provided by YouTube. <a href="javascript: Cookiebot.renew()">Renew or change your cookie consent</a>.';
    }

    if ( strpos( $html, 'youtube' ) !== false ) {

        if ( $cookie_consent_marketing ) {
            return '<div class="wp-video">' . preg_replace( '#src=(["\'])(https?:)?//(www\.)?youtube\.com#i', 'src=$1$2//$3youtube-nocookie.com', $html ) . '</div>';
        } else {
            return '<div class="wp-video"><div class="wp-video__inner">'.$cookie_text.'</div></div>';
        }


    } else {
        return $html;
    }


}

add_filter( 'embed_oembed_html', 'vnmFunctionality_embedWrapper', 10, 4 );


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
 * Random String
 */
function generate_random_string( $length = 5 ): string {
    $characters       = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen( $characters );
    $randomString     = '';
    for ( $i = 0; $i < $length; $i ++ ) {
        $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
    }

    return $randomString;
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
        $content = snipes_upper_lowercase_filter( $content );
    }

    return $content;
}

add_filter( 'the_content', 'trim_content' );


/**
 * Remove Category Prefix
 */
function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = snipes_upper_lowercase_filter( single_cat_title( '', false ) );
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
        'posts_per_page' => 3,
        'post_status'    => 'publish'
    );

    $posts_title = $posts_title ? strip_tags( $posts_title, '<span>' ) : 'latest <span class="colorize-orange">posts</span>';
    $posts_title = '<h2 class="post-block__title">' . snipes_upper_lowercase_filter( $posts_title ) . '</h2>';

    $modifier = $posts_style === 'regular' ? 'regular' : 'overlay';

    $category_link = $posts_style === 'regular' ? '<a class="post-block__link button-look" href="' . get_category_link( $posts_cat_id ) . '" rel="category tag">find out more</a>' : '';

    $post = '';

    $the_query = new WP_Query( $args );
    if ( ! $the_query->have_posts() ) {
        return '';
    } else {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $post_content = apply_filters( 'the_content', get_the_content() );
            $post_content = preg_replace( "/<h1(.*)>(.*)<\/h1>/", "", $post_content );
            //$post_content = strip_tags($post_content, '<span><stron>');
            $post_content = ( strlen( $post_content ) <= 100 ) ? $post_content : wp_html_excerpt( $post_content, 100 ) . '...';
            $post_image   = has_post_thumbnail() ? get_the_post_thumbnail( '', 'medium_large', array( 'class' => 'latest-post__image latest-post__image--' . $modifier ) ) : header_placeholder_image( 'latest-post__image latest-post__image--' . $modifier );

            if ( $posts_style === 'regular' ):
                $post .= '<article class="post-list__item latest-post latest-post--regular">';
                $post .= '<a aria-label="Read more about ' . snipes_upper_lowercase_filter( get_the_title() ) . '" class="latest-post__image-link" href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">' . $post_image . '</a>';
                $post .= '<h3 class="latest-post__title">' . snipes_upper_lowercase_filter( get_the_title() ) . '</h3>';
                $post .= '<p class="latest-post__excerpt">' . snipes_upper_lowercase_filter( $post_content ) . '</p>';
                $post .= '<a aria-label="Read more about ' . snipes_upper_lowercase_filter( get_the_title() ) . '" class="latest-post__link" href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">Read More</a>';
            else:
                $post .= '<article class="post-list__item latest-post latest-post--overlay">';
                $post .= $post_image;
                $post .= '<h3 class="latest-post__title latest-post__title--overlay">' . snipes_upper_lowercase_filter( get_the_title() ) . '</h3>';
                $post .= '<a aria-label="Read more about ' . snipes_upper_lowercase_filter( get_the_title() ) . '" class="latest-post__link latest-post__link--overlay button-look colorize-orange" href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">Read More</a>';
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
        $class .= 'section section--two-columns';
    elseif ( get_row_layout() === 'column_third' ):
        $class .= 'section section--three-columns';
    elseif ( get_row_layout() === 'column_sidebar' ):
        $class .= 'section section--sidebar';
    else:
        $class .= 'section';
    endif;

    //$class .= get_sub_field( 'layout_settings_full_width' ) ? ' section--full-width' : '';
    $class .= get_sub_field( 'layout_settings_background_image' ) ? ' section--background-image' : '';
    $class .= get_sub_field( 'layout_settings_background_color' ) ? ' section--background-color' : '';

    $width   = get_sub_field( 'layout_settings_section_width' );
    $reverse = get_sub_field( 'layout_settings_reverse' );

    if ( $reverse ):
        $class .= ' section--mobile-reverse';
    endif;

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

            $styles .= $padding_top || $padding_top === '0' ? 'padding-top:' . $padding_top / 16 . 'rem; ' : '';
            $styles .= $padding_right || $padding_right === '0' ? 'padding-right:' . $padding_right / 16 . 'rem; ' : '';
            $styles .= $padding_bottom || $padding_bottom === '0' ? 'padding-bottom:' . $padding_bottom / 16 . 'rem; ' : '';
            $styles .= $padding_left || $padding_left === '0' ? 'padding-left:' . $padding_left / 16 . 'rem; ' : '';

        endwhile;
    endif;
    if ( have_rows( 'layout_settings_margin' ) ):
        while ( have_rows( 'layout_settings_margin' ) ) : the_row();

            $margin_top    = get_sub_field( 'margin_top' );
            $margin_right  = get_sub_field( 'margin_right' );
            $margin_bottom = get_sub_field( 'margin_bottom' );
            $margin_left   = get_sub_field( 'margin_left' );

            $styles .= $margin_top || $margin_top === '0' ? 'margin-top:' . $margin_top / 16 . 'rem; ' : '';
            $styles .= $margin_right || $margin_right === '0' ? 'margin-right:' . $margin_right / 16 . 'rem; ' : '';
            $styles .= $margin_bottom || $margin_bottom === '0' ? 'margin-bottom:' . $margin_bottom / 16 . 'rem; ' : '';
            $styles .= $margin_left || $margin_left === '0' ? 'margin-left:' . $margin_left / 16 . 'rem; ' : '';

        endwhile;
    endif;


    $vertical_align = get_sub_field( 'layout_settings_vertical_align' );
    $styles         .= $vertical_align === 'center' ? 'align-items:center; ' : '';

    if ( get_sub_field( 'layout_settings_background_color' ) ):
        $styles .= 'background-color:' . get_sub_field( 'layout_settings_background_color' ) . '; ';
    endif;


    if ( $styles !== '' ):
        $styles = 'style="' . $styles . '"';
    endif;

    return 'class="' . $class . '"' . $styles;
}


/**
 * Related Gallery
 */

function show_related_gallery( $post_id ): string {
    $post        = get_post( $post_id );
    $post_blocks = parse_blocks( $post->post_content );

    if ( ICL_LANGUAGE_CODE === 'de' ) {
        $post_link = '<div class="preview-links__item"><a class="button-look button-look--full-width" rel="bookmark" href="' . get_permalink( $post_id ) . '">Zur Galerie</a></div>';
    } else {
        $post_link = '<div class="preview-links__item"><a class="button-look button-look--full-width" rel="bookmark" href="' . get_permalink( $post_id ) . '">To Gallery</a></div>';
    }
    $download_all = '';

    $output = '';

    $counter = 1;
    foreach ( $post_blocks as $block ):
        if ( isset( $block['attrs']['data'] ) ):
            $block = $block['attrs']['data'];

            foreach ( $block as $key => $value ): // Images
                if ( "image_gallery" === substr( $key, - 13 ) ):
                    if ( is_array( $value ) || is_object( $value ) ):

                        foreach ( $value as $image ):
                            $output .= '<div class="preview-gallery__item">' . wp_get_attachment_image( $image, 'gallery_thumb', array( 'class' => 'related-media__image' ) ) . '</div>';
                            if ( $counter == 4 ):
                                break;
                            endif;
                            $counter ++;
                        endforeach;

                    endif;
                    if ( $counter == 5 ):
                        break;
                    elseif ( $counter == 1 ):
                        return '';
                    endif;
                endif;
            endforeach;

            foreach ( $block as $key => $value ): // Download Link File
                if ( "download_file" === substr( $key, - 13 ) ):
                    $download_all .= '<div class="preview-links__item"><a class="button-look button-look--full-width" href="' . wp_get_attachment_url( $value ) . '" download>';
                    break;
                endif;
            endforeach;

            foreach ( $block as $key => $value ): // Download Link Text
                if ( "download_title" === substr( $key, - 14 ) ) {
                    if ( ICL_LANGUAGE_CODE !== 'de' ) {
                        $value = str_replace( [ 'Alle downloaden', 'Alle Downloaden' ], 'Download all', $value );
                    }

                    $download_all .= $value . '</a></div>';
                    break;
                }
            endforeach;

        endif;
    endforeach;

    return '<div class="related-media"><div class="related-media__gallery preview-gallery">' . $output . '</div><div class="related-media__links preview-links">' . $post_link . $download_all . '</div></div>';
}

function add_category_filter( $parent_category = 1 ): string {

    $current_category = get_queried_object_id();
    $categories       = get_categories( array(
        'orderby' => 'ID',
        'order'   => 'ASC'
    ) );

    $check_array = array();
    $output      = '';

    foreach ( $categories as $category ) {
        if ( $category->cat_ID == $parent_category || $category->parent == $parent_category ) {
            $check_array[] = $category->cat_ID; // Add to Array


            $category_link = sprintf(
                '<a class="button-look button-look--border %1$s" href="%2$s" alt="%3$s">%4$s</a>',
                esc_html( $current_category == $category->cat_ID && $current_category != $parent_category ? 'button-look--border-active' : '' ),
                esc_url( get_category_link( $category->term_id ) ),
                esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), snipes_upper_lowercase_filter( $category->name ) ) ),
                esc_html( $category->cat_ID == $parent_category ? 'Alle' : snipes_upper_lowercase_filter( $category->name ) )

            );
            $output        .= '<li class="post-filter__item">' . $category_link . '</li>';
        }
    }

    if ( ! in_array( $current_category, $check_array ) ) {
        return '';
    } else {
        return '<div class="section section--full-width section--search"><ul class="post-filter">' . $output . ' </ul></div>';
    }

}


// TODO Category Layout -> Grid / Column ----- Layout Class Background