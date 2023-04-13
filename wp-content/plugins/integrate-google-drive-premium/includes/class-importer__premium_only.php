<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;

class Importer {
	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {
		add_action( 'wp_ajax_igd_import_media', array( $this, 'import' ) );
		add_action( 'wp_ajax_nopriv_igd_import_media', array( $this, 'import' ) );
	}

	public function import() {
		$service = App::instance()->getService();

		$files = ! empty( $_POST['files'] ) ? $_POST['files'] : [];

		if ( ! empty( $files ) ) {
			foreach ( $files as $file ) {

				$file_id   = $file['id'];
				$file_type = $file['type'];

				if ( ! empty( $file['shortcutDetails'] ) ) {
					$file_id   = $file['shortcutDetails']['targetId'];
					$file_type = $file['shortcutDetails']['targetMimeType'];
				}

				$content = $service->files->get( $file_id, array(
					'alt'               => 'media',
					'supportsAllDrives' => true,
				) );

				$this->insert_attachment( $file['name'], $content, $file_type );
			}
		}

		wp_send_json_success( [
			'success' => true,
		] );
	}


	public function insert_attachment( $filename, $content, $mime_type ) {

		if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			include_once( ABSPATH . 'wp-admin/includes/media.php' );
		}


		$upload_dir  = wp_upload_dir();
		$upload_path = $upload_dir['path'];
		$upload_url  = $upload_dir['url'];

		$filename = wp_unique_filename( $upload_path, $filename );

		$extension = igd_mime_to_ext( $mime_type );

		$upload = file_put_contents( $upload_path . '/' . $filename, $content );

		if ( $upload ) {
			$attachment = array(
				'guid'           => $upload_url . '/' . $filename,
				'post_mime_type' => $mime_type,
				'post_title'     => str_replace( ' . ' . $extension, '', $filename ),
				'post_status'    => 'publish'
			);

			$image_path = $upload_path . '/' . $filename;

			// Insert attachment
			$attach_id   = wp_insert_attachment( $attachment, $image_path );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $image_path );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			return true;
		}

		return false;
	}

	/**
	 * @return Importer|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Importer::instance();