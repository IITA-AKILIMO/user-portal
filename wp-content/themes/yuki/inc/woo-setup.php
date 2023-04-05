<?php
/**
 * Yuki Theme WooCommerce Setup
 *
 * @package Yuki
 */

use LottaFramework\Facades\CZ;
use LottaFramework\Utils;

if ( ! function_exists( 'yuki_woo_setup' ) ) {
	/**
	 * WooCommerce setup.
	 */
	function yuki_woo_setup() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
}
add_action( 'after_setup_theme', 'yuki_woo_setup' );

if ( ! function_exists( 'yuki_woo_before_content' ) ) {
	/**
	 * Wrap woocommerce content - start
	 */
	function yuki_woo_before_content() {
		$layout = 'no-sidebar';
		if ( CZ::checked( 'yuki_store_sidebar_section' ) ) {
			$layout = CZ::get( 'yuki_store_sidebar_layout' );
		}

		?>
        <div class="<?php Utils::the_clsx( yuki_container_css( $layout ) ) ?>">
        <div id="content" class="flex-grow max-w-full">
        <div class="yuki-article-content yuki-entry-content clearfix mx-auto prose prose-yuki">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'yuki_woo_before_content', 5 );

if ( ! function_exists( 'yuki_woo_after_content' ) ) {
	/**
	 * Wrap woocommerce content - end
	 */
	function yuki_woo_after_content() {
		$layout = 'no-sidebar';
		if ( CZ::checked( 'yuki_store_sidebar_section' ) ) {
			$layout = CZ::get( 'yuki_store_sidebar_layout' );
		}

		?>
        </div>
        </div>
		<?php
		/**
		 * Hook - yuki_action_sidebar.
		 */
		do_action( 'yuki_action_sidebar', $layout );
		?>
        </div>
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'yuki_woo_after_content', 50 );

// Remove Default WooCommerce Sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

if ( ! function_exists( 'yuki_remove_woo_breadcrumbs' ) ) {
	/**
	 * Remove breadcrumbs for WooCommerce page.
	 */
	function yuki_remove_woo_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}
add_action( 'init', 'yuki_remove_woo_breadcrumbs' );

/**
 * Change the order of the on sale button.
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
