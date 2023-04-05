<?php
/**
 * Template helpers
 *
 * @package Kenta Business
 */

if ( ! function_exists( 'kenta_business_asset_url' ) ) {
	/**
	 * Get template assets file url
	 *
	 * @param $asset
	 *
	 * @return string
	 */
	function kenta_business_asset_url( $asset ) {
		return KENTA_BUSINESS_ASSETS_URL . $asset;
	}
}

if ( ! function_exists( 'kenta_business_pattern_markup' ) ) {
	/**
	 * Get pattern markup
	 *
	 * @param $name
	 * @param array $args
	 *
	 * @return false|string
	 */
	function kenta_business_pattern_markup( $name, $args = array() ) {
		extract( $args );

		ob_start();
		include KENTA_BUSINESS_PATH . 'template-parts/patterns/' . sanitize_title( $name ) . '.php';

		return ob_get_clean();
	}
}

if ( ! function_exists( 'kenta_business_starter_template' ) ) {
	/**
	 * Get pattern markup
	 *
	 * @param $name
	 *
	 * @return false|string
	 */
	function kenta_business_starter_template( $name ) {
		ob_start();
		include KENTA_BUSINESS_PATH . 'template-parts/starter-templates/' . sanitize_title( $name ) . '.php';

		return ob_get_clean();
	}
}
