<?php
/**
 * Yuki Helper Functions
 *
 * @package Yuki
 */

use LottaFramework\Customizer\Controls\Info;

if ( ! function_exists( 'yuki_app' ) ) {
	/**
	 * Get global application
	 *
	 * @param null $abstract
	 * @param array $parameters
	 *
	 * @return \Illuminate\Container\Container|mixed|object
	 */
	function yuki_app( $abstract = null, array $parameters = [] ) {
		return \LottaFramework\Utils::app( $abstract, $parameters );
	}
}

if ( ! function_exists( 'yuki_do_elementor_location' ) ) {
	/**
	 * Do the Elementor location, if it does not exist, display the custom template part.
	 *
	 * @param $elementor_location
	 * @param string $template_part
	 * @param null $name
	 */
	function yuki_do_elementor_location( $elementor_location, $template_part = '', $name = null ) {
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( $elementor_location ) ) {
			get_template_part( $template_part, $name );
		}
	}
}

if ( ! function_exists( 'yuki_upsell_info' ) ) {
	/**
	 * @param $info
	 *
	 * @return string
	 */
	function yuki_upsell_info( $info ) {
		$upsell_url = admin_url( 'themes.php?page=yuki-pricing' );

		return sprintf(
			$info, '<a href="' . esc_url( $upsell_url ) . '">', '</a>'
		);
	}
}

if ( ! function_exists( 'yuki_upsell_info_control' ) ) {
	/**
	 * @param $info
	 * @param null $id
	 *
	 * @return Info
	 */
	function yuki_upsell_info_control( $info, $id = null ): Info {
		return ( new Info( $id ) )
			->alignCenter()
			->hideBackground()
			->setInfo( yuki_upsell_info( $info ) );
	}
}
