<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snipes_press
 */

get_header();
?>
    <main id="primary" class="site-main">
        <?php
        if (have_posts()) :
        get_template_part('template-parts/post-header');

        if (ICL_LANGUAGE_CODE === 'de') {
            echo add_category_filter(1);
        } elseif (ICL_LANGUAGE_CODE === 'en') {
            echo add_category_filter(6);
        }

        the_archive_description('<div class="section section--archive-description">', '</div>');
        $category_layout = get_field('category_layout', get_queried_object());
        ?>
        <div class="section section--archive archive-listing<?php echo $category_layout === 'tile' ? ' archive-listing--tile' : '' ?>">
            <?php while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', get_post_type());
            endwhile;
            the_posts_navigation();
            echo '</div>';
            else :
                get_template_part('template-parts/content', 'none');
            endif; ?>
    </main>
<?php
get_footer();
