<?php
if ( get_row_layout() == 'content_type_text' ):
    echo get_sub_field( 'content_text' );

elseif ( get_row_layout() == 'content_type_latest_posts' ):
    if ( have_rows( 'latest_posts' ) ):
        while ( have_rows( 'latest_posts' ) ): the_row();
            $latest_posts_title    = get_sub_field( 'latest_posts_title' );
            $latest_posts_category = get_sub_field( 'latest_posts_category' );
            $latest_posts_style    = get_sub_field( 'latest_posts_style' );
            echo query_latest_posts( $latest_posts_title, $latest_posts_category, '', $latest_posts_style );
        endwhile;
    endif;

elseif ( get_row_layout() == 'content_type_file_download' ):
    if ( have_rows( 'file_download' ) ):
        while ( have_rows( 'file_download' ) ): the_row();
            $download_title = get_sub_field( 'file_download_title' );
            $download_file  = get_sub_field( 'file_download_file' );
            echo '<a class="button-look" href="' . wp_get_attachment_url( $download_file ) . '" download>' . $download_title . '</a>';
        endwhile;
    endif;

elseif ( get_row_layout() == 'content_type_gallery' ):
    $images = get_sub_field( 'image_gallery' );
    if ( $images ):
        $lightbox = get_sub_field( 'image_gallery_lightbox' );
        $gallery_columns = get_sub_field( 'image_gallery_columns' );
        $image_size = get_sub_field( 'image_gallery_size' );
        $gallery_columns_class = '';
        $gallery_image_size = 'full';

        if ( $image_size === 'cropped' ):
            $gallery_image_size = 'gallery_thumb';
        endif;

        if ( $gallery_columns == 'one' ):
            $gallery_columns_class = ' image-gallery--one-column';
        elseif ( $gallery_columns == 'two' ):
            $gallery_columns_class = ' image-gallery--two-columns';
        elseif ( $gallery_columns == 'three' ):
            $gallery_columns_class = ' image-gallery--three-columns';
        endif;

        $all_images = count( $images );
        $counter    = 0;
        ?>

        <div class="image-gallery<?php echo $lightbox ? ' image-gallery--lightbox' : '';
        echo $gallery_columns_class; ?>">
            <?php foreach ( $images as $image ):
                $counter ++;
                $item_class = '';

                if ( $counter == $all_images && $all_images % 2 != 0 ):
                    $item_class .= ' image-gallery__item--last';
                endif;

                if ( $lightbox ):
                    $item_class .= ' image-gallery__item--lightbox';
                endif;

                $image_src        = wp_get_attachment_image_src( $image, 'large' )[0]; // src
                $image_src_width  = wp_get_attachment_image_src( $image, 'large' )[1]; // width
                $image_src_height = wp_get_attachment_image_src( $image, 'large' )[2]; // height
                $image_download   = wp_get_attachment_url( $image );
                $image_size       = size_format( filesize( get_attached_file( $image ) ), 2 );
                $image_extension  = pathinfo( $image_download, PATHINFO_EXTENSION );
                $image_caption    = wp_get_attachment_caption( $image );
                $fig_caption      = '';

                if ( $image_caption ) {
                    $fig_caption = '<figcaption><span>' . $image_caption . '</span></figcaption>';
                }


                ?>
                <div <?php echo $lightbox ? 'aria-label="More details" aria-expanded="false" role="button" tabindex="0" ' : '' ?>
                        class="image-gallery__item<?php echo $item_class ?>"
                        data-image="<?php echo $image_src; ?>" data-imagew="<?php echo $image_src_width; ?>"
                        data-imageh="<?php echo $image_src_height; ?>" data-download="<?php echo $image_download; ?>"
                        data-size="<?php echo $image_size; ?>" data-extension="<?php echo $image_extension; ?>"
                        data-caption="<?php echo $image_caption; ?>">
                    <?php
                    if ( $image_extension !== 'svg' ):
                        echo '<figure>' . wp_get_attachment_image( $image, $gallery_image_size, '', array( 'class' => 'image-gallery__item-image' ) ) . $fig_caption . '</figure>';
                    else:
                        echo '<figure> <img class="image-gallery__item-image image-gallery__item-image--svg" src="' . $image_src . '" alt="svg File">' . $fig_caption . '</figure>';
                    endif;

                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif;


elseif ( get_row_layout() == 'content_type_accordion' ):
    if ( have_rows( 'accordion' ) ): ?>
        <div class="accordion-container">
            <?php
            while ( have_rows( 'accordion' ) ): the_row();
                $accordion_header  = get_sub_field( 'accordion_header' );
                $accordion_content = get_sub_field( 'accordion_content' );
                $random_id         = generate_random_string();
                ?>
                <div class="accordion-container__item accordion">
                    <div class="accordion__header accordion-header">
                        <div class="accordion-header__content"><?php echo $accordion_header; ?></div>
                        <button class="accordion-header__button" type="button" aria-expanded="false"
                                aria-controls="accordion-<?php echo $random_id ?>">Open<span></span>
                        </button>
                    </div>
                    <div class="accordion__content accordion-content"
                         id="accordion-<?php echo $random_id ?>"><?php echo $accordion_content; ?></div>
                </div>
                <?php $counter ++; endwhile; ?>
        </div>
    <?php endif;

