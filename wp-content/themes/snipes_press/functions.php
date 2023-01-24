<?php
/**
 * snipes_press functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package snipes_press
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

if (!function_exists('snipes_press_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function snipes_press_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on snipes_press, use a find and replace
         * to change 'snipes_press' to the name of your theme in all the template files.
         */
        load_theme_textdomain('snipes_press', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'primary' => esc_html__('Primary', 'snipes_press'),
                'footer' => esc_html__('Footer', 'snipes_press')
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        add_image_size('gallery_thumb', 1000, 570, true);

    }
endif;
add_action('after_setup_theme', 'snipes_press_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function snipes_press_content_width()
{
    $GLOBALS['content_width'] = apply_filters('snipes_press_content_width', 1400);
}

add_action('after_setup_theme', 'snipes_press_content_width', 0);


/**
 * Enqueue scripts and styles.
 */
function snipes_press_scripts()
{
    wp_enqueue_style('snipes_press-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_dequeue_style('wp-block-library');
    wp_style_add_data('snipes_press-style', 'rtl', 'replace');

    wp_enqueue_script('snipes_press-navigation', get_template_directory_uri() . '/js/index.js', array(), _S_VERSION, true);
//Use for timeline plugin
 //   wp_deregister_script('jquery');
    wp_deregister_script('wp-embed');


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'snipes_press_scripts');

function snipes_upper_lowercase_filter($txt) {
    $txt = str_replace('snipes', 'SNIPES', $txt);

    return $txt;
}

function title_filter($txt) {
    //if(is_single() && 'post' == get_post_type()) {
        return snipes_upper_lowercase_filter($txt);
    //}

    return $txt;
}
add_filter('the_title', 'title_filter');
add_filter('get_the_title', 'title_filter');

function wpdocs_filter_wp_title($title, $sep) {
    return snipes_upper_lowercase_filter($title);
}
add_filter('wp_title', 'wpdocs_filter_wp_title', 10, 2);

function content_filter($txt) {
    if(is_singular() && in_the_loop() && is_main_query()) {
        return snipes_upper_lowercase_filter($txt);
    }

    return $txt;
}
//add_filter('the_content', 'content_filter');

function wpa_filter_nav_menu_objects($items) {
    foreach($items as $item) {
        $item->title = snipes_upper_lowercase_filter($item->title);
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'wpa_filter_nav_menu_objects');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Theme Settings.
 */
require get_template_directory() . '/inc/theme-settings.php';

/**
 * ACF Setting.
 */
require get_template_directory() . '/inc/acf-settings.php';
