<?php
/**
 * Global customizer section
 *
 * @package Kenta
 */

use LottaFramework\Customizer\Controls\Collapse;
use LottaFramework\Customizer\Controls\Section;
use LottaFramework\Customizer\Controls\Slider;
use LottaFramework\Customizer\Controls\Toggle;
use LottaFramework\Customizer\Section as CustomizerSection;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Kenta_Global_Section' ) ) {

	class Kenta_Global_Section extends CustomizerSection {

		use Kenta_Widgets_Controls;

		public function getSlug( $key = '' ) {
			return 'kenta_global_sidebar' . ( ( $key === '' ) ? '' : '_' . $key );
		}

		/**
		 * {@inheritDoc}
		 */
		public function getControls() {
			$controls = [
				( new Section( 'kenta_global_layout_section' ) )
					->setLabel( __( 'Layout', 'kenta' ) )
					->setControls( $this->getLayoutControls() )
				,

				( new Section( 'kenta_global_performance_section' ) )
					->setLabel( __( 'Performance', 'kenta' ) )
					->setControls( $this->getPerformanceControls() )
				,

				( new Section( 'kenta_global_sidebar_section' ) )
					->setLabel( __( 'Sidebar', 'kenta' ) )
					->setControls( $this->getWidgetsControls( [
						'css-selective-refresh' => 'kenta-global-selective-css',
						'async-selector'        => '.kenta-sidebar',
						'customize-location'    => 'sidebar-widgets-primary-sidebar',
					] ) )
				,
			];

			return apply_filters( 'kenta_global_section_controls', $controls );
		}

		protected function getLayoutControls() {
			return [
				( new Collapse() )
					->setLabel( __( 'Content Area Spacing', 'kenta' ) )
					->openByDefault()
					->setControls( [
						( new Slider( 'kenta_homepage_content_spacing' ) )
							->setLabel( __( 'Homepage', 'kenta' ) )
							->enableResponsive()
							->bindSelectiveRefresh( 'kenta-global-selective-css' )
							->setDefaultUnit( 'px' )
							->setDefaultValue( '0px' )
						,
						( new Slider( 'kenta_archive_content_spacing' ) )
							->setLabel( __( 'Archive', 'kenta' ) )
							->enableResponsive()
							->bindSelectiveRefresh( 'kenta-global-selective-css' )
							->setDefaultUnit( 'px' )
							->setDefaultValue( '48px' )
						,
						( new Slider( 'kenta_single_post_content_spacing' ) )
							->setLabel( __( 'Single Post', 'kenta' ) )
							->enableResponsive()
							->bindSelectiveRefresh( 'kenta-global-selective-css' )
							->setDefaultUnit( 'px' )
							->setDefaultValue( '48px' )
						,
						( new Slider( 'kenta_pages_content_spacing' ) )
							->setLabel( __( 'Pages', 'kenta' ) )
							->enableResponsive()
							->bindSelectiveRefresh( 'kenta-global-selective-css' )
							->setDefaultUnit( 'px' )
							->setDefaultValue( '48px' )
						,
						( new Slider( 'kenta_store_content_spacing' ) )
							->setLabel( __( 'Store', 'kenta' ) )
							->enableResponsive()
							->bindSelectiveRefresh( 'kenta-global-selective-css' )
							->setDefaultUnit( 'px' )
							->setDefaultValue( '48px' )
						,
					] )
			];
		}

		protected function getPerformanceControls() {
			return [
				( new Toggle( 'kenta_use_local_fonts' ) )
					->setLabel( __( 'Load Google Fonts Locally', 'kenta' ) )
					->setDescription( __( 'Complying with GDPR by using local google fonts.', 'kenta' ) )
					->openByDefault()
			];
		}
	}
}
