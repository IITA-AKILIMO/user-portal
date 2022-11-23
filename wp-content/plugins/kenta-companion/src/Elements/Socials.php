<?php

namespace KentaCompanion\Elements;

use  LottaFramework\Customizer\Controls\CallToAction ;
use  LottaFramework\Customizer\Controls\ColorPicker ;
use  LottaFramework\Customizer\Controls\Condition ;
use  LottaFramework\Customizer\Controls\Placeholder ;
use  LottaFramework\Customizer\Controls\Radio ;
use  LottaFramework\Customizer\Controls\Separator ;
use  LottaFramework\Customizer\Controls\Slider ;
use  LottaFramework\Customizer\Controls\Spacing ;
use  LottaFramework\Customizer\Controls\Tabs ;
use  LottaFramework\Customizer\Controls\Toggle ;
use  LottaFramework\Customizer\GenericBuilder\Element ;
use  LottaFramework\Facades\Css ;
use  LottaFramework\Facades\CZ ;
use  LottaFramework\Icons\IconsManager ;
use  LottaFramework\Utils ;
class Socials extends Element
{
    /**
     * @param string $id
     *
     * @return string
     */
    protected function getSocialControlId( $id )
    {
        return $this->getSlug( $id );
    }
    
    public function getControls()
    {
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
    public function getSocialControls( $defaults = array() )
    {
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
        return [ ( new Tabs() )->setActiveTab( 'content' )->addTab( 'content', __( 'Content', 'kenta-companion' ), $this->getSocialContentControls( $defaults ) )->addTab( 'style', __( 'Style', 'kenta-companion' ), $this->getSocialStyleControls( $defaults ) ) ];
    }
    
    /**
     * @param array $defaults
     *
     * @return array
     */
    protected function getSocialContentControls( $defaults = array() )
    {
        $render_callback = $defaults['render-callback'];
        $controls = [
            ( new CallToAction() )->setLabel( __( 'Edit Social Network Accounts', 'kenta-companion' ) )->displayAsButton()->expandCustomize( 'kenta_global:kenta_global_socials' ),
            new Separator(),
            ( new Toggle( $this->getSocialControlId( 'open_new_tab' ) ) )->setLabel( __( 'Open In New Tab', 'kenta-companion' ) )->selectiveRefresh( ...$render_callback )->setDefaultValue( $defaults['new-tab'] ),
            ( new Toggle( $this->getSocialControlId( 'no_follow' ) ) )->setLabel( __( 'No Follow', 'kenta-companion' ) )->selectiveRefresh( ...$render_callback )->setDefaultValue( $defaults['no-follow'] ),
            new Separator(),
            ( new Slider( $this->getSocialControlId( 'icons_size' ) ) )->setLabel( __( 'Icons Size', 'kenta-companion' ) )->enableResponsive()->asyncCss( ".{$this->slug}", [
            '--kenta-social-icons-size' => 'value',
        ] )->setMin( 5 )->setMax( 50 )->setDefaultUnit( 'px' )->setDefaultValue( $defaults['icon-size'] ),
            ( new Slider( $this->getSocialControlId( 'icons_spacing' ) ) )->setLabel( __( 'Icons Spacing', 'kenta-companion' ) )->enableResponsive()->asyncCss( ".{$this->slug}", [
            '--kenta-social-icons-spacing' => 'value',
        ] )->setMin( 0 )->setMax( 100 )->setDefaultUnit( 'px' )->setDefaultValue( $defaults['icon-spacing'] ),
            new Separator(),
            ( new Radio( $this->getSocialControlId( 'icons_color_type' ) ) )->setLabel( __( 'Icons Color', 'kenta-companion' ) )->buttonsGroupView()->selectiveRefresh( ...$render_callback )->setDefaultValue( $defaults['icons-color-type'] )->setChoices( [
            'custom'   => __( 'Custom', 'kenta-companion' ),
            'official' => __( 'Official', 'kenta-companion' ),
        ] )
        ];
        $controls = array_merge( $controls, [ ( new Placeholder( $this->getSocialControlId( 'icons_shape' ) ) )->setDefaultValue( $defaults['icons-shape'] ), ( new Placeholder( $this->getSocialControlId( 'shape_fill_type' ) ) )->setDefaultValue( $defaults['icons-fill-type'] ), kenta_upsell_info_control( __( 'More social icon options in our %sPro Version%s', 'kenta-companion' ) ) ] );
        return $controls;
    }
    
    /**
     * @param array $defaults
     *
     * @return array
     */
    protected function getSocialStyleControls( $defaults = array() )
    {
        $controls = [ ( new Condition() )->setCondition( [
            $this->getSocialControlId( 'icons_color_type' ) => 'custom',
        ] )->setControls( [ ( new ColorPicker( $this->getSocialControlId( 'icons_color' ) ) )->setLabel( __( 'Icons Color', 'kenta-companion' ) )->addColor( 'initial', __( 'Initial', 'kenta-companion' ), $defaults['icons-color-initial'] )->addColor( 'hover', __( 'Hover', 'kenta-companion' ), $defaults['icons-color-hover'] )->asyncColors( ".{$this->slug}", [
            'initial' => '--kenta-social-icon-initial-color',
            'hover'   => '--kenta-social-icon-hover-color',
        ] ), new Separator() ] ) ];
        $controls = array_merge( $controls, [
            ( new Placeholder( $this->getSocialControlId( 'icons_bg_color' ) ) )->addColor( 'initial', $defaults['icons-bg-initial'] )->addColor( 'hover', $defaults['icons-bg-hover'] ),
            ( new Placeholder( $this->getSocialControlId( 'icons_border_color' ) ) )->addColor( 'initial', $defaults['icons-border-initial'] )->addColor( 'hover', $defaults['icons-border-hover'] ),
            ( new Placeholder( $this->getSocialControlId( 'padding' ) ) )->setDefaultValue( $defaults['icons-box-spacing'] ),
            kenta_upsell_info_control( __( 'Fully customize your social icons in our %sPro Version%s', 'kenta-companion' ) )
        ] );
        return $controls;
    }
    
    /**
     * {@inheritDoc}
     */
    public function enqueue_frontend_scripts()
    {
        // Add button dynamic css
        add_filter( 'kenta_filter_dynamic_css', function ( $css ) {
            $css[".{$this->slug}"] = array_merge(
                [
                '--kenta-social-icons-size'    => CZ::get( $this->getSlug( 'icons_size' ) ),
                '--kenta-social-icons-spacing' => CZ::get( $this->getSlug( 'icons_spacing' ) ),
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
    public function render( $attrs = array() )
    {
        $color = CZ::get( $this->getSlug( 'icons_color_type' ) );
        $shape = CZ::get( $this->getSlug( 'icons_shape' ) );
        $fill = CZ::get( $this->getSlug( 'shape_fill_type' ) );
        $attrs['class'] = Utils::clsx( [ $this->slug ], $attrs['class'] ?? [] );
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
        <div <?php 
        $this->print_attribute_string( 'socials' );
        ?>>
            <div class="<?php 
        Utils::the_clsx( [
            'kenta-socials',
            'kenta-socials-' . $color,
            'kenta-socials-' . $shape,
            'kenta-socials-' . $fill => $shape !== 'none'
        ] );
        ?>">
				<?php 
        foreach ( $socials as $social ) {
            ?>
                    <a <?php 
            $this->print_attribute_string( 'social-link' );
            ?>
                            style="--kenta-official-color: <?php 
            echo  esc_attr( $social['color']['official'] ?? 'var(--kenta-primary-color)' ) ;
            ?>;"
                            href="<?php 
            echo  esc_url( $social['url'] ) ;
            ?>">
					<span class="kenta-social-icon">
                        <?php 
            IconsManager::print( $social['icon'] );
            ?>
                    </span>
                    </a>
				<?php 
        }
        ?>
            </div>
        </div>
		<?php 
    }

}