<?php

namespace IGD;

defined('ABSPATH') || exit();

class Update_1_0_9 {
	private static $instance;

	public function __construct() {
		$accounts = Account::get_accounts();
		if ( ! empty( $accounts ) ) {
			foreach ( $accounts as $account ) {
				Files::instance( $account['id'] )->delete_account_files();
			}
		}

	}


	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

Update_1_0_9::instance();