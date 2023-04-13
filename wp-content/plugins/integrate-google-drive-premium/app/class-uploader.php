<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();

class Uploader {

	protected static $instance = null;

	private $client;
	private $app;
	private $account_id;

	public function __construct( $account_id = null ) {
		$this->account_id = $account_id;
		$this->client     = Client::instance( $account_id )->get_client();
		$this->app        = App::instance( $account_id );
	}

	public function get_resume_url( $data ) {
		$name = ! empty( $data['name'] ) ? sanitize_text_field( $data['name'] ) : '';

		$file_name      = pathinfo( $name, PATHINFO_FILENAME );
		$file_extension = ! empty( pathinfo( $name, PATHINFO_EXTENSION ) ) ? '.' . pathinfo( $name, PATHINFO_EXTENSION ) : '';
		$queue_index    = ! empty( $data['queueIndex'] ) ? sanitize_text_field( $data['queueIndex'] ) : '';

		$path      = ! empty( $data['path'] ) ? sanitize_text_field( $data['path'] ) : '';
		$size      = ! empty( $data['size'] ) ? sanitize_text_field( $data['size'] ) : '';
		$type      = ! empty( $data['type'] ) ? sanitize_text_field( $data['type'] ) : '';
		$folder_id = ! empty( $data['folderId'] ) ? sanitize_text_field( $data['folderId'] ) : '';

		// Create folder structure if needed
		if ( ! empty( $path ) ) {
			$last_folders = $this->create_folder_structure( $path, $folder_id );
			$path_key     = trim( $path, '/' );
			$folder_id    = $last_folders[ $path_key ];
		}

		$name_template = ! empty( $data['uploadFileName'] ) ? $data['uploadFileName'] : '%file_name%%file_extension%';

		// Create folder for woocommerce uploads
		if ( ! empty( $data['isWooCommerceUploader'] ) ) {
			$order_id = ! empty( $data['wcOrderId'] ) ? sanitize_text_field( $data['wcOrderId'] ) : null;
			$order    = $order_id ? wc_get_order( $order_id ) : null;

			$product_id = ! empty( $data['wcProductId'] ) ? sanitize_text_field( $data['wcProductId'] ) : null;
			$product    = $product_id ? wc_get_product( $product_id ) : null;

			$folder = WooCommerce_Uploads::instance()->get_upload_folder( $product, $order );

			$folder_id = $folder['id'];

		}

		// Replace template variables
		$search  = [ '%file_name%', '%file_extension%', '%queue_index%', '%date%', '%time%', '%unique_id%', ];
		$replace = [ $file_name, $file_extension, $queue_index, date( 'Y-m-d' ), date( 'H:i:s' ), uniqid(), ];

		if ( is_user_logged_in() ) {
			$user   = wp_get_current_user();
			$search = array_merge( $search, [
				'%user_login%',
				'%user_email%',
				'%user_id%',
				'%display_name%',
				'%first_name%',
				'%last_name%',
				'%user_role%',
			] );

			$replace = array_merge( $replace, [
				$user->user_login,
				$user->user_email,
				$user->ID,
				$user->display_name,
				$user->first_name,
				$user->last_name,
				implode( ', ', $user->roles ),
			] );
		}

		$name = str_replace( $search, $replace, $name_template );

		$file = new \IGDGoogle_Service_Drive_DriveFile();
		$file->setName( $name );
		$file->setMimeType( $type );

		$this->client->setDefer( true );

		$file->setParents( [ $folder_id ] );
		$request = $this->app->getService()->files->create( $file, [
			'fields'            => '*',
			'supportsAllDrives' => true
		] );

		$request_headers           = $request->getRequestHeaders();
		$request_headers['Origin'] = $_SERVER['HTTP_ORIGIN'];
		$request->setRequestHeaders( $request_headers );

		$chunkSizeBytes = 5 * 1024 * 1024;
		$media          = new \IGDGoogle_Http_MediaFileUpload(
			$this->client,
			$request,
			$type,
			null,
			true,
			$chunkSizeBytes
		);

		$media->setFileSize( $size );

		try {
			return $media->getResumeUri();
		} catch ( \Exception $exception ) {
			return [
				'error' => $exception->getMessage(),
			];
		}
	}

	public function upload_post_process( $file ) {

		// Format file data
		$file['accountId'] = $this->account_id;
		$file['type']      = $file['mimeType'];
		$file['created']   = $file['createdTime'];
		$file['updated']   = $file['modifiedTime'];

		// Permission users
		$users       = [];
		$permissions = $file['permissions'];
		if ( count( $permissions ) > 0 ) {
			foreach ( $permissions as $permission ) {
				$users[ $permission['id'] ] = [
					'type'   => $permission['type'],
					'role'   => $permission['role'],
					'domain' => ! empty( $permission['domain'] ) ? $permission['domain'] : null,
				];
			}
		}

		$file['permissions'] = array_merge( $file['capabilities'], [ 'users' => $users ] );

		//exportAs
		$file['exportAs'] = igd_get_export_as( $file['mimeType'] );

		Files::instance( $this->account_id )->add_file( $file, $file['parents'][0] );

		do_action( 'igd_insert_log', 'upload', $file['id'], $this->account_id );

	}

	public function create_folder_structure( $path, $parent_folder ) {

		$folders = array_filter( explode( '/', $path ) );

		$last_folders = [];

		$app = App::instance( $this->account_id );

		foreach ( $folders as $key => $name ) {

			// current folder path
			$folder_path = implode( '/', array_slice( $folders, 0, $key + 1 ) );

			$last_folder = array_slice( $last_folders, 0, $key );
			$last_folder = ! empty( $last_folder ) ? end( $last_folder ) : $parent_folder;

			//check if folder is already exists
			$folder_exists = $app->get_file_by_name( $name, $last_folder );

			if ( $folder_exists ) {
				$last_folders[ $folder_path ] = $folder_exists['id'];

				continue;
			}

			// Create folder if not exists
			try {

				// add last folder id to the array
				$last_folders[ $folder_path ] = $app->new_folder( $name, $last_folder );

			} catch ( \Exception $ex ) {

				error_log( 'Integrate Google Drive - Message: ' . sprintf( 'Failed to create new folders: %s', $ex->getMessage() ) );
			}

		}

		return $last_folders;

	}

	public function create_entry_folder_and_move( $files, $entry_folder_name_template, $tags, $upload_folder ) {
		$file_ids = array_map( function ( $file ) {
			return $file['id'];
		}, $files );

		$entry_folder_name = str_replace( array_keys( $tags ), array_values( $tags ), $entry_folder_name_template );

		$entry_folder = $this->app->new_folder( $entry_folder_name, $upload_folder['id'] );
		$this->app->move_file( $file_ids, $entry_folder['id'] );
	}

	public static function instance( $account_id = null ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $account_id );
		}

		return self::$instance;
	}

}