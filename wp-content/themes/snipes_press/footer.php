<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package snipes_press
 */

?>
<footer id="colophon" class="site-footer">

    <div class="site-footer__inner">
        <?php wp_nav_menu( array(
            'theme_location' => 'footer',
            'menu_id'        => '',
            'menu_class'     => 'site-footer__menu footer-menu',
            'container'      => ''
        ) ); ?>

        <ul class="site-footer__social social-menu">
            <li class="social-menu__item social-menu__item--instagram">
                <a aria-label="Instagram" rel="noopener nofollow" href="https://www.instagram.com/snipes/">Instagram</a>
            </li>
            <li class="social-menu__item social-menu__item--youtube">
                <a aria-label="YouTube" rel="noopener nofollow" href="https://www.youtube.com/user/snipes">YouTube</a>
            </li>
            <li class="social-menu__item social-menu__item--tiktok">
                <a aria-label="TikTok" rel="noopener nofollow" href="https://www.tiktok.com/@snipesknows?lang=en">TikTok</a>
            </li>
            <li class="social-menu__item social-menu__item--facebook">
                <a aria-label="Facebook" rel="noopener nofollow" href="https://www.facebook.com/Snipes.com/">Facebook</a>
            </li>
            <li class="social-menu__item social-menu__item--spotify">
                <a aria-label="Spotify" rel="noopener nofollow" href="https://open.spotify.com/user/snipesshop">Spotify</a>
            </li>
        </ul>

        <div class="site-footer__info site-info">
            © <?php echo date("Y"); ?> SNIPES
        </div>
    </div>

</footer>
<?php wp_footer(); ?>
</body>
</html>
