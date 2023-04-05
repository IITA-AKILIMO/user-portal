<?php
/**
 * Customizer settings default value
 *
 * @package Kenta Business
 */

if ( ! function_exists( 'kenta_business_return_yes' ) ) {
	function kenta_business_return_yes() {
		return 'yes';
	}
}

if ( ! function_exists( 'kenta_business_return_no' ) ) {
	function kenta_business_return_no() {
		return 'no';
	}
}

// Disable site wrap by default
add_filter( 'kenta_enable_site_wrap_default_value', 'kenta_business_return_no' );
// Show blogs archive header by default
add_filter( 'kenta_disable_blogs_archive_header_default_value', 'kenta_business_return_no' );
// Enable transparent header by default
add_filter( 'kenta_enable_transparent_header_default_value', 'kenta_business_return_yes' );
// Enable transparent header in archive page
add_filter( 'kenta_disable_archive_transparent_header_default_value', 'kenta_business_return_no' );

if ( ! function_exists( 'kenta_business_change_default_blogs_archive_title' ) ) {
	/**
	 * Alert default archive page title
	 *
	 * @param $title
	 *
	 * @return mixed|string|void
	 */
	function kenta_business_change_default_blogs_archive_title( $title ) {
		if ( is_home() ) {
			// TODO: Premium compatibility check
			return __( 'Blogs', 'kenta-business' );
		}

		return $title;
	}
}
add_filter( 'get_the_archive_title', 'kenta_business_change_default_blogs_archive_title' );

//
// Article & Archive header style
//
if ( ! function_exists( 'kenta_business_article_featured_image_position' ) ) {
	/**
	 * Change default article featured image position design
	 *
	 * @return string
	 */
	function kenta_business_article_featured_image_position() {
		return 'behind';
	}
}
add_filter( 'kenta_post_featured_image_position_default_value', 'kenta_business_article_featured_image_position' );
add_filter( 'kenta_page_featured_image_position_default_value', 'kenta_business_article_featured_image_position' );

if ( ! function_exists( 'kenta_business_remove_default_content_spacing' ) ) {
	/**
	 * Remove default content spacing
	 *
	 * @return string
	 */
	function kenta_business_remove_default_content_spacing() {
		return '0x';
	}
}
add_filter( 'kenta_single_post_content_spacing_default_value', 'kenta_business_remove_default_content_spacing' );
add_filter( 'kenta_pages_content_spacing_default_value', 'kenta_business_remove_default_content_spacing' );

if ( ! function_exists( 'kenta_business_default_archive_header_padding' ) ) {
	/**
	 * Change default padding for archive header
	 *
	 * @return array
	 */
	function kenta_business_default_archive_header_padding() {
		return array(
			'top'    => '148px',
			'bottom' => '68px',
			'left'   => '24px',
			'right'  => '24px',
			'linked' => false
		);
	}
}
add_filter( 'kenta_archive_header_padding_default_value', 'kenta_business_default_archive_header_padding' );

if ( ! function_exists( 'kenta_business_archive_title_typography' ) ) {
	function kenta_business_archive_title_typography() {
		return array(
			'family'        => 'inherit',
			'fontSize'      => [ 'desktop' => '3rem', 'tablet' => '2rem', 'mobile' => '1.875em' ],
			'variant'       => '700',
			'lineHeight'    => '1.5',
			'textTransform' => 'capitalize',
		);
	}
}
add_filter( 'kenta_archive_title_typography_default_value', 'kenta_business_archive_title_typography' );

if ( ! function_exists( 'kenta_business_archive_title_color' ) ) {
	function kenta_business_archive_title_color() {
		return array(
			'initial' => 'var(--kenta-accent-color)',
		);
	}
}
add_filter( 'kenta_archive_title_color_default_value', 'kenta_business_archive_title_color' );

if ( ! function_exists( 'kenta_archive_description_color' ) ) {
	function kenta_archive_description_color() {
		return array(
			'initial' => 'var(--kenta-accent-active)',
		);
	}
}
add_filter( 'kenta_archive_description_color_default_value', 'kenta_archive_description_color' );

if ( ! function_exists( 'kenta_business_hero_background' ) ) {
	/**
	 * Change default hero background for archive, single posts and pages
	 *
	 * @return array
	 */
	function kenta_business_hero_background() {
		return array(
			'type'     => 'gradient',
			'gradient' => 'linear-gradient(180deg,#d3f0ff,#f2f2fc)',
			'color'    => 'var(--kenta-primary-color)',
		);
	}
}
add_filter( 'kenta_archive_header_background_default_value', 'kenta_business_hero_background' );
add_filter( 'kenta_post_featured_image_background_overlay_default_value', 'kenta_business_hero_background' );
add_filter( 'kenta_page_featured_image_background_overlay_default_value', 'kenta_business_hero_background' );

//
// Transparent Header settings
//

if ( ! function_exists( 'kenta_business_transparent_header_device' ) ) {
	function kenta_business_transparent_header_device() {
		return 'all';
	}
}
add_filter( 'kenta_enable_transparent_header_device_default_value', 'kenta_business_transparent_header_device' );

//
// Default color preset
//

if ( ! function_exists( 'kenta_business_default_color_presets' ) ) {
	function kenta_business_default_color_presets() {
		return 'kenta-business';
	}
}
add_filter( 'kenta_color_palettes_default_value', 'kenta_business_default_color_presets' );

if ( ! function_exists( 'kenta_business_color_presets' ) ) {
	function kenta_business_color_presets( $presets ) {
		$presets['kenta-business'] = array(
			'kenta-primary-color'  => '#5956e9',
			'kenta-primary-active' => '#0693E3',
			'kenta-accent-color'   => '#000248',
			'kenta-accent-active'  => '#52526c',
			'kenta-base-300'       => '#e2e8f0',
			'kenta-base-200'       => '#f1f5f9',
			'kenta-base-100'       => '#f8fafc',
			'kenta-base-color'     => '#ffffff',
		);

		return $presets;
	}
}
add_filter( 'kenta_filter_color_presets', 'kenta_business_color_presets' );
