<?php

namespace KentaCompanion\Core;

use KentaCompanion\Container\Container;

/**
 * Container instance for our plugin
 *
 * @package Kenta Companion
 */
class KentaCompanion extends Container {

	public function __construct() {
		self::setInstance( $this );

		add_action( 'kcmp/after_bootstrap', [ $this, 'after_boostrap' ] );

		add_action( 'rest_api_init', [ Route::class, 'api_v1' ] );

		add_action( 'admin_menu', [ $this, 'admin_menu' ] );

		add_action( 'kcmp/show_admin_setup_page', [ $this, 'show_about_kenta_theme_page' ] );

		add_filter( 'kenta_admin_page_customizer_items', [ $this, 'admin_page_customizer_items' ] );
	}

	/**
	 * Boostrap theme extenions
	 *
	 * @return void
	 */
	public function after_boostrap() {
		if ( ! kcmp_is_valid_theme() ) {
			return;
		}

		// register extensions
		$extensions = kcmp( 'extensions' );
		$extensions
			->register( 'builder', [
				'class' => \KentaCompanion\Extensions\Builder::class,
			] )
			->register( 'archive', [
				'class' => \KentaCompanion\Extensions\Archive::class,
			] )
			->register( 'article', [
				'class' => \KentaCompanion\Extensions\Article::class,
			] )
			->register( 'button', [
				'class' => \KentaCompanion\Extensions\Button::class,
			] )
			->register( 'icon-button', [
				'class' => \KentaCompanion\Extensions\IconButton::class,
			] )
			->register( 'copyright', [
				'class' => \KentaCompanion\Extensions\Copyright::class,
			] )
			->register( 'widgets', [
				'class' => \KentaCompanion\Extensions\Widgets::class,
			] )
			->register( 'menu-element', [
				'class' => \KentaCompanion\Extensions\MenuElement::class,
			] )
			->register( 'socials', [
				'class' => \KentaCompanion\Extensions\Socials::class,
			] )
			->register( 'scroll-top', [
				'class' => \KentaCompanion\Extensions\ScrollTop::class,
			] )
			->register( 'cookies-consent', [
				'class' => \KentaCompanion\Extensions\CookiesConsent::class,
			] )
			->register( 'card', [
				'class' => \KentaCompanion\Extensions\Card::class,
			] )
			->register( 'pagination', [
				'class' => \KentaCompanion\Extensions\Pagination::class,
			] )
			->bootstrap();
	}

	/**
	 * Register admin menu
	 */
	public function admin_menu() {
		$setup   = kcmp_plugin_setup_page();
		$starter = kcmp_plugin_starter_page();

		add_menu_page(
			$setup['page_title'],
			$setup['menu_title'],
			$setup['capability'],
			$setup['menu_slug'],
			[ $this, 'show_admin_setup_page' ],
			KCMP_ASSETS_URL . 'images/kenta-logo.svg',
			'58.6'
		);

		if ( kcmp_is_valid_theme() ) {
			add_submenu_page(
				$starter['parent_slug'],
				$starter['page_title'],
				$starter['menu_title'],
				$starter['capability'],
				$starter['menu_slug'],
				[ $this, 'show_starter_sites_page' ]
			);
		}
	}

