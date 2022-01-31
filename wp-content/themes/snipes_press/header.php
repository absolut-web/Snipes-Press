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
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
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

    <div class="header__lang-switch lang-select">


        <div class="page-menu__lang lang-select">
            <button class="lang-select__button" type="button">
                <span>DE</span>
                <img width="20" height="15" src="<?php bloginfo( 'template_directory' ); ?>/media/icons/flag-gb.svg" alt="German"></button>

            <div class="lang-select__alternate visually-hidden">
                <a href="?lang=pl"><span>EN</span>
                    <img width="20" height="15" src="<?php bloginfo( 'template_directory' ); ?>/media/icons/flag-pl.svg" alt="English">
                </a>
            </div>
        </div>


    </div>
</header>
