<?php
/**
 * Theme functions
 *
 * @package Kenta Business
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'KENTA_BUSINESS_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'KENTA_BUSINESS_VERSION', '1.0.2' );
}

if ( ! defined( 'KENTA_BUSINESS_PATH' ) ) {
	define( 'KENTA_BUSINESS_PATH', trailingslashit( get_stylesheet_directory() ) );
}

if ( ! defined( 'KENTA_BUSINESS_URL' ) ) {
	define( 'KENTA_BUSINESS_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}

if ( ! defined( 'KENTA_BUSINESS_ASSETS_URL' ) ) {
	define( 'KENTA_BUSINESS_ASSETS_URL', KENTA_BUSINESS_URL . 'assets/' );
}

// Helper functions
require_once KENTA_BUSINESS_PATH . 'helpers.php';
// Theme patterns
require_once KENTA_BUSINESS_PATH . 'patterns.php';
// Customizer settings hook
require_once KENTA_BUSINESS_PATH . 'customizer.php';

if ( ! function_exists( 'kenta_business_enqueue_styles' ) ) {
	function kenta_business_enqueue_styles() {
		wp_enqueue_style(
			'kenta-business-style',
			get_stylesheet_uri(),
			array(),
			KENTA_BUSINESS_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'kenta_business_enqueue_styles' );

if ( ! function_exists( 'kenta_business_setup' ) ) {
	/**
	 * Theme setup
	 */
	function kenta_business_setup() {
		add_editor_style( 'style.css' );
	}
}
add_action( 'after_setup_theme', 'kenta_business_setup' );

if ( ! function_exists( 'kenta_business_starter_content' ) ) {
	/**
	 * Starter content
	 *
	 * @param $starter
	 *
	 * @return mixed
	 */
	function kenta_business_starter_content( $starter ) {
		$starter['posts'] = array(
			'front' => array(
				'post_type'    => 'page',
				'post_title'   => esc_html__( 'Home', 'exs' ),
				'thumbnail'    => '{{image-cup}}',
				'post_content' => kenta_business_starter_template( 'home' ),
				'template'     => 'page-templates/homepage.php',
			),
			'about',
			'contact',
			'blog',
		);

		$starter['options'] = array(
			'show_on_front'  => 'page',
			'page_on_front'  => '{{front}}',
			'page_for_posts' => '{{blog}}',
		);

		return $starter;
	}
}
add_filter( 'kenta_filter_starter_content', 'kenta_business_starter_content' );
