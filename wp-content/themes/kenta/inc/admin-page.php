<?php
/**
 * Kenta Theme Admin Page Hooks
 *
 * @package Kenta
 */

if ( ! function_exists( 'kenta_admin_get_start_notice' ) ) {
	/**
	 * Show get start notice
	 *
	 * @return void
	 */
	function kenta_admin_get_start_notice() {
		if ( get_option( 'kenta_active_template' ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( false !== strpos( $screen->base, 'kenta' ) ) {
			return;
		}

		get_template_part( 'template-parts/admin-start' );
	}
}

add_action( 'admin_notices', 'kenta_admin_get_start_notice' );

if ( ! function_exists( 'kenta_dismiss_notice' ) ) {
	/**
	 * Dismiss admin notice
	 */
	function kenta_dismiss_notice() {
		global $current_user;

		$user_id = $current_user->ID;

		$dismiss_option = filter_input( INPUT_GET, 'kenta_dismiss', FILTER_SANITIZE_STRING );
		if ( is_string( $dismiss_option ) && in_array( $dismiss_option, array( 'start' ) ) ) {
			add_user_meta( $user_id, "kenta_dismissed_$dismiss_option", 'true', true );
//			delete_user_meta( $user_id, "kenta_dismissed_$dismiss_option", 'true', true );
			wp_die( '', '', array( 'response' => 200 ) );
		}
	}
}
add_action( 'admin_init', 'kenta_dismiss_notice' );

if ( ! function_exists( 'kenta_install_companion' ) ) {
	/**
	 * Install Kenta Companion Plugin By One Click
	 */
	function kenta_install_companion() {
		require_once ABSPATH . 'wp-admin/admin-header.php';

		?>
        <div class="wrap">
			<?php
			kenta_do_install_plugins( [
				'kenta-companion' => esc_html__( 'Kenta Companion', 'kenta' ),
				'kenta-blocks'    => esc_html__( 'Kenta Blocks', 'kenta' ),
			], admin_url( 'themes.php' ) );
			?>
        </div>
		<?php
	}
}
add_action( 'admin_action_kenta_install_companion', 'kenta_install_companion' );
// Update dynamic css cache action
add_action( 'admin_action_kenta_update_dynamic_css_cache', 'kenta_update_dynamic_css_cache' );

if ( ! function_exists( 'kenta_show_admin_page' ) ) {
	/**
	 * Show admin page
	 *
	 * @return void
	 */
	function kenta_show_admin_page() {
		get_template_part( 'template-parts/admin', 'container' );
	}
}

if ( ! function_exists( 'kenta_add_admin_menu' ) ) {
	/**
	 * Add admin menu
	 *
	 * @return void
	 */
	function kenta_add_admin_menu() {
		add_theme_page(
			esc_html__( 'Kenta Theme', 'kenta' ),
			esc_html__( 'Kenta Theme', 'kenta' ),
			'edit_theme_options',
			'kenta-theme',
			'kenta_show_admin_page'
		);
	}
}

if ( ! function_exists( 'kenta_cmp_need_upgrade_notice' ) ) {
	/**
	 * Show upgrade Kenta Companion notice
	 */
	function kenta_cmp_need_upgrade_notice() {
		get_template_part( 'template-parts/admin-cmp-upgrade' );
	}
}

if ( KENTA_CMP_ACTIVE ) {
	add_action( 'kcmp/show_admin_setup_page', 'kenta_show_admin_page' );
	// Kenta Companion plugin is out of date
	if ( defined( 'KCMP_VERSION' ) && version_compare( KCMP_VERSION, MIN_KENTA_CMP_VERSION, '<' ) ) {
		add_action( 'admin_notices', 'kenta_cmp_need_upgrade_notice' );
	}
} else {
	add_action( 'admin_menu', 'kenta_add_admin_menu' );
}
