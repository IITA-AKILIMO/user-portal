<?php

/**
 * Theme: Classic.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package Automatic_YouTube_Gallery
 */

$player_ratio = ! empty( $attributes['player_ratio'] ) ? (float) $attributes['player_ratio'] : '56.25';

$params = array(
    'uid'            => sanitize_text_field( $attributes['uid'] ),
    'autoplay'       => (int) $attributes['autoplay'],
    'loop'           => (int) $attributes['loop'],
    'controls'       => (int) $attributes['controls'],
    'modestbranding' => (int) $attributes['modestbranding'],
    'cc_load_policy' => (int) $attributes['cc_load_policy'],
    'iv_load_policy' => (int) $attributes['iv_load_policy'],
    'hl'             => sanitize_text_field( $attributes['hl'] ),
    'cc_lang_pref'   => sanitize_text_field( $attributes['cc_lang_pref'] )
);

$featured = $videos[0]; // Featured Video
?>

<div id="ayg-<?php echo esc_attr( $attributes['uid'] ); ?>" class="ayg ayg-theme-single" data-params='<?php echo wp_json_encode( $params ); ?>'>
    <!-- Player -->
    <div class="ayg-player">
        <div class="ayg-player-wrapper" style="padding-bottom: <?php echo (float) $player_ratio; ?>%;">
            <?php
            // Image
            $image_src = 'none';
        
            if ( isset( $video->thumbnails->default ) ) {
                $image_src = $video->thumbnails->default->url;
            }        
            
            if ( 75 == (int) $attributes['player_ratio'] ) { // 4:3 ( default - 120x90, high - 480x360, standard - 640x480 )
                if ( isset( $video->thumbnails->high ) ) {
                    $image_src = $video->thumbnails->high->url;
                }
            }        
            
            if ( 56.25 == (float) $attributes['player_ratio'] ) { // 16:9 ( medium - 320x180, maxres - 1280x720 )
                if ( isset( $video->thumbnails->medium ) ) {
                    $image_src = $video->thumbnails->medium->url;
                }
            } 

            // Player
            $tag = 'div';
            if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
                $tag = 'iframe';
            }

            printf(
                '<%1$s id="ayg-player-%2$s" class="ayg-player-iframe" width="100%%" height="100%%" src="https://www.youtube.com/embed/%3$s" data-id="%3$s" data-image="%4%s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></%1$s>',
                $tag,
                esc_attr( $attributes['uid'] ),
                esc_attr( $featured->id ),
                esc_attr( $image_src )
            );
            ?>            
        </div>

        <div class="ayg-player-caption">
            <?php if ( ! empty( $attributes['player_title'] ) ) : ?>    
                <h2 class="ayg-player-title"><?php echo esc_html( $featured->title ); ?></h2>  
            <?php endif; ?>

            <?php if ( ! empty( $attributes['player_description'] ) && ! empty( $featured->description ) ) : ?>  
                <div class="ayg-player-description"><?php echo wp_kses_post( ayg_get_player_description( $featured ) ); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
