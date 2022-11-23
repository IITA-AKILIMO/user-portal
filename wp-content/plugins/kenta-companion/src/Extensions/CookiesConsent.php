<?php

namespace KentaCompanion\Extensions;

use LottaFramework\Customizer\Controls\Background;
use LottaFramework\Customizer\Controls\BoxShadow;
use LottaFramework\Customizer\Controls\ColorPicker;
use LottaFramework\Customizer\Controls\Condition;
use LottaFramework\Customizer\Controls\Editor;
use LottaFramework\Customizer\Controls\Number;
use LottaFramework\Customizer\Controls\Section;
use LottaFramework\Customizer\Controls\Select;
use LottaFramework\Customizer\Controls\Separator;
use LottaFramework\Customizer\Controls\Slider;
use LottaFramework\Customizer\Controls\Tabs;
use LottaFramework\Customizer\Controls\Text;
use LottaFramework\Facades\AsyncCss;
use LottaFramework\Facades\Css;
use LottaFramework\Facades\CZ;
use LottaFramework\Utils;

/**
 * Class for cookie consent extension
 *
 * @package Kenta Companion
 */
class CookiesConsent {

	public function __construct() {
		// inject scroll top customize controls
		add_filter( 'kenta_global_section_controls', [ $this, 'injectControls' ] );
		// render hook
		add_filter( 'kenta_action_after', [ $this, 'render' ] );
		// add css
		add_filter( 'kenta_filter_dynamic_css', [ $this, 'css' ] );
	}

