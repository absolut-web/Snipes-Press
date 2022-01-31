<?php
if ( get_row_layout() == 'content_type_text' ):
    $text = get_sub_field( 'content_text' );
    echo '<div class="section--item">' . $text . '</div>';


elseif ( get_row_layout() == 'content_type_latest_posts' ):
    if ( have_rows( 'latest_posts' ) ):
        while ( have_rows( 'latest_posts' ) ): the_row();
            $latest_posts_title    = get_sub_field( 'latest_posts_title' );
            $latest_posts_category = get_sub_field( 'latest_posts_category' );
            $latest_posts_style = get_sub_field( 'latest_posts_style' );
            echo query_latest_posts( $latest_posts_title, $latest_posts_category, '',$latest_posts_style );
        endwhile;
    endif;
endif;
