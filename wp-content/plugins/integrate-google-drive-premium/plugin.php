<?php

/**
 * Plugin Name: Integrate Google Drive (PRO)
 * Plugin URI:  https://softlabbd.com/integrate-google-drive
 * Description: Complete Google Drive solution for WordPress to integrate, browse, embed, display, share, play and download the documents and media files directly from your Google Drive into your WordPress website.
 * Version:     1.1.93
 * Update URI: https://api.freemius.com
 * Author:      SoftLab
 * Author URI:  https://softlabbd.com/
 * Text Domain: integrate-google-drive
 * Domain Path: /languages/
 */
// don't call the file directly
if ( !defined( 'ABSPATH' ) ) {
    wp_die( __( 'You can\'t access this page', 'integrate-google-drive' ) );
}

if ( function_exists( 'igd_fs' ) ) {
    igd_fs()->set_basename( true, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    
    if ( !function_exists( 'igd_fs' ) ) {
        // Create a helper function for easy SDK access.
        function igd_fs()
        {
            global  $igd_fs ;
            
            if ( !isset( $igd_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $igd_fs = fs_dynamic_init( array(
                    'id'             => '9618',
                    'slug'           => 'integrate-google-drive',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_eb27e7eaa4f2692b385aec28288f2',
                    'is_premium'     => true,
                    'premium_suffix' => '(PRO)',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 3,
                    'is_require_payment' => true,
                ),
                    'menu'           => array(
                    'slug'       => 'integrate-google-drive',
                    'first-path' => 'admin.php?page=integrate-google-drive-getting-started',
                    'support'    => false,
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $igd_fs;
        }
        
        // Init Freemius.
        igd_fs();
        // Signal that SDK was initiated.
        do_action( 'igd_fs_loaded' );
    }
    
    /** define constants */
    define( 'IGD_VERSION', '1.1.93' );
    define( 'IGD_FILE', __FILE__ );
    define( 'IGD_PATH', dirname( IGD_FILE ) );
    define( 'IGD_INCLUDES', IGD_PATH . '/includes' );
    define( 'IGD_URL', plugins_url( '', IGD_FILE ) );
    define( 'IGD_ASSETS', IGD_URL . '/assets' );
    define( 'IGD_CACHE_DIR', WP_CONTENT_DIR . '/integrate-google-drive-cache' );
    define( 'IGD_CACHE_URL', content_url() . '/integrate-google-drive-cache' );
    //check min-php version
    
    if ( version_compare( PHP_VERSION, '7.0', '<=' ) ) {
        deactivate_plugins( plugin_basename( IGD_FILE ) );
        $notice = sprintf( 'Unsupported PHP version. %1$s requires WordPress version %2$s or greater. Please update your PHP to the latest version.', '<strong>Google Drive to WordPress</strong>', '<strong>5.6.0</strong>' );
        wp_die( $notice );
    }
    
    // check min-wp version
    
    if ( !version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ) {
        $notice = sprintf( 'Unsupported WordPress version. %1$s requires WordPress version %2$s or greater. Please update your WordPress to the latest version.', '<strong>Google Drive to WordPress</strong>', '<strong>5.0</strong>' );
        wp_die( $notice );
    }
    
    //Include the base plugin file.
    include_once IGD_INCLUDES . '/base.php';
}
