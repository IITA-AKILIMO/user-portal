<?php
/**
 * Plugin bootstrap
 */

namespace KentaBlocks;

use KentaBlocks\Traits\Admin;
use KentaBlocks\Traits\Assets;
use KentaBlocks\Traits\Blocks;

class Bootstrap {

	use Blocks;
	use Assets;
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

		add_action( 'init', array( $this, 'register_assets' ) );
		add_action( 'init', array( $this, 'blocks_init' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ), 9999 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'rest_api_init', array( Route::class, 'api_v1' ) );
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
}