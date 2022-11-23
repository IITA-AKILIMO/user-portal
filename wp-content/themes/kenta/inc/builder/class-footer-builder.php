<?php
/**
 * Footer builder instance
 *
 * @package Kenta
 */

use LottaFramework\Customizer\Controls\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Kenta_Footer_Builder' ) ) {

	class Kenta_Footer_Builder {

		/**
		 * @var null
		 */
		protected static $_instance = null;

		/**
		 * @var Builder|null
		 */
		protected $_builder = null;

		/**
		 * Construct builder
		 */
		protected function __construct() {
			$this->_builder = ( new Builder( 'kenta_footer_builder' ) )
				->setLabel( __( 'Footer Elements', 'kenta' ) )
				->showLabel()
				->bindSelectiveRefresh( 'kenta-footer-selective-css' )
				->selectiveRefresh( '.kenta-footer-area', 'kenta_footer_render' )
				->setColumn( Kenta_Footer_Column::instance() );

			$this->_builder
				->addElement( new Kenta_Logo_Element( 'footer-logo', 'kenta_footer_el_logo', __( 'Logo', 'kenta' ) ) )
				->addElement( new Kenta_Copyright_Element( 'copyright', 'kenta_footer_el_copyright', __( 'Copyright', 'kenta' ) ) )
				->addElement( new Kenta_Menu_Element( 'footer-menu', 'kenta_footer_el_menu', __( 'Footer Menu', 'kenta' ), [
					'depth'                 => 1,
					'top-level-height'      => '36px',
					'top-level-height-unit' => 'px',
					'selective-refresh'     => 'kenta-footer-selective-css',
				] ) )
				// Widgets
				->addElement( new Kenta_Widgets_Element( 'widgets-1', 'kenta_footer_el_widgets_1', __( 'Widgets Area #1', 'kenta' ) ) )
				->addElement( new Kenta_Widgets_Element( 'widgets-2', 'kenta_footer_el_widgets_2', __( 'Widgets Area #2', 'kenta' ) ) )
				->addElement( new Kenta_Widgets_Element( 'widgets-3', 'kenta_footer_el_widgets_3', __( 'Widgets Area #3', 'kenta' ) ) )
				->addElement( new Kenta_Widgets_Element( 'widgets-4', 'kenta_footer_el_widgets_4', __( 'Widgets Area #4', 'kenta' ) ) )
				->addElement( new Kenta_Socials_Element( 'footer-socials', 'kenta_footer_el_socials', __( 'Socials', 'kenta' ) ) );

			$this->_builder
				->addRow(
					( new Kenta_Footer_Row( 'top', __( 'Top Row', 'kenta' ) ) )
						->setMaxColumns( 4 )
						->addColumn( [], [
							'width' => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ]
						] )
						->addColumn( [], [
							'width' => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ]
						] )
						->addColumn( [], [
							'width' => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ]
						] )
						->addColumn( [], [
							'width' => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ]
						] )
				)
				->addRow(
					( new Kenta_Footer_Row( 'middle', __( 'Middle Row', 'kenta' ) ) )
						->setMaxColumns( 4 )
						->addColumn( [ 'widgets-1' ], [
							'width'   => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ],
							'padding' => [ 'top' => '12px', 'right' => '12px', 'bottom' => '12px', 'left' => '12px' ]
						] )
						->addColumn( [ 'widgets-2' ], [
							'width'   => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ],
							'padding' => [ 'top' => '12px', 'right' => '12px', 'bottom' => '12px', 'left' => '12px' ]
						] )
						->addColumn( [ 'widgets-3' ], [
							'width'   => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ],
							'padding' => [ 'top' => '12px', 'right' => '12px', 'bottom' => '12px', 'left' => '12px' ]
						] )
						->addColumn( [ 'footer-logo' ], [
							'width'   => [ 'desktop' => '25%', 'tablet' => '50%', 'mobile' => '100%' ],
							'padding' => [ 'top' => '12px', 'right' => '12px', 'bottom' => '12px', 'left' => '12px' ]
						] )
				)
				->addRow(
					( new Kenta_Footer_Row( 'bottom', __( 'Bottom Row', 'kenta' ), [
						'border_top' => [
							1,
							'solid',
							'var(--kenta-base-300)'
						]
					] ) )
						->setMaxColumns( 4 )
						->addColumn( [ 'footer-menu' ], [
							'width'           => [ 'desktop' => '60%', 'tablet' => '100%', 'mobile' => '100%' ],
							'direction'       => 'row',
							'align-items'     => 'center',
							'justify-content' => [
								'desktop' => 'flex-start',
								'tablet'  => 'center',
								'mobile'  => 'center'
							],
						] )
						->addColumn( [ 'copyright' ], [
							'width'           => [ 'desktop' => '40%', 'tablet' => '100%', 'mobile' => '100%' ],
							'direction'       => 'row',
							'align-items'     => 'center',
							'justify-content' => [
								'desktop' => 'flex-end',
								'tablet'  => 'center',
								'mobile'  => 'center'
							],
						] )
				);

			do_action( 'kenta_footer_builder_initialized', $this->_builder );
		}

		/**
		 * Get footer builder
		 *
		 * @return Kenta_Footer_Builder|null
		 */
		public static function instance() {
			if ( self::$_instance === null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Magic static calls
		 *
		 * @param $method
		 * @param $args
		 *
		 * @return mixed
		 */
		public static function __callStatic( $method, $args ) {
			$builder = self::instance()->builder();

			if ( method_exists( $builder, $method ) ) {
				return $builder->$method( ...$args );
			}

			return null;
		}

		/**
		 * @return Builder|null
		 */
		public function builder() {
			return $this->_builder;
		}
	}
}
