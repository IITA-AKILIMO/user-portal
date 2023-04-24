<?php
/**
 * Kenta Helper Functions
 *
 * @package Kenta
 */

if ( ! function_exists( 'kenta_app' ) ) {
	/**
	 * Get global application
	 *
	 * @param null $abstract
	 * @param array $parameters
	 *
	 * @return \Illuminate\Container\Container|mixed|object
	 */
	function kenta_app( $abstract = null, array $parameters = [] ) {
		return \LottaFramework\Utils::app( $abstract, $parameters );
	}
}

if ( ! function_exists( 'kenta_kses' ) ) {
	/**
	 * Kses function support svg
	 *
	 * @param $data
	 *
	 * @return string
	 */
	function kenta_kses( $data ) {
		$kses_defaults = wp_kses_allowed_html( 'post' );

		// add svg support
		$svg_args = array(
			'svg'      => array(
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true,
			),
			'clipPath' => array( 'id' => true ),
			'rect'     => array( 'width' => true, 'height' => true, 'fill' => true, 'transform' => true ),
			'defs'     => array(),
			'g'        => array( 'fill' => true ),
			'title'    => array( 'title' => true ),
			'path'     => array( 'd' => true, 'fill' => true, ),
		);

		return wp_kses( $data, array_merge( $kses_defaults, $svg_args ) );
	}
}

if ( ! function_exists( 'kenta_do_elementor_location' ) ) {
	/**
	 * Do the Elementor location, if it does not exist, display the custom template part.
	 *
	 * @param $elementor_location
	 * @param string $template_part
	 * @param null $name
	 */
	function kenta_do_elementor_location( $elementor_location, $template_part = '', $name = null ) {
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( $elementor_location ) ) {
			get_template_part( $template_part, $name );
		}
	}
}

if ( ! function_exists( 'kenta_is_woo_page' ) ) {
	/**
	 * Is woo card, account, checkout page
	 *
	 * @return bool
	 */
	function kenta_is_woo_page() {
		return KENTA_WOOCOMMERCE_ACTIVE && ( is_cart() || is_account_page() || is_checkout() );
	}
}

if ( ! function_exists( 'kenta_is_woo_shop' ) ) {
	/**
	 * Is products or product detail page
	 *
	 * @return bool
	 */
	function kenta_is_woo_shop() {
		return KENTA_WOOCOMMERCE_ACTIVE && is_woocommerce();
	}
}