	public function injectControls( $controls ) {
		$rerender = [
			'.kenta-cookies-consent-container',
			[ $this, 'render' ],
			[ 'container_inclusive' => true ]
		];

		$controls[] = ( new Section( 'kenta_global_cookies_consent' ) )
			->setLabel( __( 'Cookies Consent', 'kenta-companion' ) )
			->enableSwitch()
			->setControls( [
				( new Tabs() )
					->setActiveTab( 'content' )
					->addTab( 'content', __( 'Content', 'kenta-companion' ), [
						( new Select( 'kenta_cookies_consent_style' ) )
							->setLabel( __( 'Consent Style' ) )
							->setDefaultValue( 'full-width' )
							->selectiveRefresh( ...$rerender )
							->setChoices( [
								'left-bottom'  => __( 'Left Bottom' ),
								'right-bottom' => __( 'Right Bottom' ),
								'full-width'   => __( 'Full Width' ),
							] )
						,
						( new Select( 'kenta_cookies_consent_period' ) )
							->setLabel( __( 'Cookie Period', 'kenta-companion' ) )
							->setDefaultValue( 'forever' )
							->setChoices( [
								'onehour'     => __( 'One hour', 'kenta-companion' ),
								'oneday'      => __( 'One day', 'kenta-companion' ),
								'oneweek'     => __( 'One week', 'kenta-companion' ),
								'onemonth'    => __( 'One month', 'kenta-companion' ),
								'threemonths' => __( 'Three months', 'kenta-companion' ),
								'sixmonths'   => __( 'Six months', 'kenta-companion' ),
								'oneyear'     => __( 'One year', 'kenta-companion' ),
								'forever'     => __( 'Forever', 'kenta-companion' )
							] )
						,
						( new Number( 'kenta_cookies_consent_zindex' ) )
							->setLabel( __( 'Z-Index', 'kenta-companion' ) )
							->asyncCss( '.kenta-cookies-consent-container', [ 'z-index' => 'value' ] )
							->setDescription( __( 'Please increase this value if cookies consent box are obscured by other content on the page.', 'kenta-companion' ) )
							->setMin( 0 )
							->setMax( 99999999 )
							->setDefaultUnit( false )
							->setDefaultValue( 99 )
						,
						( new Separator() ),
						( new Editor( 'kenta_cookies_consent_content' ) )
							->setLabel( __( 'Content', 'kenta-companion' ) )
							->asyncHtml( '.kenta-cookies-consent-text' )
							->setDefaultValue( __( 'We use cookies to improve your experience on our website', 'kenta-companion' ) )
						,
						( new Separator() ),
						( new Text( 'kenta_cookies_consent_accept_text' ) )
							->setLabel( __( 'Accept Button text', 'kenta-companion' ) )
							->asyncText( '.kenta-cookies-consent-buttons .accept-button' )
							->setDefaultValue( __( 'Accept', 'kenta-companion' ) )
						,
						( new Text( 'kenta_cookies_consent_decline_text' ) )
							->setLabel( __( 'Decline Button text', 'kenta-companion' ) )
							->asyncText( '.kenta-cookies-consent-buttons .decline-button' )
							->setDefaultValue( __( 'Decline', 'kenta-companion' ) )
						,
						( new Condition() )
							->setCondition( [ 'kenta_cookies_consent_style' => '!full-width' ] )
							->setControls( [
								( new Separator() ),
								( new Slider( 'kenta_cookies_consent_width' ) )
									->setLabel( __( 'Max Width', 'kenta-companion' ) )
									->asyncCss( '.kenta-cookies-consent', [ '--kenta-cookies-consent-width' => 'value' ] )
									->setMin( 100 )
									->setMax( 600 )
									->setDefaultUnit( 'px' )
									->setDefaultValue( '400px' )
								,
							] )
						,
					] )
					->addTab( 'style', __( 'Style', 'kenta-companion' ), [
						( new ColorPicker( 'kenta_cookies_consent_color' ) )
							->setLabel( __( 'Color', 'kenta-companion' ) )
							->asyncColors( ".kenta-cookies-consent", [
								'text'    => 'color',
								'initial' => '--kenta-link-initial-color',
								'hover'   => '--kenta-link-hover-color',
							] )
							->enableAlpha()
							->addColor( 'text', __( 'Text Initial', 'kenta-companion' ), 'var(--kenta-accent-active)' )
							->addColor( 'initial', __( 'Initial', 'kenta-companion' ), 'var(--kenta-primary-color)' )
							->addColor( 'hover', __( 'Hover', 'kenta-companion' ), 'var(--kenta-primary-active)' )
						,
						( new BoxShadow( 'kenta_cookies_consent_shadow' ) )
							->setLabel( __( 'Shadow', 'kenta-companion' ) )
							->asyncCss( '.kenta-cookies-consent', AsyncCss::shadow() )
							->setDefaultShadow(
								'rgba(44, 62, 80, 0.15)',
								'0px', '0px',
								'24px', '0px', true
							)
						,
						( new Background( 'kenta_cookies_consent_background' ) )
							->setLabel( __( 'Background', 'kenta-companion' ) )
							->asyncCss( '.kenta-cookies-consent', AsyncCss::background() )
							->setDefaultValue( [
								'type'  => 'color',
								'color' => 'var(--kenta-base-color)',
							] )
						,
						( new Separator() ),
						( new ColorPicker( 'kenta_cookies_consent_accept_colors' ) )
							->setLabel( __( 'Accept Button', 'kenta-companion' ) )
							->asyncColors( ".kenta-cookies-consent .accept-button", [
								'text-initial' => '--kenta-button-text-initial-color',
								'text-hover'   => '--kenta-button-text-hover-color',
								'bg-initial'   => '--kenta-button-initial-color',
								'bg-hover'     => '--kenta-button-hover-color',
							] )
							->addColor( 'text-initial', __( 'Text Initial', 'kenta-companion' ), 'var(--kenta-base-color)' )
							->addColor( 'text-hover', __( 'Text Hover', 'kenta-companion' ), 'var(--kenta-base-color)' )
							->addColor( 'bg-initial', __( 'Background Initial', 'kenta-companion' ), 'var(--kenta-primary-color)' )
							->addColor( 'bg-hover', __( 'Background Hover', 'kenta-companion' ), 'var(--kenta-accent-color)' )
						,
						( new ColorPicker( 'kenta_cookies_consent_decline_colors' ) )
							->setLabel( __( 'Decline Button', 'kenta-companion' ) )
							->asyncColors( ".kenta-cookies-consent .decline-button", [
								'text-initial' => '--kenta-button-text-initial-color',
								'text-hover'   => '--kenta-button-text-hover-color',
								'bg-initial'   => '--kenta-button-initial-color',
								'bg-hover'     => '--kenta-button-hover-color',
							] )
							->addColor( 'text-initial', __( 'Text Initial', 'kenta-companion' ), 'var(--kenta-accent-color)' )
							->addColor( 'text-hover', __( 'Text Hover', 'kenta-companion' ), 'var(--kenta-accent-color)' )
							->addColor( 'bg-initial', __( 'Background Initial', 'kenta-companion' ), 'var(--kenta-base-200)' )
							->addColor( 'bg-hover', __( 'Background Hover', 'kenta-companion' ), 'var(--kenta-base-300)' )
						,
					] )
			] );

		return $controls;
	}

