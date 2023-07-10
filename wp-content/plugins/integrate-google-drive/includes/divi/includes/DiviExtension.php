<?php

namespace IGD;

class DiviExtension extends \DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'integrate-google-drive';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'igd-divi-extension';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * \DiviExtension() constructor.
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function __construct( $name = 'igd-divi-extension', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );


		add_action( 'wp_enqueue_scripts', function () {

			Enqueue::instance()->frontend_scripts();
			wp_enqueue_script( 'igd-frontend' );

		}, 99 );


	}
}

new DiviExtension();
