<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;

class WooCommerce_Downloads {

	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {

		// Handle Downloads
		add_action( 'woocommerce_download_file_force', [ $this, 'do_download' ], 1 );
		add_action( 'woocommerce_download_file_xsendfile', [ $this, 'do_download' ], 1 );
		add_action( 'woocommerce_download_file_redirect', [ $this, 'do_redirect' ], 1 );

	}


	public function do_download( $file_url ) {
		if ( ! strpos( $file_url, 'igd-wc-download' ) ) {
			return;
		}

		$parts = parse_url( $file_url );
		parse_str( $parts['query'], $query_args );

		$id         = ! empty( $query_args['id'] ) ? $query_args['id'] : '';
		$account_id = ! empty( $query_args['account_id'] ) ? $query_args['account_id'] : '';
		$type       = ! empty( $query_args['type'] ) ? $query_args['type'] : '';

		$is_folder = ! empty( $query_args['is_folder'] ) || igd_is_dir( $type );

		if ( $is_folder ) {
			igd_download_zip( [ $id ], '', $account_id );
		} else {
			$download_url = admin_url( 'admin-ajax.php?action=igd_download&id=' . $id . '&accountId=' . $account_id );
			wp_redirect( $download_url );
		}

		exit();

	}

	/**
	 * Redirect to the content in the Google Drive instead of downloading the file
	 *
	 * @param $file_url
	 *
	 * @return void
	 */
	public function do_redirect( $file_url ) {
		if ( ! strpos( $file_url, 'igd-wc-download' ) ) {
			return;
		}

		$parts = parse_url( $file_url );
		parse_str( $parts['query'], $query_args );

		$id         = $query_args['id'];
		$account_id = ! empty( $query_args['account_id'] ) ? $query_args['account_id'] : '';
		$type       = ! empty( $query_args['type'] ) ? $query_args['type'] : '';
		$name       = ! empty( $query_args['name'] ) ? $query_args['name'] : '';

		$file_string = base64_encode( json_encode( array(
			'id'        => $id,
			'accountId' => $account_id,
			'type'      => $type,
			'name'      => $name,
		) ) );

		$redirect_url = site_url( '?direct_file=' . $file_string );
		wp_redirect( $redirect_url );

		exit();
	}

	/**
	 * @return WooCommerce_Downloads|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

WooCommerce_Downloads::instance();