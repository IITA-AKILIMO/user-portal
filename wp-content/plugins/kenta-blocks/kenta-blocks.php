<?php

/*
 * Plugin Name: Kenta Blocks
 * Plugin URI: https://kentatheme.com/blocks/
 * Description: The Swiss Army knife of Gutenberg page builders. Use Section / Column blocks to create any site layout. We also have unlimited colors, backgrounds, typography and more. All blocks are responsive. Always display perfectly and fully customize, whether desktop or mobile.
 * Author: WP Moose
 * Version: 1.2.2
 * Requires at least: 5.6
 * Requires PHP: 7.2
 * License: GPLv3
 * Author URI: https://www.wpmoose.com
 * Text Domain: kenta-blocks
 *
 */
// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'kb_fs' ) ) {
    kb_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'kb_fs' ) ) {
        // Create a helper function for easy SDK access.
        function kb_fs()
        {
            global  $kb_fs ;
            
            if ( !isset( $kb_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $kb_fs = fs_dynamic_init( array(
                    'id'             => '10934',
                    'slug'           => 'kenta-blocks',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_79663eeb2916a8f1f4e96f8fdb41f',
                    'is_premium'     => false,
                    'premium_suffix' => 'Premium',
                    'anonymous_mode' => true,
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                    'slug'    => 'kenta-blocks',
                    'pricing' => false,
                    'contact' => true,
                    'support' => true,
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $kb_fs;
        }
        
        // Init Freemius.
        kb_fs();
        // Signal that SDK was initiated.
        do_action( 'kb_fs_loaded' );
    }
    
    /**
     * Defining plugin constants.
     *
     * @since 0.0.1
     */
    define( 'KENTA_BLOCKS_VERSION', '1.2.2' );
    define( 'KENTA_BLOCKS_PLUGIN_FILE', __FILE__ );
    define( 'KENTA_BLOCKS_PLUGIN_PATH', trailingslashit( plugin_dir_path( KENTA_BLOCKS_PLUGIN_FILE ) ) );
    define( 'KENTA_BLOCKS_PLUGIN_URL', trailingslashit( plugins_url( '/', KENTA_BLOCKS_PLUGIN_FILE ) ) );
    /**
     * Library constants
     *
     * @since 1.1.0
     */
    if ( !defined( 'KENTA_BLOCKS_LIBRARY_API' ) ) {
        define( 'KENTA_BLOCKS_LIBRARY_API', 'https://kentatheme.com/index.php?rest_route=/kenta-library/v1' );
    }
    if ( !defined( 'KENTA_BLOCKS_LIBRARY_API_CACHE_SECONDS' ) ) {
        define( 'KENTA_BLOCKS_LIBRARY_API_CACHE_SECONDS', DAY_IN_SECONDS );
    }
    /**
     * Including composer autoloader globally.
     *
     * @since 1.0.0
     */
    require_once KENTA_BLOCKS_PLUGIN_PATH . 'vendor/autoload.php';
    /**
     * Run plugin after all others plugins
     *
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', function () {
        \KentaBlocks\Bootstrap::instance();
    } );
    /**
     * Regenerate all assets files when plugin activation
     *
     * @since 1.2.1
     */
    register_activation_hook( __FILE__, 'kenta_blocks_regenerate_assets' );
}
