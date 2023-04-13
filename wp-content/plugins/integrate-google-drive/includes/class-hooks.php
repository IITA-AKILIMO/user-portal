<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;
class Hooks
{
    /**
     * @var null
     */
    protected static  $instance = null ;
    public function __construct()
    {
        //Handle uninstall
        igd_fs()->add_action( 'after_uninstall', [ $this, 'uninstall' ] );
        $settings = get_option( 'igd_settings' );
        
        if ( !empty($settings['ownApp']) && !empty($settings['clientID']) && !empty($settings['clientSecret']) ) {
            add_filter( 'igd/client_id', function () use( $settings ) {
                return $settings['clientID'];
            } );
            add_filter( 'igd/client_secret', function () use( $settings ) {
                return $settings['clientSecret'];
            } );
            add_filter( 'igd/redirect_uri', function () {
                return admin_url( '?action=integrate-google-drive-authorization' );
            } );
        }
        
        add_action( 'template_redirect', [ $this, 'direct_content' ] );
    }
    
    public function create_user_folder( $user_id )
    {
        Private_Folders::instance()->create_user_folder( $user_id );
    }
    
    public function delete_user_folder( $user_id )
    {
        Private_Folders::instance()->delete_user_folder( $user_id );
    }
    
    public function direct_content()
    {
        
        if ( !empty($_GET['direct_file']) ) {
            $file = $_GET['direct_file'];
            $file = json_decode( base64_decode( $file ), true );
            if ( empty($file['permissions']) ) {
                $file['permissions'] = [];
            }
            $is_dir = igd_is_dir( $file['type'] );
            add_filter( 'show_admin_bar', '__return_false' );
            // Remove all WordPress actions
            remove_all_actions( 'wp_head' );
            remove_all_actions( 'wp_print_styles' );
            remove_all_actions( 'wp_print_head_scripts' );
            remove_all_actions( 'wp_footer' );
            // Handle `wp_head`
            add_action( 'wp_head', 'wp_enqueue_scripts', 1 );
            add_action( 'wp_head', 'wp_print_styles', 8 );
            add_action( 'wp_head', 'wp_print_head_scripts', 9 );
            add_action( 'wp_head', 'wp_site_icon' );
            // Handle `wp_footer`
            add_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
            // Handle `wp_enqueue_scripts`
            remove_all_actions( 'wp_enqueue_scripts' );
            // Also remove all scripts hooked into after_wp_tiny_mce.
            remove_all_actions( 'after_wp_tiny_mce' );
            if ( $is_dir ) {
                Enqueue::instance()->frontend_scripts();
            }
            $type = ( $is_dir ? 'browser' : 'embed' );
            ?>

            <!doctype html>
            <html lang="<?php 
            language_attributes();
            ?>">
            <head>
                <meta charset="<?php 
            bloginfo( 'charset' );
            ?>">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title><?php 
            echo  $file['name'] ;
            ?></title>

				<?php 
            do_action( 'wp_head' );
            ?>

				<?php 
            if ( 'embed' == $type ) {
                ?>
                    <style>
                        html, body {
                            margin: 0;
                            padding: 0;
                            width: 100%;
                            height: 100%;
                        }

                        #igd-direct-content {
                            width: 100%;
                            height: 100vh;
                            overflow: hidden;
                            position: relative;
                        }

                        #igd-direct-content:after {
                            content: '';
                            width: 60px;
                            height: 55px;
                            position: absolute;
                            opacity: 1;
                            right: 12px;
                            top: 0;
                            z-index: 10000000;
                            background-color: #d1d1d1;
                            cursor: default !important;
                        }

                        #igd-direct-content .igd-embed {
                            width: 100%;
                            height: 100%;
                            border: none;
                        }
                    </style>
				<?php 
            }
            ?>

            </head>
            <body>

            <div id="igd-direct-content">
				<?php 
            $data = [
                'folders'            => [ $file ],
                'type'               => $type,
                'allowPreviewPopout' => false,
            ];
            echo  Shortcode::instance()->render_shortcode( [], $data ) ;
            ?>
            </div>

			<?php 
            do_action( 'wp_footer' );
            ?>

            </body>
            </html>

			<?php 
            exit;
        }
    
    }
    
    public function uninstall()
    {
        //Remove cron
        $timestamp = wp_next_scheduled( 'igd_sync_interval' );
        if ( $timestamp ) {
            wp_unschedule_event( $timestamp, 'igd_sync_interval' );
        }
        //Delete data
        
        if ( igd_get_settings( 'deleteData', false ) ) {
            delete_option( 'igd_tokens' );
            delete_option( 'igd_accounts' );
            delete_option( 'igd_settings' );
            delete_option( 'igd_cached_folders' );
            igd_delete_cache();
        }
    
    }
    
    /**
     * @return Hooks|null
     */
    public static function instance()
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
Hooks::instance();