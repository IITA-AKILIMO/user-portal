<?php
/**
 * Integration Name: Webhook
 * Version: 1.0
 * Plugin URI:  https://wpmudev.com/
 * Description: Integrate Forminator Custom Forms with Webhook to execute various action you like
 * Author: WPMU DEV
 * Author URI: http://wpmudev.com
 *
 * @package Forminator
 */

define( 'FORMINATOR_ADDON_WEBHOOK_VERSION', '1.0' );

/**
 * Forminator addon webhook directory path
 *
 * @return string
 */
function forminator_addon_webhook_dir() {
	return trailingslashit( __DIR__ );
}

Forminator_Integration_Loader::get_instance()->register( 'webhook' );

/**
 * Validate a webhook URL with temporarily extended allowed ports.
 *
 * WordPress's wp_http_validate_url() only allows ports 80, 443, and 8080.
 * This function temporarily hooks into the `http_allowed_safe_ports` filter
 * to add extra ports during validation, then removes the filter immediately.
 *
 * By default only port 8443 is added. Use the `forminator_webhook_allowed_ports`
 * filter to customise the list.
 *
 * @since 1.53.0
 *
 * @param string $url The webhook URL to validate.
 *
 * @return string|false The validated URL on success, false on failure.
 */
function forminator_webhook_validate_url( $url ) {
	add_filter( 'http_allowed_safe_ports', 'forminator_webhook_extend_ports' );
	$result = wp_http_validate_url( $url );
	remove_filter( 'http_allowed_safe_ports', 'forminator_webhook_extend_ports' );

	return $result;
}

/**
 * Extend the list of allowed safe ports for webhook URL validation.
 *
 * @since 1.53.0
 *
 * @param int[] $ports Existing allowed port numbers.
 * @return int[] Modified array with extra ports added.
 */
function forminator_webhook_extend_ports( $ports ) {
	/**
	 * Filter the extra ports allowed for webhook URLs.
	 *
	 * @since 1.53.0
	 *
	 * @param int[] $extra_ports Array of additional port numbers. Default: array( 8443 ).
	 */
	$extra_ports = apply_filters( 'forminator_webhook_allowed_ports', array( 8443 ) );
	$extra_ports = array_map( 'absint', array_filter( (array) $extra_ports ) );

	return array_unique( array_merge( (array) $ports, $extra_ports ) );
}
