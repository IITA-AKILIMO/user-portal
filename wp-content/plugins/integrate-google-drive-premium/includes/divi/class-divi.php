<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;

class Divi {

	private static $instance;

	public function __construct() {
		add_action( 'divi_extensions_init', [ $this, 'init' ] );
	}

	public function init() {
		if ( ! class_exists( __NAMESPACE__ . '\DiviModules' ) ) {
			return;
		}

		include_once IGD_INCLUDES . '/divi/class-divi-modules.php';

	}

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Divi::get_instance();