	public function admin_page_customizer_items( $items ) {
		return array_merge( $items, [
			[
				'label'    => __( 'Social Settings', 'kenta' ),
				'icon'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M26.656 21.344c-1.824 0-3.456 0.928-4.416 2.368l-11.904-5.952c0.192-0.544 0.32-1.152 0.32-1.76s-0.128-1.216-0.32-1.76l11.904-5.952c0.96 1.44 2.592 2.368 4.416 2.368 2.944 0 5.344-2.368 5.344-5.312s-2.4-5.344-5.344-5.344-5.312 2.4-5.312 5.344c0 0.608 0.128 1.184 0.32 1.76l-11.904 5.92c-0.96-1.408-2.592-2.368-4.416-2.368-2.944 0-5.344 2.4-5.344 5.344s2.4 5.344 5.344 5.344c1.824 0 3.456-0.96 4.416-2.4l11.904 5.952c-0.192 0.576-0.32 1.152-0.32 1.76 0 2.944 2.368 5.344 5.312 5.344s5.344-2.4 5.344-5.344-2.4-5.312-5.344-5.312zM26.656 1.344c2.208 0 4 1.792 4 4s-1.792 4-4 4c-1.536 0-2.88-0.928-3.552-2.208 0-0.032 0-0.032 0-0.032s0 0 0 0c-0.256-0.544-0.448-1.12-0.448-1.76 0-2.208 1.792-4 4-4zM5.344 20c-2.208 0-4-1.792-4-4s1.792-4 4-4c1.536 0 2.88 0.896 3.552 2.208 0 0 0 0 0 0s0 0 0 0c0.288 0.544 0.448 1.152 0.448 1.792s-0.16 1.216-0.448 1.76c0 0 0 0 0 0.032 0 0 0 0 0 0-0.672 1.312-2.016 2.208-3.552 2.208zM26.656 30.656c-2.208 0-4-1.792-4-4 0-0.64 0.192-1.216 0.448-1.76 0 0 0 0 0 0s0 0 0-0.032c0.672-1.28 2.016-2.208 3.552-2.208 2.208 0 4 1.792 4 4s-1.792 4-4 4z"></path></svg>',
				'location' => 'kenta_global:kenta_global_socials',
			],
			[
				'label'    => __( 'Scroll Top Settings', 'kenta' ),
				'icon'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M15.36 6.688c0.352-0.352 0.928-0.352 1.28 0l4.416 4.416c0.576 0.544 0.16 1.472-0.608 1.472h-2.72v16.288c-0.096 0.992-0.832 1.792-1.728 1.792h-0.16c-0.896-0.096-1.568-0.96-1.568-1.984v-16.096h-2.72c-0.768 0-1.184-0.928-0.608-1.472l4.416-4.416zM29.344 0.928c0.96 0 1.728 0.768 1.728 1.728s-0.768 1.728-1.728 1.728h-26.688c-0.96 0-1.728-0.768-1.728-1.728s0.768-1.728 1.728-1.728h26.688z"></path></svg>',
				'location' => 'kenta_global:kenta_global_scroll_top',
			],
			[
				'label'    => __( 'Cookies Consent Settings', 'kenta' ),
				'icon'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M257.5 27.6c-.8-5.4-4.9-9.8-10.3-10.6c-22.1-3.1-44.6 .9-64.4 11.4l-74 39.5C89.1 78.4 73.2 94.9 63.4 115L26.7 190.6c-9.8 20.1-13 42.9-9.1 64.9l14.5 82.8c3.9 22.1 14.6 42.3 30.7 57.9l60.3 58.4c16.1 15.6 36.6 25.6 58.7 28.7l83 11.7c22.1 3.1 44.6-.9 64.4-11.4l74-39.5c19.7-10.5 35.6-27 45.4-47.2l36.7-75.5c9.8-20.1 13-42.9 9.1-64.9c-.9-5.3-5.3-9.3-10.6-10.1c-51.5-8.2-92.8-47.1-104.5-97.4c-1.8-7.6-8-13.4-15.7-14.6c-54.6-8.7-97.7-52-106.2-106.8zM208 208c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32zm0 128c0 17.7-14.3 32-32 32s-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32zm160 0c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z"/></svg>',
				'location' => 'kenta_global:kenta_global_cookies_consent',
			],
		] );
	}

	public function show_about_kenta_theme_page() {
		if ( kcmp_is_valid_theme() ) {
			return;
		}

		kcmp_get_template_part( 'about-kenta' );
	}

	/**
	 * Show setup page
	 */
	public function show_admin_setup_page() {
		do_action( 'kcmp/show_admin_setup_page' );
	}

	/**
	 * Show starter sites
	 */
	public function show_starter_sites_page() {
		kcmp_get_template_part( 'starter-sites' );
	}
}