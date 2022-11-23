<?php
/**
 * Single post customizer section
 *
 * @package Kenta
 */

use LottaFramework\Customizer\Controls\ColorPicker;
use LottaFramework\Customizer\Controls\Icons;
use LottaFramework\Customizer\Controls\ImageRadio;
use LottaFramework\Customizer\Controls\Section;
use LottaFramework\Customizer\Controls\Separator;
use LottaFramework\Customizer\Controls\Spacing;
use LottaFramework\Customizer\Section as CustomizerSection;
use LottaFramework\Facades\AsyncCss;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Kenta_Single_Post_Section' ) ) {

	class Kenta_Single_Post_Section extends CustomizerSection {

		use Kenta_Article_Controls;

		/**
		 * {@inheritDoc}
		 */
		public function getControls() {
			return [
				( new Section( 'kenta_post_container' ) )
					->setLabel( __( 'Container', 'kenta' ) )
					->setControls( $this->getContainerControls( 'single_post', [
						'layout' => 'narrow',
					] ) )
				,
				( new Section( 'kenta_post_sidebar_section' ) )
					->setLabel( __( 'Sidebar', 'kenta' ) )
					->enableSwitch( false )
					->setControls( [
						( new ImageRadio( 'kenta_post_sidebar_layout' ) )
							->setLabel( __( 'Sidebar Layout', 'kenta' ) )
							->setDefaultValue( 'right-sidebar' )
							->setChoices( [
								'left-sidebar'  => [
									'title' => __( 'Left Sidebar', 'kenta' ),
									'src'   => kenta_image_url( 'left-sidebar.png' ),
								],
								'right-sidebar' => [
									'title' => __( 'Right Sidebar', 'kenta' ),
									'src'   => kenta_image_url( 'right-sidebar.png' ),
								],
							] )
						,
					] )
				,

				( new Section( 'kenta_post_header' ) )
					->setLabel( __( 'Post Header', 'kenta' ) )
					->enableSwitch()
					->setControls( $this->getHeaderControls( 'post', [
						'selector'          => '.kenta-post-header.kenta-article-header',
						'selective-refresh' => [
							'.kenta-post-header.kenta-article-header',
							function () {
								kenta_show_article_header( 'kenta_single_post' );
							},
							[ 'container_inclusive' => true ]
						],
					] ) )
				,

				( new Section( 'kenta_post_featured_image' ) )
					->setLabel( __( 'Featured Image', 'kenta' ) )
					->enableSwitch()
					->setControls( $this->getFeaturedImageControls( 'post', [
						'selector'          => '.kenta_post_feature_image.article-featured-image',
						'selective-refresh' => [
							'.kenta_post_feature_image.article-featured-image',
							function () {
								kenta_show_article_feature_image( 'kenta_single_post', 'kenta_post' );
							},
							[ 'container_inclusive' => true ]
						]
					] ) )
				,

				( new Section( 'kenta_post_navigation' ) )
					->setLabel( __( 'Posts Navigation', 'kenta' ) )
					->enableSwitch()
					->setControls( $this->getNavigationControls( 'post' ) )
				,
			];
		}

		/**
		 * @return array
		 */
		protected function getNavigationControls( $type ) {
			return [
				( new ColorPicker( 'kenta_' . $type . '_navigation_text_color' ) )
					->setLabel( __( 'Text Color', 'kenta' ) )
					->asyncColors( '.kenta-post-navigation', [
						'initial' => '--kenta-navigation-initial-color',
						'hover'   => '--kenta-navigation-hover-color',
					] )
					->addColor( 'initial', __( 'Initial', 'kenta' ), 'var(--kenta-accent-color)' )
					->addColor( 'hover', __( 'Hover', 'kenta' ), 'var(--kenta-primary-color)' )
				,
				( new Separator() ),
				( new Icons( 'kenta_' . $type . '_navigation_prev_icon' ) )
					->setLabel( __( 'Prev Icon', 'kenta' ) )
					->selectiveRefresh( '.kenta-post-navigation', 'kenta_add_post_navigation', [
						'container_inclusive' => true,
					] )
					->setDefaultValue( [
						'value'   => 'fas fa-arrow-left-long',
						'library' => 'fa-solid',
					] )
				,
				( new Icons( 'kenta_' . $type . '_navigation_next_icon' ) )
					->setLabel( __( 'Prev Icon', 'kenta' ) )
					->setDefaultValue( [
						'value'   => 'fas fa-arrow-right-long',
						'library' => 'fa-solid',
					] )
				,
				( new Separator() ),
				( new Spacing( 'kenta_' . $type . '_navigation_padding' ) )
					->setLabel( __( 'Padding', 'kenta' ) )
					->asyncCss( '.kenta-post-navigation', AsyncCss::dimensions( 'padding' ) )
					->setDisabled( [ 'left', 'right' ] )
					->setSpacing( [
						'top'    => '24px',
						'bottom' => '24px',
						'linked' => true
					] )
				,
			];
		}
	}
}
