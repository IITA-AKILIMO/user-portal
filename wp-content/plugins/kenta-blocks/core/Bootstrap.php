<?php
/**
 * Plugin bootstrap
 */

namespace KentaBlocks;

use KentaBlocks\Traits\Admin;
use KentaBlocks\Traits\Blocks;

class Bootstrap {

	use Blocks;
	use Admin;

	/**
	 * Global instance
	 *
	 * @var Bootstrap
	 */
	private static $_instance = null;

	/**
	 * Private constructor
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->add_filters();
		$this->add_actions();

		// init default settings
		$defaultSettings = require KENTA_BLOCKS_PLUGIN_PATH . 'inc/settings.php';
		kenta_blocks_setting()->addSettings( $defaultSettings );

		// Show opt-in notice
		if ( ! kb_fs()->is_registered() ) {
			kenta_blocks_notices()->add_notice(
				sprintf(
					__( 'We made a few tweaks to the Kenta Blocks, %s', 'kenta-blocks' ),
					sprintf( '<b><a href="%s">%s</a></b>',
						add_query_arg( [ 'page' => 'kenta-blocks-optin' ], admin_url( 'admin.php' ) ),
						__( 'Opt in to make Kenta Blocks better!', 'kenta-blocks' )
					)
				),
				'connect_account',
				'Kenta Blocks'
			);
		}
	}

	/**
	 * Add all filters
	 */
	protected function add_filters() {
		$isWP58OrAbove = version_compare( get_bloginfo( 'version' ), '5.8', '>=' );

		add_filter( $isWP58OrAbove ? 'block_categories_all' : 'block_categories', array(
			$this,
			'blocks_categories'
		), PHP_INT_MAX );
	}

	/**
	 * Add all actions
	 */
	protected function add_actions() {

		kenta_blocks_assets();

		add_action( 'init', array( $this, 'blocks_init' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'rest_api_init', array( Route::class, 'api_v1' ) );

		add_action( 'current_screen', array( $this, 'remove_optin_notice' ) );
	}

	/**
	 * Singleton instance
	 *
	 * @since 0.0.1
	 */
	public static function instance() {
		if ( self::$_instance === null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Remove opt-in notice in opt-in screen
	 */
	public function remove_optin_notice() {
		$screen = get_current_screen();
		if ( 'kenta-blocks_page_kenta-blocks-optin' === $screen->id ||
		     'kenta_page_kenta-companion-optin' === $screen->id ) {
			kenta_blocks_notices()->remove_notice( 'connect_account' );
		}
	}
}