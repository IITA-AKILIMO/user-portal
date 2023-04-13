<?php

defined( 'ABSPATH' ) || exit;

use IGD\App;
use IGD\Client;
use IGD\Download;
use IGD\Importer;
use IGD\Shortcode_Builder;
use IGD\Uploader;


class IGD_Ajax {

	private static $instance = null;

	public function __construct() {

		// Preview content
		add_action( 'wp_ajax_igd_preview', [ $this, 'preview' ] );
		add_action( 'wp_ajax_nopriv_igd_preview', [ $this, 'preview' ] );

		// Get share URL
		add_action( 'wp_ajax_igd_get_share_link', [ $this, 'get_share_link' ] );
		add_action( 'wp_ajax_nopriv_igd_get_share_link', [ $this, 'get_share_link' ] );

		// Generate thumbnail
		add_action( 'wp_ajax_igd_get_preview_thumbnail', [ $this, 'get_preview_thumbnail' ] );
		add_action( 'wp_ajax_nopriv_igd_get_preview_thumbnail', [ $this, 'get_preview_thumbnail' ] );

		// Delete Shortcode
		add_action( 'wp_ajax_igd_delete_shortcode', [ $this, 'delete_shortcode' ] );
		add_action( 'wp_ajax_nopriv_igd_delete_shortcode', [ $this, 'delete_shortcode' ] );

		// TODO: Remove in future for block dependency
		add_action( 'wp_ajax_igd_get_shortcodes', [ $this, 'get_shortcodes' ] );
		add_action( 'wp_ajax_nopriv_igd_get_shortcodes', [ $this, 'get_shortcodes' ] );

		// Clear cache files
		add_action( 'wp_ajax_igd_clear_cache', [ $this, 'clear_cache_files' ] );

		// Download file
		add_action( 'wp_ajax_igd_download', [ $this, 'download' ] );
		add_action( 'wp_ajax_nopriv_igd_download', [ $this, 'download' ] );

		// Get download status
		add_action( 'wp_ajax_igd_download_status', [ $this, 'get_download_status' ] );
		add_action( 'wp_ajax_nopriv_igd_download_status', [ $this, 'get_download_status' ] );

		// Zip Download
		add_action( 'wp_ajax_igd_download_zip', [ $this, 'download_zip' ] );
		add_action( 'wp_ajax_nopriv_igd_download_zip', [ $this, 'download_zip' ] );


		// Get upload direct url
		add_action( 'wp_ajax_igd_get_upload_url', [ $this, 'get_upload_url' ] );
		add_action( 'wp_ajax_nopriv_igd_get_upload_url', [ $this, 'get_upload_url' ] );


		// Stream
		add_action( 'wp_ajax_igd_stream', [ $this, 'stream_content' ] );
		add_action( 'wp_ajax_nopriv_igd_stream', [ $this, 'stream_content' ] );

		if ( igd_fs()->can_use_premium_code__premium_only() ) {

			// Upload notification
			add_action( 'wp_ajax_igd_upload_notification', [ $this, 'send_upload_notification__premium_only' ] );
			add_action( 'wp_ajax_nopriv_igd_upload_notification', [ $this, 'send_upload_notification__premium_only' ] );
		}

		// Handle admin  notice
		add_action( 'wp_ajax_igd_handle_notice', [ $this, 'handle_notice' ] );

		// Hide Recommended Plugins
		add_action( 'wp_ajax_igd_hide_recommended_plugins', [ $this, 'hide_recommended_plugins' ] );

		// Upload post process
		add_action( 'wp_ajax_igd_file_uploaded', [ $this, 'upload_post_process' ] );
		add_action( 'wp_ajax_nopriv_igd_file_uploaded', [ $this, 'upload_post_process' ] );
	}

	public function upload_post_process() {
		$file = ! empty( $_REQUEST['file'] ) ? $_REQUEST['file'] : [];

		$account_id = ! empty( $file['accountId'] ) ? sanitize_text_field( $file['accountId'] ) : '';

		Uploader::instance( $account_id )->upload_post_process( $file );

		//Save uploaded files in the order meta-data for order-received page and my-account page
		$item_id    = ! empty( $_REQUEST['wcOrderId'] ) ? intval( $_REQUEST['wcOrderId'] ) : false;
		$product_id = ! empty( $_REQUEST['wcProductId'] ) ? intval( $_REQUEST['wcProductId'] ) : false;

		if ( $item_id ) {
			if ( function_exists( 'wc_add_order_item_meta' ) ) {
				wc_add_order_item_meta( $item_id, '_igd_files', $file );
			}
		} elseif ( $product_id ) {
			//Save uploaded files in the session for checkout page

			if ( function_exists( 'WC' ) ) {
				$files = WC()->session->get( 'igd_product_files_' . $product_id, [] );

				$files[] = $file;

				WC()->session->set( 'igd_product_files_' . $product_id, $files );
			}
		}

	}

	public function hide_recommended_plugins() {
		update_option( "igd_hide_recommended_plugins", true );
		wp_send_json_success();
	}