	public function render() {
		if ( ! CZ::checked( 'kenta_global_cookies_consent' ) ) {
			return;
		}

		$attrs = [
			'class' => Utils::clsx( [
				'kenta-cookies-consent',
				CZ::get( 'kenta_cookies_consent_style' )
			] )
		];

		if ( is_customize_preview() ) {
			$attrs['data-shortcut']          = 'border';
			$attrs['data-shortcut-location'] = 'kenta_global:kenta_global_cookies_consent';
		}

		$period = CZ::get( 'kenta_cookies_consent_period' );

		?>
        <div class="kenta-cookies-consent-container" data-period="<?php echo esc_attr( $period ); ?>">
            <div class="kenta-cookies-consent-wrap">
                <div <?php Utils::print_attribute_string( $attrs ); ?>>
                    <div class="kenta-cookies-consent-text kenta-raw-html">
						<?php echo wp_kses_post( CZ::get( 'kenta_cookies_consent_content' ) ) ?>
                    </div>
                    <div class="kenta-cookies-consent-buttons">
                        <button type="button" class="kenta-button accept-button">
							<?php echo esc_html( CZ::get( 'kenta_cookies_consent_accept_text' ) ) ?>
                        </button>
                        <button type="button" class="kenta-button decline-button">
							<?php echo esc_html( CZ::get( 'kenta_cookies_consent_decline_text' ) ) ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	public function css( $css ) {
		if ( ! CZ::checked( 'kenta_global_cookies_consent' ) ) {
			return $css;
		}

		$css['.kenta-cookies-consent-container'] = [
			'z-index' => CZ::get( 'kenta_cookies_consent_zindex' )
		];

		$css['.kenta-cookies-consent'] = array_merge(
			Css::colors( CZ::get( 'kenta_cookies_consent_color' ), [
				'text'    => 'color',
				'initial' => '--kenta-link-initial-color',
				'hover'   => '--kenta-link-hover-color',
			] ),
			Css::background( CZ::get( 'kenta_cookies_consent_background' ) ),
			Css::shadow( CZ::get( 'kenta_cookies_consent_shadow' ) )
		);

		$css['.kenta-cookies-consent .accept-button'] = Css::colors( CZ::get( 'kenta_cookies_consent_accept_colors' ), [
			'text-initial' => '--kenta-button-text-initial-color',
			'text-hover'   => '--kenta-button-text-hover-color',
			'bg-initial'   => '--kenta-button-initial-color',
			'bg-hover'     => '--kenta-button-hover-color',
		] );

		$css['.kenta-cookies-consent .decline-button'] = Css::colors( CZ::get( 'kenta_cookies_consent_decline_colors' ), [
			'text-initial' => '--kenta-button-text-initial-color',
			'text-hover'   => '--kenta-button-text-hover-color',
			'bg-initial'   => '--kenta-button-initial-color',
			'bg-hover'     => '--kenta-button-hover-color',
		] );

		return $css;
	}
}