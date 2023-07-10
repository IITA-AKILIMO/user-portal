<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;

class Rest_Api_Controller {
	/** @var null */
	private static $instance = null;

	private $namespace = 'igd/v1';

	/**
	 * Rest_Api_Controller constructor.
	 *
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_api' ] );
	}

	/**
	 * Register rest API
	 *
	 * @since 1.0.0
	 */
	public function register_api() {

		// Move File/ Folder
		register_rest_route( $this->namespace, '/move-file/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'move_file' ),
				'permission_callback' => '__return_true',
			),
		) );

		//handle rename
		register_rest_route( $this->namespace, '/rename/', array(
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'handle_rename' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Copy file/ folder
		register_rest_route( $this->namespace, '/copy/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'handle_copy' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Create a new folder
		register_rest_route( $this->namespace, '/new-folder/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'new_folder' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Switch Account
		register_rest_route( $this->namespace, '/switch-account/', array(
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'switch_account' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Delete Account
		register_rest_route( $this->namespace, '/delete-account/', array(
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'delete_account' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Set Permission
		register_rest_route( $this->namespace, '/set-permission/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'set_permission' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Save Settings
		register_rest_route( $this->namespace, '/save-settings/', array(
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'save_settings' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Update user folders
		register_rest_route( $this->namespace, '/update-user-folders/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'update_user_folders' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Get users data
		register_rest_route( $this->namespace, '/get-users-data/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_users_data' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Update Shortcode
		register_rest_route( $this->namespace, '/update-shortcode/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'update_shortcode' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Duplicate Shortcode
		register_rest_route( $this->namespace, '/duplicate-shortcode/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'duplicate_shortcode' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Get Shortcode Content
		register_rest_route( $this->namespace, '/get-shortcode-content/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_shortcode_content' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Get Files
		register_rest_route( $this->namespace, '/get-files/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_files' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Search Files
		register_rest_route( $this->namespace, '/search-files/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'search_files' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Get Folders
		register_rest_route( $this->namespace, '/get-folders/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_folders' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Get Embed Content
		register_rest_route( $this->namespace, '/get-embed-content/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_embed_content' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Delete Files
		register_rest_route( $this->namespace, '/delete-files/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'delete_files' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Create Doc
		register_rest_route( $this->namespace, '/create-doc/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'create_doc' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Get export data
		register_rest_route( $this->namespace, '/export-data/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_export_data' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Import Data
		register_rest_route( $this->namespace, '/import-data/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'import_data' ),
				'permission_callback' => '__return_true',
			),
		) );

		// File Uploaded
		register_rest_route( $this->namespace, '/file-uploaded/', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'upload_post_process' ),
				'permission_callback' => '__return_true',
			),
		) );

		// Get Shortcodes
		register_rest_route( $this->namespace, '/get-shortcodes/', array(
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_shortcodes' ),
				'permission_callback' => '__return_true',
			),
		) );

	}

	public function get_shortcodes() {
		$shortcodes = Shortcode_Builder::instance()->get_shortcode();

		$formatted = [];

		if ( ! empty( $shortcodes ) ) {
			foreach ( $shortcodes as $shortcode ) {
				$shortcode->config    = maybe_unserialize( $shortcode->config );
				$shortcode->locations = ! empty( $shortcode->locations ) ? array_values( maybe_unserialize( $shortcode->locations ) ) : [];


				$formatted[] = $shortcode;
			}
		}

		return rest_ensure_response( $formatted );
	}

	public function upload_post_process( $request ) {
		$data = $request->get_json_params();

		$file = ! empty( $data['file'] ) ? $data['file'] : [];

		$account_id = ! empty( $file['accountId'] ) ? sanitize_text_field( $file['accountId'] ) : '';

		Uploader::instance( $account_id )->upload_post_process( $file );

		//Save uploaded files in the order meta-data for order-received page and my-account page
		$item_id = ! empty( $data['wcOrderItemId'] ) ? intval( $data['wcOrderItemId'] ) : false;
		if ( $item_id ) {
			if ( function_exists( 'wc_add_order_item_meta' ) ) {
				wc_add_order_item_meta( $item_id, '_igd_files', $file );
			}

		}

		//Save uploaded files in the session for checkout page
		$product_id = ! empty( $data['wcProductId'] ) ? intval( $data['wcProductId'] ) : false;
		if ( $product_id ) {

			$files = WC()->session->get( 'igd_product_files_' . $product_id, [] );

			$files[] = $file;

			WC()->session->set( 'igd_product_files_' . $product_id, $files );
		}

		return rest_ensure_response( array( 'success' => true ) );
	}

	public function import_data( $request ) {
		$settings   = $request->get_param( 'settings' );
		$shortcodes = $request->get_param( 'shortcodes' );
		$user_files = $request->get_param( 'user_files' );
		$events     = $request->get_param( 'events' );

		if ( ! empty( $settings ) ) {
			update_option( 'igd_settings', $settings );
		}

		if ( ! empty( $shortcodes ) ) {
			$shortcode_builder = Shortcode_Builder::instance();
			$shortcode_builder->delete_shortcode();

			foreach ( $shortcodes as $shortcode ) {
				$shortcode_builder->update_shortcode( $shortcode, true );
			}
		}

		if ( ! empty( $user_files ) ) {
			foreach ( $user_files as $user_id => $files ) {
				update_user_option( $user_id, 'folders', $files );
			}
		}

		if ( ! empty( $events ) ) {
			$statistics = Statistics::instance();
			$statistics->clear_statistics();
			foreach ( $events as $event ) {
				$statistics->insert_log( $event );
			}
		}

		return rest_ensure_response( array(
			'status' => 'success',
		) );

	}

	public function get_export_data( $request ) {
		$type = $request->get_param( 'type' );
		$type = ! empty( $type ) ? $type : 'all';

		$export_data = array();

		// Settings
		if ( 'all' == $type || 'settings' == $type ) {
			$export_data['settings'] = igd_get_settings();
		}

		// Shortcodes
		if ( 'all' == $type || 'shortcodes' == $type ) {
			$export_data['shortcodes'] = Shortcode_Builder::instance()->get_shortcode();
		}


		// User Private Files
		if ( 'all' == $type || 'user_files' == $type ) {
			$user_files = array();
			$users      = get_users();
			foreach ( $users as $user ) {
				$folders                 = get_user_option( 'folders', $user->ID );
				$user_files[ $user->ID ] = ! empty( $folders ) ? $folders : array();
			}
			$export_data['user_files'] = $user_files;
		}


		// Events
		if ( 'all' == $type || 'events' == $type ) {
			$export_data['events'] = Statistics::instance()->get_events( '2022-01-01', date( 'Y-m-d' ) );
		}

		return rest_ensure_response( $export_data );
	}

	public function create_doc( $request ) {

		$posted = $request->get_json_params();

		$name   = $posted['name'];
		$type   = $posted['type'];
		$folder = ! empty( $posted['folder'] ) ? $posted['folder'] : [
			'id'        => Account::get_active_account()['id'],
			'accountId' => Account::get_active_account()['accountId'],
		];

		$mime_type = 'application/vnd.google-apps.document';
		if ( $type == 'sheet' ) {
			$mime_type = 'application/vnd.google-apps.spreadsheet';
		} elseif ( $type == 'slide' ) {
			$mime_type = 'application/vnd.google-apps.presentation';
		}

		$item = App::instance( $folder['accountId'] )->getService()->files->create(
			new \IGDGoogle_Service_Drive_DriveFile( [
				'name'     => $name,
				'mimeType' => $mime_type,
				'parents'  => [ $folder['id'] ],
			] ), [
			'fields' => '*',
		] );

		// add new folder to cache
		$file = igd_file_map( $item, $folder['accountId'] );

		Files::instance( $folder['accountId'] )->add_file( $file );

		return rest_ensure_response( $file );

	}

	public function delete_files( $request ) {
		$posted = $request->get_json_params();

		$file_ids   = ! empty( $posted['file_ids'] ) ? $posted['file_ids'] : [];
		$account_id = ! empty( $posted['account_id'] ) ? $posted['account_id'] : '';

		//send email notification
		if ( igd_get_settings( 'deleteNotifications', true ) ) {
			do_action( 'igd_send_notification', 'delete', $file_ids, $account_id );
		}

		wp_send_json_success( App::instance( $account_id )->delete( $file_ids, $account_id ) );
	}

	public function get_embed_content( $request ) {
		$posted  = $request->get_json_params();
		$content = igd_get_embed_content( $posted );
		wp_send_json_success( $content );
	}

	public function get_files( $request ) {

		$user_id = null;
		$referer = wp_get_referer();

		//if referer is dokan vendor dashboard product edit page
		if ( strpos( $referer, '_dokan_edit_product_nonce' ) !== false || strpos( $referer, '_dokan_add_product_nonce' ) !== false ) {
			$user_id = get_current_user_id();
		}

		$active_account = Account::instance( $user_id )->get_active_account();

		if ( empty( $active_account ) ) {
			wp_send_json_error( __( 'No active account found', 'integrate-google-drive' ) );
		}

		$params = [
			'folder'      => [
				'id'        => $active_account['root_id'],
				'accountId' => $active_account['id'],
			],
			'fileNumbers' => 1000,
			'sort'        => [
				'sortBy'        => 'name',
				'sortDirection' => 'asc'
			],
			'from_server' => false,
		];

		//merge request params
		if ( ! is_object( $request ) ) {
			$params = wp_parse_args( $request, $params );
		} else {
			$params = wp_parse_args( $request->get_json_params(), $params );
		}

		$account_id   = ! empty( $folder['accountId'] ) ? $folder['accountId'] : $active_account['id'];
		$file_numbers = $params['fileNumbers'];
		$refresh      = ! empty( $params['refresh'] );
		$sort         = $params['sort'];

		$from_server = ! empty( $params['from_server'] );

		//get folder
		$folder = $params['folder'];

		// Reset cache and get new files
		if ( $refresh ) {
			igd_delete_cache();
		}

		$app = App::instance( $account_id );

		$folder_id = $folder['id'];

		//set transient for 1 hour to prevent fetching from server
		if ( $from_server ) {
			$transient = get_transient( 'igd_latest_fetch_' . $folder_id );
			if ( $transient ) {
				$from_server = false;
			} else {
				set_transient( 'igd_latest_fetch_' . $folder_id, true, 60 * MINUTE_IN_SECONDS );
			}
		}

		if ( 'computers' == $folder_id ) {
			$files = $app->get_computers_files( $sort );
		} elseif ( 'shared-drives' == $folder_id ) {
			$files = $app->get_shared_drives();
		} elseif ( 'shared' == $folder_id ) {
			$files = $app->get_shared_files( $sort );
		} elseif ( 'recent' == $folder_id ) {
			$files = $app->get_recent_files();
		} elseif ( 'starred' == $folder_id ) {
			$files = $app->get_starred_files( $sort );
		} else {

			//Get files from folder
			if ( ! empty( $folder['shortcutDetails'] ) ) {
				$folder_id = $folder['shortcutDetails']['targetId'];
			}

			$files = $app->get_files( [], $folder_id, $sort, $from_server );
		}

		// Handle maximum file to show
		if ( ! empty( $file_numbers ) && $file_numbers > 0 && count( $files ) > $file_numbers ) {
			$files = array_slice( $files, 0, $file_numbers );
		}

		if ( ! is_object( $request ) ) {
			return $files;
		}

		if ( ! empty( $files['error'] ) ) {
			return rest_ensure_response( $files );
		}

		$data = [
			'files' => $files,
		];

		$data['breadcrumbs'] = igd_get_breadcrumb( $folder );

		return rest_ensure_response( $data );

	}

	public function search_files( $request ) {

		if ( ! is_object( $request ) ) {
			$data = $request;
		} else {
			$data = $request->get_json_params();
		}

		$folders          = ! empty( $data['folders'] ) ? $data['folders'] : [];
		$keyword          = ! empty( $data['keyword'] ) ? $data['keyword'] : '';
		$account_id       = ! empty( $data['accountId'] ) ? $data['accountId'] : Account::get_active_account()['id'];
		$sort             = ! empty( $data['sort'] ) ? $data['sort'] : [ 'sortBy' => 'name', 'sortDirection' => 'asc' ];
		$full_text_search = ! empty( $data['fullTextSearch'] );
		$file_numbers     = ! empty( $data['fileNumbers'] ) ? $data['fileNumbers'] : 1000;

		$app   = App::instance( $account_id );
		$files = $app->get_search_files( $keyword, $folders, $sort, $full_text_search, $file_numbers );

		if ( ! empty( $files['error'] ) ) {
			return rest_ensure_response( $files );
		}

		// Handle maximum file to show
		if ( count( $files ) > $file_numbers ) {
			$files = array_slice( $files, 0, $file_numbers );
		}

		if ( ! is_object( $request ) ) {
			return $files;
		}

		$data = [
			'files' => $files,
		];

		return rest_ensure_response( $data );

	}

	public function get_folders( $request ) {
		$active_account = Account::get_active_account();

		$folder = [
			'id'        => $active_account['root_id'],
			'accountId' => $active_account['id']
		];

		$params = $request->get_json_params();

		if ( $params['folder'] ) {
			$folder = $params['folder'];
		}

		$files = $this->get_files( [ 'folder' => $folder ] );

		if ( ! empty( $files ) ) {
			$new_files = [];

			foreach ( $files as $file ) {
				if ( ! igd_is_dir( $file['type'] ) ) {
					continue;
				}

				$new_files[] = $file;
			}

			$files = $new_files;
		}

		wp_send_json_success( $files );
	}

	public function get_shortcode_content( $request ) {
		$data = $request->get_json_params();

		$html = Shortcode::instance()->render_shortcode( [], $data );

		wp_send_json_success( $html );
	}

	public function update_shortcode( $request ) {
		$shortcode_data = $request->get_json_params();

		$id = Shortcode_Builder::instance()->update_shortcode( $shortcode_data );

		$data = [
			'id'         => $id,
			'config'     => $shortcode_data,
			'title'      => $shortcode_data['title'],
			'status'     => $shortcode_data['status'],
			'created_at' => ! empty( $shortcode_data['created_at'] ) ? $shortcode_data['created_at'] : date( 'Y-m-d H:i:s', time() ),
		];

		wp_send_json_success( $data );
	}

	public function duplicate_shortcode( $request ) {
		$ids = $request->get_param( 'ids' );

		$data = [];
		if ( ! empty( $ids ) ) {

			foreach ( $ids as $id ) {
				$data[] = Shortcode_Builder::instance()->duplicate_shortcode( $id );
			}
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Get users data
	 *
	 * @param $request
	 *
	 * @return void
	 */
	public function get_users_data( $request ) {
		$data = json_decode( $request->get_body(), 1 );

		$args = [];

		if ( ! empty( $data ) ) {
			$search = ! empty( $data['search'] ) ? $data['search'] : '';
			$role   = ! empty( $data['role'] ) ? $data['role'] : '';
			$page   = ! empty( [ 'page' ] ) ? $data['page'] : 1;
			$offset = 10 * ( $page - 1 );

			$args = [
				'number' => 10,
				'role'   => 'all' != $role ? $role : '',
				'offset' => $offset,
				'search' => ! empty( $search ) ? "*$search*" : '',
			];
		}

		$user_data = Private_Folders::instance()->get_user_data( $args );

		wp_send_json_success( $user_data );
	}

	/**
	 * Update user folders
	 *
	 * @param $request
	 *
	 * @return void
	 */
	public function update_user_folders( $request ) {
		$data = json_decode( $request->get_body(), 1 );

		$id      = $data['id'];
		$folders = $data['folders'];

		update_user_option( $id, 'folders', $folders );

		wp_send_json_success();
	}

	/**
	 * @param $request
	 *
	 * @return void
	 */
	public function save_settings( $request ) {
		$data = json_decode( $request->get_body(), 1 );

		update_option( 'igd_settings', $data );

		wp_send_json_success();
	}

	public function new_folder( $request ) {
		$data = json_decode( $request->get_body(), 1 );

		$folder_name   = sanitize_text_field( $data['name'] );
		$parent_folder = $data['parent'];
		$parent_folder = ! empty( $parent_folder['id'] ) ? $parent_folder['id'] : $parent_folder;

		App::instance()->new_folder( $folder_name, $parent_folder );

		wp_send_json_success();
	}

	public function set_permission( $request ) {
		$requested = json_decode( $request->get_body(), 1 );

		$files = ! empty( $requested['files'] ) ? $requested['files'] : [];

		if ( ! empty( $files ) ) {

			foreach ( $files as $file ) {
				$account_id = ! empty( $file['accountId'] ) ? $file['accountId'] : '';
				$app        = App::instance( $account_id );

				if ( ! $app->has_permission( $file ) ) {
					$app->set_permission( $file );
				}
			}
		}

		wp_send_json_success();
	}

	// Delete account
	public function delete_account( $request ) {
		$data = json_decode( $request->get_body() );
		$id   = $data->id;

		Account::delete_account( $id );

		wp_send_json_success();

	}

	// Switch account
	public function switch_account( $request ) {
		$data = $request->get_json_params();

		if ( empty( $data['id'] ) ) {
			return rest_ensure_response( new \WP_Error( 'error', 'Account id is required', array( 'status' => 400 ) ) );
		}

		return rest_ensure_response( Account::set_active_account( $data['id'] ) );
	}

	public function move_file( $request ) {
		$posted = json_decode( $request->get_body(), 1 );

		$file_ids = ! empty( $posted['file_ids'] ) ? $posted['file_ids'] : '';

		$active_account = Account::instance()->get_active_account();

		$folder_id = ! empty( $posted['folder_id'] ) ? sanitize_text_field( $posted['folder_id'] ) : $active_account['root_id'];

		wp_send_json_success( App::instance()->move_file( $file_ids, $folder_id ) );
	}

	public function handle_rename( $request ) {
		$data = json_decode( $request->get_body(), 1 );

		$name    = sanitize_text_field( $data['name'] );
		$file_id = sanitize_text_field( $data['file_id'] );

		wp_send_json_success( App::instance()->rename( $name, $file_id ) );

	}

	public function handle_copy( $request ) {
		$data = json_decode( $request->get_body(), 1 );

		$files      = ! empty( $data['files'] ) ? $data['files'] : [];
		$account_id = $files[0]['accountId'];

		$copied_files = App::instance( $account_id )->copy( $files );

		return rest_ensure_response( $copied_files );

	}

	/**
	 * @return Rest_Api_Controller|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Rest_Api_Controller::instance();