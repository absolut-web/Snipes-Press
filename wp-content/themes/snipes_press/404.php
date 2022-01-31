<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package snipes_press
 */

get_header();
?>
    <main id="primary" class="site-main">
        <?php get_template_part( 'template-parts/post-header' ); ?>
        <div class="section section--not-found">
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'snipes_press' ); ?></p>
            <?php get_search_form(); ?>
        </div>

        <div class="section">
            <?php echo query_latest_posts( '', 1 ); ?>
        </div>
    </main>
<?php
get_footer();
