<?php

/**
 * Player
 *
 * @link    https://plugins360.com
 * @since   2.5.0
 *
 * @package Automatic_YouTube_Gallery
 */

$player_ratio = ! empty( $attributes['player_ratio'] ) ? (float) $attributes['player_ratio'] : 56.25;

$video_attributes = array(
    'src'   => esc_url( ayg_get_youtube_embed_url( $video->id, $attributes ) ),
    'ratio' => $player_ratio
);

if ( isset( $video->title ) ) {
    $video_attributes['title'] = esc_attr( $video->title );
}

if ( isset( $attributes['poster'] ) && ! empty( $attributes['poster'] ) ) {
    $video_attributes['poster'] = $attributes['poster'];
} else {
    if ( $player_ratio >= 170 ) { // Shorts / Vertical
        if ( isset( $video->thumbnails->maxres ) ) {
            $video_attributes['poster'] = $video->thumbnails->maxres->url;
        } elseif ( isset( $video->thumbnails->medium ) ) {
            $video_attributes['poster'] = $video->thumbnails->medium->url;
        } elseif ( isset( $video->thumbnails->high ) ) {
            $video_attributes['poster'] = $video->thumbnails->high->url;
        }
    } elseif ( $player_ratio >= 70 ) { // Classic 4:3
        if ( isset( $video->thumbnails->standard ) ) {
            $video_attributes['poster'] = $video->thumbnails->standard->url;
        } elseif ( isset( $video->thumbnails->high ) ) {
            $video_attributes['poster'] = $video->thumbnails->high->url;
        }
    } else { // Standard 16:9
        if ( isset( $video->thumbnails->maxres ) ) {
            $video_attributes['poster'] = $video->thumbnails->maxres->url;
        } elseif ( isset( $video->thumbnails->medium ) ) {
            $video_attributes['poster'] = $video->thumbnails->medium->url;
        }
    }

    if ( empty( $video_attributes['poster'] ) && isset( $video->thumbnails->default ) ) {
        $video_attributes['poster'] = $video->thumbnails->default->url;
    }
}

if ( isset( $video_attributes['poster'] ) ) {
    $video_attributes['poster'] = apply_filters( 'ayg_player_image_url', esc_url( $video_attributes['poster'] ), $video, $attributes );
}

if ( ! empty( $attributes['lazyload'] ) ) {
    $video_attributes['lazyload'] = '';
}

$player_html = sprintf( '<ayg-player %s></ayg-player>', ayg_combine_video_attributes( $video_attributes ) );

// Allow filtering before output
echo apply_filters( 'the_ayg_player', $player_html, $video, $attributes );