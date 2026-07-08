<?php

/**
 * Search Form
 *
 * @link    https://plugins360.com
 * @since   2.5.7
 *
 * @package Automatic_YouTube_Gallery
 */

// Build attributes		
$source_type = sanitize_text_field( $attributes['type'] );

$params = array(
    'uid'                  => sanitize_text_field( $attributes['uid'] ),
    'post_id'              => (int) $attributes['post_id'],
    'type'                 => $source_type,
    'src'                  => sanitize_text_field( $attributes[ $source_type ] ),
    'order'                => sanitize_text_field( $attributes['order'] ), // Works only when type = "search".
    'limit'                => (int) $attributes['limit'], // Works only when type = "search".
    'per_page'             => (int) $attributes['per_page'],
    'cache'                => (int) $attributes['cache'],
    'columns'              => ! empty( $attributes['columns'] ) ? (int) $attributes['columns'] : 1,
    'thumb_ratio'          => ! empty( $attributes['thumb_ratio'] ) ? (float) $attributes['thumb_ratio'] : 56.25,
    'thumb_title'          => ! empty( $attributes['thumb_title'] ) ? (int) $attributes['thumb_title'] : 0,
    'thumb_title_length'   => ! empty( $attributes['thumb_title_length'] ) ? (int) $attributes['thumb_title_length'] : 0,
    'thumb_excerpt'        => ! empty( $attributes['thumb_excerpt'] ) ? (int) $attributes['thumb_excerpt'] : 0,
    'thumb_excerpt_length' => ! empty( $attributes['thumb_excerpt_length'] ) ? (int) $attributes['thumb_excerpt_length'] : 0,
    'player_description'   => ! empty( $attributes['player_description'] ) ? (int) $attributes['player_description'] : 0
);

$params = apply_filters( 'ayg_search_form_params', $params, $attributes ); 
$params = apply_filters( 'ayg_search_form_args', $params, $attributes ); // Deprecated for consistency in version 2.7.2
?>
<ayg-search-form data-params="<?php echo esc_attr( wp_json_encode( $params ) ); ?>">
    <form class="ayg-search-form">
        <input type="text" class="ayg-search-input" placeholder="<?php esc_attr_e( 'Search Videos', 'automatic-youtube-gallery' ); ?>" />
        <button type="button" class="ayg-search-btn"> 
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
        <button type="button" class="ayg-reset-btn" style="display: none;"> 
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </form>
</ayg-search-form>