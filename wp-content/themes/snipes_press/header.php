<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package snipes_press
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ec6409">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src=https://www.googletagmanager.com/gtag/js?id=G-BK090W84Y5></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-BK090W84Y5');
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-9319103-26"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-9319103-26');
    </script>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader visually-hidden"
   href="#primary"><?php esc_html_e( 'Skip to content', 'snipes_press' ); ?></a>
<header class="header">
    <div class="header__logo">
        <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img class="logo__image" width="120" height="42"
                 src="<?php bloginfo( 'template_directory' ); ?>/media/snipes-logo.svg"
                 alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        </a>
    </div>
    <div class="header__menu site-menu">
        <button class="site-menu__button site-menu-button" aria-controls="primary-menu"
                aria-expanded="false"><?php esc_html_e( 'Menu', 'snipes_press' ); ?>
            <span class="site-menu-button__icon"></span>
        </button>
        <nav class="site-menu__container">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'menu_class'     => 'menu-list',
                'container'      => ''
            ) );
            ?>

        </nav>
    </div>

    <div class="header__lang-switch lang-switch">
        <button class="lang-switch__button lang-button" aria-label="Select Language" type="button"
                aria-controls="language-switch-menu"
                aria-expanded="false">
            <?php if ( ICL_LANGUAGE_CODE === 'de' ):
                echo '<span>DE</span> <img width="24" height="18" src="' . get_template_directory_uri() . '/media/flags/de.svg" alt="Flag of Germany" class="lang-button__flag">';
            elseif ( ICL_LANGUAGE_CODE === 'en' ):
                echo '<span>EN</span> <img width="24" height="18" src="' . get_template_directory_uri() . '/media/flags/gb.svg" alt="Flag of Great Britain" class="lang-button__flag">';
            endif;
            ?>
        </button>

        <div class="lang-switch__menu visually-hidden" id="language-switch-menu">
            <?php do_action( 'wpml_add_language_selector' ); ?>
        </div>

    </div>
</header>
