<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();


class Shortcode_Builder {
	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {
	}

	public function get_shortcode( $id = null ) {
		global $wpdb;

		$table = $wpdb->prefix . 'integrate_google_drive_shortcodes';

		if ( $id ) {
			$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id=%d", $id ) );
		} else {
			$result = $wpdb->get_results( "SELECT * FROM $table" );
		}

		return $result;

	}

	public function update_shortcode( $posted, $force_insert = false ) {
		global $wpdb;

		$table  = $wpdb->prefix . 'integrate_google_drive_shortcodes';
		$id     = ! empty( $posted['id'] ) ? intval( $posted['id'] ) : '';
		$status = ! empty( $posted['status'] ) ? sanitize_key( $posted['status'] ) : 'on';
		$title  = ! empty( $posted['title'] ) ? sanitize_text_field( $posted['title'] ) : '';

		$data = [
			'title'  => $title,
			'status' => $status,
			'config' => ! empty( $posted['config'] ) ? $posted['config'] : serialize( $posted ),
		];


		$data_format = [ '%s', '%s', '%s' ];

		if ( ! empty( $posted['created_at'] ) ) {
			$data['created_at'] = $posted['created_at'];
			$data_format[]      = '%s';
		}

		if ( ! empty( $posted['updated_at'] ) ) {
			$data['updated_at'] = $posted['updated_at'];
			$data_format[]      = '%s';
		}

		if ( ! $id || $force_insert ) {
			$wpdb->insert( $table, $data, $data_format );

			return $wpdb->insert_id;
		} else {
			$wpdb->update( $table, $data, [ 'id' => $id ], $data_format, [ '%d' ] );

			return $id;
		}

	}

	public function duplicate_shortcode( $id ) {
		if ( empty( $id ) ) {
			return false;
		}

		$shortcode = $this->get_shortcode( $id );
		if ( $shortcode ) {
			$shortcode               = (array) $shortcode;
			$shortcode['title']      = 'Copy of ' . $shortcode['title'];
			$shortcode['created_at'] = current_time( 'mysql' );
			$shortcode['updated_at'] = current_time( 'mysql' );
			$insert_id               = $this->update_shortcode( $shortcode, true );

			$data = array_merge( $shortcode, [
				'id'     => $insert_id,
				'config' => unserialize( $shortcode['config'] ),
			] );

			return $data;
		}

		return false;
	}

	public function delete_shortcode( $id = false ) {
		global $wpdb;
		$table = $wpdb->prefix . 'integrate_google_drive_shortcodes';

		if ( $id ) {
			$wpdb->delete( $table, [ 'id' => $id ], [ '%d' ] );
		} else {
			$wpdb->query( "TRUNCATE TABLE $table" );
		}

	}

	public static function view() { ?>
        <div id="igd-shortcode-builder"></div>
	<?php }

	/**
	 * @return Shortcode_Builder|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Shortcode_Builder::instance();