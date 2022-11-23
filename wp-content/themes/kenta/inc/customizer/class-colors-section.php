<?php
/**
 * Colors customizer section
 *
 * @package Kenta
 */

use LottaFramework\Customizer\Controls\Background;
use LottaFramework\Customizer\Controls\BoxShadow;
use LottaFramework\Customizer\Controls\ColorPalettes;
use LottaFramework\Customizer\Controls\ColorPicker;
use LottaFramework\Customizer\Controls\Condition;
use LottaFramework\Customizer\Controls\Filters;
use LottaFramework\Customizer\Controls\Separator;
use LottaFramework\Customizer\Controls\Toggle;
use LottaFramework\Customizer\Section;
use LottaFramework\Facades\AsyncCss;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Kenta_Colors_Section' ) ) {

	class Kenta_Colors_Section extends Section {

		/**
		 * {@inheritDoc}
		 */
		public function getControls() {
			$palettes = ( new ColorPalettes( 'kenta_color_palettes', [
				'kenta-primary-color'  => __( 'Primary Color', 'kenta' ),
				'kenta-primary-active' => __( 'Primary Active', 'kenta' ),
				'kenta-accent-color'   => __( 'Accent Color', 'kenta' ),
				'kenta-accent-active'  => __( 'Accent Active', 'kenta' ),
				'kenta-base-color'     => __( 'Base Color', 'kenta' ),
				'kenta-base-50'        => __( 'Base 50', 'kenta' ),
				'kenta-base-100'       => __( 'Base 100', 'kenta' ),
				'kenta-base-200'       => __( 'Base 200', 'kenta' ),
				'kenta-base-300'       => __( 'Base 300', 'kenta' ),
			] ) )
				->setLabel( __( 'Color Presets', 'kenta' ) )
				->setDefaultValue( 'preset-1' );

			foreach ( kenta_color_presets() as $id => $preset ) {
				$palettes->addPalette( $id, $preset );
			}

			return [
				$palettes,
				( new ColorPicker( 'kenta_primary_color' ) )
					->setLabel( __( 'Primary Color', 'kenta' ) )
					->enableAlpha()
					->setSwatches( [] )
					->asyncColors( ':root', [
						'default' => '--kenta-primary-color',
						'active'  => '--kenta-primary-active',
					] )
					->addColor( 'default', __( 'Default', 'kenta' ), 'var(--kenta-primary-color)' )
					->addColor( 'active', __( 'Active', 'kenta' ), 'var(--kenta-primary-active)' )
				,
				( new ColorPicker( 'kenta_accent_color' ) )
					->setLabel( __( 'Accent Color', 'kenta' ) )
					->enableAlpha()
					->setSwatches( [] )
					->asyncColors( ':root', [
						'default' => '--kenta-accent-color',
						'active'  => '--kenta-accent-active',
					] )
					->addColor( 'default', __( 'Default', 'kenta' ), 'var(--kenta-accent-color)' )
					->addColor( 'active', __( 'Active', 'kenta' ), 'var(--kenta-accent-active)' )
				,
				( new ColorPicker( 'kenta_base_color' ) )
					->setLabel( __( 'Base Color', 'kenta' ) )
					->enableAlpha()
					->setSwatches( [] )
					->asyncColors( ':root', [
						'default' => '--kenta-base-color',
						'100'     => '--kenta-base-100',
						'200'     => '--kenta-base-200',
						'300'     => '--kenta-base-300',
					] )
					->addColor( '300', __( 'Base 300', 'kenta' ), 'var(--kenta-base-300)' )
					->addColor( '200', __( 'Base 200', 'kenta' ), 'var(--kenta-base-200)' )
					->addColor( '100', __( 'Base 100', 'kenta' ), 'var(--kenta-base-100)' )
					->addColor( 'default', __( 'Base Color', 'kenta' ), 'var(--kenta-base-color)' )
				,
				( new Separator( 'kenta_site_background_separator' ) ),
				( new Toggle( 'kenta_enable_site_wrap' ) )
					->setLabel( __( 'Site Wrap', 'kenta' ) )
					->setDescription( __( 'Enable boundaries for your site on large screens (>1600px)', 'kenta' ) )
					->asyncCss( '.kenta-site-wrap', [
						'max-width'               => AsyncCss::unescape( AsyncCss::valueMapper( [
							'yes' => '1600px',
							'no'  => 'inherit',
						] ) ),
						'--kenta-site-wrap-width' => AsyncCss::unescape( AsyncCss::valueMapper( [
							'yes' => '1600px',
							'no'  => '100vw',
						] ) ),
					] )
					->openByDefault()
				,
				( new Background( 'kenta_site_background' ) )
					->setLabel( __( 'Site Background', 'kenta' ) )
					->asyncCss( '.kenta-site-wrap', AsyncCss::background() )
					->enableResponsive()
					->setDefaultValue( [
						'type'  => 'color',
						'color' => 'var(--kenta-base-100)',
					] )
				,
				( new Condition( 'kenta_site_wrap_condition' ) )
					->setCondition( [ 'kenta_enable_site_wrap' => 'yes' ] )
					->setControls( [
						( new Background( 'kenta_site_body_background' ) )
							->setLabel( __( 'Body Background', 'kenta' ) )
							->asyncCss( '.kenta-body', AsyncCss::background() )
							->enableResponsive()
							->setDefaultValue( [
								'type'  => 'color',
								'color' => 'var(--kenta-base-200)',
							] )
						,
						( new BoxShadow( 'kenta_site_wrap_shadow' ) )
							->setLabel( __( 'Site Box Shadow', 'kenta' ) )
							->asyncCss( '.kenta-site-wrap', AsyncCss::shadow() )
							->setDefaultShadow(
								'rgba(44, 62, 80, 0.06)',
								'0px',
								'0px',
								'24px',
								'0px',
								true
							)
						,
					] )
				,
				( new Filters( 'kenta_site_filters' ) )
					->setLabel( __( 'Site Css Filters', 'kenta' ) )
					->asyncCss( ':root', AsyncCss::filters() )
				,
				( new Separator( 'kenta_gutenberg_color_palette_separator' ) ),
				( new Toggle( 'kenta_color_palette_in_gutenberg' ) )
					->setLabel( __( 'Use Colors in Gutenberg Editor', 'kenta' ) )
					->setDescription( __( "This option allow you to replace the original Gutenberg's color palette with the colors you defined above.", 'kenta' ) )
					->openByDefault()
				,
			];
		}
	}
}

