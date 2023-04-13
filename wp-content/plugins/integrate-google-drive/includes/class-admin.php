<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;
class Admin
{
    /**
     * @var null
     */
    protected static  $instance = null ;
    private  $pages = array() ;
    public function __construct()
    {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action( 'admin_notices', [ $this, 'lost_authorization_notice' ] );
        add_action( 'admin_init', [ $this, 'init_update' ] );
        //Handle oAuth authorization
        add_action( 'admin_init', [ $this, 'handle_authorization' ] );
        //Handle custom app authorization
        add_action( 'admin_init', [ $this, 'app_authorization' ] );
        // Remove admin notices from plugin pages
        add_action( 'admin_notices', [ $this, 'display_notices' ] );
        //admin body class
        add_filter( 'admin_body_class', [ $this, 'admin_body_class' ] );
    }
    
    public function admin_body_class( $classes )
    {
        $admin_pages = Admin::instance()->get_pages();
        global  $current_screen ;
        
        if ( in_array( $current_screen->id, $admin_pages ) ) {
            $key = array_search( $current_screen->id, $admin_pages );
            $classes .= ' igd-admin-page igd_' . $key . ' ';
        }
        
        return $classes;
    }
    
    public function display_notices()
    {
        
        if ( get_option( 'igd_account_notice' ) ) {
            ob_start();
            include IGD_INCLUDES . '/views/notice/account.php';
            $notice_html = ob_get_clean();
            igd()->add_notice( 'info igd-account-notice error', $notice_html );
            return;
        }
        
        //Rating notice if proxy notice is off
        
        if ( 'off' != get_option( 'igd_rating_notice' ) && 'off' != get_transient( 'igd_rating_notice_interval' ) ) {
            ob_start();
            include IGD_INCLUDES . '/views/notice/rating.php';
            $notice_html = ob_get_clean();
            igd()->add_notice( 'info igd-rating-notice', $notice_html );
            return;
        }
    
    }
    
    public function app_authorization()
    {
        
        if ( isset( $_GET['action'] ) && 'integrate-google-drive-authorization' == sanitize_key( $_GET['action'] ) ) {
            $state = $_GET['state'];
            $state_url = base64_decode( $state );
            //remove action from params
            unset( $_GET['action'] );
            $params = http_build_query( $_GET );
            $redirect_url = $state_url . '&' . $params;
            wp_redirect( $redirect_url );
            exit;
        }
    
    }
    
    public function handle_authorization()
    {
        
        if ( isset( $_GET['action'] ) && 'authorization' == sanitize_key( $_GET['action'] ) ) {
            $client = Client::instance();
            $client->create_access_token();
            $redirect = admin_url( 'admin.php?page=integrate-google-drive-settings&tab=accounts' );
            echo  '<script type="text/javascript">window.opener.parent.location.href = "' . $redirect . '"; window.close();</script>' ;
            die;
        }
    
    }
    
    public function init_update()
    {
        
        if ( current_user_can( 'manage_options' ) ) {
            include_once IGD_INCLUDES . '/class-update.php';
            $updater = Update::instance();
            if ( $updater->needs_update() ) {
                $updater->perform_updates();
            }
        }
    
    }
    
