<?php
global $ays_pb_db_version;
$ays_pb_db_version = '1.5.7';
/**
 * Fired during plugin activation
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ays_Pb
 * @subpackage Ays_Pb/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Pb_Activator {

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
  public static function activate() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        global $wpdb;
        global $ays_pb_db_version;

        $installed_ver   = get_option( "ays_pb_db_version" );
        $table           = $wpdb->prefix . 'ays_pb';
        $categories_table = $wpdb->prefix . 'ays_pb_categories';
        $settings_table  = $wpdb->prefix . 'ays_pb_settings';
        $charset_collate = $wpdb->get_charset_collate();

        if($installed_ver != $ays_pb_db_version) {
            $sql = "CREATE TABLE `" . $table . "` (
                      `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                      `title` VARCHAR(256) NOT NULL,
                      `popup_name` VARCHAR(256) NOT NULL,
                      `description` TEXT NOT NULL,
                      `category_id` INT(16) UNSIGNED NOT NULL ,
                      `autoclose` INT NOT NULL,
                      `cookie` INT NOT NULL,
                      `width` INT(16) NOT NULL,
                      `height` INT NOT NULL,
                      `bgcolor` VARCHAR(30) NOT NULL,
                      `textcolor` VARCHAR(30) NOT NULL,
                      `bordersize` INT NOT NULL,
                      `bordercolor` VARCHAR(30) NOT NULL,
                      `border_radius` INT NOT NULL,
                      `shortcode` TEXT NOT NULL,
                      `users_role` TEXT NOT NULL,
                      `custom_class` TEXT NOT NULL,
                      `custom_css` TEXT NOT NULL,
                      `custom_html` TEXT NOT NULL,
                      `onoffswitch` VARCHAR(20) NOT NULL,
                      `show_only_for_author` VARCHAR(20) DEFAULT NULL,
                      `show_all` VARCHAR(20) NOT NULL,
                      `delay` INT NOT NULL, 
                      `scroll_top` INT NOT NULL,
                      `animate_in` VARCHAR(20) NOT NULL,
                      `animate_out` VARCHAR(20) NOT NULL,
                      `action_button` TEXT NOT NULL,
                      `view_place` TEXT NOT NULL,
                      `action_button_type` VARCHAR(20) NOT NULL,
                      `modal_content` VARCHAR(20) NOT NULL,
                      `view_type` VARCHAR(20) NOT NULL,
                      `onoffoverlay` VARCHAR(20) DEFAULT 'On',
                      `overlay_opacity` VARCHAR(20) NOT NULL,
                      `show_popup_title` VARCHAR(20) DEFAULT 'On',
                      `show_popup_desc` VARCHAR(20) DEFAULT 'On',
                      `close_button` VARCHAR(20) DEFAULT 'off',
                      `header_bgcolor` VARCHAR(30) NOT NULL,
                      `bg_image` VARCHAR(256)  DEFAULT '',
                      `log_user` VARCHAR(20) DEFAULT 'On',
                      `guest` VARCHAR(20) DEFAULT 'On',
                      `active_date_check` VARCHAR(20) DEFAULT 'off',
                      `activeInterval` VARCHAR(20) DEFAULT '',
                      `deactiveInterval` VARCHAR(20) DEFAULT '',
                      `pb_position` VARCHAR(30) NOT NULL,
                      `pb_margin` INT NOT NULL,
                      `options` TEXT DEFAULT '',
                      PRIMARY KEY (`id`)
                    )$charset_collate;";

            $sql_schema = "SELECT * 
                    FROM INFORMATION_SCHEMA.TABLES
                    WHERE table_schema = '".DB_NAME."' 
                        AND table_name = '".$table."' ";
            $pb_const = $wpdb->get_results($sql_schema);
            
            if(empty($pb_const)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$categories_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(256) NOT NULL,
                `description` TEXT NOT NULL,
                `published` TINYINT UNSIGNED NOT NULL,
                PRIMARY KEY (`id`)
            )$charset_collate;";

             $sql_schema = "SELECT * 
                    FROM INFORMATION_SCHEMA.TABLES
                    WHERE table_schema = '".DB_NAME."' 
                        AND table_name = '".$categories_table."' ";
            $pb_cat_const = $wpdb->get_results($sql_schema);
            
            if(empty($pb_cat_const)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$settings_table."` (
                      `id` INT(11) NOT NULL AUTO_INCREMENT,
                      `meta_key` TEXT NULL DEFAULT NULL,
                      `meta_value` TEXT NULL DEFAULT NULL,
                      `note` TEXT NULL DEFAULT NULL,
                      `options` TEXT NULL DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    )$charset_collate;";

            $sql_schema = "SELECT * 
                    FROM INFORMATION_SCHEMA.TABLES
                    WHERE table_schema = '".DB_NAME."' 
                        AND table_name = '".$settings_table."' ";
            $pb_settings_const = $wpdb->get_results($sql_schema);

            if(empty($pb_settings_const)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }
            
            update_option('ays_pb_db_version', $ays_pb_db_version);

            $popup_categories = $wpdb->get_var("SELECT COUNT(*) FROM " . $categories_table . " WHERE `title`='Uncategorized'");
            if ($popup_categories == 0) {
                $wpdb->insert($categories_table, array(
                    'title' => 'Uncategorized', 
                    'description' => '', 
                    'published' => 1
                ));
            }
        }

        $metas = array(
            "options"
        );
        
        foreach($metas as $meta_key){
            $meta_val = "";
            $sql = "SELECT COUNT(*) FROM `".$settings_table."` WHERE `meta_key` = '".$meta_key."'";
            $result = $wpdb->get_var($sql);
            if(intval($result) == 0){
                $result = $wpdb->insert(
                    $settings_table,
                    array(
                        'meta_key'    => $meta_key,
                        'meta_value'  => $meta_val,
                        'note'        => "",
                        'options'     => ""
                    ),
                    array( '%s', '%s', '%s', '%s' )
                );
            }
        }

  }

  public static function ays_pb_db_check() {
        global $ays_pb_db_version;
        if ( get_site_option( 'ays_pb_db_version' ) != $ays_pb_db_version ) {
            self::activate();
            self::alter_tables();
        }
  }

  private static function alter_tables(){
      global $wpdb;
        $table = $wpdb->prefix . 'ays_pb';

        $query = "SELECT * FROM ".$table;
        $ays_pb_infos = $wpdb->query( $query );

        if($ays_pb_infos == 0){

            $query = "INSERT INTO ".$table." (title, description, category_id, autoclose, cookie, width, height, bgcolor, textcolor, bordersize, bordercolor, border_radius, custom_html, onoffswitch, show_only_for_author, show_all, delay, scroll_top, animate_in, animate_out, action_button_type, modal_content, view_type, onoffoverlay, overlay_opacity, show_popup_title,  show_popup_desc, close_button, header_bgcolor, bg_image, log_user, guest, active_date_check, activeInterval, deactiveInterval, pb_position, pb_margin) VALUES ('Demo Title', 'Demo Description', '1' , '20', '0', '400', '500', '#ffffff', '#000000', '1', '#ffffff', '4', 'My first Popup', 'On', 'on', 'all', '0', '0', 'fadeIn', 'fadeOutUpBig', 'pageLoaded', 'custom_html', 'default', 'On', '0.5', 'On', 'On','off', '#ffffff', '', 'On', 'On', 'off', '', '','center-center', '0')";
            $wpdb->query( $query );
        }
  }
}