elseif ( get_row_layout() == 'content_type_team' ):
    if ( have_rows( 'team' ) ): ?>
        <div class="team-container">
            <?php
            while ( have_rows( 'team' ) ): the_row();
                $member_name      = get_sub_field( 'team_name' );
                $member_photo     = get_sub_field( 'team_image' );
                $member_content   = get_sub_field( 'team_content' );
                $member_instagram = get_sub_field( 'team_instagram' );
                $member_youtube   = get_sub_field( 'team_youtube' );
                $member_tiktok    = get_sub_field( 'team_tiktok' );
                $member_facebook  = get_sub_field( 'team_facebook' );
                $member_twitter   = get_sub_field( 'team_twitter' );
                $member_spotify   = get_sub_field( 'team_spotify' );

                ?>
                <div type="button" aria-label="More details" role="button" tabindex="0"
                     class="team-container__item team-member">

                    <?php echo wp_get_attachment_image( $member_photo, 'full', '', array( 'class' => 'team-member__photo' ) ); ?>

                    <div class="team-member__name team-member-name">
                        <?php echo $member_name; ?>
                    </div>

                    <div aria-hidden="true" class="team-member__name team-member__name--clone team-member-name">
                        <?php echo $member_name; ?>
                    </div>

                    <div class="team-member__content">
                        <?php echo $member_content; ?>
                    </div>

                    <div class="team-member__social team-member-social">
                        <?php if ( $member_instagram ): ?>
                            <a class="team-member-social__link" rel="noopener nofollow" aria-label="Instagram"
                               target="_blank"
                               href="<?php echo( $member_instagram ); ?>">
                                <img class="team-member-social__icon" width="20" height="20"
                                     src="<?php bloginfo( 'template_directory' ); ?>/media/icons/social-media/instagram-brands.svg"
                                     alt="Instagram">
                            </a>
                        <?php endif; ?>

                        <?php if ( $member_youtube ): ?>
                            <a class="team-member-social__link" rel="noopener nofollow" aria-label="YouTube"
                               target="_blank"
                               href="<?php echo( $member_youtube ); ?>">
                                <img class="team-member-social__icon" width="20" height="20"
                                     src="<?php bloginfo( 'template_directory' ); ?>/media/icons/social-media/youtube-brands.svg"
                                     alt="YouTube">
                            </a>
                        <?php endif; ?>

                        <?php if ( $member_tiktok ): ?>
                            <a class="team-member-social__link" rel="noopener nofollow" aria-label="TikTok"
                               target="_blank"
                               href="<?php echo( $member_tiktok ); ?>">
                                <img class="team-member-social__icon" width="20" height="20"
                                     src="<?php bloginfo( 'template_directory' ); ?>/media/icons/social-media/tiktok-brands.svg"
                                     alt="TikTok">
                            </a>
                        <?php endif; ?>

                        <?php if ( $member_facebook ): ?>
                            <a class="team-member-social__link" rel="noopener nofollow" aria-label="Facebook"
                               target="_blank"
                               href="<?php echo( $member_facebook ); ?>">
                                <img class="team-member-social__icon" width="20" height="20"
                                     src="<?php bloginfo( 'template_directory' ); ?>/media/icons/social-media/facebook-f-brands.svg"
                                     alt="Facebook">
                            </a>
                        <?php endif; ?>

                        <?php if ( $member_spotify ): ?>
                            <a class="team-member-social__link" rel="noopener nofollow" aria-label="Spotify"
                               target="_blank"
                               href="<?php echo( $member_spotify ); ?>">
                                <img class="team-member-social__icon" width="20" height="20"
                                     src="<?php bloginfo( 'template_directory' ); ?>/media/icons/social-media/spotify-brands.svg"
                                     alt="Spotify">
                            </a>
                        <?php endif; ?>

                        <?php if ( $member_twitter ): ?>
                            <a class="team-member-social__link" rel="noopener nofollow" aria-label="Spotify"
                               target="_blank"
                               href="<?php echo( $member_twitter ); ?>">
                                <img class="team-member-social__icon" width="20" height="20"
                                     src="<?php bloginfo( 'template_directory' ); ?>/media/icons/social-media/twitter-brands.svg"
                                     alt="Twitter">
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    <?php endif;

elseif
( get_row_layout() == 'content_type_related_gallery' ):
    $post_id = get_sub_field( 'related_gallery' );
    if ( $post_id ):
        echo show_related_gallery( $post_id );
    endif;
endif;
