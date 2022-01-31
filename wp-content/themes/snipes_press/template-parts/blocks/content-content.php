<?php
$id = 'layout-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

$className = 'layout';
if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}

if ( ! empty( $block['align'] ) ) {
    $className .= ' align' . $block['align'];
}


if ( have_rows( 'content' ) ):
    while ( have_rows( 'content' ) ) : the_row(); ?>
        <?php if ( get_row_layout() == 'one_column' ):
            $text = get_sub_field( 'text' );
            ?>
            <div class="section section--large">
                <div class="content content--block">
                    <div class="content__item">
                        <?php echo $text; ?>
                    </div>
                </div>
            </div>

        <?php elseif ( get_row_layout() == 'two_columns' ): ?>
            <div class="section section--large">
                <div class="content content--block content--columns">
                    <?php if ( have_rows( 'column' ) ):
                        while ( have_rows( 'column' ) ) : the_row();
                            get_template_part( 'template-parts/block/inc/column-content' );
                        endwhile;
                    endif;
                    if ( have_rows( 'column_2' ) ):
                        while ( have_rows( 'column_2' ) ) : the_row();
                            get_template_part( 'template-parts/block/inc/column-content' );
                        endwhile;
                    endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>
