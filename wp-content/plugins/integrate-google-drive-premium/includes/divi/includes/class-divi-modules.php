<?php

namespace IGD\divi\includes;

class DiviModules extends \DiviExtension {
	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'igd-divi-modules';

	/**
	 * The extension's version.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = IGD_VERSION;

	/**
	 * DiviModules constructor.
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function __construct( $name = 'igd-divi-modules', $args = [] ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new DiviModules();
