<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;

class Integration {

	private static $instance = null;

	public function __construct() {

		//require_once IGD_INCLUDES . '/divi/class-divi.php';

		//require_once IGD_INCLUDES . '/integrations/class-tutor.php';

		// Classic editor
		if ( $this->is_active( 'classic-editor' ) ) {
			require_once IGD_INCLUDES . '/class-tinymce.php';
		}

		// Block editor
		if ( $this->is_active( 'gutenberg-editor' ) ) {
			require_once IGD_INCLUDES . '/blocks/class-blocks.php';
		}

		// Elementor
		if ( $this->is_active( 'elementor' ) ) {
			require_once IGD_INCLUDES . '/elementor/class-elementor.php';
		}

		add_action( 'plugins_loaded', function () {
			// Load CF7 integration
			if ( $this->is_active( 'cf7' ) && defined( 'WPCF7_VERSION' ) && version_compare( WPCF7_VERSION, '5.0', '>=' ) ) {
				require_once IGD_INCLUDES . '/integrations/class-cf7.php';
			}
		} );

		if ( igd_fs()->can_use_premium_code__premium_only() ) {

			// Load EDD integration
			if ( $this->is_active( 'edd' ) && class_exists( 'Easy_Digital_Downloads' ) ) {
				require_once IGD_INCLUDES . '/integrations/class-edd__premium_only.php';
			}

			// Load WooCommerce integration
			if ( $this->is_active( 'woocommerce' ) ) {
				add_action( 'woocommerce_loaded', function () {
					$is_download_active = igd_get_settings( 'wooCommerceDownload', true );
					$is_upload_active   = igd_get_settings( 'wooCommerceUpload', true );

					$is_dokan_download_active = $this->is_active( 'dokan' ) && igd_get_settings( 'dokanDownload', true );
					$is_dokan_upload_active   = $this->is_active( 'dokan' ) && igd_get_settings( 'dokanUpload', true );

					if ( $is_download_active || $is_dokan_download_active ) {
						include_once IGD_INCLUDES . '/integrations/woocommerce__premium_only/class-woocommerce-downloads.php';
					}

					if ( $is_upload_active || $is_dokan_upload_active ) {
						include_once IGD_INCLUDES . '/integrations/woocommerce__premium_only/class-woocommerce-uploads.php';
					}

				} );
			}

			// Load Dokan integration
			if ( $this->is_active( 'dokan' ) ) {
				add_action( 'dokan_loaded', function () {
					include_once IGD_INCLUDES . '/integrations/class-dokan__premium_only.php';
				} );
			}

			// Load Fluent Forms integration
			add_action( 'plugins_loaded', function () {

				// Load WPForms integration
				if ( $this->is_active( 'wpforms' ) && defined( 'WPFORMS_VERSION' ) ) {
					require_once IGD_INCLUDES . '/integrations/class-wpforms__premium_only.php';
				}

				// Load Gravity Forms integration
				if ( $this->is_active( 'gravityforms' ) && class_exists( 'GFAddOn' ) ) {
					require_once IGD_INCLUDES . '/integrations/class-gravityforms__premium_only.php';
				}

				// Load Fluent Forms integration
				if ( $this->is_active( 'fluentforms' ) && defined( 'FLUENTFORM' ) ) {
					require_once IGD_INCLUDES . '/integrations/class-fluentforms__premium_only.php';
				}

				// Load Formidable Forms integration
				if ( $this->is_active( 'formidableforms' ) && function_exists( 'load_formidable_forms' ) ) {
					require_once IGD_INCLUDES . '/integrations/class-formidableforms__premium_only.php';
				}

				// Load Ninja Forms integration
				if ( $this->is_active( 'ninjaforms' ) && function_exists( 'ninja_forms_three_table_exists' ) ) {
					require_once IGD_INCLUDES . '/integrations/class-ninjaforms__premium_only.php';
				}

				// Load ACF integration
				if ( $this->is_active( 'acf' ) && class_exists( 'ACF' ) ) {
					add_action( 'acf/include_field_types', function () {
						require_once IGD_INCLUDES . '/integrations/class-acf__premium_only.php';
					} );
				}


			} );


		}

	}

	/**
	 * Check if integration is active
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function is_active( $key ) {
		$integrations = igd_get_settings( 'integrations', [
			'classic-editor',
			'gutenberg-editor',
			'elementor',
			'cf7'
		] );

		return in_array( $key, $integrations );
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

Integration::instance();