	public function handle_notice() {
		$type  = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
		$value = isset( $_POST['value'] ) ? sanitize_text_field( $_POST['value'] ) : '';

		if ( 'rating' == $type ) {
			if ( 'hide_notice' == $value ) {
				update_option( 'igd_rating_notice', 'off' );
			} else {
				set_transient( 'igd_rating_notice_interval', 'off', $value * DAY_IN_SECONDS );
			}
		}

		update_option( sanitize_key( 'igd_notices' ), [] );
	}

	public function get_upload_url() {
		$data = $_POST;

		$account_id = ! empty( $data['accountId'] ) ? sanitize_text_field( $data['accountId'] ) : '';

		$url = Uploader::instance( $account_id )->get_resume_url( $data );

		if ( isset( $url['error'] ) ) {
			wp_send_json_error( $url );
		}

		wp_send_json_success( $url );
	}

	public function get_share_link() {
		$file = $_REQUEST['file'];

		$embed_link = igd_get_embed_url( $file );

		if ( ! $embed_link ) {
			wp_send_json_error( [ 'message' => __( 'Something went wrong! Preview is not available', 'integrate-google-drive' ) ] );
		}

		$view_link = str_replace( [ 'edit?usp=drivesdk', 'preview?rm=minimal', 'preview' ], 'view', $embed_link );

		wp_send_json_success( [ 'embedLink' => $embed_link, 'viewLink' => $view_link ] );

	}

	public function clear_cache_files() {
		igd_delete_cache();

		wp_send_json_success();
	}

	public function get_shortcodes() {
		$shortcodes = Shortcode_Builder::instance()->get_shortcode();

		$formatted = [];

		if ( ! empty( $shortcodes ) ) {
			foreach ( $shortcodes as $shortcode ) {
				$shortcode->config = unserialize( $shortcode->config );

				$formatted[] = igd_sanitize_array_bool( $shortcode );
			}
		}

		wp_send_json_success( $formatted );
	}

	public function delete_shortcode() {
		$id = ! empty( $_POST['id'] ) ? intval( $_POST['id'] ) : '';

		Shortcode_Builder::instance()->delete_shortcode( $id );

		wp_send_json_success();
	}

	public function preview() {
		$file_id    = sanitize_text_field( $_REQUEST['file_id'] );
		$account_id = sanitize_text_field( $_REQUEST['account_id'] );

		$popout = true;

		if ( ! empty( $_REQUEST['popout'] ) ) {
			$popout = filter_var( $_REQUEST['popout'], FILTER_VALIDATE_BOOLEAN );
		}

		if ( ! empty( $_REQUEST['direct_link'] ) ) {
			$popout = false;
		}

		$app  = App::instance( $account_id );
		$file = $app->get_file_by_id( $file_id );

		$preview_url = igd_get_embed_url( $file, false, false, true, $popout );

		if ( ! $preview_url ) {
			_e( 'Something went wrong! Preview is not available', 'integrate-google-drive' );
			die();
		}

		do_action( 'igd_insert_log', 'preview', $file_id, $account_id );

		header( 'Location: ' . $preview_url );

		die();
	}


	public function download() {

		$account_id = ! empty( $_REQUEST['accountId'] ) ? sanitize_text_field( $_REQUEST['accountId'] ) : '';
		$file_id    = ! empty( $_REQUEST['id'] ) ? sanitize_text_field( $_REQUEST['id'] ) : '';
		$mimetype   = ! empty( $_REQUEST['mimetype'] ) ? sanitize_text_field( $_REQUEST['mimetype'] ) : 'default';


		try {
			$file = App::instance( $account_id )->get_file_by_id( $file_id );
		} catch ( Exception $e ) {
			_e( 'Something went wrong! File may be deleted or moved to trash.', 'integrate-google-drive' );
			die();
		}

		//insert download log
		do_action( 'igd_insert_log', 'download', $file_id, $account_id );

		//send email notification
		if ( igd_get_settings( 'downloadNotifications', true ) ) {
			do_action( 'igd_send_notification', 'download', [ $file_id ], $account_id );
		}

		//check if shortcut file then get the original file
		if ( igd_is_shortcut( $file['type'] ) ) {
			$file = App::instance( $account_id )->get_file_by_id( $file['shortcutDetails']['targetId'] );
		}

		// get the last-modified-date of this very file
		$updated_date = $file['updated'];

		// get a unique hash of this file (etag)
		$etag_file = md5( $updated_date );

		// get the HTTP_IF_MODIFIED_SINCE header if set
		$if_modified_since = isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) ? sanitize_text_field( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) : false;

