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
			KENTA_BLOCKS_PLUGIN_URL . 'assets/images/kenta-blocks-logo.svg',
			'58.7'
		);

		if ( ! kb_fs()->is_registered() ) {
			add_submenu_page(
				'kenta-blocks',
				__( 'Opt In', 'kenta-blocks' ),
				__( 'Opt In', 'kenta-blocks' ),
				'manage_options',
				'kenta-blocks-optin',
				[ kb_fs(), '_connect_page_render' ]
			);
		}
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