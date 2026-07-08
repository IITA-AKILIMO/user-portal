<?php

/**
 * Theme: Live Stream.
 *
 * @link    https://plugins360.com
 * @since   1.6.4
 *
 * @package Automatic_YouTube_Gallery
 */

$player_width = ! empty( $attributes['player_width'] ) ? (int) $attributes['player_width'] . 'px' : '100%';
$player_ratio = ! empty( $attributes['player_ratio'] ) ? (float) $attributes['player_ratio'] : 56.25;

$featured = $videos[0]; // Featured Video
?>
<div id="ayg-<?php echo esc_attr( $attributes['uid'] ); ?>" class="ayg ayg-theme ayg-theme-livestream">
    <div class="ayg-player">
        <div class="ayg-player-container" style="max-width: <?php echo $player_width; ?>;">
            <?php
            $attributes['poster'] = sprintf( 'https://i.ytimg.com/vi/%s/0.jpg', esc_attr( $featured->id ) ); 

            if ( isset( $featured->thumbnails->default ) ) {
                $attributes['poster'] = $featured->thumbnails->default->url;
            }

            if ( $player_ratio >= 170 ) { // Shorts / Vertical
                if ( isset( $featured->thumbnails->maxres ) ) {
                    $attributes['poster'] = $featured->thumbnails->maxres->url;
                } elseif ( isset( $featured->thumbnails->medium ) ) {
                    $attributes['poster'] = $featured->thumbnails->medium->url;
                } elseif ( isset( $featured->thumbnails->high ) ) {
                    $attributes['poster'] = $featured->thumbnails->high->url;
                }
            } elseif ( $player_ratio >= 70 ) { // Classic 4:3
                if ( isset( $featured->thumbnails->standard ) ) {
                    $attributes['poster'] = $featured->thumbnails->standard->url;
                } elseif ( isset( $featured->thumbnails->high ) ) {
                    $attributes['poster'] = $featured->thumbnails->high->url;
                }
            } else { // Standard 16:9
                if ( isset( $featured->thumbnails->maxres ) ) {
                    $attributes['poster'] = $featured->thumbnails->maxres->url;
                } elseif ( isset( $featured->thumbnails->medium ) ) {
                    $attributes['poster'] = $featured->thumbnails->medium->url;
                }
            } 

            the_ayg_player( $featured, $attributes ); 
            ?>            
        </div>
    </div>
</div>