    public function admin_menu()
    {
        $main_menu_added = false;
        $file_browser_users = igd_get_settings( 'accessFileBrowserUsers', [ 'administrator' ] );
        $settings_users = igd_get_settings( 'accessSettingsUsers', [ 'administrator' ] );
        $shortcode_builder_users = igd_get_settings( 'accessShortcodeBuilderUsers', [ 'administrator' ] );
        $statistics_users = igd_get_settings( 'accessStatisticsUsers', [ 'administrator' ] );
        $getting_started_users = igd_get_settings( 'accessGettingStartedUsers', [ 'administrator' ] );
        $private_files_users = igd_get_settings( 'accessPrivateFilesUsers', [ 'administrator' ] );
        $file_browser_user_roles = array_filter( $file_browser_users, function ( $item ) {
            return is_string( $item );
        } );
        $settings_user_roles = array_filter( $settings_users, function ( $item ) {
            return is_string( $item );
        } );
        $shortcode_builder_user_roles = array_filter( $shortcode_builder_users, function ( $item ) {
            return is_string( $item );
        } );
        $statistics_user_roles = array_filter( $statistics_users, function ( $item ) {
            return is_string( $item );
        } );
        $private_files_user_roles = array_filter( $private_files_users, function ( $item ) {
            return is_string( $item );
        } );
        $getting_started_users_roles = array_filter( $getting_started_users, function ( $item ) {
            return is_string( $item );
        } );
        $current_user = wp_get_current_user();
        $can_access_file_browser = !empty(array_intersect( $current_user->roles, $file_browser_user_roles )) || in_array( $current_user->ID, $file_browser_users ) || is_multisite() && is_super_admin();
        //File browser page
        
        if ( $can_access_file_browser ) {
            $this->pages['file_browser_page'] = add_menu_page(
                __( 'Integrate Google Drive', 'integrate-google-drive' ),
                __( 'Google Drive', 'integrate-google-drive' ),
                'read',
                'integrate-google-drive',
                [ 'IGD\\App', 'view' ],
                IGD_ASSETS . '/images/drive.png',
                30
            );
            $this->pages['file_browser_page'] = add_submenu_page(
                'integrate-google-drive',
                __( 'File Browser - Integrate Google Drive', 'integrate-google-drive' ),
                __( 'File Browser', 'integrate-google-drive' ),
                'read',
                'integrate-google-drive'
            );
            $main_menu_added = true;
        }
        
        //Shortcode builder page
        $can_access_shortcode_builder = !empty(array_intersect( $current_user->roles, $shortcode_builder_user_roles )) || in_array( $current_user->ID, $shortcode_builder_users ) || is_multisite() && is_super_admin();
        if ( $can_access_shortcode_builder ) {
            
            if ( !$main_menu_added ) {
                $this->pages['shortcode_builder_page'] = add_menu_page(
                    __( 'Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Google Drive', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ 'IGD\\Shortcode_Builder', 'view' ],
                    IGD_ASSETS . '/images/drive.png',
                    30
                );
                $this->pages['shortcode_builder_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Shortcode Builder - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Shortcode Builder', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ 'IGD\\Shortcode_Builder', 'view' ]
                );
                $main_menu_added = true;
            } else {
                $this->pages['shortcode_builder_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Shortcode Builder - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Shortcode Builder', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive-shortcode-builder',
                    [ 'IGD\\Shortcode_Builder', 'view' ],
                    90
                );
            }
        
        }
        //Users Private Files page
        $can_access_private_files = !empty(array_intersect( $current_user->roles, $private_files_user_roles )) || in_array( $current_user->ID, $private_files_users ) || is_multisite() && is_super_admin();
        if ( $can_access_private_files ) {
            
            if ( !$main_menu_added ) {
                $this->pages['private_files_page'] = add_menu_page(
                    __( 'Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Google Drive', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ 'IGD\\App', 'view' ],
                    IGD_ASSETS . '/images/drive.png',
                    30
                );
                $this->pages['private_files_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Users Private Files - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Users Private Files', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ 'IGD\\Private_Folders', 'view' ]
                );
                $main_menu_added = true;
            } else {
                $this->pages['private_files_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Users Private Files - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Users Private Files', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive-private-files',
                    [ 'IGD\\Private_Folders', 'view' ],
                    90
                );
            }
        
        }
        $can_access_getting_started = !empty(array_intersect( $current_user->roles, $getting_started_users_roles )) || in_array( $current_user->ID, $getting_started_users ) || is_multisite() && is_super_admin();
        if ( $can_access_getting_started ) {
            
            if ( !$main_menu_added ) {
                $this->pages['getting_started_page'] = add_menu_page(
                    __( 'Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Google Drive', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ 'IGD\\App', 'view' ],
                    IGD_ASSETS . '/images/drive.png',
                    30
                );
                $this->pages['getting_started_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Getting Started - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Getting Started', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ $this, 'render_getting_started_page' ]
                );
                $main_menu_added = true;
            } else {
                $this->pages['getting_started_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Getting Started - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Getting Started', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive-getting-started',
                    [ $this, 'render_getting_started_page' ],
                    90
                );
            }
        
        }
        //Settings page
        $can_access_settings = !empty(array_intersect( $current_user->roles, $settings_user_roles )) || in_array( $current_user->ID, $settings_users ) || is_multisite() && is_super_admin();
        if ( $can_access_settings ) {
            
            if ( !$main_menu_added ) {
                $this->pages['settings_page'] = add_menu_page(
                    __( 'Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Google Drive', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ $this, 'render_settings_page' ],
                    IGD_ASSETS . '/images/drive.png',
                    30
                );
                $this->pages['settings_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Settings - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Settings', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive',
                    [ $this, 'render_settings_page' ]
                );
                $main_menu_added = true;
            } else {
                $this->pages['settings_page'] = add_submenu_page(
                    'integrate-google-drive',
                    __( 'Settings - Integrate Google Drive', 'integrate-google-drive' ),
                    __( 'Settings', 'integrate-google-drive' ),
                    'read',
                    'integrate-google-drive-settings',
                    [ $this, 'render_settings_page' ],
                    90
                );
            }
        
        }
        //Recommended plugins page
        if ( empty(get_option( "igd_hide_recommended_plugins" )) ) {
            add_submenu_page(
                'integrate-google-drive',
                esc_html__( 'Recommended Plugins', 'integrate-google-drive' ),
                esc_html__( 'Recommended Plugins', 'integrate-google-drive' ),
                'manage_options',
                'integrate-google-drive-recommended-plugins',
                [ $this, 'render_recommended_plugins_page' ]
            );
        }
    }
    
    public function render_recommended_plugins_page()
    {
        include IGD_INCLUDES . '/views/recommended-plugins.php';
    }
    
    public function lost_authorization_notice()
    {
        $accounts = Account::get_accounts();
        if ( !empty($accounts) ) {
            foreach ( $accounts as $id => $account ) {
                
                if ( !empty($account['lost']) ) {
                    $msg = sprintf( '<div class="flex items-center"> <strong>Integrate Google Drive</strong> lost authorization for account <strong>%s</strong>. <a class="button" href="%s">Refresh</a></div>', $account['email'], admin_url( 'admin.php?page=integrate-google-drive-settings' ) );
                    igd()->add_notice( 'error igd-lost-auth-notice', $msg );
                }
            
            }
        }
    }
    
    public function render_getting_started_page()
    {
        include_once IGD_INCLUDES . '/views/getting-started/index.php';
    }
    
    public function render_settings_page()
    {
        ?>
        <div id="igd-settings"></div>
	<?php 
    }
    
    public function get_pages()
    {
        return array_filter( $this->pages );
    }
    
    /**
     * @return Admin|null
     */
    public static function instance()
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
Admin::instance();