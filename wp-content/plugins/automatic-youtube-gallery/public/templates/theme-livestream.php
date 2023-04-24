<?php

/**
 * Theme: Live Stream.
 *
 * @link    https://plugins360.com
 * @since   1.6.4
 *
 * @package Automatic_YouTube_Gallery
 */

$livestream_settings = get_option( 'ayg_livestream_settings' );

$player_ratio = ! empty( $attributes['player_ratio'] ) ? (float) $attributes['player_ratio'] : '56.25';

$params = array(  
    'uid'            => sanitize_text_field( $attributes['uid'] ),
    'autoplay'       => (int) $attributes['autoplay'],
    'controls'       => (int) $attributes['controls'],
    'modestbranding' => (int) $attributes['modestbranding'],
    'cc_load_policy' => (int) $attributes['cc_load_policy'],
    'iv_load_policy' => (int) $attributes['iv_load_policy'],
    'hl'             => sanitize_text_field( $attributes['hl'] ),
    'cc_lang_pref'   => sanitize_text_field( $attributes['cc_lang_pref'] ),
    'is_live'        => 1
);
?>

<div id="ayg-<?php echo esc_attr( $attributes['uid'] ); ?>" class="ayg ayg-theme-livestream" data-params='<?php echo wp_json_encode( $params ); ?>'>
    <!-- Player -->
    <div class="ayg-player">
        <div class="ayg-player-wrapper" style="padding-bottom: <?php echo (float) $player_ratio; ?>%;">
            <div id="ayg-player-<?php echo esc_attr( $attributes['uid'] ); ?>" class="ayg-player-iframe" style="display: none;" width="100%" height="100%" src="about:blank" data-id="<?php echo esc_attr( $response->id ); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></div>
        </div>
    </div>
    
    <!-- Fallback Message -->
    <div class="ayg-fallback-message" style="display: none;">
        <?php echo wp_kses_post( $livestream_settings['fallback_message'] ); ?>
    </div>
</div>

