<?php

namespace IGD;

class Private_Folders {
	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {
	}

	public function create_user_folder( $user_id = null, $data = [] ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$user = get_userdata( $user_id );
		if ( ! $user ) {
			return [];
		}

		@set_time_limit( 60 );

		if ( ! empty( $data ) ) {
			$name_template   = ! empty( $data['nameTemplate'] ) ? $data['nameTemplate'] : '%user_login% (%user_email%)';
			$parent_folder   = ! empty( $data['parentFolder'] ) ? $data['parentFolder'] : [
				'id'        => Account::instance()->get_active_account()['root_id'],
				'accountId' => Account::instance()->get_active_account()['id'],
			];
			$template_folder = ! empty( $data['templateFolder'] ) ? $data['templateFolder'] : null;
		} else {
			$name_template   = igd_get_settings( 'nameTemplate', '%user_login% (%user_email%)' );
			$parent_folder   = igd_get_settings( 'parentFolder' );
			$template_folder = igd_get_settings( 'templateFolder' );
		}


		$user_folder = $this->create_folder( [
			'parent' => $parent_folder,
			'name'   => $name_template,
			'user'   => $user,
		] );

		update_user_option( $user_id, 'folders', [ $user_folder ] );

		// Check if the template folder should be copied to the user folder
		if ( ! empty( $template_folder ) ) {
			// Check if the template folder is the same as the parent folder or the template folder and the parent folder not in the same account
			if ( ( $template_folder['id'] != $parent_folder['id'] ) || ( $template_folder['accountId'] == $parent_folder['accountId'] ) ) {
				try {
					$app = App::instance( $parent_folder['accountId'] );
					$app->copy_folder( $template_folder['id'], $user_folder['id'] );
				} catch ( \Exception $e ) {
					error_log( $e->getMessage() );
				}
			}
		}

		return [ $user_folder ];
	}

	public function create_folder( $data ) {

		$parent_folder = ! empty( $data['parent'] ) ? $data['parent'] : [
			'id'        => 'root',
			'accountId' => Account::instance()->get_active_account()['id']
		];

		$app = App::instance( $parent_folder['accountId'] );

		$folder_name = $this->get_folder_name( $data );

		try {
			return $app->new_folder( $folder_name, $parent_folder['id'] );
		} catch ( \Exception $e ) {
			error_log( $e->getMessage() );

			return [];
		}
	}

	public function get_folder_name( $data ) {
		$name_template = ! empty( $data['name'] ) ? $data['name'] : '%user_login% (%user_email%)';

		$date      = date( 'Y-m-d' );
		$time      = date( 'H:i' );
		$unique_id = uniqid();

		$search = [
			'%date%',
			'%time%',
			'%unique_id%',
		];

		$replace = [
			$date,
			$time,
			$unique_id,
		];

		$folder_name = str_replace( $search, $replace, $name_template );

		//handle user data
		if ( ! empty( $data['user'] ) ) {
			$user = $data['user'];

			$user_login   = $user->user_login;
			$user_email   = $user->user_email;
			$display_name = $user->display_name;
			$first_name   = $user->first_name;
			$last_name    = $user->last_name;
			$user_role    = implode( ', ', $user->roles );

			$search = array_merge( $search, [
				'%user_login%',
				'%user_email%',
				'%display_name%',
				'%first_name%',
				'%last_name%',
				'%user_role%',
			] );

			$replace = array_merge( $replace, [
				$user_login,
				$user_email,
				$display_name,
				$first_name,
				$last_name,
				$user_role,
			] );

			$folder_name = str_replace( $search, $replace, $folder_name );

			$user_id = $user->ID;

			//Check if %user_meta_{key}% is in the name template
			if ( preg_match( '/%user_meta_(?P<meta_key>.*?)%/', $name_template, $matches ) ) {
				$meta_key    = trim( $matches['meta_key'] );
				$meta_value  = get_user_meta( $user_id, $meta_key, true );
				$folder_name = str_replace( '%user_meta_' . $meta_key . '%', $meta_value, $folder_name );
			}

		}

		//handle wc order data
		if ( ! empty( $data['wc_order'] ) ) {
			$order = $data['wc_order'];

			$order_id   = $order->get_id();
			$order_date = $order->get_date_created()->date( 'Y-m-d' );

			$search = array_merge( $search, [
				'%wc_order_id%',
				'%wc_order_date%',
			] );

			$replace = array_merge( $replace, [
				$order_id,
				$order_date,
			] );

			$folder_name = str_replace( $search, $replace, $folder_name );
		}

		// Handle wc product data
		if ( ! empty( $data['wc_product'] ) ) {
			$product = $data['wc_product'];

			$product_id   = $product->get_id();
			$product_name = $product->get_name();

			$search = array_merge( $search, [
				'%wc_product_id%',
				'%wc_product_name%',
			] );

			$replace = array_merge( $replace, [
				$product_id,
				$product_name,
			] );

			$folder_name = str_replace( $search, $replace, $folder_name );

		}

		return $folder_name;
	}

	public function delete_user_folder( $user_id ) {
		$folders = get_user_option( 'folders', $user_id );
		if ( empty( $folders ) ) {
			return;
		}

		$account_id = $folders[0]['accountId'];
		$folder_ids = wp_list_pluck( $folders, 'id' );

		try {
			App::instance( $account_id )->delete( $folder_ids, $account_id );
		} catch ( \Exception $e ) {
			error_log( $e->getMessage() );

			return;
		}
	}

	/**
	 * Get users data
	 *
	 * @return array
	 */
	public function get_user_data( $args = [] ) {

		$default = [
			'number'  => 999,
			'offset'  => 0,
			'role'    => '',
			'search'  => '',
			'order'   => 'asc',
			'orderby' => 'ID',
			'fields'  => 'all_with_meta',
		];

		$args = wp_parse_args( $args, $default );

		$users_query = new \WP_User_Query( $args );

		$data = [
			'roles' => count_users()["avail_roles"],
			'total' => $users_query->get_total(),
		];

		$results = $users_query->get_results();

		// Users Data
		$users = [];

		foreach ( $results as $user ) {

			// Gravatar
			$display_gravatar = igd_get_user_gravatar( $user->ID );

			$folders = get_user_option( 'folders', $user->ID );

			$users[] = [
				'id'       => $user->ID,
				'avatar'   => $display_gravatar,
				'username' => $user->user_login,
				'name'     => $user->display_name,
				'email'    => $user->user_email,
				'role'     => implode( ', ', $this->get_role_list( $user ) ),
				'folders'  => ! empty( $folders ) ? $folders : [],
			];
		}

		$data['users'] = $users;

		return $data;
	}

	/**
	 * Get user role list
	 *
	 * @param $user
	 *
	 * @return mixed|void
	 */
	public function get_role_list( $user ) {

		$wp_roles = wp_roles();

		$role_list = [];
		foreach ( $user->roles as $role ) {
			if ( isset( $wp_roles->role_names[ $role ] ) ) {
				$role_list[ $role ] = translate_user_role( $wp_roles->role_names[ $role ] );
			}
		}

		if ( empty( $role_list ) ) {
			$role_list['none'] = _x( 'None', 'No user roles', 'integrate-google-drive' );
		}

		return apply_filters( 'get_role_list', $role_list, $user );
	}

	public static function view() { ?>
        <script>
            var igdUserData = <?php echo json_encode( self::instance()->get_user_data( [ 'number' => 10 ] ) ) ?>;
        </script>
        <div id="igd-private-folders-app"></div>
	<?php }

	/**
	 * @return Private_Folders|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}