		// get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
		$etag_header = isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) ? trim( sanitize_text_field( $_SERVER['HTTP_IF_NONE_MATCH'] ) ) : false;

		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', strtotime( $updated_date ) ) . ' GMT' );
		header( "Etag: {$etag_file}" );
		header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 60 * 5 ) . ' GMT' );
		header( 'Cache-Control: must-revalidate' );

		if ( $if_modified_since && $etag_header && ( strpos( $if_modified_since, $etag_file ) !== false ) ) {
			header( 'HTTP/1.1 304 Not Modified' );
			exit();
		}

		$download = Download::instance( $file, false, $mimetype );
		$download->start_download();
		exit();

	}

	public function get_preview_thumbnail() {
		$id         = sanitize_text_field( $_REQUEST['id'] );
		$account_id = ! empty( $_REQUEST['accountId'] ) ? sanitize_text_field( $_REQUEST['accountId'] ) : '';
		$size       = sanitize_key( $_REQUEST['size'] );

		$file = App::instance( $account_id )->get_file_by_id( $id );

		if ( 'large' === $size ) {
			$thumbnail_attributes = '=s0';
		} else if ( 'gallery' === $size ) {
			$thumbnail_attributes = '=h300-nu-iv1';
		} else {
			$thumbnail_attributes = '=w200-h190-p-k-nu-iv1';
		}

		$thumbnail_file = $id . $thumbnail_attributes . '.png';

		if ( file_exists( IGD_CACHE_DIR . '/thumbnails/' . $thumbnail_file ) && ( filemtime( IGD_CACHE_DIR . '/thumbnails/' . $thumbnail_file ) === strtotime( $file['updated'] ) ) ) {
			$url      = IGD_CACHE_URL . '/thumbnails/' . $thumbnail_file;
			$img_info = getimagesize( $url );
			header( "Content-type: {$img_info['mime']}" );
			readfile( $url );

			exit();
		}

		$download_link = "https://lh3.google.com/u/0/d/{$id}{$thumbnail_attributes}";

		try {

			$client = Client::instance( $account_id )->get_client();

			$request = new \IGDGoogle_Http_Request( $download_link, 'GET' );

			$client->getIo()->setOptions( [
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_FOLLOWLOCATION => true
			] );

			$httpRequest = $client->getAuth()->authenticatedRequest( $request );

			// Save the thumbnail locally
			$headers = $httpRequest->getResponseHeaders();

			if ( ! stristr( $headers['content-type'], 'image' ) ) {
				return;
			}

			if ( ! file_exists( IGD_CACHE_DIR . '/thumbnails' ) ) {
				@mkdir( IGD_CACHE_DIR . '/thumbnails', 0755 );
			}

			if ( ! is_writable( IGD_CACHE_DIR . '/thumbnails' ) ) {
				@chmod( IGD_CACHE_DIR . '/thumbnails', 0755 );
			}

			@file_put_contents( IGD_CACHE_DIR . '/thumbnails/' . $thumbnail_file, $httpRequest->getResponseBody() ); //New SDK: $response->getBody()
			touch( IGD_CACHE_DIR . '/thumbnails/' . $thumbnail_file, strtotime( $file['updated'] ) );

			echo $httpRequest->getResponseBody();

		} catch ( \Exception $e ) {
			echo esc_html( $e->getMessage() );
		}

		exit();
	}

	public function get_download_status() {
		$id     = ! empty( $_REQUEST['id'] ) ? sanitize_text_field( $_REQUEST['id'] ) : '';
		$status = get_transient( 'igd_download_status_' . $id );

		wp_send_json_success( $status );
	}

	public function stream_content() {
		$file_id    = ! empty( $_REQUEST['id'] ) ? sanitize_text_field( $_REQUEST['id'] ) : '';
		$account_id = ! empty( $_REQUEST['accountId'] ) ? sanitize_text_field( $_REQUEST['accountId'] ) : '';

		do_action( 'igd_insert_log', 'stream', $file_id, $account_id );

		$file = App::instance( $account_id )->get_file_by_id( $file_id );

		//check if shortcut file then get the original file
		if ( igd_is_shortcut( $file['type'] ) ) {
			$file = App::instance( $account_id )->get_file_by_id( $file['shortcutDetails']['targetId'] );
		}

		Download::instance( $file, true )->start_download();

		exit();
	}

	public function download_zip() {
		$file_ids   = ! empty( $_REQUEST['file_ids'] ) ? json_decode( base64_decode( sanitize_text_field( $_REQUEST['file_ids'] ) ) ) : [];
		$request_id = ! empty( $_REQUEST['id'] ) ? sanitize_text_field( $_REQUEST['id'] ) : '';
		$account_id = ! empty( $_REQUEST['accountId'] ) ? sanitize_text_field( $_REQUEST['accountId'] ) : '';

		//send email notification
		if ( igd_get_settings( 'downloadNotifications', true ) ) {
			do_action( 'igd_send_notification', 'download', $file_ids, $account_id );
		}

		igd_download_zip( $file_ids, $request_id, $account_id );
		exit();
	}

	public function send_upload_notification__premium_only() {
		$file_ids   = ! empty( $_POST['fileIds'] ) ? $_POST['fileIds'] : [];
		$account_id = ! empty( $_POST['accountId'] ) ? sanitize_text_field( $_POST['accountId'] ) : '';

		//send email notification
		if ( igd_get_settings( 'uploadNotifications', true ) ) {
			do_action( 'igd_send_notification', 'upload', $file_ids, $account_id );
		}
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

IGD_Ajax::instance();