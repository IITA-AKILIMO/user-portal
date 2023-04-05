<?php
/**
 * Must be required before plugin run
 *
 * @package Kenta Companion
 */

if ( ! function_exists( 'kcmp_kenta_need_upgrade_notice' ) ) {
	function kcmp_kenta_need_upgrade_notice() {
		$path = KCMP_PLUGIN_PATH . 'templates/kenta-upgrade-notice.php';
		if ( file_exists( $path ) ) {
			require $path;
		}
	}
}

if ( ! function_exists( 'kcmp_enqueue_admin_scripts' ) ) {
	function kcmp_enqueue_admin_scripts() {
		$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';

		wp_enqueue_style(
			'kenta-cmp-admin-style',
			KCMP_ASSETS_URL . 'css/kenta-admin' . $suffix . '.css',
			[],
			KCMP_VERSION
		);

		$screen = get_current_screen();

		if ( ! in_array( $screen->base, [ 'toplevel_page_kenta-companion', 'kenta_page_kenta-starter-sites' ] ) ) {
			return;
		}

		wp_enqueue_script(
			'kenta-cmp-admin-script',
			KCMP_ASSETS_URL . 'js/kenta-admin' . $suffix . '.js',
			[
				'jquery',
				'wp-api-fetch',
				'wp-element',
				'wp-components'
			],
			KCMP_VERSION
		);

		$localize = [
			'general' => [
				'premium_kb' => function_exists( 'kcmp_is_premium_kb_installed' ) && kcmp_is_premium_kb_installed(),
			],
			'starter' => [
				'plan' => kenta_fs()->can_use_premium_code() ? 'premium' : 'free',
				'api'  => kcmp( 'demos' )->api( kcmp_current_template() . '/' ),
			],
		];

		wp_localize_script(
			'kenta-cmp-admin-script',
			'KentaCompanion',
			apply_filters( 'kcmp/admin_js_localize', $localize )
		);
	}
}
