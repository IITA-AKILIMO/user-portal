<?php

/**
 * Thumbnail
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package Automatic_YouTube_Gallery
 */

$single_url   = ayg_get_single_video_url( $video, $attributes );

$image_url    = '';
$thumb        = null;
$thumb_width  = 320;
$thumb_height = 180;
$thumb_ratio  = isset( $attributes['thumb_ratio'] ) ? (float) $attributes['thumb_ratio'] : 56.25;
$aspect_ratio = '16 / 9';

if ( $thumb_ratio >= 170 ) { // Shorts / Vertical
    if ( isset( $video->thumbnails->maxres ) ) {
        $thumb = $video->thumbnails->maxres;
    } elseif ( isset( $video->thumbnails->medium ) ) {
        $thumb = $video->thumbnails->medium;
    } elseif ( isset( $video->thumbnails->high ) ) {
        $thumb = $video->thumbnails->high;
    }

    $aspect_ratio = '9 / 16';
} elseif ( $thumb_ratio >= 70 ) { // Classic 4:3
    if ( isset( $video->thumbnails->standard ) ) {
        $thumb = $video->thumbnails->standard;
    } elseif ( isset( $video->thumbnails->high ) ) {
        $thumb = $video->thumbnails->high;
    }

    $aspect_ratio = '4 / 3';
} else { // Standard 16:9
    if ( isset( $video->thumbnails->maxres ) ) {
        $thumb = $video->thumbnails->maxres;
    } elseif ( isset( $video->thumbnails->medium ) ) {
        $thumb = $video->thumbnails->medium;
    }
}

if ( empty( $thumb ) && isset( $video->thumbnails->default ) ) {
    $thumb = $video->thumbnails->default;
}

if ( isset( $thumb ) ) {
    $image_url    = $thumb->url;
    $thumb_width  = isset( $thumb->width )  ? (int) $thumb->width  : $thumb_width;
    $thumb_height = isset( $thumb->height ) ? (int) $thumb->height : $thumb_height;
}

$image_url = apply_filters( 'ayg_thumbnail_image_url', $image_url, $video, $attributes );
?>
<div class="ayg-thumbnail" data-id="<?php echo esc_attr( $video->id ); ?>" data-title="<?php echo esc_attr( $video->title ); ?>" data-url="<?php echo esc_attr( $single_url ); ?>">
    <div class="ayg-thumbnail-media" style="--ayg-image-ratio: <?php echo esc_attr( $aspect_ratio ); ?>">
        <?php
        // Image
        echo sprintf(
            '<img src="%s" class="ayg-thumbnail-image" width="%d" height="%d" alt="%s" %s/>',
            esc_url( $image_url ),
            $thumb_width,
            $thumb_height,
            esc_attr( $video->title ),
            ! empty( $attributes['lazyload'] ) ? 'loading="lazy" decoding="async"' : 'decoding="async"'
        );

        // Now Playing
        echo sprintf( 
            '<div class="ayg-thumbnail-now-playing" style="display: none;">%s</div>', 
            esc_html__( 'Now Playing', 'automatic-youtube-gallery' ) 
        );

        // Play Icon
        echo sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" fill="white" width="40" height="40" viewBox="0 0 24 24" class="ayg-icon ayg-thumbnail-icon-play" title="%1$s" aria-label="%1$s"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.603 3.113A1.125 1.125 0 0 1 9 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113Z" clip-rule="evenodd" /></svg>',
            esc_attr__( 'Play', 'automatic-youtube-gallery' )
        );
        ?>        
    </div>
    <div class="ayg-thumbnail-caption">
        <?php if ( ! empty( $attributes['thumb_title'] ) ) : ?> 
            <div class="ayg-thumbnail-title"><?php echo esc_html( ayg_trim_words( $video->title, (int) $attributes['thumb_title_length'] ) ); ?></div>
        <?php endif; ?> 
        <?php if ( ! empty( $attributes['thumb_excerpt'] ) && ! empty( $video->description ) ) : ?>
            <div class="ayg-thumbnail-excerpt"><?php echo wp_kses_post( ayg_trim_words( $video->description, (int) $attributes['thumb_excerpt_length'] ) ); ?></div>
        <?php endif; ?>
        <?php if ( ! empty( $attributes['player_description'] ) && ! empty( $video->description ) ) : ?>  
            <div class="ayg-thumbnail-description" style="display: none;"><?php echo wp_kses_post( ayg_get_player_description( $video, $attributes ) ); ?></div>
        <?php endif; ?>
    </div>           
</div>