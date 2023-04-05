<?php
/**
 * Class for declaring the content importer used in the Kenta Companion plugin
 *
 * @package Kenta Companion
 */

namespace KentaCompanion\DemoImporter;

use KentaCompanion\DemoImporter\ContentImporter\WXRImporter;

class ContentImporter {
	/**
	 * The importer class object used for importing content.
	 *
	 * @var WXRImporter
	 */
	private $importer;

	/**
	 * Constructor method.
	 *
	 * @param array $importer_options Importer options.
	 */
	public function __construct( $importer_options = array() ) {
		// Include files that are needed for WordPress Importer v2.
		$this->include_required_files();

		// Set the WordPress Importer v2 as the importer used in this plugin.
		// More: https://github.com/humanmade/WordPress-Importer.
		$this->importer = new WXRImporter();

		foreach ( $importer_options as $option => $value ) {
			if ( property_exists( $this->importer, $option ) ) {
				$this->importer->{$option} = $value;
			}
		}
	}


	/**
	 * Include required files.
	 */
	private function include_required_files() {
		// Load Importer API.
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! class_exists( '\WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

			if ( file_exists( $class_wp_importer ) ) {
				require $class_wp_importer;
			}
		}

		if ( ! function_exists( 'post_exists' ) ) {
			include_once ABSPATH . 'wp-admin/includes/post.php';
		}

		if ( ! function_exists( 'wp_insert_category' ) ) {
			include_once ABSPATH . 'wp-admin/includes/taxonomy.php';
		}
	}

	/**
	 * Imports content from a WordPress export file.
	 *
	 * @param string $data_file path to xml file, file with WordPress export data.
	 */
	public function import( $data_file ) {
		$this->importer->import( $data_file );
	}

	/**
	 * Import content from an WP XML file.
	 *
	 * @param string $import_file_path Path to the import file.
	 */
	public function import_content( $import_file_path ) {
		$output = '';

		// Import content.
		if ( ! empty( $import_file_path ) ) {
			ob_start();
			$this->import( $import_file_path );
			$output = ob_get_clean();
			flush_rewrite_rules();
		}

		return $output;
	}
}