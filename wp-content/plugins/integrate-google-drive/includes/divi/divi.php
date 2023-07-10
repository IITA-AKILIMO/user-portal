<?php


use IGD\Enqueue;

if ( ! function_exists( 'igd_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function igd_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/DiviExtension.php';
}
add_action( 'divi_extensions_init', 'igd_initialize_extension' );

	add_action( 'et_builder_ready', 'igd_divi_editor_scripts' );

	function igd_divi_editor_scripts() {
		Enqueue::instance()->admin_scripts( '', false );
		wp_enqueue_script( 'igd-divi', IGD_ASSETS . '/js/divi.js', [ 'igd-admin' ], IGD_VERSION, true );
	}

endif;
