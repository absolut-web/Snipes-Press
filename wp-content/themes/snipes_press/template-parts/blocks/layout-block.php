<?php
$id = 'layout-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'layout';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}


if (have_rows('layout')):
    while (have_rows('layout')) : the_row(); ?>
        <?php if (get_row_layout() == 'column_full'): // One Column ?>
            <div <?php echo add_section_styles(); ?>>
                <?php if (have_rows('columns')):
                    while (have_rows('columns')) : the_row();
                        if (have_rows('column_one_content_type')):
                            echo '<div class="section__column">';
                            while (have_rows('column_one_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                    endwhile;
                endif;
                $background_image = get_sub_field('layout_settings_background_image');
                if ($background_image):
                    echo wp_get_attachment_image($background_image, 'full', '', array('class' => 'section__background-image'));
                endif;
                ?>
            </div>

        <?php elseif (get_row_layout() == 'column_half'): // Two Columns  ?>
            <div <?php echo add_section_styles(); ?>>
                <?php if (have_rows('columns')):
                    while (have_rows('columns')) : the_row();
                        if (have_rows('column_one_content_type')):
                            echo '<div class="section__column">';
                            while (have_rows('column_one_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                        if (have_rows('column_two_content_type')):
                            echo '<div class="section__column">';
                            while (have_rows('column_two_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                    endwhile;
                endif;
                $background_image = get_sub_field('layout_settings_background_image');
                if ($background_image):
                    echo wp_get_attachment_image($background_image, 'full', '', array('class' => 'section__background-image'));
                endif;
                ?>
            </div>

        <?php elseif (get_row_layout() == 'column_third'): // Three Columns  ?>
            <div <?php echo add_section_styles(); ?>>
                <?php if (have_rows('columns')):
                    while (have_rows('columns')) : the_row();
                        if (have_rows('column_one_content_type')):
                            echo '<div class="section__column">';
                            while (have_rows('column_one_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                        if (have_rows('column_two_content_type')):
                            echo '<div class="section__column">';
                            while (have_rows('column_two_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                        if (have_rows('column_three_content_type')):
                            echo '<div class="section__column">';
                            while (have_rows('column_three_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                    endwhile;
                endif;
                $background_image = get_sub_field('layout_settings_background_image');
                if ($background_image):
                    echo wp_get_attachment_image($background_image, 'full', '', array('class' => 'section__background-image'));
                endif;
                ?>
            </div>

        <?php elseif (get_row_layout() == 'column_sidebar'): // Two Columns with Sidebar  ?>
            <div <?php echo add_section_styles(); ?>>
                <?php if (have_rows('columns')):
                    while (have_rows('columns')) : the_row();
                        if (have_rows('column_one_content_type')):
                            echo '<div class="section__column">';
                            while (have_rows('column_one_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                        if (have_rows('column_two_content_type')):
                            echo '<div class="section__column section__column--sidebar">';
                            while (have_rows('column_two_content_type')) : the_row();
                                get_template_part('template-parts/blocks/column-content');
                            endwhile;
                            echo '</div>';
                        endif;
                    endwhile;
                endif;
                $background_image = get_sub_field('layout_settings_background_image');
                if ($background_image):
                    echo wp_get_attachment_image($background_image, 'full', '', array('class' => 'section__background-image'));
                endif;
                ?>

            </div>
        <?php endif; ?>

    <?php endwhile; ?>
<?php endif; ?>
