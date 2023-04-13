<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();

class Account {

	private static $instance = null;

	private static $user_id;

	public function __construct( $user_id = null ) {
		self::$user_id = $user_id;
	}

	/**
	 * @param $id
	 *
	 * @return array|false|mixed|null
	 */
	public static function get_accounts( $id = null ) {

		$accounts = array_filter( (array) get_option( 'igd_accounts' ) );

		if ( ! empty( self::$user_id ) ) {
			//accounts added by users
			$accounts = wp_list_filter( $accounts, [ 'user_id' => self::$user_id ] );
		} else {
			//account where user id is not set
			$accounts = array_filter( $accounts, function ( $account ) {
				return empty( $account['user_id'] );
			} );
		}

		if ( $id ) {
			return ! empty( $accounts[ $id ] ) ? $accounts[ $id ] : [];
		}

		return ! empty( $accounts ) ? $accounts : [];
	}

	/**
	 * Add new account or e previous account
	 *
	 * @param $data
	 */
	public static function update_account( $data ) {
		$accounts = array_filter( (array) get_option( 'igd_accounts' ) );

		//If account is already added by other user then add account with user id
		if ( ! empty( $accounts[ $data['id'] ] ) ) {
			$existing_account = $accounts[ $data['id'] ];

			if (
				( ! empty( $existing_account['user_id'] ) && empty( $data['user_id'] ) )
				|| ( empty( $existing_account['user_id'] ) && ! empty( $data['user_id'] ) )
				|| ( ! empty( $existing_account['user_id'] ) && ! empty( $data['user_id'] ) ) && ( $existing_account['user_id'] != $data['user_id'] )
			) {
				$new_id              = $data['id'] . '_' . get_current_user_id();
				$data['id']          = $new_id;
				$accounts[ $new_id ] = $data;
			} else {
				$accounts[ $data['id'] ] = $data;
			}
		} else {
			$accounts[ $data['id'] ] = $data;
		}

		update_option( 'igd_accounts', $accounts );
		update_option( 'igd_account_notice', false );

		return $data;
	}

	public static function get_active_account() {
		$accounts = self::get_accounts();

		$cookie = isset( $_COOKIE['igd_active_account'] ) ? $_COOKIE['igd_active_account'] : null;

		if ( ! empty( $cookie ) ) {
			$cookie = str_replace( "\\\"", "\"", $cookie );

			$account = json_decode( $cookie, true );

			//check if user id is not same then remove cookie
			if ( ! empty( self::$user_id ) && ! empty( $account['user_id'] ) && self::$user_id != $account['user_id'] ) {
				setcookie( 'igd_active_account', '', time() - 3600, '/' );

				$account = @array_shift( $accounts );

				return ! empty( $account ) ? $account : [];
			}

			if ( ! empty( $account['id'] ) && empty( $accounts[ $account['id'] ] ) ) {
				setcookie( 'igd_active_account', '', time() - 3600, '/' );
			} else {
				return $account;
			}
		}

		$account = @array_shift( $accounts );
		if ( ! empty( $account ) ) {
			return $account;
		}

		return [];
	}

	/**
	 * @param string $account_id
	 *
	 * @return bool
	 */
	public static function set_active_account( $account_id ) {
		$accounts = self::get_accounts();

		$account = [];

		if ( ! empty( $accounts[ $account_id ] ) ) {
			$account = $accounts[ $account_id ];

			setcookie( 'igd_active_account', json_encode( $account ), time() + ( 30 * DAY_IN_SECONDS ), "/" );
		} elseif ( ! empty( $accounts ) ) {
			$account = @array_shift( $accounts );

			setcookie( 'igd_active_account', json_encode( $account ), time() + ( 30 * DAY_IN_SECONDS ), "/" );
		} else {
			setcookie( 'igd_active_account', '', time() - 3600, "/" );
		}

		return $account;
	}

	/**
	 * @param $account_id
	 *
	 * @return void
	 */
	public static function delete_account( $account_id ) {
		$accounts = array_filter( (array) get_option( 'igd_accounts' ) );

		$removed_account = $accounts[ $account_id ];

		// Delete all the account files
		Files::instance( $account_id )->delete_account_files();

		//delete token
		$authorization = new Authorization( $removed_account );
		$authorization->remove_token();

		//remove account data from saved accounts
		unset( $accounts[ $account_id ] );

		$active_account = self::get_active_account();

		// Update active account
		if ( ! empty( $active_account ) && $account_id == $active_account['id'] ) {
			if ( count( $accounts ) ) {
				self::set_active_account( array_key_first( $accounts ) );
			}
		}

		update_option( 'igd_accounts', $accounts );
	}

	public static function instance( $user_id = null ) {
		if ( ! self::$instance ) {
			self::$instance = new self( $user_id );
		} elseif ( ! empty( $user_id ) ) {
			self::$user_id = $user_id;
		}

		return self::$instance;
	}

}
