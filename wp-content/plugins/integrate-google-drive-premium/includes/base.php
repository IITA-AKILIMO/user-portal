<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();

final class Main {


	/**
	 * The single instance of the class.
	 *
	 * @var Main
	 * @since 1.0.0
	 */
	protected static $instance = null;

	/**
	 * Main constructor.
	 */
	public function __construct() {
		$this->init_auto_loader();
		$this->includes();
		$this->init_hooks();

		register_activation_hook( IGD_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( IGD_FILE, array( $this, 'deactivate' ) );

		do_action( 'igd_loaded' );
	}

	public function activate() {
		if ( ! class_exists( 'IGD\Install' ) ) {
			require_once IGD_INCLUDES . '/class-install.php';
		}

		Install::activate();
	}

	public function deactivate() {
		if ( ! class_exists( 'IGD\Install' ) ) {
			require_once IGD_INCLUDES . '/class-install.php';
		}

		Install::deactivate();
	}


	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function includes() {

		//core includes
		require_once IGD_INCLUDES . '/functions.php';
		require_once IGD_INCLUDES . '/class-enqueue.php';
		require_once IGD_INCLUDES . '/class-hooks.php';
		require_once IGD_INCLUDES . '/class-ajax.php';
		require_once IGD_INCLUDES . '/class-shortcode.php';
		require_once IGD_INCLUDES . '/class-rest-api.php';

        // Monitor shortcodes locations
		require_once IGD_INCLUDES . '/class-shortcode-locations.php';

		// Integration
		include_once IGD_INCLUDES . '/class-integration.php';

		//pro files
		if ( igd_fs()->can_use_premium_code__premium_only() ) {
			require_once IGD_INCLUDES . '/class-importer__premium_only.php';

			// Statistics Settings
			if ( igd_get_settings( 'enableStatistics', true ) ) {
				require_once IGD_INCLUDES . '/class-statistics__premium_only.php';

				if ( igd_get_settings( 'emailReport', false ) ) {
					require_once IGD_INCLUDES . '/class-email-report__premium_only.php';
				}

			}
		}

		//admin includes
		if ( is_admin() ) {
			require_once IGD_INCLUDES . '/class-admin.php';
		}

	}

	public function init_auto_loader() {

		// Only loads the app files
		spl_autoload_register( function ( $class_name ) {

			if ( false !== strpos( $class_name, 'IGD' ) ) {
				$classes_dir = IGD_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;

				$file_name = strtolower( str_replace( [ 'IGD\\', '_' ], [ '', '-' ], $class_name ) );

				$file_name = "class-$file_name.php";

				$file = $classes_dir . $file_name;

				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}

		} );


	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks() {

		add_action( 'admin_notices', [ $this, 'print_notices' ], 15 );

		// Localize our plugin
		add_action( 'init', [ $this, 'localization_setup' ] );

		// Plugin action links
		add_filter( 'plugin_action_links_' . plugin_basename( IGD_FILE ), [ $this, 'plugin_action_links' ] );

	}

	public function plugin_action_links( $links ) {
		$links[] = '<a href="https://softlabbd.com/docs-category/integrate-google-drive-docs/" target="_blank">' . __( 'Docs', 'integrate-google-drive' ) . '</a>';

		return $links;
	}


	/**
	 * Initialize plugin for localization
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'integrate-google-drive', false, dirname( plugin_basename( IGD_FILE ) ) . '/languages/' );
	}


	public function add_notice( $class, $message ) {

		$notices = get_option( sanitize_key( 'igd_notices' ), [] );
		if ( is_string( $message ) && is_string( $class ) && ! wp_list_filter( $notices, array( 'message' => $message ) ) ) {

			$notices[] = array(
				'message' => $message,
				'class'   => $class,
			);

			update_option( sanitize_key( 'igd_notices' ), $notices );
		}

	}

	/**
	 * Prince admin notice
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function print_notices() {
		$notices = get_option( sanitize_key( 'igd_notices' ), [] );

		foreach ( $notices as $notice ) { ?>
            <div class="notice notice-large is-dismissible igd-admin-notice notice-<?php echo esc_attr( $notice['class'] ); ?>">
				<?php echo $notice['message']; ?>
            </div>
			<?php
			update_option( sanitize_key( 'igd_notices' ), [] );
		}
	}


	/**
	 * Main Instance.
	 *
	 * Ensures only one instance of IGD is loaded or can be loaded.
	 *
	 * @return Main - Main instance.
	 * @since 1.0.0
	 * @static
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

//kickoff igd
if ( ! function_exists( 'igd' ) ) {
	function igd() {
		return Main::instance();
	}
}

igd();