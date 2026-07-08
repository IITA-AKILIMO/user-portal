<?php
/**
 * Google font helper functions.
 *
 * @package Forminator
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Return all fonts
 *
 * @since 1.0
 * @return mixed
 */
function forminator_get_all_fonts() {
	$cached_fonts = forminator_cached_fonts();
	$cached_fonts = ! empty( $cached_fonts ) ? json_decode( $cached_fonts, true ) : forminator_load_from_google();

	/**
	 * Retrieve all available fonts.
	 *
	 * Example format:
	 * array(
	 *     'family'   => 'ABeeZee',
	 *     'category' => 'sans-serif',
	 *     'variants' => array('regular', 'italic')
	 * )
	 *
	 * @since 1.37
	 *
	 * @param array $cached_fonts Array of supported fonts.
	 *
	 * @return array Filtered list of fonts.
	 */
	return apply_filters( 'forminator_on_get_all_fonts', $cached_fonts );
}

/**
 * Load & return fonts from Google
 *
 * @since 1.0
 * @return mixed
 */
function forminator_load_from_google() {
	return array();
}

/**
 * Fetch fonts from Bunny Fonts API and transform to the expected format.
 *
 * @since 1.54.0
 * @return array|false Transformed fonts array or false on failure.
 */
function forminator_fetch_bunny_fonts() {
	$response = wp_remote_get( 'https://fonts.bunny.net/list' );

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return false;
	}

	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body, true );

	if ( ! is_array( $data ) ) {
		return false;
	}

	$fonts = array();

	foreach ( $data as $font_data ) {
		if ( empty( $font_data['familyName'] ) || empty( $font_data['category'] ) ) {
			continue;
		}

		$variants = forminator_build_font_variants(
			isset( $font_data['weights'] ) ? $font_data['weights'] : array( 400 ),
			isset( $font_data['styles'] ) ? $font_data['styles'] : array( 'normal' )
		);

		$fonts[] = array(
			'family'   => $font_data['familyName'],
			'category' => $font_data['category'],
			'variants' => $variants,
		);
	}

	usort(
		$fonts,
		function ( $a, $b ) {
			return strcasecmp( $a['family'], $b['family'] );
		}
	);

	return $fonts;
}

/**
 * Build variant strings from weights and styles arrays.
 *
 * @since 1.54.0
 * @param array $weights Font weights.
 * @param array $styles  Font styles.
 * @return array Variant strings.
 */
function forminator_build_font_variants( $weights, $styles ) {
	$variants = array();

	foreach ( $weights as $weight ) {
		foreach ( $styles as $style ) {
			if ( 400 === (int) $weight ) {
				$variants[] = 'italic' === $style ? 'italic' : 'regular';
			} else {
				$variants[] = 'italic' === $style ? $weight . 'italic' : (string) $weight;
			}
		}
	}

	return $variants;
}

/**
 * Return font families
 *
 * @param bool $is_object Is object.
 *
 * @since 1.0
 * @return mixed
 */
function forminator_get_font_families( $is_object ) {
	$families = forminator_get_all_fonts();

	if ( $is_object ) {
		return $families;
	}

	// backwards compatibility.
	$families = wp_list_pluck( $families, 'family' );

	return $families;
}

/**
 * Return cached fonts, fetching from Bunny Fonts API when the refresh flag has expired.
 *
 * Fonts are persisted in a WordPress option and a transient flag controls when they
 * should be refreshed from the Bunny Fonts API (every 30 days by default).
 *
 * @since 1.0
 * @since 1.54.0 Stores fonts in a WP option and uses a transient flag to schedule refreshes.
 * @return string JSON-encoded font list.
 */
function forminator_cached_fonts() {
	$option_key  = 'forminator_bunny_fonts';
	$refresh_key = 'forminator_bunny_fonts_refresh';

	if ( false !== get_transient( $refresh_key ) ) {
		return (string) get_option( $option_key, '' );
	}

	$fonts = forminator_fetch_bunny_fonts();

	if ( ! empty( $fonts ) ) {
		$json = wp_json_encode( $fonts );
		update_option( $option_key, $json, false );
		set_transient( $refresh_key, 1, MONTH_IN_SECONDS );
		return $json;
	}

	return (string) get_option( $option_key, '' );
}
