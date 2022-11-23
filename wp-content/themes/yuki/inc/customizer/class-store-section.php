<?php
/**
 * Store customizer section
 *
 * @package Yuki
 */

use LottaFramework\Customizer\Controls\ColorPicker;
use LottaFramework\Customizer\Controls\ImageRadio;
use LottaFramework\Customizer\Controls\Section;
use LottaFramework\Customizer\Controls\Separator;
use LottaFramework\Customizer\Controls\Typography;
use LottaFramework\Customizer\Section as CustomizerSection;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Yuki_Store_Section' ) ) {

	class Yuki_Store_Section extends CustomizerSection {

		use Yuki_Article_Controls;

		/**
		 * {@inheritDoc}
		 */
		public function getControls() {
			return [
				( new Section( 'yuki_store_sidebar_section' ) )
					->setLabel( __( 'Sidebar', 'yuki' ) )
					->enableSwitch( false )
					->setControls( [
						( new ImageRadio( 'yuki_store_sidebar_layout' ) )
							->setLabel( __( 'Sidebar Layout', 'yuki' ) )
							->setDefaultValue( 'right-sidebar' )
							->setChoices( [
								'left-sidebar'  => [
									'title' => __( 'Left Sidebar', 'yuki' ),
									'src'   => yuki_image_url( 'left-sidebar.png' ),
								],
								'right-sidebar' => [
									'title' => __( 'Right Sidebar', 'yuki' ),
									'src'   => yuki_image_url( 'right-sidebar.png' ),
								],
							] )
						,
					] )
				,

				( new Section( 'yuki_store_form_section' ) )
					->setLabel( __( 'Form', 'yuki' ) )
					->setControls( [
						( new Typography( 'yuki_store_form_typography' ) )
							->setLabel( __( 'Typography', 'yuki' ) )
							->bindSelectiveRefresh( 'yuki-global-selective-css' )
							->setDefaultValue( [
								'family'     => 'inherit',
								'fontSize'   => '0.85rem',
								'variant'    => '400',
								'lineHeight' => '1.5em'
							] )
						,
						( new Separator() ),
						( new ColorPicker( 'yuki_store_form_color' ) )
							->setLabel( __( 'Controls Color', 'yuki' ) )
							->enableAlpha()
							->bindSelectiveRefresh( 'yuki-global-selective-css' )
							->addColor( 'background', __( 'Background', 'yuki' ), 'var(--yuki-base-color)' )
							->addColor( 'border', __( 'Border', 'yuki' ), 'var(--yuki-base-200)' )
							->addColor( 'active', __( 'Active', 'yuki' ), 'var(--yuki-primary-color)' )
						,
					] )
				,
			];
		}
	}
}


