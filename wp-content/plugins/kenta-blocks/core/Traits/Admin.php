<?php
/**
 * Admin hooks
 *
 * @package Kenta Blocks
 */

namespace KentaBlocks\Traits;

trait Admin {
	/**
	 * Register admin menu
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		add_menu_page(
			__( 'Kenta Blocks', 'kenta-blocks' ),
			__( 'Kenta Blocks', 'kenta-blocks' ),
			'manage_options',
			'kenta-blocks',
			array( $this, 'show_admin_menu' ),
			KENTA_BLOCKS_PLUGIN_URL . 'assets/images/kenta-blocks-logo.svg'
		);
	}

	/**
	 * Show admin menu
	 *
	 * @return void
	 */
	public function show_admin_menu() {
		kenta_blocks_template_part( 'admin' );
	}
}