<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snipes_press
 */

?>

<?php get_template_part( 'template-parts/post-header' ); ?>
<div class="section section--full-width section--search">
    <?php get_search_form(); ?>
</div>
<div class="section section--not-found">
    <?php
    if ( is_search() ) :
        ?>
        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'snipes_press' ); ?></p>
    <?php
    else :
        ?>
        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'snipes_press' ); ?></p>
    <?php
    endif;
    ?>
</div>

<div class="section">
    <?php echo query_latest_posts( '', 1 ); ?>
</div>