if ( ! function_exists( 'kenta_is_plugin_installed' ) ) {
	/**
	 * Check whether a plugin is installed
	 *
	 * @param $slug
	 *
	 * @return bool
	 */
	function kenta_is_plugin_installed( $slug ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$all_plugins = get_plugins();

		if ( ! empty( $all_plugins[ $slug ] ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'kenta_install_plugin' ) ) {
	/**
	 * Install new plugin
	 *
	 * @param $plugin_zip
	 *
	 * @return array|bool|WP_Error
	 */
	function kenta_install_plugin( $plugin_zip ) {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();

		$upgrader  = new Plugin_Upgrader();
		$installed = $upgrader->install( $plugin_zip );

		return $installed;
	}
}

if ( ! function_exists( 'kenta_upgrade_plugin' ) ) {
	/**
	 * Upgrade plugin
	 *
	 * @param $slug
	 *
	 * @return array|bool|WP_Error
	 */
	function kenta_upgrade_plugin( $slug ) {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();

		$upgrader = new Plugin_Upgrader();
		$upgraded = $upgrader->upgrade( $slug );

		return $upgraded;
	}
}

if ( ! function_exists( 'kenta_do_install_plugins' ) ) {
	/**
	 * Install and active plugin
	 *
	 * @param $plugins
	 * @param $back_url
	 */
	function kenta_do_install_plugins( $plugins, $back_url ) {
		echo '<div class="notice notice-warning"><p>';
		echo esc_html__( 'The installation process is starting. This process may take a while on some hosts, so please be patient.', 'kenta' );
		echo '</p></div>';

		foreach ( $plugins as $slug => $name ) {
			$name        = '<strong>' . $name . '</strong>';
			$plugin_slug = "{$slug}/{$slug}.php";
			$plugin_zip  = "https://downloads.wordpress.org/plugin/{$slug}.latest-stable.zip";

			if ( kenta_is_plugin_installed( $plugin_slug ) ) {
				echo '<h4>';
				echo sprintf( esc_html__( 'Upgrading %s ...', 'kenta' ), $name );
				echo '</h4>';
				kenta_upgrade_plugin( $plugin_slug );
				$installed = true;
			} else {
				echo '<h4>';
				echo sprintf( esc_html__( 'Installing %s ...', 'kenta' ), $name );
				echo '</h4>';
				$installed = kenta_install_plugin( $plugin_zip );
			}

			if ( ! is_wp_error( $installed ) && $installed ) {
				echo '<h4>';
				echo sprintf( esc_html__( 'Activating %s ...', 'kenta' ), $name );
				echo '</h4>';
				activate_plugin( $plugin_slug );
				echo '<div class="updated"><p>';
				echo sprintf( esc_html__( '%s installed successfully', 'kenta' ), $name );
				echo '</p></div>';
			} else {
				echo '<div class="error"><p>';
				echo sprintf( esc_html__( 'Could not install the %s plugin.', 'kenta' ), $name );
				echo '</p></div>';
			}

			echo '<br><br>';
		}

		echo '<p>';
		esc_html_e( 'All Done!', 'kenta' );
		echo '</p>';
		echo '<p><a href="' . esc_url( $back_url ) . '">' . esc_html__( 'Return To Theme Page', 'kenta' ) . '</a></p>';
	}
}

if ( ! function_exists( 'kenta_why_companion_link' ) ) {
	function kenta_why_companion_link() {
		return '<span>' . __( 'Access our starter sites and more extensions', 'kenta' ) . '</span>';
		// return '<a href="#" target="_blank">' . __( 'Why do I need a companion plugin?', 'kenta' ) . '</a>';
	}
}

if ( ! function_exists( 'kenta_pro_features_link' ) ) {
	function kenta_pro_features_link() {
		return '<a href="https://kentatheme.com/pricing/" target="_blank">' . __( 'Learn More', 'kenta' ) . '</a>';
	}
}

if ( ! function_exists( 'kenta_upsell_url' ) ) {
	/**
	 * Get upsell url
	 *
	 * @return string
	 */
	function kenta_upsell_url() {
		if ( function_exists( 'kcmp_upsell_url' ) ) {
			return kcmp_upsell_url();
		}

		return 'https://kentatheme.com/pricing';
	}
}

if ( ! function_exists( 'kenta_upsell_info' ) ) {
	/**
	 * @param $info
	 *
	 * @return string
	 */
	function kenta_upsell_info( $info ) {
		if ( function_exists( 'kcmp_upsell_info' ) ) {
			return kcmp_upsell_info( $info );
		}

		$upsell_url = kenta_upsell_url();

		return sprintf(
			$info, '<a target="_blank" href="' . esc_url( $upsell_url ) . '">', '</a>'
		);
	}
}

if ( ! function_exists( 'kenta_upsell_info_control' ) ) {
	/**
	 * @param $info
	 * @param null $id
	 *
	 * @return \LottaFramework\Customizer\Controls\Info
	 */
	function kenta_upsell_info_control( $info, $id = null ) {
		return ( new \LottaFramework\Customizer\Controls\Info( $id ) )
			->alignCenter()
			->hideBackground()
			->setInfo( kenta_upsell_info( $info ) );
	}
}

if ( ! function_exists( 'kenta_docs_control' ) ) {
	/**
	 * @param $info
	 * @param $url
	 *
	 * @return \LottaFramework\Customizer\Controls\Info
	 */
	function kenta_docs_control( $info, $url, $id = null ) {
		return ( new \LottaFramework\Customizer\Controls\Info( $id ) )
			->alignCenter()
			->setInfo( sprintf(
				$info, '<a target="_blank" href="' . esc_url( $url ) . '">', '</a>'
			) );
	}
}

if ( ! function_exists( 'kenta_theme_admin_url' ) ) {
	/**
	 * Get kenta theme admin page url
	 *
	 * @param $args
	 *
	 * @return string
	 */
	function kenta_theme_admin_url( $args ) {
		return apply_filters( 'kenta_admin_page_url', add_query_arg( array_merge( $args, [
			'page' => 'kenta-theme'
		] ), admin_url( 'themes.php' ) ), $args );
	}
}

if ( ! function_exists( 'kenta_install_cmp_redirect_url' ) ) {
	/**
	 * @param string $hash
	 *
	 * @return string
	 */
	function kenta_install_cmp_redirect_url( $hash = '' ) {
		$switch              = apply_filters( 'kenta_welcome_demo_switch_after_importing', false );
		$args['page']        = 'kenta-starter-sites';
		$args['skip-opt-in'] = 'yes';
		if ( $switch ) {
			$args['switch'] = true;
		}

		return add_query_arg( $args, admin_url( 'admin.php' ) ) . $hash;
	}
}
