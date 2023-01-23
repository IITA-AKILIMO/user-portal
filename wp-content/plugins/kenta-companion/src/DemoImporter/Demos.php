<?php

namespace KentaCompanion\DemoImporter;

use KentaCompanion\Utils\Downloader;

/**
 * Demo importer
 */
class Demos {

	/**
	 * Holds the date and time string for demo import and log file.
	 *
	 * @var string
	 */
	public $demo_import_start_time = '';

	/**
	 * Holds any error messages, that should be printed out at the end of the import.
	 *
	 * @var string
	 */
	public $frontend_error_messages = [];

	/**
	 * Active demo information
	 *
	 * @var null
	 */
	protected $active = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->include_required_files();

		// Update widget and customizer demo import settings data.
		add_action( 'kcmp/template_imported', array( $this, 'update_nav_menu_items' ) );
		add_filter( 'kcmp/customizer_import_settings', array( $this, 'update_customizer_data' ), 10, 3 );
		// Update content links
//		add_action( 'kcmp/content_imported', array( $this, 'update_content_links' ), 10, 1 );
	}

	/**
	 * Include required files
	 *
	 * @return void
	 */
	protected function include_required_files() {
		if ( ! function_exists( 'wp_crop_image' ) ) {
			include( ABSPATH . 'wp-admin/includes/image.php' );
		}

		if ( ! function_exists( 'get_filesystem_method' ) || ! function_exists( 'request_filesystem_credentials' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
	}

	/**
	 * Set the $demo_import_start_time variable with the current date and time string.
	 */
	public function set_demo_import_start_time() {
		$this->demo_import_start_time = date( apply_filters( 'kcmp/date_format_for_file_names', 'Y-m-d__H-i-s' ) );
	}

	/**
	 * Get demo server api
	 *
	 * @param $path
	 *
	 * @return string
	 */
	public function api( $path = '' ) {
		$api = defined( 'KENTA_CMP_DEMOS_API' ) ? KENTA_CMP_DEMOS_API : 'https://demofiles.wpmoose.com/';

		return trailingslashit( $api ) . $path;
	}

	/**
	 * Get all demos
	 *
	 * @param bool $force
	 *
	 * @return mixed|void
	 */
	public function all( $force = false ) {

		if ( $force ) {
			delete_transient( 'kcmp_demos' );
		}

		$demos    = get_transient( 'kcmp_demos' );
		$template = kcmp_current_template();

		if ( false === $demos || ( isset( $demos->slug ) && $template !== $demos->slug ) ) {
			$raw_demos = wp_safe_remote_get( $this->api( "{$template}/config.json" ) );

			if ( ! is_wp_error( $raw_demos ) ) {
				$demos = json_decode( wp_remote_retrieve_body( $raw_demos ) );

				if ( $demos ) {
					set_transient( 'kcmp_demos', $demos, DAY_IN_SECONDS );
				}
			}
		}

		return apply_filters( "kcmp_{$template}_demos", false === $demos ? new \stdClass() : $demos );
	}

	/**
	 * Get template data
	 *
	 * @param string $slug
	 * @param boolean $license_check
	 *
	 * @return \WP_Error
	 */
	public function get( $slug, $license_check = true ) {
		$demofiles = $this->all();
		// network error
		if ( ! property_exists( $demofiles, 'demos' ) ) {
			return new \WP_Error(
				'template_import_network_error',
				__( 'Error: Network error.', 'kenta-companion' )
			);
		}

		$demos = $demofiles->demos;

		// demo does not exists
		if ( ! property_exists( $demos, $slug ) ) {
			return new \WP_Error(
				'template_import_does_not_exists',
				__( 'Error: Template doest not exists.', 'kenta-companion' )
			);
		}

		$demo = $demos->{$slug};

		if ( $license_check ) {
			$premium = property_exists( $demo, 'premium' ) && $demo->premium;
			// not allowed
			if ( $premium && kenta_fs()->is_not_paying() ) {
				return new \WP_Error(
					'template_import_premium_not_paying',
					__( 'Error: You need upgrade your plan to import Premium Template.', 'kenta-companion' )
				);
			}
		}

		return $demo;
	}

	/**
	 * Perform import action
	 *
	 * @param $slug
	 * @param string[] $types
	 *
	 * @return string|void|\WP_Error
	 */
	public function import( $slug, $types = [ 'content', 'customizer', 'widgets', 'site_settings' ] ) {
		$demo = $this->get( $slug );
		if ( is_wp_error( $demo ) ) {
			return $demo;
		}

		$dummy      = $demo->dummy;
		$template   = kcmp_current_template();
		$downloader = new Downloader();

		$this->active = array(
			'slug' => $slug,
			'data' => $demo
		);

		do_action( 'kcmp/template_before_import', $slug, $types );

		$this->set_demo_import_start_time();

		// import dummy data
		foreach ( $types as $type ) {
			if ( ! property_exists( $dummy, $type ) ) {
				continue;
			}

			do_action( 'kcmp/template_before_import_' . $type );

			$remote_filename = $dummy->{$type};

			$url      = $this->api( "{$template}/{$slug}/{$remote_filename}" );
			$filename = apply_filters( 'kcmp/downloaded_' . $type . '_file_prefix', 'kcmp-' . $type . '-import-file_' ) .
			            $this->demo_import_start_time .
			            '_' . $slug . '_' . $remote_filename;
			$file     = $downloader->download_file( $url, $filename );

			// Return from this function if there was an error.
			if ( is_wp_error( $file ) ) {
				return $file;
			}

			$this->{'import_' . $type}( $file, $slug, $demo );

			kcmp( 'io' )->delete( $file );

			do_action( 'kcmp/template_after_import_' . $type );
		}

		do_action( 'kcmp/template_imported', $slug, $types );

		$this->active = null;

		return $this->frontend_error_messages;
	}

	/**
	 * Import content
	 *
	 * @param string $xml_file
	 * @param string $slug
	 * @param \stdClass $demo
	 *
	 * @return void
	 */
	public function import_content( $xml_file, $slug, $demo ) {

		// Importer options array.
		$importer_options = apply_filters( 'kcmp/importer_options', array(
			'fetch_attachments' => true,
		) );

		$importer = new ContentImporter( $importer_options );
		$importer->import_content( $xml_file );
		// import core options
		$this->import_core_options( $slug, $demo );
	}

	/**
	 * Import customizer file
	 *
	 * @param string $cz_file
	 * @param string $slug
	 * @param \stdClass $data
	 *
	 * @return void
	 */
	public function import_customizer( $cz_file, $slug, $data ) {
		CustomizerImporter::import( $cz_file, $slug, $data );
	}

	/**
	 * Import widgets file
	 *
	 * @param string $widget_file
	 *
	 * @return void
	 */
	public function import_widgets( $widget_file ) {
		WidgetImporter::import( $widget_file );
	}

	/**
	 * Import elementor site settings
	 *
	 * @return void
	 */
	public function import_site_settings( $settings_file, $slug ) {
		$elementor_version = defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : false;
		if ( $elementor_version === false ) {
			return new \WP_Error( 'elementor_missing', __( 'Elementor Page Builder is not available.', 'kenta-companion' ) );
		}

		if ( ! version_compare( $elementor_version, '3.0.0', '>=' ) ) {
			return new \WP_Error( 'elementor_too_old', __( 'Elementor Page Builder version is too old.', 'kenta-companion' ) );
		}

		$raw = kcmp( 'io' )->data_from_file( $settings_file );

		// Make sure we got the data.
		if ( is_wp_error( $raw ) ) {
			$this->append_to_frontend_error_messages( $raw->get_error_message() );

			return;
		}

		$site_settings = json_decode( $raw, true );

		if ( ! empty( $site_settings['settings'] ) ) {
			$default_kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();

			$kit_settings = $default_kit->get_settings();
			$new_settings = $site_settings['settings'];
			$settings     = array_merge( $kit_settings, $new_settings );

			$default_kit->save( [ 'settings' => $settings ] );
		}

		kcmp_localize_elementor_image( $slug );
	}

	/**
	 * Import core options
	 *
	 * @param string $slug
	 * @param \stdClass $data
	 *
	 * @return void
	 */
	public function import_core_options( $slug, $data ) {

		if ( ! property_exists( $data, 'core' ) ) {
			return;
		}

		$core_options = (array) $data->core;
		foreach ( $core_options as $key => $value ) {
			// Format the value based on option key.
			switch ( $key ) {
				case 'show_on_front':
					if ( in_array( $value, array( 'posts', 'page' ) ) ) {
						update_option( 'show_on_front', $value );
					}
					break;
				case 'page_on_front':
				case 'page_for_posts':
					$page = get_page_by_title( $value );

					if ( is_object( $page ) && $page->ID ) {
						update_option( $key, $page->ID );
						update_option( 'show_on_front', 'page' );
					}
					break;
				case 'kenta_blocks_sync_theme':
					update_option( 'kb_sync_kenta_theme', $value );
					break;
				case 'blogname':
				case 'blogdescription':
					update_option( $key, sanitize_text_field( $value ) );
					break;
			}
		}
	}

	/**
	 * Update custom nav menu items URL.
	 */
	public function update_nav_menu_items() {
		$menu_locations = get_nav_menu_locations();

		foreach ( $menu_locations as $location => $menu_id ) {

			if ( is_nav_menu( $menu_id ) ) {
				$menu_items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'any' ) );

				if ( ! empty( $menu_items ) ) {
					foreach ( $menu_items as $menu_item ) {
						if ( isset( $menu_item->url ) && isset( $menu_item->db_id ) && 'custom' == $menu_item->type ) {
							$site_parts = parse_url( home_url( '/' ) );
							$menu_parts = parse_url( $menu_item->url );

							// Update existing custom nav menu item URL.
							if ( isset( $menu_parts['path'] ) && isset( $menu_parts['host'] ) && apply_filters( 'kcmp/demo_importer_nav_menu_item_url_hosts', in_array( $menu_parts['host'], array(
									'kentatheme.com'
								) ) ) ) {

								$menu_item->url = str_replace( array(
									$menu_parts['scheme'],
									$menu_parts['host'] . ( isset( $menu_parts['port'] ) ? ':' . $menu_parts['port'] : '' ),
									$menu_parts['path']
								), array(
									$site_parts['scheme'],
									$site_parts['host'] . ( isset( $site_parts['port'] ) ? ':' . $site_parts['port'] : '' ),
									trailingslashit( $site_parts['path'] )
								), $menu_item->url );

								update_post_meta( $menu_item->db_id, '_menu_item_url', esc_url_raw( $menu_item->url ) );
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Update customizer settings data.
	 *
	 * @param array $settings
	 * @param string $slug
	 * @param \stdClass $data
	 *
	 * @return array
	 */
	public function update_customizer_data( $settings, $slug, $data ) {
		if ( ! property_exists( $data, 'customizer' ) ) {
			return $settings;
		}

		$customizer = json_decode( wp_json_encode( $data->customizer ), true );

		foreach ( $customizer as $data_type => $data_value ) {
			if ( ! in_array( $data_type, array( 'pages', 'categories', 'nav_menu_locations' ) ) ) {
				continue;
			}

			// Format the value based on data type.
			switch ( $data_type ) {
				case 'pages':
					foreach ( $data_value as $option_key => $option_value ) {
						if ( ! empty( $settings['mods'][ $option_key ] ) ) {
							$page = get_page_by_title( $option_value );

							if ( is_object( $page ) && $page->ID ) {
								$settings['mods'][ $option_key ] = $page->ID;
							}
						}
					}
					break;
				case 'categories':
					foreach ( $data_value as $taxonomy => $taxonomy_data ) {
						if ( ! taxonomy_exists( $taxonomy ) ) {
							continue;
						}

						foreach ( $taxonomy_data as $option_key => $option_value ) {
							if ( ! empty( $settings['mods'][ $option_key ] ) ) {
								$term = get_term_by( 'name', $option_value, $taxonomy );

								if ( is_object( $term ) && $term->term_id ) {
									$settings['mods'][ $option_key ] = $term->term_id;
								}
							}
						}
					}
					break;
				case 'nav_menu_locations':
					$nav_menus = wp_get_nav_menus();

					if ( ! empty( $nav_menus ) ) {
						foreach ( $nav_menus as $nav_menu ) {
							if ( is_object( $nav_menu ) ) {
								foreach ( $data_value as $location => $location_name ) {
									if ( $nav_menu->name == $location_name ) {
										$settings['mods'][ $data_type ][ $location ] = $nav_menu->term_id;
									}
								}
							}
						}
					}
					break;
			}
		}

		return $settings;
	}

	/**
	 * Update content links
	 *
	 * @param $postdata
	 * @param $post
	 */
	public function update_content_links( $data ) {
		if ( ! $this->active ) {
			return;
		}

		$demo_site = KCMP_DEMO_SITE_URL . $this->active['slug'];

		foreach ( $data['processed_posts'] as $post_id ) {
			$post = get_post( $post_id );
			if ( ! $post ) {
				continue;
			}

			$content = $post->post_content;

			preg_match_all( '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match );

			$urls = array_unique( $match[0] );

			if ( empty( $urls ) ) {
				continue;
			}

			$map_urls = array();

			// find inner pages url
			foreach ( $urls as $url ) {
				if ( 0 === strpos( $url, $demo_site ) ) {
					$page = get_page_by_path( str_replace( $demo_site, '', $url ) );
					if ( $page ) {
						$map_urls[ $url ] = get_page_link( $page );
					}
				}
			}

			// replace demo site url
			foreach ( $map_urls as $old_url => $new_url ) {
				$content = str_replace( $old_url, $new_url, $content );
				$old_url = str_replace( '/', '/\\', $old_url );
				$new_url = str_replace( '/', '/\\', $new_url );
				$content = str_replace( $old_url, $new_url, $content );
			}

			wp_update_post( array(
				'ID'           => $post->ID,
				'post_content' => $content
			) );
		}
	}

	/**
	 * Get log file path
	 *
	 * @return string path to the log file
	 */
	public function get_log_file_path() {
		$upload_dir  = wp_upload_dir();
		$upload_path = apply_filters( 'kcmp/upload_file_path', trailingslashit( $upload_dir['path'] ) );

		$log_path = $upload_path . apply_filters( 'kcmp/log_file_prefix', 'log_file_' ) . $this->demo_import_start_time . apply_filters( 'kcmp/log_file_suffix_and_file_extension', '.txt' );

		kcmp_register_file_as_media_attachment( $log_path );

		return $log_path;
	}

	/**
	 * Setter function to append additional value to the private frontend_error_messages value.
	 *
	 * @param $text
	 */
	public function append_to_frontend_error_messages( $text ) {
		$lines = array();

		if ( ! empty( $text ) ) {
			$text  = str_replace( '<br>', PHP_EOL, $text );
			$lines = explode( PHP_EOL, $text );
		}

		foreach ( $lines as $line ) {
			if ( ! empty( $line ) && ! in_array( $line, $this->frontend_error_messages ) ) {
				$this->frontend_error_messages[] = $line;
			}
		}
	}
}