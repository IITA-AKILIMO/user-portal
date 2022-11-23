<?php
/**
 * Socials element
 *
 * @package Kenta
 */

use LottaFramework\Customizer\Controls\CallToAction;
use LottaFramework\Customizer\Controls\ColorPicker;
use LottaFramework\Customizer\Controls\Condition;
use LottaFramework\Customizer\Controls\Placeholder;
use LottaFramework\Customizer\Controls\Radio;
use LottaFramework\Customizer\Controls\Separator;
use LottaFramework\Customizer\Controls\Slider;
use LottaFramework\Customizer\Controls\Tabs;
use LottaFramework\Customizer\Controls\Toggle;
use LottaFramework\Customizer\GenericBuilder\Element;
use LottaFramework\Facades\Css;
use LottaFramework\Facades\CZ;
use LottaFramework\Icons\IconsManager;
use LottaFramework\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Kenta_Socials_Element' ) ) {


	class Kenta_Socials_Element extends Element {

		/**
		 * @param string $id
		 *
		 * @return string
		 */
		protected function getSocialControlId( $id ) {
			return $this->getSlug( $id );
		}

		public function getControls() {
			return $this->getSocialControls( wp_parse_args( $this->defaults, [
				'render-callback'   => $this->selectiveRefresh(),
				'icons-color-type'  => 'official',
				'icons-box-spacing' => [
					'top'    => '0px',
					'bottom' => '0px',
					'left'   => '0px',
					'right'  => '0px',
					'linked' => true,
				],
			] ) );
		}

		/**
		 * @return array
		 */
		public function getSocialControls( $defaults = [] ) {
			$defaults = wp_parse_args( $defaults, [
				'render-callback'      => [],
				'new-tab'              => 'yes',
				'no-follow'            => 'yes',
				'icon-size'            => '16px',
				'icon-spacing'         => '16px',
				'icons-color-type'     => 'custom',
				'icons-shape'          => 'none',
				'icons-fill-type'      => 'solid',
				'icons-color-initial'  => 'var(--kenta-accent-color)',
				'icons-color-hover'    => 'var(--kenta-primary-color)',
				'icons-bg-initial'     => 'var(--kenta-base-200)',
				'icons-bg-hover'       => 'var(--kenta-primary-color)',
				'icons-border-initial' => 'var(--kenta-base-200)',
				'icons-border-hover'   => 'var(--kenta-primary-color)',
				'icons-box-spacing'    => [
					'top'    => '0px',
					'right'  => '0px',
					'bottom' => '0px',
					'left'   => '0px',
					'linked' => true,
				],
			] );

			return [
				( new Tabs() )
					->setActiveTab( 'content' )
					->addTab( 'content', __( 'Content', 'kenta' ), $this->getSocialContentControls( $defaults ) )
					->addTab( 'style', __( 'Style', 'kenta' ), $this->getSocialStyleControls( $defaults ) )
			];
		}

		/**
		 * @param array $defaults
		 *
		 * @return array
		 */
		protected function getSocialContentControls( $defaults = [] ) {

			$render_callback = $defaults['render-callback'];

			$controls = [
				( new CallToAction() )
					->setLabel( __( 'Edit Social Network Accounts', 'kenta' ) )
					->displayAsButton()
					->expandCustomize( 'kenta_global:kenta_global_socials' )
				,
				( new Separator() ),
				( new Toggle( $this->getSocialControlId( 'open_new_tab' ) ) )
					->setLabel( __( 'Open In New Tab', 'kenta' ) )
					->selectiveRefresh( ...$render_callback )
					->setDefaultValue( $defaults['new-tab'] )
				,
				( new Toggle( $this->getSocialControlId( 'no_follow' ) ) )
					->setLabel( __( 'No Follow', 'kenta' ) )
					->selectiveRefresh( ...$render_callback )
					->setDefaultValue( $defaults['no-follow'] )
				,
				( new Separator() ),
				( new Slider( $this->getSocialControlId( 'icons_size' ) ) )
					->setLabel( __( 'Icons Size', 'kenta' ) )
					->enableResponsive()
					->asyncCss( ".$this->slug", [ '--kenta-social-icons-size' => 'value' ] )
					->setMin( 5 )
					->setMax( 50 )
					->setDefaultUnit( 'px' )
					->setDefaultValue( $defaults['icon-size'] )
				,
				( new Slider( $this->getSocialControlId( 'icons_spacing' ) ) )
					->setLabel( __( 'Icons Spacing', 'kenta' ) )
					->enableResponsive()
					->asyncCss( ".$this->slug", [ '--kenta-social-icons-spacing' => 'value' ] )
					->setMin( 0 )
					->setMax( 100 )
					->setDefaultUnit( 'px' )
					->setDefaultValue( $defaults['icon-spacing'] )
				,
				( new Separator() ),
				( new Radio( $this->getSocialControlId( 'icons_color_type' ) ) )
					->setLabel( __( 'Icons Color', 'kenta' ) )
					->buttonsGroupView()
					->selectiveRefresh( ...$render_callback )
					->setDefaultValue( $defaults['icons-color-type'] )
					->setChoices( [
						'custom'   => __( 'Custom', 'kenta' ),
						'official' => __( 'Official', 'kenta' ),
					] )
				,
			];

			return apply_filters( 'kenta_socials_element_content_controls', $controls, $this->getSocialControlId( '' ), $defaults );
		}

		/**
		 * @param array $defaults
		 *
		 * @return array
		 */
		protected function getSocialStyleControls( $defaults = [] ) {
			$controls = [
				( new Condition() )
					->setCondition( [ $this->getSocialControlId( 'icons_color_type' ) => 'custom' ] )
					->setControls( [
						( new ColorPicker( $this->getSocialControlId( 'icons_color' ) ) )
							->setLabel( __( 'Icons Color', 'kenta' ) )
							->addColor( 'initial', __( 'Initial', 'kenta' ), $defaults['icons-color-initial'] )
							->addColor( 'hover', __( 'Hover', 'kenta' ), $defaults['icons-color-hover'] )
							->asyncColors( ".$this->slug", [
								'initial' => '--kenta-social-icon-initial-color',
								'hover'   => '--kenta-social-icon-hover-color',
							] )
						,
						( new Separator() ),
					] )
				,
			];

			return apply_filters( 'kenta_socials_element_style_controls', $controls, $this->getSocialControlId( '' ), $defaults );
		}

		/**
		 * {@inheritDoc}
		 */
		public function enqueue_frontend_scripts() {
			// Add button dynamic css
			add_filter( 'kenta_filter_dynamic_css', function ( $css ) {
				$css[".$this->slug"] = array_merge(
					[
						'--kenta-social-icons-size'    => CZ::get( $this->getSlug( 'icons_size' ) ),
						'--kenta-social-icons-spacing' => CZ::get( $this->getSlug( 'icons_spacing' ) )
					],
					Css::dimensions( CZ::get( $this->getSlug( 'padding' ) ), 'padding' ),
					Css::colors( CZ::get( $this->getSlug( 'icons_color' ) ), [
						'initial' => '--kenta-social-icon-initial-color',
						'hover'   => '--kenta-social-icon-hover-color',
					] ),
					Css::colors( CZ::get( $this->getSlug( 'icons_bg_color' ) ), [
						'initial' => '--kenta-social-bg-initial-color',
						'hover'   => '--kenta-social-bg-hover-color',
					] ),
					Css::colors( CZ::get( $this->getSlug( 'icons_border_color' ) ), [
						'initial' => '--kenta-social-border-initial-color',
						'hover'   => '--kenta-social-border-hover-color',
					] )
				);

				return $css;
			} );
		}

		/**
		 * {@inheritDoc}
		 */
		public function render( $attrs = [] ) {
			$color = CZ::get( $this->getSlug( 'icons_color_type' ) );
			$shape = CZ::get( $this->getSlug( 'icons_shape' ) );
			$fill  = CZ::get( $this->getSlug( 'shape_fill_type' ) );

			$attrs['class'] = Utils::clsx( [
				$this->slug
			], $attrs['class'] ?? [] );

			foreach ( $attrs as $attr => $value ) {
				$this->add_render_attribute( 'socials', $attr, $value );
			}

			$this->add_render_attribute( 'social-link', 'class', 'kenta-social-link' );

			if ( CZ::checked( $this->getSlug( 'open_new_tab' ) ) ) {
				$this->add_render_attribute( 'social-link', 'target', '_blank' );
			}

			if ( CZ::checked( $this->getSlug( 'no_follow' ) ) ) {
				$this->add_render_attribute( 'social-link', 'rel', 'nofollow' );
			}

			$socials = CZ::repeater( 'kenta_social_networks' );

			?>
            <div <?php $this->print_attribute_string( 'socials' ); ?>>
                <div class="<?php Utils::the_clsx( [
					'kenta-socials',
					'kenta-socials-' . $color,
					'kenta-socials-' . $shape,
					'kenta-socials-' . $fill => $shape !== 'none',
				] ); ?>">
					<?php foreach ( $socials as $social ) { ?>
                        <a <?php $this->print_attribute_string( 'social-link' ); ?>
                                style="--kenta-official-color: <?php echo esc_attr( $social['color']['official'] ?? 'var(--kenta-primary-color)' ) ?>;"
                                href="<?php echo esc_url( $social['url'] ) ?>">
					<span class="kenta-social-icon">
                        <?php IconsManager::print( $social['icon'] ); ?>
                    </span>
                        </a>
					<?php } ?>
                </div>
            </div>
			<?php
		}
	}
}
