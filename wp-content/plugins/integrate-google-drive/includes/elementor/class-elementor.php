<?php

namespace IGD\elementor;

defined( 'ABSPATH' ) || exit;
use  IGD\Enqueue ;
class Elementor
{
    /**
     * @var null
     */
    protected static  $instance = null ;
    public function __construct()
    {
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_categories' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'frontend_scripts' ] );
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'editor_scripts' ] );
        add_filter( 'elementor/editor/localize_settings', [ $this, 'promote_pro_elements' ] );
    }
    
    public function promote_pro_elements( $config )
    {
        $promotion_widgets = [];
        if ( isset( $config['promotionWidgets'] ) ) {
            $promotion_widgets = $config['promotionWidgets'];
        }
        $combine_array = array_merge( $promotion_widgets, [
            [
            'name'       => 'igd_browser',
            'title'      => __( 'File Browser', 'integrate-google-drive' ),
            'icon'       => 'igd-browser',
            'categories' => '["integrate_google_drive"]',
        ],
            [
            'name'       => 'igd_uploader',
            'title'      => __( 'File Uploader', 'integrate-google-drive' ),
            'icon'       => 'igd-uploader',
            'categories' => '["integrate_google_drive"]',
        ],
            [
            'name'       => 'igd_media',
            'title'      => __( 'Media Player', 'integrate-google-drive' ),
            'icon'       => 'igd-media',
            'categories' => '["integrate_google_drive"]',
        ],
            [
            'name'       => 'igd_search',
            'title'      => __( 'Search Box', 'integrate-google-drive' ),
            'icon'       => 'igd-search',
            'categories' => '["integrate_google_drive"]',
        ],
            [
            'name'       => 'igd_slider',
            'title'      => __( 'Slider Carousel', 'integrate-google-drive' ),
            'icon'       => 'igd-slider',
            'categories' => '["integrate_google_drive"]',
        ]
        ] );
        $config['promotionWidgets'] = $combine_array;
        return $config;
    }
    
    public function editor_scripts()
    {
        wp_enqueue_style(
            'igd-elementor-editor',
            IGD_ASSETS . '/css/elementor-editor.css',
            [],
            IGD_VERSION
        );
        wp_style_add_data( 'igd-elementor-editor', 'rtl', 'replace' );
    }
    
    public function frontend_scripts()
    {
        if ( isset( $_GET['elementor-preview'] ) ) {
            Enqueue::instance()->admin_scripts( '', false );
        }
        Enqueue::instance()->frontend_scripts();
        wp_enqueue_script(
            'igd-elementor',
            IGD_ASSETS . '/js/elementor.js',
            [ 'jquery' ],
            IGD_VERSION,
            true
        );
    }
    
    public function register_widgets( $widgets_manager )
    {
        include_once IGD_INCLUDES . '/elementor/class-elementor-gallery-widget.php';
        include_once IGD_INCLUDES . '/elementor/class-elementor-embed-widget.php';
        include_once IGD_INCLUDES . '/elementor/class-elementor-download-widget.php';
        include_once IGD_INCLUDES . '/elementor/class-elementor-view-widget.php';
        include_once IGD_INCLUDES . '/elementor/class-elementor-shortcodes-widget.php';
        
        if ( method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Gallery_Widget() );
            $widgets_manager->register( new Embed_Widget() );
            $widgets_manager->register( new Download_Widget() );
            $widgets_manager->register( new View_Widget() );
            $widgets_manager->register( new Shortcodes_Widget() );
        } else {
            $widgets_manager->register_widget_type( new Gallery_Widget() );
            $widgets_manager->register_widget_type( new Embed_Widget() );
            $widgets_manager->register_widget_type( new Download_Widget() );
            $widgets_manager->register_widget_type( new View_Widget() );
            $widgets_manager->register_widget_type( new Shortcodes_Widget() );
        }
    
    }
    
    public function add_categories( $elements_manager )
    {
        $elements_manager->add_category( 'integrate_google_drive', [
            'title' => __( 'Integrate Google Drive', 'integrate-google-drive' ),
            'icon'  => 'fa fa-plug',
        ] );
    }
    
    /**
     * @return Elementor|null
     */
    public static function instance()
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
Elementor::instance();