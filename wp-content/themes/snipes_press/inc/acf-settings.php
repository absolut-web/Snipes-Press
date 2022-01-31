<?php

function my_acf_init() {
    if ( function_exists( 'acf_register_block' ) ) {
        // Layout
        acf_register_block( array(
            'name'            => 'layout',
            'title'           => __( 'Layout' ),
            'description'     => __( 'Block Layout' ),
            'render_callback' => 'my_acf_block_render_callback',
            'category'        => 'layout',
            'mode'            => 'edit',
            'align'           => 'full',
            'supports'        => array(
                'align' => false,
                'mode' => false
            ),
            'keywords'        => array( 'Layout', 'Content' )
        ) );
    }
}

add_action( 'acf/init', 'my_acf_init' );

function my_acf_block_render_callback( $block ) {
    $slug = str_replace( 'acf/', '', $block['name'] );
    if ( file_exists( get_theme_file_path( "/template-parts/blocks/{$slug}-block.php" ) ) ) {
        include( get_theme_file_path( "/template-parts/blocks/{$slug}-block.php" ) );
    }
}