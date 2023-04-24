<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();


class Files {
	/**
	 * @var null
	 */
	protected static $instance = null;

	private $table;
	private $account_id;

	public function __construct( $account_id = null ) {

		if ( empty( $account_id ) ) {
			$active_account = Account::get_active_account();
			if ( $active_account ) {
				$account_id = $active_account['id'];
			}
		}

		$this->account_id = $account_id;

		global $wpdb;
		$this->table = $wpdb->prefix . 'integrate_google_drive_files';
	}

	/**
	 * Get files
	 *
	 * @param $parent_id
	 *
	 * @return array
	 */
	public function get( $parent_id ) {
		global $wpdb;

		$where = [];

		if ( ! empty( $this->account_id ) ) {
			$where['account_id'] = $this->account_id;
		}

		if ( 'computers' == $parent_id ) {
			$where['is_computers'] = 1;
		} elseif ( 'shared-drives' == $parent_id ) {
			$where['is_shared_drive'] = 1;
		} elseif ( 'shared' == $parent_id ) {
			$where['is_shared_with_me'] = 1;
		} elseif ( 'starred' == $parent_id ) {
			$where['is_starred'] = 1;
		} elseif ( 'recent' == $parent_id ) {
			$where['is_recent'] = '!=0';
		} else {
			$where['parent_id'] = $parent_id;
		}

		$where_placeholders = '';
		$where_values       = [];

		foreach ( $where as $key => $value ) {
			if ( 'is_recent' == $key ) {
				$where_placeholders .= " AND $key != %s ORDER BY `is_recent` ASC";
				$where_values[]     = $value;
			} else {
				$where_placeholders .= " AND $key=%s";
				$where_values[]     = $value;
			}

		}

		$sql = "SELECT data FROM `$this->table` WHERE 1 $where_placeholders";

		$items = $wpdb->get_results( $wpdb->prepare( $sql, $where_values ), ARRAY_A );

		$files = [];

		if ( ! empty( $items ) ) {
			foreach ( $items as $item ) {
				$files[] = unserialize( $item['data'] );
			}
		}


		return $files;
	}

	/**
	 * Set files
	 *
	 * @param $files
	 * @param $folder
	 *
	 * @return void
	 */
	public function set( $files, $folder = '' ) {

		if ( ! empty( $files ) ) {
			foreach ( $files as $key => $file ) {
				$this->add_file( $file, $folder, $key );
			}
		}
	}

	/**
	 * Get cached file by ID
	 *
	 * @param $id
	 *
	 * @return false|mixed
	 */
	public function get_file_by_id( $id ) {
		global $wpdb;

		$sql  = $wpdb->prepare( "SELECT data FROM `$this->table` WHERE id = %s", $id );
		$item = $wpdb->get_row( $sql, ARRAY_A );

		return ! empty( $item['data'] ) ? unserialize( $item['data'] ) : false;
	}

	public function get_file_by_name( $name ) {
		global $wpdb;

		$sql  = $wpdb->prepare( "SELECT data FROM `$this->table` WHERE name = %s", $name );
		$item = $wpdb->get_row( $sql, ARRAY_A );

		return ! empty( $item['data'] ) ? unserialize( $item['data'] ) : false;
	}

	/**
	 * @param $file
	 * @param $folder
	 *
	 * @return void
	 */
	public function add_file( $file, $folder_id = '', $key = null ) {

		global $wpdb;

		$is_computers      = 'computers' == $folder_id;
		$is_shared_with_me = 'shared' == $folder_id || ! empty( $file['sharedWithMeTime'] );
		$is_starred        = 'starred' == $folder_id || ! empty( $file['starred'] );
		$is_recent         = 'recent' == $folder_id ? $key + 1 : null;
		$is_shared_drive   = ! empty( $file['shared-drives'] );

		$sql = "REPLACE INTO `$this->table` (id, name, parent_id, account_id, type, data, is_computers, is_shared_with_me, is_starred, is_recent, is_shared_drive) 
		VALUES (%s,%s,%s,%s,%s,%s,%d,%d,%d,%d,%d )";

		$values = [
			$file['id'],
			$file['name'],
			! empty( $file['parents'] ) ? $file['parents'][0] : '',
			$this->account_id,
			$file['type'],
			serialize( $file ),
			$is_computers,
			$is_shared_with_me,
			$is_starred,
			$is_recent,
			$is_shared_drive,
		];

		$wpdb->query( $wpdb->prepare( $sql, $values ) );

	}

	/**
	 * @return void
	 */
	public function delete_account_files() {
		global $wpdb;

		$wpdb->delete( $this->table, [ 'account_id' => $this->account_id ], [ '%s' ] );
	}

	/**
	 * @param $data
	 * @param $where
	 * @param $format
	 * @param $where_format
	 *
	 * @return void
	 */
	public function update_file( $data, $where, $format = [], $where_format = [] ) {
		global $wpdb;

		$wpdb->update( $this->table, $data, $where, $format, $where_format );

	}

	/**
	 * @param $where
	 * @param $where_format
	 *
	 * @return void
	 */
	public function delete( $where, $where_format = [] ) {
		global $wpdb;

		$wpdb->delete( $this->table, $where, $where_format );
	}

	/**
	 * @return Files|null
	 */
	public static function instance( $account_id = null ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $account_id );
		}

		return self::$instance;
	}

}

Files::instance();