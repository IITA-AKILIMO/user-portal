<?php

/**
 * Fired during plugin activation
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package Automatic_YouTube_Gallery
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AYG_Activator class.
 *
 * @since 1.0.0
 */
class AYG_Activator {

	/**
	 * Called when the plugin is activated.
	 *
	 * @since 1.0.0
	 */
	public static function activate() {
		// Insert the plugin settings and default values for the first time
		$defaults = ayg_get_default_settings();

		foreach ( $defaults as $option_name => $values ) {
			if ( false == get_option( $option_name ) ) {	
        		add_option( $option_name, $values );						
    		}
		}
		
		// Create a custom database table "{$wpdb->prefix}ayg_videos" 
		ayg_db_create_videos_table();

		// Insert the plugin version
		add_option( 'ayg_version', AYG_VERSION );
	}

}