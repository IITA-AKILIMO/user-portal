<?php
/**
 * Articles customizer section
 *
 * @package Kenta
 */

use LottaFramework\Customizer\Controls\ImageRadio;
use LottaFramework\Customizer\Controls\Section;
use LottaFramework\Customizer\Section as CustomizerSection;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Kenta_Pages_Section' ) ) {

	class Kenta_Pages_Section extends CustomizerSection {

		use Kenta_Article_Controls;

		/**
		 * {@inheritDoc}
		 */
		public function getControls() {
			return [
				( new Section( 'kenta_pages_container' ) )
					->setLabel( __( 'Container', 'kenta' ) )
					->setControls( $this->getContainerControls( 'pages' ) )
				,
				( new Section( 'kenta_page_sidebar_section' ) )
					->setLabel( __( 'Sidebar', 'kenta' ) )
					->enableSwitch( false )
					->setControls( [
						( new ImageRadio( 'kenta_page_sidebar_layout' ) )
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

				( new Section( 'kenta_page_header' ) )
					->setLabel( __( 'Page Header', 'kenta' ) )
					->enableSwitch()
					->setControls( $this->getHeaderControls( 'page', [
						'selector'          => '.kenta-page-header.kenta-article-header',
						'selective-refresh' => [
							'.kenta-page-header.kenta-article-header',
							function () {
								kenta_show_article_header( 'kenta_pages' );
							},
							[ 'container_inclusive' => true ]
						],
						'elements'          => [
							[ 'id' => 'title', 'visible' => true ],
						],
						'metas'             => [
							'elements' => [
								[ 'id' => 'published', 'visible' => true ]
							],
						],
					] ) )
				,

				( new Section( 'kenta_page_featured_image' ) )
					->setLabel( __( 'Featured Image', 'kenta' ) )
					->enableSwitch()
					->setControls( $this->getFeaturedImageControls( 'page', [
						'selector'          => '.kenta_page_feature_image.article-featured-image',
						'selective-refresh' => [
							'.kenta_page_feature_image.article-featured-image',
							function () {
								kenta_show_article_feature_image( 'kenta_pages', 'kenta_page' );
							},
							[ 'container_inclusive' => true ]
						]
					] ) )
				,
			];
		}
	}

}
