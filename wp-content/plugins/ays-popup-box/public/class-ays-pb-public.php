<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/public
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Pb_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        $this->settings = new Ays_PopupBox_Settings_Actions($this->plugin_name);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ays_Pb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ays_Pb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        // wp_enqueue_style( $this->plugin_name.'-font-awesome', AYS_PB_PUBLIC_URL . '/css/ays-pb-font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pb_animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

	}

    /**
     * Register style sheets for the public side of the site footer.
     *
     * @since    1.0.0
     */
    public function enqueue_styles_footer(){
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ays-pb-public.css', array(), $this->version, 'all' );
    }

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ays_Pb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ays_Pb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ays-pb-public.js', array( 'jquery' ), $this->version, false );

         wp_localize_script($this->plugin_name, 'pbLocalizeObj', array(
                'icons' => array(
                    'close_icon' => '<svg class="ays_pb_material_close_icon" xmlns="https://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" alt="Pop-up Close"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
                    'close_circle_icon' => '<svg class="ays_pb_material_close_circle_icon" xmlns="https://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="36" alt="Pop-up Close"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>',
                    'volume_up_icon' => '<svg class="ays_pb_fa_volume" xmlns="https://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="36"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>',
                    'volume_mute_icon' => '<svg xmlns="https://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M7 9v6h4l5 5V4l-5 5H7z"/></svg>',
                ),

            ) );
	}
	

	public function ays_generate_shortcode(){
        add_shortcode( 'ays_pb', array($this, 'ays_generate_popup') );
    }
	
	public function ays_set_cookie($attr){
		
        $cookie_time = (isset($attr['cookie']) && $attr['cookie'] != 0) ? absint(intval($attr['cookie'])) : -1;
        $cookie_name = 'ays_popup_cookie_'.$attr['id'];
        $cookie_value = $attr['title'];
        $cookie_expiration =  time() + ($cookie_time * 60);
        setcookie($cookie_name, $cookie_value, $cookie_expiration, '/');
    }

    public function ays_remove_cookie($attr){
        $cookie_name = 'ays_popup_cookie_'.$attr['id'];
        if(isset($_COOKIE[$cookie_name])){
            unset($_COOKIE[$cookie_name]);
            $cookie_expiration =  time() - 1;   
            setcookie($cookie_name, null, $cookie_expiration, '/');
        }
    }

    public function ays_pb_set_cookie_only_once($attr){

        if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
             $id = $_REQUEST['id'];
         }else{
            $id = $attr['id'];
         }

        if(isset($_REQUEST['title']) && $_REQUEST['title'] != ''){
              $title = $_REQUEST['title'];
        }else{
            $title =  $attr['title'];
        }
        
        $cookie_name = 'ays_show_popup_only_once_'.$id;
        $cookie_value =  $title;
        $cookie_expiration = time() + (10 * 365 * 24 * 60 * 60);
        setcookie($cookie_name, $cookie_value, $cookie_expiration, '/');
    }

    public function ays_pb_remove_cookie_only_once($attr){
        $cookie_name = 'ays_show_popup_only_once_'.$attr['id'];
        if(isset($_COOKIE[$cookie_name])){
            unset($_COOKIE[$cookie_name]);
            $cookie_expiration =  time() - 1;   
            setcookie($cookie_name, null, $cookie_expiration, '/');
        }
    }
	

	public function ays_generate_popup( $attr ){

        $id = ( isset($attr['id']) ) ? absint( intval( $attr['id'] ) ) : null;
		$popupbox = $this->get_pb_by_id($id);
        $options = ( isset( $popupbox['options'] ) && $popupbox['options'] != '' ) ? json_decode($popupbox['options'], true) : array();
        $ays_popup_on = $popupbox['onoffswitch'];

        /*******************************************************************************************************/

        $settings_options = $this->settings->ays_get_setting('options');
        if($settings_options){
            $settings_options = json_decode($settings_options, true);
        }else{
            $settings_options = array();
        }

        /*******************************************************************************************************/

        if(isset($options['pb_mobile']) && $options['pb_mobile'] == "on"){
            $check_mobile_device = $this->ays_pb_detect_mobile_device();
            if ($check_mobile_device) {
                $popupbox['onoffswitch'] = 'Off';
            }
        }

        //Hide on PC
        $options['hide_on_pc'] = ( isset( $options['hide_on_pc'] ) && $options['hide_on_pc'] == "on" ) ? "on" : "off";
        $ays_pb_hide_on_pc = ( isset( $options['hide_on_pc'] ) && $options['hide_on_pc'] == "on" ) ? true : false;

        if( $ays_pb_hide_on_pc ){
            $check_pc = $this->ays_pb_detect_mobile_device();
            if( !$check_pc ){
                $popupbox['onoffswitch'] = 'Off';
            }
        }

        //Hide on Tablets
        $options['hide_on_tablets'] = ( isset( $options['hide_on_tablets'] ) && $options['hide_on_tablets'] == "on" ) ? "on" : "off";
        $ays_pb_hide_on_tablets = ( isset( $options['hide_on_tablets'] ) && $options['hide_on_tablets'] == "on" ) ? true : false;

        if( $ays_pb_hide_on_tablets ){
            $check_tablets = $this->ays_pb_detect_tablet_device();
            if( $check_tablets ){
                $popupbox['onoffswitch'] = 'Off';
            }
        }

        if (isset($popupbox['active_date_check']) && $popupbox['active_date_check'] == "on"){
            if (isset($popupbox['activeInterval']) && isset($popupbox['deactiveInterval'])) {
                $current_time = strtotime(current_time("Y-m-d H:i:s"));
                $startDate    = strtotime($popupbox['activeInterval']);
                $endDate      = strtotime($popupbox['deactiveInterval']);

                if ($startDate < $current_time && $endDate > $current_time) {
                    $popupbox['onoffswitch'] = $ays_popup_on;
                }
                else{
                    $popupbox['onoffswitch'] = "Off";
                }
            }
        }

		if (isset($popupbox['log_user']) && isset($popupbox['guest'])){
            if ( is_user_logged_in() && $popupbox['log_user'] != "On" || $popupbox['guest'] !='On' && $popupbox['log_user'] != "On") {
                $popupbox['onoffswitch'] = 'Off';
            }
            elseif (!is_user_logged_in() && $popupbox['log_user'] == "On"){
                if ($popupbox['guest'] !='On') {
                    $popupbox['onoffswitch'] = 'Off';
                }
            }
        }

        // Tigran
        global $wp_roles;
        $user = wp_get_current_user();
        $users_roles  = $wp_roles->role_names;
        $users_role = (isset($popupbox['users_role']) && $popupbox['users_role'] != '') ? $popupbox['users_role'] : '';
        $users_role = json_decode($users_role);
        $is_user_role = false;
        if(!empty($users_role)){
            if (is_array($users_role)) {
                foreach($users_role as $key => $role){
                    if(in_array($role, $users_roles)){
                        $users_role[$key] = array_search($role, $users_roles);
                    }                        
                }
            }else{
                if(in_array($users_role, $users_roles)){
                    $users_role = array_search($users_role, $users_roles);
                }
            }
            if(is_array($users_role)){
                foreach($users_role as $role){                        
                    if (in_array(strtolower($role), (array)$user->roles)) {
                        $is_user_role = true;
                        break;
                    }
                }                    
            }else{
                if (in_array(strtolower($users_role), (array)$user->roles)) {
                    $is_user_role = true;
                }
            }

            if (!$is_user_role) {
                $popupbox['onoffswitch'] = 'Off';
            }
        }

        if(isset($_COOKIE['ays_pb_dismiss_ad_'.$id])){
            $popupbox['onoffswitch'] = 'Off';
        }
        
        if(isset($options['enable_dismiss']) && $options['enable_dismiss'] == 'off'){
            if(isset($_COOKIE['ays_pb_dismiss_ad_'.$id])){
                unset($_COOKIE['ays_pb_dismiss_ad_'.$id]);
                $cookie_expiration =  time() - 1;   
                setcookie('ays_pb_dismiss_ad_'.$id, null, $cookie_expiration, '/');
            }
        }        

        //Show popup only for author
        $popupbox['show_only_for_author'] = ( isset( $popupbox['show_only_for_author'] ) && $popupbox['show_only_for_author'] == "on") ? $popupbox['show_only_for_author'] : 'off';
        $show_only_for_author = ( isset( $popupbox['show_only_for_author']) && $popupbox['show_only_for_author'] == "on") ? true : false;

        $popup_author = ( isset( $options['create_author'] ) && $options['create_author'] != '' ) ? absint( $options['create_author'] ) : '';

        $super_admin = get_super_admins();

        if($show_only_for_author){
            if($popup_author == ''){
                if( ! in_array($user->user_login, $super_admin ) ){
                    $popupbox['onoffswitch'] = 'Off';
                }
            }else if($user->ID != $popup_author){
                $popupbox['onoffswitch'] = 'Off';
            }
        }

        //Tigran
        if(isset($popupbox['onoffswitch']) && $popupbox['onoffswitch'] == 'On'){
			
			if(!isset($_COOKIE['ays_popup_cookie_'.$id])){
				$this->ays_set_cookie($popupbox);
			}elseif(isset($popupbox['cookie']) && $popupbox['cookie'] == 0){
                $this->ays_remove_cookie($popupbox);
            }else{
				return;
			}
            
			$ays_pb_shortcode               = $popupbox["shortcode"];            
            $width = ( isset($attr['w']) ) ? absint( intval( $attr['w'] ) ) : $popupbox["width"];
            $height = ( isset($attr['h']) ) ? absint( intval( $attr['h'] ) ) : $popupbox["height"];
			$popupbox["width"] = $width;
			$popupbox["height"] = $height;
            $show_title                     = $popupbox["show_popup_title"];
            $show_desc                      = $popupbox["show_popup_desc"];
            $closeButton                    = $popupbox["close_button"];
			$ays_pb_autoclose               = $popupbox["autoclose"];
			$ays_pb_title           		= $popupbox["title"];
			$ays_pb_description     		= $popupbox["description"];
			$ays_pb_bgcolor					= $popupbox["bgcolor"];
			$ays_pb_header_bgcolor		    = $popupbox["header_bgcolor"];
			// $ays_pb_custom_css              = $popupbox["custom_css"];
			$ays_pb_animate_in              = $popupbox["animate_in"];
			$ays_pb_animate_out             = $popupbox["animate_out"];
			$ays_pb_template                = ($popupbox["view_type"] == false || $popupbox["view_type"] == '') ? 'default' : $popupbox["view_type"];
			$ays_pb_custom_css              = wp_unslash( stripslashes( htmlspecialchars_decode( $popupbox["custom_css"] ) ) );
			$ays_pb_custom_html             = $popupbox["custom_html"];
			$popupbox["delay"]              = ($popupbox["delay"] == false) ? 0 : $popupbox["delay"];
			$popupbox["scroll_top"]         = ($popupbox["scroll_top"] == false) ? 0 : $popupbox["scroll_top"];
			$ays_pb_show_all                = $popupbox["show_all"];
			$ays_pb_action_buttons          = ($popupbox["action_button"] == false || $popupbox["action_button"] == '') ? "" : $popupbox["action_button"] ;
			$ays_pb_action_buttons_type     = ($popupbox["action_button_type"] == false) ? "both" : $popupbox["action_button_type"];
			$ays_pb_modal_content           = ($popupbox["modal_content"] == false) ? "shortcode" : $popupbox["modal_content"];
			$ays_pb_delay = intval($popupbox["delay"]);
			$ays_pb_scroll_top = intval($popupbox["scroll_top"]);
			
			$ays_pb_textcolor = (!isset($popupbox["textcolor"])) ? "#000000" : $popupbox["textcolor"];
			$ays_pb_bordersize = (!isset($popupbox["bordersize"])) ? 0 : $popupbox["bordersize"];
			$ays_pb_bordercolor = (!isset($popupbox["bordercolor"])) ? "#000000" : $popupbox["bordercolor"];
            $ays_pb_border_radius = (!isset($popupbox["border_radius"])) ? "4" : $popupbox["border_radius"];
            $custom_class  = (isset($popupbox['custom_class']) && $popupbox['custom_class'] != "") ? $popupbox['custom_class'] : "";
            //popup box font-family
            $ays_pb_font_family  = (isset($options['pb_font_family']) && $options['pb_font_family'] != '') ? $options['pb_font_family'] : '';

            $close_button_size = (isset($options['close_button_size']) && $options['close_button_size'] != '') ? abs($options['close_button_size']) : '1';

            //Close button color
            $close_button_color = (isset($options['close_button_color']) && $options['close_button_color'] != "") ? esc_attr( stripslashes( $options['close_button_color'])) : $ays_pb_textcolor;

            //Close button color on hover
            $close_button_hover_color = (isset($options['close_button_hover_color']) && $options['close_button_hover_color'] != "") ? esc_attr( stripslashes( $options['close_button_hover_color'])) : $close_button_color;
            
            $modal_class = 'ays-pb-modal';

            $show_only_once =  isset($options['show_only_once']) && $options['show_only_once'] == 'on' ? 'on' : 'off';

            if(!isset($_COOKIE['ays_show_popup_only_once_'.$id]) && isset($options['show_only_once']) && $options['show_only_once'] == 'on' && $ays_pb_action_buttons_type != 'clickSelector'){
                $this->ays_pb_set_cookie_only_once($popupbox);
            }elseif(isset($options['show_only_once']) && $options['show_only_once'] == 'off'){
                $this->ays_pb_remove_cookie_only_once($popupbox);
            }elseif(!isset($options['show_only_once'])){

            }
            elseif(isset($_COOKIE['ays_show_popup_only_once_'.$id]) && isset($options['show_only_once']) && $options['show_only_once'] == 'on'){
                return;
            }else{

            }


            $open = '';
            if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
               if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                    $open = "checked";
                    $ays_pb_animate_in_open = $ays_pb_animate_in;
                }else{ 
                    $open = "";
                    $ays_pb_animate_in_open = "";
                } 
            }

            if($ays_pb_action_buttons_type == 'clickSelector'){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
                $open = "";
            }
            if($ays_pb_title != ''){
                $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family'>$ays_pb_title</h2>";
            }
            if($ays_pb_description != ''){
                $ays_pb_description = "<p>$ays_pb_description</p>";
            }
            if($ays_pb_custom_css != '' || $ays_pb_custom_css != null){
                $ays_pb_custom_css = "<style>$ays_pb_custom_css</style>";
            }

            //Overlay Color
            $ays_pb_overlay_color = (isset($options["overlay_color"]) && $options["overlay_color"] != '') ? $options["overlay_color"] : "#000";

            //Close button Delay
            $close_button_delay   = (isset($options["close_button_delay"]) && $options["close_button_delay"] != '') ? absint( intval($options["close_button_delay"]) ) : 0;

            //Animation Speed
            $ays_pb_animation_speed = (isset($options["animation_speed"]) && $options["animation_speed"] !== '') ? abs( $options["animation_speed"]) : 1;

            //Close Animation Speed
            $ays_pb_close_animation_speed = (isset($options["close_animation_speed"]) && $options["close_animation_speed"] !== '') ? abs($options["close_animation_speed"]) : 1;

            $ays_pb_animation_close_milleseconds = $ays_pb_close_animation_speed * 1000;

            //Close button text
            $ays_pb_close_button_val = (isset($options['close_button_text']) && $options['close_button_text'] != '') ? $options['close_button_text'] : 'x';

            $ays_pb_position = isset($popupbox['pb_position']) && $popupbox['pb_position'] != '' ? $popupbox['pb_position'] : 'center-center';
            $ays_pb_margin = isset($popupbox['pb_margin']) && $popupbox['pb_margin'] != '' ? intval( $popupbox['pb_margin'] ) : 0;

            //close popup by ESC
            $close_popup_esc = (isset($options['close_popup_esc']) && $options['close_popup_esc'] == 'on') ? $options['close_popup_esc'] : 'off';
            
            $close_popup_esc_flag = false;

            if($close_popup_esc == 'on'){
                $close_popup_esc_flag = true;
            }

            //close popup my clicking outsite the box
            $close_popup_overlay = (isset($options['close_popup_overlay']) && $options['close_popup_overlay'] == 'on') ? $options['close_popup_overlay'] : 'off';
            $close_popup_overlay_flag= false;

            if($close_popup_overlay == 'on'){
                $close_popup_overlay_flag = true;
            }

            if(!isset($options["close_animation_speed"])){
                $ays_pb_close_animation_speed = $ays_pb_animation_speed;

                $ays_pb_animation_close_milleseconds = $ays_pb_close_animation_speed * 1000;
            }

            $disable_scroll = (isset($options['disable_scroll']) && $options['disable_scroll'] == 'on') ? true : false;

            $enable_pb_fullscreen = (isset($options['enable_pb_fullscreen']) && $options['enable_pb_fullscreen'] == 'on') ? true : false;

            // popup minimal height
            $pb_min_height_val = (isset($options['pb_min_height']) && $options['pb_min_height'] != '') ? absint(intval($options['pb_min_height'])) : 0;

            if ($pb_min_height_val == 0) {
                $pb_min_height = '';
            }else{
                $pb_min_height = "min-height: ".$pb_min_height_val."px;";
            }

        /* 
         * Popup Box container background gradient
         * 
         */
        
        // Checking exists background gradient option
                
        $options['enable_background_gradient'] = (!isset($options['enable_background_gradient'])) ? "off" : $options['enable_background_gradient'];
        
        if(isset($options['background_gradient_color_1']) && $options['background_gradient_color_1'] != ''){
            $background_gradient_color_1 = $options['background_gradient_color_1'];
        }else{
            $background_gradient_color_1 = "#000";
        }

        if(isset($options['background_gradient_color_2']) && $options['background_gradient_color_2'] != ''){
            $background_gradient_color_2 = $options['background_gradient_color_2'];
        }else{
            $background_gradient_color_2 = "#fff";
        }

        if(isset($options['quiz_gradient_direction']) && $options['quiz_gradient_direction'] != ''){
            $pb_gradient_direction = $options['quiz_gradient_direction'];
        }else{
            $pb_gradient_direction = 'vertical';
        }
        switch($pb_gradient_direction) {
            case "horizontal":
                $pb_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $pb_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $pb_gradient_direction = "to bottom left";
                break;
            default:
                $pb_gradient_direction = "to bottom";
        }

        // Popup Box container background gradient enabled/disabled
        
        if(isset($options['enable_background_gradient']) && $options['enable_background_gradient'] == "on"){
            $enable_background_gradient = true;
        }else{
            $enable_background_gradient = false;
        }

        // PopupBox container width for mobile
        if(isset($options['mobile_width']) && $options['mobile_width'] != ''){
            $mobile_width = $options['mobile_width'] . '%';
            if($options['mobile_width'] == 0){
                $mobile_width = '100%';
            }
        }else{
            $mobile_width = '100%';
        }

        // PopupBox container max-width for mobile
        if(isset($options['mobile_max_width']) && $options['mobile_max_width'] != ''){
            $mobile_max_width = $options['mobile_max_width'] . '%';
        }else{
            $mobile_max_width = '100%';
        }

        //Font Size for mobile
        $pb_font_size_for_mobile = (isset($options['pb_font_size_for_mobile']) && $options['pb_font_size_for_mobile'] != '') ? absint($options['pb_font_size_for_mobile']) : 13;

        ///////////////////////////////////////////////////////////////////////////////////

        /*
         * PopupBox sound
         */

        $enable_pb_sound     = false;
        $ays_pb_sound_status = false;
        $ays_pb_sound        = "";
        $ays_pb_sound_html   = "";
        $ays_pb_check_sound  = (isset($options['enable_pb_sound']) && $options['enable_pb_sound'] != '') ? $options['enable_pb_sound'] : 'off'; 
        
        if(isset($settings_options['ays_pb_sound']) && $settings_options['ays_pb_sound'] != ''){
            $ays_pb_sound_status = true;
            $ays_pb_sound = $settings_options['ays_pb_sound'];
        }
        
        if(isset($options['enable_pb_sound']) && $options['enable_pb_sound'] == "on"){
            if($ays_pb_sound_status){
                $enable_pb_sound = true;
            }
        }
        
        if($enable_pb_sound){
            $ays_pb_sound_html = "<audio id='ays_pb_sound_".$id."' class='ays_pb_sound' src='".$ays_pb_sound."'></audio>";
        }
        
        //Popup box close sound

        $animation_pb = false;
        $ays_pb_close_sound_status = false;
        $ays_pb_close_sound = "";
        $ays_pb_close_sound_html = "";
        $ays_pb_check_anim_speed  = (isset($options['animation_speed']) && $options['animation_speed'] != '') ? $options['animation_speed'] : '1';
        
        if(isset($settings_options['ays_pb_close_sound']) && $settings_options['ays_pb_close_sound'] != ""){
            $ays_pb_close_sound_status  = true;
            $ays_pb_close_sound = $settings_options['ays_pb_close_sound'];
        }

        if(isset($options['animation_speed'])){
            if($ays_pb_close_sound_status){
                $animation_pb = true;
            }
        }

        if($animation_pb){
            $ays_pb_close_sound_html = "<audio id='ays_pb_close_sound_".$id."' class='ays_pb_close_sound' src='".$ays_pb_close_sound."'></audio>";
        }

        //ays_pb_hover_show_close_btn
        $options['ays_pb_hover_show_close_btn'] = (isset($options['ays_pb_hover_show_close_btn']) && $options['ays_pb_hover_show_close_btn'] == "on") ? "on" : "off";
        $ays_pb_hover_show_close_btn = (isset($options['ays_pb_hover_show_close_btn']) && $options['ays_pb_hover_show_close_btn'] == "on") ? true : false;

        $mobile_height = (isset($options['mobile_height']) && $options['mobile_height'] != "") ? $options['mobile_height'] : $popupbox["height"];

        if(isset($options['mobile_height']) && $options['mobile_height'] != ''){
            
            $mobile_height = $options['mobile_height'];
            if( $options['mobile_height'] == 0){
                $mobile_height = $popupbox["height"];
            }
        }else{
            $mobile_height = $popupbox["height"];
        }

        //Blured overlay
        $options['blured_overlay'] = ( isset( $options['blured_overlay'] ) && $options['blured_overlay'] != '' ) ? $options['blured_overlay'] : 'off';
        $ays_pb_blured_overlay = ( isset( $options['blured_overlay'] ) && $options['blured_overlay'] == 'on' ) ? true : false;

        $blured_overlay = '';
        if($ays_pb_blured_overlay && $popupbox['onoffoverlay'] == 'On'){
            $blured_overlay = '-webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(20px);
            opacity:unset !important;';
            $ays_pb_overlay_color = Ays_Pb_Data::hex2rgba( $ays_pb_overlay_color, 0.5 );

        }
        //Disabel scroll on popup
        $options['disable_scroll_on_popup'] = ( isset( $options['disable_scroll_on_popup'] ) && $options['disable_scroll_on_popup'] != '' ) ? $options['disable_scroll_on_popup'] : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options['disable_scroll_on_popup'] ) && $options['disable_scroll_on_popup'] == 'on' ) ? true : false;

        $disable_scroll_on_popup = '';
        $disable_scroll_display_none = '';
        $position_absolute_popup_scroll = '';
        $padding_top_popup_scroll = '';
        $width_popup_scroll = '';
        $bottom_popup_scroll = '';
        $margin_top = '';
        if($ays_pb_disable_scroll_on_popup){
            $disable_scroll_on_popup = 'overflow:hidden !important;';
            $disable_scroll_display_none = 'display:none;';
            $position_absolute_popup_scroll = 'position:absolute;';
            $padding_top_popup_scroll = 'padding:65px 10px;';
            $width_popup_scroll = 'width:100%';
            $bottom_popup_scroll = 'bottom:unset';
            $margin_top = 'margin-top: 65px;';
        }

        //Background image position for mobile
        $options['pb_bg_image_direction_on_mobile'] = ( isset( $options['pb_bg_image_direction_on_mobile'] ) && $options['pb_bg_image_direction_on_mobile'] != "" ) ? $options['pb_bg_image_direction_on_mobile'] : "on";
        $pb_bg_image_direction_on_mobile = ( isset( $options['pb_bg_image_direction_on_mobile'] ) && $options['pb_bg_image_direction_on_mobile'] == "on" ) ? true : false;

        $ays_pb_image_direction_timer = '';
        $ays_pb_image_direction_content_alignment = '';
        $ays_pb_image_direction_footer_alignment = '';
        $ays_pb_image_direction_image = '';
        if($pb_bg_image_direction_on_mobile){
            $ays_pb_image_direction_timer = 'right: 20%;bottom:0;';
            $ays_pb_image_direction_content_alignment = 'align-items: center;';
            $ays_pb_image_direction_footer_alignment = 'flex-direction: column;align-items: center;justify-content: start;';
            $ays_pb_image_direction_image = 'width:100%; height:180px;';
        }

        /*******************************************************************************************************/

            
            $ays_pb_bgcolor_rgba = $this->hex2rgba($ays_pb_bgcolor, 0.85);

			$popupbox_view = $ays_pb_custom_css."
					<div class='ays-pb-modals av_pop_modals_".$id."' style='min-width: 100%;'>
                        <input type='hidden' value='".$ays_pb_animate_in."' id='ays_pb_modal_animate_in_".$id."'>
                        <input type='hidden' value='".$ays_pb_animate_out."' id='ays_pb_modal_animate_out_".$id."'>
                        <input type='hidden' value='".$ays_pb_animation_close_milleseconds."' id='ays_pb_animation_close_speed_".$id."'>
						<input id='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-check' type='checkbox' ".$open."/>
                        {$ays_pb_sound_html}
                        {$ays_pb_close_sound_html}";

            switch($ays_pb_template){
                case 'mac':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $mac_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $mac_template->ays_pb_template_macos($popupbox);
                     
                    $modal_class = 'ays_window';
                    $modal_close_additional_js = "";
                    break;
                case 'cmd':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $cmd_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $cmd_template->ays_pb_template_cmd($popupbox);
                    $modal_class = 'ays_window';
                    $modal_close_additional_js = "";
                    break;
                case 'ubuntu':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $ubuntu_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $ubuntu_template->ays_pb_template_ubuntu($popupbox);
                    $modal_class = 'ays_ubuntu_window';
                    $modal_close_additional_js = "";
                    break;
                case 'winXP':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $winxp_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $winxp_template->ays_pb_template_winxp($popupbox);
                    $modal_class = 'ays_winxp_window';
                    $modal_close_additional_js = "";
                    break;
                case 'win98':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $win98_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $win98_template->ays_pb_template_win98($popupbox);
                    $modal_class = 'ays_win98_window';
                    $modal_close_additional_js = "";
                    break;
                case 'lil':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $lil_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $lil_template->ays_pb_template_lil($popupbox);
                    $modal_class = 'ays_lil_window';
                    $modal_close_additional_js = "";
                    break;
                case 'image':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $lil_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $lil_template->ays_pb_template_image($popupbox);
                    $modal_class = 'ays_image_window';
                    $modal_close_additional_js = "";
                    break;
                case 'minimal':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $minimal_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $minimal_template->ays_pb_template_minimal($popupbox);
                    $modal_class = 'ays_minimal_window';
                    $modal_close_additional_js = "";
                    break;
                case 'template':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $lil_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $lil_template->ays_pb_template_template($popupbox);
                    $modal_class = 'ays_template_window';
                    $modal_close_additional_js = "";
                    break;
                case 'video':
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $video_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $video_template->ays_pb_template_video($popupbox);
                    $modal_class = 'ays_video_window';
                    $modal_close_additional_js = "";
                    break;
                default:
                    include_once( 'partials/ays-pb-public-templates.php' );
                    $default_template =  new Ays_Pb_Public_Templates($this->plugin_name, $this->version);
                    $popupbox_view .= $default_template->ays_pb_template_default($popupbox);
                    $modal_close_additional_js = "";
                    break;
            }

            if( !$enable_pb_fullscreen ){

                switch ( $ays_pb_position){
                    
                    case "center-center":
                        $popupbox_view .= "<script>
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'top': '0', 'right': '0', 'bottom': '0', 'left': '0'});             
                                           </script>";
                        break;
                    case "left-top":
                        if(($popupbox['view_type'] === 'image' || $popupbox['view_type'] === 'minimal')  && $closeButton != 'on'){
                            $ays_pb_conteiner_pos = "35px";
                        }else{
                            $ays_pb_conteiner_pos = 0;
                        }
                        $popupbox_view .= "<script>
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'top': '".$ays_pb_conteiner_pos."',  'left': '0','right': 'unset','bottom':'unset', 'margin': '".$ays_pb_margin."px'});             
                                           </script>";
                        break;
                    case "top-center":
                        if(($popupbox['view_type'] === 'image' || $popupbox['view_type'] === 'minimal') && $closeButton != 'on'){
                            $ays_pb_conteiner_pos = "35px";
                        }else{
                            $ays_pb_conteiner_pos = 0;
                        }
                        $popupbox_view .= "<script>
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'top': '".$ays_pb_conteiner_pos."',  'left': '0','right': '0','bottom':'unset', 'margin': '".$ays_pb_margin."px auto'});
                                           </script>";
                        break;    
                    case "right-top":
                        if(($popupbox['view_type'] === 'image' || $popupbox['view_type'] === 'minimal') && $closeButton != 'on'){
                            $ays_pb_conteiner_pos = "35px";
                        }else{
                            $ays_pb_conteiner_pos = 0;
                        }
                        $popupbox_view .= "<script>
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'top': '".$ays_pb_conteiner_pos."', 'right': '0','left':'unset','bottom':'unset', 'margin': '".$ays_pb_margin."px'});             
                                           </script>";
                        break;
                    case "left-center":
                        $popupbox_view .= "<script>
                                            var popupHeight = ".($popupbox["height"]/2).";
                                            var userScreenHeight = (jQuery(window).height()/2);
                                            var result = (userScreenHeight - popupHeight) + 'px';
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'top': result,  'left': '0','right': 'unset','bottom':'unset', 'margin': '".$ays_pb_margin."px'});           
                                           </script>";
                        break; 
                    case "right-center":
                        $popupbox_view .= "<script>
                                            var popupHeight = ".($popupbox["height"]/2).";
                                            var userScreenHeight = (jQuery(window).height()/2);
                                            var result = (userScreenHeight - popupHeight) + 'px';
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'top': result,  'left': 'unset','right': '0','bottom':'unset', 'margin': '".$ays_pb_margin."px'});         
                                           </script>";
                        break;       
                    case "right-bottom":
                        if($popupbox['view_type'] === 'image' || $popupbox['view_type'] === 'minimal'){
                            $ays_pb_conteiner_pos = "35px";
                        }else{
                            $ays_pb_conteiner_pos = 0;
                        }
                        $popupbox_view .= "<script>
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'right': '0', 'bottom': '".$ays_pb_conteiner_pos."', 'left': 'unset','top':'unset', 'margin': '".$ays_pb_margin."px'});             
                                           </script>";
                        break;
                    case "center-bottom":
                        if($popupbox['view_type'] === 'image' || $popupbox['view_type'] === 'minimal'){
                            $ays_pb_conteiner_pos = "35px";
                        }else{
                            $ays_pb_conteiner_pos = 0;
                        }
                        $popupbox_view .= "<script>
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({'top': 'unset',  'left': '0','right': '0','bottom':'".$ays_pb_conteiner_pos."', 'margin': '".$ays_pb_margin."px auto'});
                                           </script>";
                        break;    
                    case "left-bottom":
                        if($popupbox['view_type'] === 'image' || $popupbox['view_type'] === 'minimal'){
                            $ays_pb_conteiner_pos = "35px";
                        }else{
                            $ays_pb_conteiner_pos = 0;
                        }
                        $popupbox_view .= "<script>
                                            jQuery(document).find('.ays-pb-modal_".$id."').css({ 'bottom': '".$ays_pb_conteiner_pos."', 'left': '0', 'top':'unset','right':'unset', 'margin': '".$ays_pb_margin."px'});             
                                           </script>";
                        break;
                }
            }
            
            $popupbox_view .= "<div id='ays-pb-screen-shade_".$id."' overlay='overlay_".$id."'></div>
                        <input type='hidden' class='ays_pb_delay_".$id."' value='".$ays_pb_delay."'/>
                        <input type='hidden' class='ays_pb_scroll_".$id."' value='".$ays_pb_scroll_top."'/>
                        <input type='hidden' class='ays_pb_abt_".$id."' value='".$ays_pb_action_buttons_type."'/>
					</div>                   
                    <style>
                        .ays-pb-modal_".$id."{
                            ".$pb_min_height."
                        }

                        .ays-pb-modal_".$id.", .av_pop_modals_".$id." {
                            display:none;
                        }
                        .ays-pb-modal-check:checked ~ #ays-pb-screen-shade_".$id." {
                            opacity: 0.5;
                            pointer-events: auto;
                        }
                        
                        .ays_cmd_window {                            
                            background-color: ".$ays_pb_bgcolor_rgba.";
                        }
                        
                        .ays_cmd_window-cursor .ays_cmd_i-cursor-underscore {
                            background-color: black;
                        }
                        
                        .ays_cmd_window-cursor .ays_cmd_i-cursor-indicator {
                            background-color: transparent;
                        }

                        .ays-pb-modal_".$id." .ays_fa-close-button:before{
                            content: '". $ays_pb_close_button_val ."';
                        }

                        .ays-pb-modal_".$id." .ays_pb_description > *, 
                        .ays-pb-modal_".$id." .ays_pb_timer,
                        .ays-pb-modal_".$id." .ays_content_box p,
                        .ays-pb-modal_".$id." .ays-pb-dismiss-ad > a#ays_pb_dismiss_ad{
                            color: ".$ays_pb_textcolor.";
                            font-family: ".$ays_pb_font_family.";
                        }

                        .ays-pb-modal_".$id." .close-image-btn{
                            color: ".$close_button_color." !important;
                        }    

                        .ays-pb-modal_".$id." .close-image-btn:hover,
                        .ays-pb-modal_".$id." .close-lil-btn:hover,
                        .ays-pb-modal_".$id." .close-template-btn:hover{
                            color: ".$close_button_hover_color." !important;
                        }    

                        .ays-pb-modal_".$id." .ays_pb_material_close_circle_icon{
                            fill: ".$close_button_color." !important;
                        }

                        .ays-pb-modal_".$id." .ays_pb_material_close_circle_icon:hover{
                            fill: ".$close_button_hover_color." !important;
                        }
                        
                        .ays-pb-modal_".$id." .ays_pb_material_close_icon{
                            fill: ".$close_button_color." !important;
                        }
                        
                        .ays-pb-modal_".$id." .ays_pb_material_close_icon:hover{
                            fill: ".$close_button_hover_color." !important;
                        }
                        
                        #ays-pb-screen-shade_".$id." {
                            opacity: 0;
                            background: ".$ays_pb_overlay_color.";
                            position: absolute;
                            left: 0;
                            right: 0;
                            top: 0;
                            bottom: 0;
                            pointer-events: none;
                            transition: opacity 0.8s;
                            ".$blured_overlay.";
                        }

                        .ays-pb-modal_".$id.".".$ays_pb_animate_in."{
                            animation-duration: ".$ays_pb_animation_speed."s !important;
                        }
                        .ays-pb-modal_".$id.".".$ays_pb_animate_out." {
                            animation-duration: ".$ays_pb_close_animation_speed."s !important;
                            
                        }

                        .ays-pb-disable-scroll-on-popup{
                            ".$disable_scroll_on_popup." 
                            overflow-y: hidden !important;
                        }
                        .ays_lil_window .ays_lil_main,
                        .ays_window.ays-pb-modal_".$id." .ays_pb_description,
                        .ays_win98_window.ays-pb-modal_".$id." .ays_pb_description,
                        .ays_cmd_window.ays-pb-modal_".$id." .ays_pb_description,
                        .ays_winxp_window.ays-pb-modal_".$id." .ays_pb_description,
                        .ays_ubuntu_window.ays-pb-modal_".$id." .ays_pb_description{
                            ".$margin_top."
                        }
                        
                        .ays-pb-modals .ays-pb-modal_".$id." .ays_pb_description + hr{
                            ".$disable_scroll_display_none."
                        }

                        .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_lil_head, .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_topBar, .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_cmd_window-header, .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_ubuntu_topbar, .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_ubuntu_tools, .ays-pb-modal_".$id." .ays_winxp_title-bar, .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_win98_head, .ays-pb-modal_".$id." .ays_cmd_window-header, .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_cmd_window-cursor, .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_ubuntu_folder-info.ays_pb_timer_".$id.", .ays_cmd_window-content .ays_pb_timer.ays_pb_timer_".$id."{
                            ".$position_absolute_popup_scroll."
                            ".$width_popup_scroll."
                                                     
                        }
                        .ays_cmd_window-content .ays_pb_timer.ays_pb_timer_".$id."{
                            ".$bottom_popup_scroll."
                        }
                        .ays-pb-modals.av_pop_modals_".$id." .ays-pb-modal_".$id." .ays_pb_description ~ ays-pb-modal .ays_pb_description{
                            ".$padding_top_popup_scroll."
                        }

                        .ays-pb-modal_".$id." .ays-pb-modal-close_".$id.":hover .close-lil-btn {
                            transform: rotate(180deg) scale(".$close_button_size.") !important;
                        }

                        @media screen and (max-width: 768px){
                            .ays-pb-modal_".$id."{
                                width: $mobile_width !important;
                                max-width: $mobile_max_width !important;
                                height : ".$mobile_height."px !important;
                                box-sizing: border-box;
                            }

                            .ays-pb-modal_".$id."  .ays_pb_description > p{
                                font-size: {$pb_font_size_for_mobile}px !important;
                                word-break: break-all;
                                word-wrap: break-word;
                            }

                            .ays-pb-modal_".$id.".ays_template_window p.ays_pb_timer.ays_pb_timer_".$id."{
                                {$ays_pb_image_direction_timer}
                            }
                            .ays-pb-modal_".$id.".ays_template_window footer.ays_template_footer{
                                {$ays_pb_image_direction_footer_alignment}
                            }

                            .ays-pb-modal_".$id.".ays_template_window div.ays_bg_image_box{
                                {$ays_pb_image_direction_image}
                            }
                        }
                    </style>
                    ";


            if($ays_pb_action_buttons_type != 'clickSelector'){
                $popupbox_view .= "
                    <script>
                    (function( $ ) {
	                    'use strict';
                        $(document).ready(function(){
                            $(document).find('.ays-pb-modals').appendTo($(document.body));
                            let ays_pb_scrollTop_".$id." = parseInt($(document).find('.ays_pb_scroll_".$id."').val()),
                                ays_pb_delayOpen_".$id." = parseInt($(document).find('.ays_pb_delay_".$id."').val()),
                                time_pb_".$id." = $(document).find('.ays_pb_timer_".$id." span').data('seconds'),
                                ays_pb_effectIn_".$id." = $(document).find('#ays_pb_modal_animate_in_".$id."').val(),
                                ays_pb_animation_close_speed = $(document).find('#ays_pb_animation_close_speed_".$id."').val(),
                                ays_pb_animation_close_seconds = (ays_pb_animation_close_speed / 1000);
                            if( ays_pb_delayOpen_".$id." == 0 &&  ays_pb_scrollTop_".$id." == 0){
                                $(document).find('.av_pop_modals_".$id."').css('display','block');
                            }

                            ays_pb_animation_close_speed = parseFloat(ays_pb_animation_close_speed) - 50;

                            $(document).find('.ays_music_sound').css({'display':'none'});
                            if(time_pb_".$id." !== undefined){
                                if(time_pb_".$id." !== 0){
                                    $(document).find('#ays-pb-modal-checkbox_".$id."').trigger('click');
                                    if(ays_pb_scrollTop_".$id." == 0){
                                        var ays_pb_flag =  true;
                                        $(document).find('.ays-pb-modal_".$id."').css({
                                            'animation-duration': ays_pb_animation_close_seconds + 's'
                                        });
                                        let timer_pb_".$id." = setInterval(function(){
                                            let newTime_pb_".$id." = time_pb_".$id."--;
                                            let ays_pb_effectOut_".$id." = $(document).find('#ays_pb_modal_animate_out_".$id."').val();
                                            $(document).find('.ays_pb_timer_".$id." span').text(newTime_pb_".$id.");
                                            if(newTime_pb_".$id." <= 0){
                                                $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                                $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id." ".$custom_class." '+ays_pb_effectOut_".$id.");
                                                if(ays_pb_effectOut_".$id." != 'none'){
                                                    setTimeout(function(){ 
                                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                        $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                    }, ays_pb_animation_close_speed);
                                                }else{
                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                    $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                }
                                                $modal_close_additional_js
                                                clearInterval(timer_pb_".$id.");
                                            }
                                            $(document).find('.ays-pb-modal-close_".$id."').one('click', function(){ 
                                                $(document).find('.av_pop_modals_".$id."').css('pointer-events', 'none');
                                                $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id." ".$custom_class." '+ays_pb_effectOut_".$id.");
                                                $(this).parents('.ays-pb-modals').find('iframe').each(function(){
                                                    var key = /https:\/\/www.youtube.com/;
                                                    var src = $(this).attr('src');
                                                    $(this).attr('src', $(this).attr('src'));
                                                });
                                                $(this).parents('.ays-pb-modals').find('video.wp-video-shortcode').each(function(){
                                                    if(typeof $(this).get(0) != 'undefined'){
                                                        if ( ! $(this).get(0).paused ) {
                                                            $(this).get(0).pause();
                                                        }
                                                    }
                                                });
                                                $(this).parents('.ays-pb-modals').find('audio.wp-audio-shortcode').each(function(){
                                                    if(typeof $(this).get(0) != 'undefined'){
                                                        if ( ! $(this).get(0).paused ) {
                                                            $(this).get(0).pause();
                                                        }
                                                    }
                                                });
                                                var close_sound_src = $(document).find('#ays_pb_close_sound_".$id."').attr('src');
                                                if('".$ays_pb_check_anim_speed."' && typeof close_sound_src !== 'undefined' && '". $ays_pb_check_sound ."' === 'on'){
                                                    if('".$ays_pb_check_anim_speed."' !== 0){
                                                        var playPromise = $(document).find('#ays_pb_close_sound_".$id."').get(0).play();
                                                        if (playPromise !== undefined) {
                                                            playPromise.then(function() {
                                                                audio.pause();
                                                            }).catch(function(error) {
                                                                
                                                            });
                                                        }
                                                    }
                                                }
                                                if(ays_pb_effectOut_".$id." != 'none'){
                                                    setTimeout(function(){
                                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                        $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                                        $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                        if($('#ays_pb_close_sound_".$id."').get(0) != undefined){
                                                            if(!$('#ays_pb_close_sound_".$id."').get(0).paused){
                                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                audio.pause();
                                                                audio.currentTime = 0;
                                                            }
                                                        }    
                                                    }, ays_pb_animation_close_speed);  
                                                }else{
                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                    $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                                    $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                    if($('#ays_pb_close_sound_".$id."').get(0) != undefined){
                                                        if(!$('#ays_pb_close_sound_".$id."').get(0).paused){
                                                            $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                            var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                            audio.pause();
                                                            audio.currentTime = 0;
                                                        }
                                                    }    
                                                }
                                                $modal_close_additional_js
                                                $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none'});
                                                clearInterval(timer_pb_".$id.");
                                            });
                                            $(document).on('keydown', function(event) { 
                                                if('".$close_popup_esc_flag."' && ays_pb_flag){
                                                    if (event.keyCode == 27) {                                    
                                                        $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                                    } 
                                                }
                                                ays_pb_flag = false;
                                            });
                                        },1000); 
                                        if('".$close_popup_overlay_flag."' && '".$popupbox['onoffoverlay']."' == 'On'){
                                            $(document).find('.av_pop_modals_".$id."').on('click', function(e) {
                                                var pb_parent = $(this);
                                                var pb_div = $(this).find('.ays-pb-modal_".$id."');
                                                if (!pb_div.is(e.target) && pb_div.has(e.target).length === 0){
                                                    $(document).find('.ays-pb-modal-close_".$id."').click();
                                                }
                                            });
                                        }
                                    }
                                } else {
                                     $(document).find('.ays_pb_timer_".$id."').css('display','none');
                                     $(document).find('.ays-pb-modal_".$id."').css({
                                        'animation-duration': ays_pb_animation_close_seconds + 's'
                                     }); 
                                     $(document).find('.ays-pb-modal-close_".$id."').one('click', function(){
                                        let ays_pb_effectOut_".$id." = $(document).find('#ays_pb_modal_animate_out_".$id."').val();                                      
                                        $(document).find('.av_pop_modals_".$id."').css('pointer-events', 'none');
                                        $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id." ".$custom_class." '+ays_pb_effectOut_".$id.");
                                        $(this).parents('.ays-pb-modals').find('iframe').each(function(){
                                            var key = /https:\/\/www.youtube.com/;
                                            var src = $(this).attr('src');
                                            $(this).attr('src', $(this).attr('src'));
                                        });
                                        $(this).parents('.ays-pb-modals').find('video.wp-video-shortcode').each(function(){
                                            if(typeof $(this).get(0) != 'undefined'){
                                                if ( ! $(this).get(0).paused ) {
                                                    $(this).get(0).pause();
                                                }
                                            }
                                        });
                                        $(this).parents('.ays-pb-modals').find('audio.wp-audio-shortcode').each(function(){
                                            if(typeof $(this).get(0) != 'undefined'){
                                                if ( ! $(this).get(0).paused ) {
                                                    $(this).get(0).pause();
                                                }
                                            }
                                        });
                                        if(ays_pb_effectOut_".$id." != 'none'){
                                            setTimeout(function(){
                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                                $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                if($('#ays_pb_close_sound_".$id."').get(0) != undefined){
                                                    if(!$('#ays_pb_close_sound_".$id."').get(0).paused){
                                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                        var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                        audio.pause();
                                                        audio.currentTime = 0;
                                                    }
                                                }   
                                            }, ays_pb_animation_close_speed);  
                                        }else{
                                            $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                            $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                            $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                            if($('#ays_pb_close_sound_".$id."').get(0) != undefined){
                                                if(!$('#ays_pb_close_sound_".$id."').get(0).paused){
                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                    var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                    audio.pause();
                                                    audio.currentTime = 0;
                                                }
                                            }   
                                        }
                                        $modal_close_additional_js
                                        $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none'});
                                     });
                                }
                            }
                            let count = 0;
                            if( ays_pb_scrollTop_".$id." !== 0 ){
                                $(window).scroll(function() {
                                    if(($(this).scrollTop() >= ays_pb_scrollTop_".$id.") && (count === 0)) {
                                        count++;
                                        if( ays_pb_delayOpen_".$id." !== 0 ){                        
                                            $(document).find('.ays-pb-modal_".$id."').css('animation-delay', ays_pb_delayOpen_".$id."/1000);
                                            setTimeout(function(){
                                                $(document).find('.av_pop_modals_".$id."').css('display','block');
                                                $(document).find('.ays-pb-modal_".$id."').addClass(ays_pb_effectIn_".$id.");
                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'block');
                                                $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0.5'});
                                                $(document).find('.ays-pb-modal-check_".$id."').prop('checked', true);
                                            }, ays_pb_delayOpen_".$id.");
                                        }else{
                                            $(document).find('.av_pop_modals_".$id."').css('display','block');
                                            $(document).find('.ays-pb-modal_".$id."').addClass(ays_pb_effectIn_".$id.");
                                            $(document).find('.ays-pb-modal_".$id."').css('display', 'block');
                                            $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0.5'});
                                            $(document).find('.ays-pb-modal-check_".$id."').prop('checked', true);
                                        }
                                        if (".$close_button_delay." != 0 && '".$closeButton."' != 'on') {
                                            let close_button_delay = ".$close_button_delay.";
                                            if (".$popupbox["delay"]." != 0) {
                                               close_button_delay += Math.floor(".$popupbox["delay"].");
                                            }
                                            $(document).find('.ays-pb-modal-close_".$id."').css({'display': 'none'});
                                            setTimeout(function(){ 
                                                $(document).find('.ays-pb-modal-close_".$id."').css({'display': 'block'});
                                            }, close_button_delay );
                                        }
                                        if(".$ays_pb_autoclose." != 0){
                                            $(document).find('.ays-pb-modal_".$id."').css({
                                                'animation-duration': ays_pb_animation_close_seconds + 's'
                                            });
                                            let timer_pb_".$id." = setInterval(function(){
                                                let newTime_pb_".$id." = time_pb_".$id."--;
                                                let ays_pb_effectOut_".$id." = $(document).find('#ays_pb_modal_animate_out_".$id."').val();
                                                $(document).find('.ays_pb_timer_".$id." span').text(newTime_pb_".$id.");
                                                if(newTime_pb_".$id." <= 0){
                                                    $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                                    $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id."  ".$custom_class." '+ays_pb_effectOut_".$id.");
                                                    if(ays_pb_effectOut_".$id." != 'none'){
                                                        setTimeout(function(){
                                                            $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                            $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                        }, ays_pb_animation_close_speed);
                                                    }else{
                                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                        $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                    }
                                                    $modal_close_additional_js
                                                    clearInterval(timer_pb_".$id.");
                                                }
                                                $(document).find('.ays-pb-modal-close_".$id."').one('click', function(){      
                                                    $(document).find('.av_pop_modals_".$id."').css('pointer-events', 'none');
                                                    $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id."  ".$custom_class." '+ays_pb_effectOut_".$id.");
                                                    $(this).parents('.ays-pb-modals').find('iframe').each(function(){
                                                        var key = /https:\/\/www.youtube.com/;
                                                        var src = $(this).attr('src');
                                                        $(this).attr('src', $(this).attr('src'));
                                                    });
                                                    $(this).parents('.ays-pb-modals').find('video.wp-video-shortcode').each(function(){
                                                        if(typeof $(this).get(0) != 'undefined'){
                                                            if ( ! $(this).get(0).paused ) {
                                                                $(this).get(0).pause();
                                                            }
                                                        }
                                                    });
                                                    $(this).parents('.ays-pb-modals').find('audio.wp-audio-shortcode').each(function(){
                                                        if(typeof $(this).get(0) != 'undefined'){
                                                            if ( ! $(this).get(0).paused ) {
                                                                $(this).get(0).pause();
                                                            }
                                                        }
                                                    });
                                                    if(ays_pb_effectOut_".$id." != 'none'){
                                                        setTimeout(function(){
                                                            $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                            $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                                            $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                            if($('#ays_pb_close_sound_".$id."').get(0) != undefined){
                                                                if(!$('#ays_pb_close_sound_".$id."').get(0).paused){
                                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                    var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                    audio.pause();
                                                                    audio.currentTime = 0;
                                                                }
                                                            }   
                                                        }, ays_pb_animation_close_speed); 
                                                    }else{
                                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                        $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                                        $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag','true');
                                                        if($('#ays_pb_close_sound_".$id."').get(0) != undefined){
                                                            if(!$('#ays_pb_close_sound_".$id."').get(0).paused){
                                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                audio.pause();
                                                                audio.currentTime = 0;
                                                            }
                                                        }
                                                    }
                                                    $modal_close_additional_js
                                                    $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none'});
                                                    clearInterval(timer_pb_".$id.");
                                                });
                                                var ays_pb_flag = true;
                                                $(document).on('keydown', function(event) { 
                                                    if('".$close_popup_esc_flag."' && ays_pb_flag){
                                                        if (event.keyCode == 27) {                                    
                                                            $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                                            ays_pb_flag = false;
                                                        } 
                                                    }
                                                });
                                            },1000);
                                        }
                                    }
                                });
                            }else{
                                if( ays_pb_delayOpen_".$id." !== 0 ){
                                    $(document).find('.ays-pb-modal_".$id."').css('animation-delay', ays_pb_delayOpen_".$id."/1000);
                                    setTimeout(function(){
                                        $(document).find('.av_pop_modals_".$id."').css('display','block');
                                        $(document).find('.ays-pb-modal_".$id."').addClass(ays_pb_effectIn_".$id.");
                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'block');
                                        $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0.5'});
                                        $(document).find('.ays-pb-modal-check_".$id."').attr('checked', 'checked');

                                        if('".$disable_scroll."'){
                                            $(document).find('body').removeClass('pb_enable_scroll');
                                            $(document).find('body').addClass('pb_disable_scroll'); 

                                            $(document).find('html').removeClass('pb_enable_scroll');
                                            $(document).find('html').addClass('pb_disable_scroll');   
                                           
                                        }

                                    }, ays_pb_delayOpen_".$id.");
                                } else {
                                    if($(document).find('.ays_pb_abt_".$id."').val() != 'clickSelector'){
                                        $(document).find('.av_pop_modals_".$id."').css('display','block');
                                        $(document).find('.ays-pb-modal_".$id."').addClass(ays_pb_effectIn_".$id.");
                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'block');
                                        $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0.5'});
                                        $(document).find('.ays-pb-modal-check_".$id."').attr('checked', 'checked');

                                        if('".$disable_scroll."'){
                                            $(document).find('body').removeClass('pb_enable_scroll');
                                            $(document).find('body').addClass('pb_disable_scroll'); 

                                            $(document).find('html').removeClass('pb_enable_scroll');
                                            $(document).find('html').addClass('pb_disable_scroll');   
                                           
                                        }
                                    }
                                }
                            }
                            if ('".$popupbox['onoffoverlay']."' != 'On'){
                                $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none !important', 'pointer-events': 'none', 'background': 'none'});
                                $(document).find('.ays-pb-modal_".$id."').css('pointer-events', 'auto');
                                $(document).find('.av_pop_modals_".$id."').css('pointer-events','none');
                            };
                            if($(document).find('.ays-pb-modals video').hasClass('wp-video-shortcode')){
                                var videoWidth  = $(document).find('.ays-pb-modals video.wp-video-shortcode').attr('width');
                                var videoHeight = $(document).find('.ays-pb-modals video.wp-video-shortcode').attr('height');
                                setTimeout(function(){
                                    $(document).find('.ays-pb-modals .wp-video').removeAttr('style');
                                    $(document).find('.ays-pb-modals .mejs-container').removeAttr('style');
                                    $(document).find('.ays-pb-modals video.wp-video-shortcode').removeAttr('style');

                                    $(document).find('.ays-pb-modals .wp-video').css({'width': '100%'});
                                    $(document).find('.ays-pb-modals .mejs-container').css({'width': '100%','height': videoHeight + 'px'});
                                    $(document).find('.ays-pb-modals video.wp-video-shortcode').css({'width': '100%','height': videoHeight + 'px'});
                                },1000);
                            }
                            if($(document).find('.ays-pb-modals iframe').attr('style') != ''){
                                setTimeout(function(){
                                    $(document).find('.ays-pb-modals iframe').removeAttr('style');
                                },500);
                            }
                            if(".$ays_pb_autoclose." == 0){
                                if('".$close_popup_overlay_flag."' && '".$popupbox['onoffoverlay']."' == 'On'){
                                    $(document).find('.av_pop_modals_".$id."').on('click', function(e) {
                                        var pb_parent = $(this);
                                        var pb_div = $(this).find('.ays-pb-modal_".$id."');
                                        if (!pb_div.is(e.target) && pb_div.has(e.target).length === 0){
                                            $(document).find('.ays-pb-modal-close_".$id."').click();
                                        }
                                    });
                                }
                                var ays_pb_flag = true;
                                $(document).on('keydown', function(event) { 
                                    if('".$close_popup_esc_flag."' && ays_pb_flag){
                                        if (event.keyCode == 27) {                                    
                                            $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                            ays_pb_flag = false;
                                        } 
                                    }
                                });
                            }
                            
                            jQuery(document).on('click', '.ays-pb-modal-close_".$id."', function() {
                                $(document).find('body').removeClass('pb_disable_scroll');
                                $(document).find('body').addClass('pb_enable_scroll');

                                $(document).find('html').removeClass('pb_disable_scroll');
                                $(document).find('html').addClass('pb_enable_scroll');
                            });           
                           
                        });
                    })( jQuery );
                </script>";
            }

            if($ays_pb_action_buttons_type != 'pageLoaded'){
                if($show_only_once == 'on'){
                    $cl = 'one';
                }else{
                    $cl = 'on';
                }
                $popupbox_view .= "                
                    <script>
                        (function( $ ) {
                            'use strict';
                        $(document).ready(function(){       
                            var ays_flag = true;
                            var show_only_once = '{$show_only_once}';
                        
                            $(document).find('".$ays_pb_action_buttons."').".$cl."('click', function(){
                            $(document).find('.ays_music_sound').css({'display':'block'});

                            if(show_only_once == 'on'){
                                $.ajax({
                                    url: '".admin_url('admin-ajax.php')."',
                                    method: 'post',
                                    dataType: 'json',
                                    data: {
                                        action: 'ays_pb_set_cookie_only_once',
                                        id: ".$popupbox['id'].",
                                        title: '".htmlentities($popupbox['title'],ENT_QUOTES)."',
                                    },
                                });
                            }
                             
                              var dataAttr = $(document).find('.ays-pb-modal_".$id."').attr('data-ays-flag');
                              if(ays_flag && dataAttr == 'true'){
                                ays_flag = false;
                                $(document).find('.av_pop_modals_".$id."').css('display','block');
                                $(document).find('.av_pop_modals_".$id."').css('pointer-events', 'auto');
                                $(document).find('.ays_pb_timer_".$id." span').html($(document).find('.ays_pb_timer_".$id." span').attr('data-ays-seconds'));
                                clearInterval(timer_pb_".$id.");
                                timer_pb_".$id." = null;
                                $(document).find('.ays-pb-modal_".$id."').removeClass($(document).find('#ays_pb_modal_animate_out_".$id."').val());
                                $(document).find('.ays-pb-modal_".$id."').addClass($(document).find('#ays_pb_modal_animate_in_".$id."').val());
                                $(document).find('.ays-pb-modal_".$id."').css('display', 'block');
                                $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0.5', 'display': 'block'});
                                $(document).find('.ays-pb-modal-check_".$id."').prop('checked', true);
                                $(document).find('.ays-pb-modal-check_".$id."').attr('checked', true);
                                // $(document).find('#ays-pb-modal-checkbox_".$id."').trigger('click');
                                var ays_pb_animation_close_speed = $(document).find('#ays_pb_animation_close_speed_".$id."').val();
                                var ays_pb_animation_close_seconds = (ays_pb_animation_close_speed / 1000);
                                var sound_src = $(document).find('#ays_pb_sound_".$id."').attr('src');
                                var close_sound_src = $(document).find('#ays_pb_close_sound_".$id."').attr('src');

                                ays_pb_animation_close_speed = parseFloat(ays_pb_animation_close_speed) - 50;
                                
                                if ('". $ays_pb_check_sound ."' === 'on' && typeof sound_src !== 'undefined'){
                                    $('#ays_pb_sound_".$id."').get(0).play();
                                    $(document).find('.ays_pb_pause_sound_".$id."').on('click',function(){
                                        var audio = $('#ays_pb_sound_".$id."').get(0);
                                        audio.pause();
                                        audio.currentTime = 0;
                                    });
                                }
                                //close sound start
                                if('".$ays_pb_check_anim_speed."' && typeof close_sound_src !== 'undefined' && '". $ays_pb_check_sound ."' === 'on'){
                                    if('".$ays_pb_check_anim_speed."' !== 0){
                                        $(document).find('.ays_pb_pause_sound_".$id."').on('click',function(){
                                            $('#ays_pb_close_sound_".$id."').get(0).play();
                                            if(ays_pb_effectOut_".$id." != 'none'){
                                                setTimeout(function(){
                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                        var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                        audio.pause();
                                                        audio.currentTime = 0;
                                                        clearInterval(timer_pb_".$id.");
                                                }, ays_pb_animation_close_speed);
                                            }else{
                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                audio.pause();
                                                audio.currentTime = 0;
                                            }
                                        });
                                    }
                                }
                                //close sound end

                                var time_pb_str_".$id." = $(document).find('.ays_pb_timer_".$id." span').attr('data-ays-seconds');
                                var time_pb_".$id." = parseInt(time_pb_str_".$id.");
                                if(time_pb_".$id." !== undefined){ 
                                 if(time_pb_".$id." !== 0){
                                    var timer_pb_".$id." = setInterval(function(){
                                        let newTime_pb_".$id." = time_pb_".$id."--;
                                        let ays_pb_effectOut_".$id." = $(document).find('#ays_pb_modal_animate_out_".$id."').val();
                                        $(document).find('.ays_pb_timer_".$id." span').text(newTime_pb_".$id.");
                                        $(document).find('.ays-pb-modal_".$id."').css({
                                            'animation-duration': ays_pb_animation_close_seconds + 's'
                                        }); 
                                        if(newTime_pb_".$id." <= 0){
                                            $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                            $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id." ".$custom_class." '+$(document).find('#ays_pb_modal_animate_out_".$id."').val());
                                            $modal_close_additional_js
                                            if(ays_pb_effectOut_".$id." != 'none'){
                                                setTimeout(function(){
                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                    ays_flag = true;
                                                }, ays_pb_animation_close_speed);
                                            }else{
                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                ays_flag = true;
                                            }
                                            if ('". $ays_pb_check_sound ."' === 'on' && typeof sound_src !== 'undefined'){
                                                var audio = $('#ays_pb_sound_".$id."').get(0);
                                                audio.pause();
                                                audio.currentTime = 0;
                                                clearInterval(timer_pb_".$id.");
                                            }
                                            if ('". $ays_pb_check_anim_speed ."' && typeof close_sound_src !== 'undefined' && '". $ays_pb_check_sound ."' === 'on'){
                                                if('".$ays_pb_check_anim_speed."' !== 0){
                                                    $('#ays_pb_close_sound_".$id."').get(0).play();
                                                    if(ays_pb_effectOut_".$id." != 'none'){
                                                        setTimeout(function(){
                                                            $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                            ays_flag = true;
                                                                var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                audio.pause();
                                                                audio.currentTime = 0;
                                                                clearInterval(timer_pb_".$id.");
                                                        }, ays_pb_animation_close_speed);
                                                    }else{
                                                        $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                            ays_flag = true;
                                                            var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                            audio.pause();
                                                            audio.currentTime = 0;
                                                    }
                                                }
                                            }
                                        }
                                        $(document).find('.ays-pb-modal-close_".$id."').one('click', function(){
                                            $(document).find('.av_pop_modals_".$id."').css('pointer-events', 'none');
                                            $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id." ".$custom_class." '+ays_pb_effectOut_".$id.");
                                            $(this).parents('.ays-pb-modals').find('iframe').each(function(){
                                                var key = /https:\/\/www.youtube.com/;
                                                var src = $(this).attr('src');
                                                $(this).attr('src', $(this).attr('src'));
                                            });
                                            $(this).parents('.ays-pb-modals').find('video.wp-video-shortcode').each(function(){
                                                if(typeof $(this).get(0) != 'undefined'){
                                                    if ( ! $(this).get(0).paused ) {
                                                        $(this).get(0).pause();
                                                    }

                                                }
                                            });
                                            $(this).parents('.ays-pb-modals').find('audio.wp-audio-shortcode').each(function(){
                                                if(typeof $(this).get(0) != 'undefined'){
                                                    if ( ! $(this).get(0).paused ) {
                                                        $(this).get(0).pause();
                                                    }

                                                }
                                            });
                                            $modal_close_additional_js
                                            if(ays_pb_effectOut_".$id." != 'none'){
                                                setTimeout(function(){ 
                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none'); 
                                                    ays_flag = true;
                                                }, ays_pb_animation_close_speed);  
                                            }else{
                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none'); 
                                                ays_flag = true;
                                            }
                                            $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none'});
                                            clearInterval(timer_pb_".$id.");
                                        });
                                        
                                        var ays_pb_flag =  true;
                                        $(document).on('keydown', function(event) { 
                                            if('".$close_popup_esc_flag."' && ays_pb_flag){
                                                if (event.keyCode == 27) { 
                                                    $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                                    ays_pb_flag = false;
                                                    if ('". $ays_pb_check_sound ."' === 'on' && typeof sound_src !== 'undefined'){
                                                        var audio = $('#ays_pb_sound_".$id."').get(0);
                                                        audio.pause();
                                                        audio.currentTime = 0;
                                                        clearInterval(timer_pb_".$id.");
                                                    }
                                                    if('".$ays_pb_check_anim_speed."' && typeof close_sound_src !== 'undefined' && '". $ays_pb_check_sound ."' === 'on'){
                                                        if('".$ays_pb_check_anim_speed."' !== 0){
                                                            $('#ays_pb_close_sound_".$id."').get(0).play();
                                                            if(ays_pb_effectOut_".$id." != 'none'){
                                                                setTimeout(function(){
                                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                        var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                        audio.pause();
                                                                        audio.currentTime = 0;
                                                                        clearInterval(timer_pb_".$id.");
                                                                }, ays_pb_animation_close_speed);
                                                            }else{
                                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                audio.pause();
                                                                audio.currentTime = 0;
                                                                clearInterval(timer_pb_".$id.");
                                                            }
                                                        }
                                                    }
                                                } 
                                            }
                                        });
                                    }, 1000);
                                    if('".$ays_pb_action_buttons_type."' != 'both'){
                                        if('".$close_popup_overlay_flag."' && '".$popupbox['onoffoverlay']."' == 'On'){
                                            $(document).find('#ays-pb-screen-shade_".$id."').on('click', function() {
                                                var pb_parent_div = $(this).find('.ays-pb-modals');
                                                var pb_div = $(this).parents('.ays-pb-modals').find('.ays-pb-modal_".$id."');
                                                if (!pb_parent_div.is(pb_div) && pb_parent_div.has(pb_div).length === 0){
                                                    $(document).find('.ays-pb-modal-close_".$id."').click();
                                                    if ('". $ays_pb_check_sound ."' === 'on' && typeof sound_src !== 'undefined'){
                                                        var audio = $('#ays_pb_sound_".$id."').get(0);
                                                        audio.pause();
                                                        audio.currentTime = 0;
                                                        clearInterval(timer_pb_".$id.");
                                                    }
                                                    if('".$ays_pb_check_anim_speed."' && typeof close_sound_src !== 'undefined' && '". $ays_pb_check_sound ."' === 'on'){
                                                        if('".$ays_pb_check_anim_speed."' !== 0){
                                                            $('#ays_pb_close_sound_".$id."').get(0).play();
                                                            if(ays_pb_effectOut_".$id." != 'none'){
                                                                setTimeout(function(){
                                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                        var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                        audio.pause();
                                                                        audio.currentTime = 0;
                                                                }, ays_pb_animation_close_speed);
                                                            }else{
                                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                audio.pause();
                                                                audio.currentTime = 0;
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    }else{
                                        if('".$close_popup_overlay_flag."' && '".$popupbox['onoffoverlay']."' == 'On'){
                                            $(document).find('.av_pop_modals_".$id."').on('click', function(e) {
                                                var pb_parent_div = $(this);
                                                var pb_div = $(this).find('.ays-pb-modal_".$id."');
                                                if (!pb_div.is(e.target) && pb_div.has(e.target).length === 0){
                                                    $(document).find('.ays-pb-modal-close_".$id."').click();
                                                    if ('". $ays_pb_check_sound ."' === 'on' && typeof sound_src !== 'undefined'){
                                                        var audio = $('#ays_pb_sound_".$id."').get(0);
                                                        audio.pause();
                                                        audio.currentTime = 0;
                                                        clearInterval(timer_pb_".$id.");
                                                    }
                                                    if('".$ays_pb_check_anim_speed."' && typeof close_sound_src !== 'undefined' && '". $ays_pb_check_sound ."' === 'on'){
                                                        if('".$ays_pb_check_anim_speed."' !== 0){
                                                            $('#ays_pb_close_sound_".$id."').get(0).play();
                                                            if(ays_pb_effectOut_".$id." != 'none'){
                                                                setTimeout(function(){
                                                                    $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                        var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                        audio.pause();
                                                                        audio.currentTime = 0;
                                                                        clearInterval(timer_pb_".$id.");
                                                                }, ays_pb_animation_close_speed);
                                                            }else{
                                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                                var audio = $('#ays_pb_close_sound_".$id."').get(0);
                                                                audio.pause();
                                                                audio.currentTime = 0;
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    }   
                                } else {
                                     $(document).find('.ays_pb_timer_".$id."').css('display','none');
                                     $(document).find('.ays-pb-modal_".$id."').css({
                                        'animation-duration': ays_pb_animation_close_seconds + 's'
                                     }); 
                                     $(document).find('.ays-pb-modal-close_".$id."').one('click', function(){  
                                        let ays_pb_effectOut_".$id." = $(document).find('#ays_pb_modal_animate_out_".$id."').val();                                      
                                        $(document).find('.av_pop_modals_".$id."').css('pointer-events', 'none');
                                        $(document).find('.ays-pb-modal_".$id."').attr('class', '".$modal_class." ays-pb-modal_".$id." ".$custom_class." '+ays_pb_effectOut_".$id.");
                                        $(this).parents('.ays-pb-modals').find('iframe').each(function(){
                                            var key = /https:\/\/www.youtube.com/;
                                            var src = $(this).attr('src');
                                            $(this).attr('src', $(this).attr('src'));
                                        });
                                        $(this).parents('.ays-pb-modals').find('video.wp-video-shortcode').each(function(){
                                            if(typeof $(this).get(0) != 'undefined'){
                                                if ( ! $(this).get(0).paused ) {
                                                    $(this).get(0).pause();
                                                }

                                            }
                                        });
                                        $(this).parents('.ays-pb-modals').find('audio.wp-audio-shortcode').each(function(){
                                            if(typeof $(this).get(0) != 'undefined'){
                                                if ( ! $(this).get(0).paused ) {
                                                    $(this).get(0).pause();
                                                }

                                            }
                                        });
                                        if(ays_pb_effectOut_".$id." != 'none'){
                                            setTimeout(function(){
                                                $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                                $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                                ays_flag = true;
                                            }, ays_pb_animation_close_speed);  
                                        }else{
                                            $(document).find('.ays-pb-modal_".$id."').css('display', 'none');
                                            $(document).find('.av_pop_modals_".$id."').css('display', 'none');
                                            ays_flag = true;
                                        }
                                        $modal_close_additional_js
                                        $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none'});
                                        });
                                    }
                                }


                                if('".$disable_scroll."'){
                                    $(document).find('body').removeClass('pb_enable_scroll');
                                    $(document).find('body').addClass('pb_disable_scroll'); 

                                    $(document).find('html').removeClass('pb_enable_scroll');
                                    $(document).find('html').addClass('pb_disable_scroll');   
                                    jQuery(document).on('click', '.ays-pb-modal-close_".$id."', function() {
                                        $(document).find('body').removeClass('pb_disable_scroll');
                                        $(document).find('body').addClass('pb_enable_scroll');

                                        $(document).find('html').removeClass('pb_disable_scroll');
                                        $(document).find('html').addClass('pb_enable_scroll');
                                    });           
                                }

                                if ('".$popupbox['onoffoverlay']."' != 'On'){
                                    $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none !important', 'pointer-events': 'none'});
                                    $(document).find('.ays-pb-modal_".$id."').css('pointer-events', 'auto');
                                    $(document).find('.av_pop_modals_".$id."').css('pointer-events','none');
                                };
                                if (".$close_button_delay." != 0 && '".$closeButton."' != 'on'){
                                    $(document).find('.ays-pb-modal-close_".$id."').css({'display': 'none'});
                                    setTimeout(function(){ 
                                        $(document).find('.ays-pb-modal-close_".$id."').css({'display': 'block'});
                                    },". $close_button_delay .");
                                };
                              }
                              if(".$ays_pb_autoclose." == 0){
                                if('".$close_popup_overlay_flag."' && '".$popupbox['onoffoverlay']."' == 'On'){
                                    $(document).find('.av_pop_modals_".$id."').on('click', function(e) {
                                        var pb_parent = $(this);
                                        var pb_div = $(this).find('.ays-pb-modal_".$id."');
                                        if (!pb_div.is(e.target) && pb_div.has(e.target).length === 0){
                                            $(document).find('.ays-pb-modal-close_".$id."').click();
                                        }
                                    });
                                }
                                var ays_pb_flag = true;
                                $(document).on('keydown', function(event) { 
                                    if('".$close_popup_esc_flag."' && ays_pb_flag){
                                        if (event.keyCode == 27) {                                    
                                            $(document).find('.ays-pb-modal-close_".$id."').trigger('click');
                                            ays_pb_flag = false;
                                        } 
                                    }
                                });
                            }
                            });
                            if ('".$popupbox['onoffoverlay']."' != 'On'){
                                $(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none !important', 'pointer-events': 'none'});
                                $(document).find('.ays-pb-modal_".$id."').css('pointer-events', 'auto');
                                $(document).find('.av_pop_modals_".$id."').css('pointer-events','none');
                            };
                            if('".$ays_pb_action_buttons_type."' != 'both'){
                                if($(document).find('.ays-pb-modals video').hasClass('wp-video-shortcode')){
                                    var videoWidth  = $(document).find('.ays-pb-modals video.wp-video-shortcode').attr('width');
                                    var videoHeight = $(document).find('.ays-pb-modals video.wp-video-shortcode').attr('height');
                                    setTimeout(function(){
                                        $(document).find('.ays-pb-modals .wp-video').removeAttr('style');
                                        $(document).find('.ays-pb-modals .mejs-container').removeAttr('style');
                                        $(document).find('.ays-pb-modals video.wp-video-shortcode').removeAttr('style');

                                        $(document).find('.ays-pb-modals .wp-video').css({'width': '100%'});
                                        $(document).find('.ays-pb-modals .mejs-container').css({'width': '100%','height': videoHeight + 'px'});
                                        $(document).find('.ays-pb-modals video.wp-video-shortcode').css({'width': '100%','height': videoHeight + 'px'});
                                    },1000);
                                }
                                if($(document).find('.ays-pb-modals iframe').attr('style') != ''){
                                    setTimeout(function(){
                                        $(document).find('.ays-pb-modals iframe').removeAttr('style');
                                    },500);
                                }
                            }
                            
                        });
                    })( jQuery );
                </script>";
            }

            if ($popupbox['onoffoverlay'] != 'On'){
                $popupbox_view .= "<script>
                    jQuery(document).ready(function() {
                        jQuery(document).find('#ays-pb-screen-shade_".$id."').css({'opacity': '0', 'display': 'none !important', 'pointer-events': 'none'});
                        jQuery(document).find('.ays-pb-modal_".$id."').css('pointer-events', 'auto');
                        jQuery(document).find('.av_pop_modals_".$id."').css('pointer-events','none');
                    })
                </script>";
            }

            if ($close_button_delay != 0 && $closeButton != 'on' && $ays_pb_scroll_top == 0) {
                if ($popupbox["delay"] != 0) {
                   $close_button_delay += floor($popupbox["delay"]);
                }
                $popupbox_view .= "
                <script>
                    jQuery(document).ready(function() {
                        jQuery(document).find('.ays-pb-modal-close_".$id."').css({'display': 'none'});
                        setTimeout(function(){ 
                            jQuery(document).find('.ays-pb-modal-close_".$id."').css({'display': 'block'});
                        },". $close_button_delay .");
                    })
                </script>";
            }

            if($ays_pb_hover_show_close_btn){
                $popupbox_view .= "
                <script>
                    jQuery(document).ready(function() {
                        modernMinimal = jQuery(document).find('.ays-pb-modal_".$id."').data('name');
                        if(modernMinimal != 'modern_minimal'){
                            jQuery(document).find('.ays-pb-modal-close_".$id."').hide();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_win98_btn-close').hide();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_winxp_title-bar-close').hide();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_ubuntu_close').hide();
                            jQuery(document).find('.ays-pb-modal_".$id."').on('mouseover',function(){
                                jQuery(document).find('.ays-pb-modal-close_".$id."').show();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_win98_btn-close').show();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_winxp_title-bar-close').show();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_ubuntu_close').show();
                            });
                            jQuery(document).find('.ays-pb-modal_".$id."').on('mouseleave',function(){
                                jQuery(document).find('.ays-pb-modal-close_".$id."').hide();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_win98_btn-close').hide();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_winxp_title-bar-close').hide();
                                jQuery(document).find('.ays-pb-modal_".$id." .ays_ubuntu_close').hide();
                            });
                        }
                    })
                </script>";
            }
            return $popupbox_view;
        }

    }


    public static function ays_autoembed( $content ) {
        global $wp_embed;
        $content = stripslashes( wpautop( $content ) );
        $content = $wp_embed->autoembed( $content );
        if ( strpos( $content, '[embed]' ) !== false ) {
            $content = $wp_embed->run_shortcode( $content );
        }
        $content = do_shortcode( $content );
        return $content;
    }

    public function ays_has_shortcode_in_posts($id){

	    if (isset(get_post()->post_content)) {
            $ays_has_shortcode = strpos(get_post()->post_content, '[ays_pb id=' . $id . '');
            if ($ays_has_shortcode !== false) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function ays_shortcodes_show_all(){
        global $wpdb;
        global $wp;
        $woo = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
        if ($woo) {
            //For woocommerce shop page 
            if(is_shop()){
                $post_id = woocommerce_get_page_id('shop');
            }else{
                $post_id = get_the_ID();
            }
        }else{
            $post_id = get_the_ID();
        }

        $page_url = home_url(add_query_arg(array($_GET), $wp->request));
        $home_url = get_site_url();

        $sql2 = "SELECT * FROM {$wpdb->prefix}ays_pb";
        $result2 = $wpdb->get_results($sql2, "ARRAY_A");

        if(!empty($result2)){
            foreach($result2 as $key => $i){
                $show_all = $i['show_all'];
                switch($show_all){
                    case 'no':
                        $show_popup = false;
                    break;
                    case 'yes':
                        $show_popup = true;
                    break;
                    case 'all':
                        $show_popup = true;
                    break;
                    case 'selected':
                        $show_popup = false;
                    break;
                    case 'except':
                        $show_popup = true;
                    break;
                    default:
                    $show_popup = true;
                    $show_all = 'all';
                }
                $show = array('no', 'selected');
                $options = array();
                if ($i['options'] != '' || $i['options'] != null) {
                    $options = json_decode($i['options'], true);
                }
                $ays_pb_view_place = array();
                if($show_all != 'all'){
                    if($post_id != false){
                        if (!empty($i["view_place"])) {
                            $ays_pb_view_place  = explode( '***', $i["view_place"] );
                            if(in_array($post_id."", $ays_pb_view_place)){
                                if(in_array($show_all, $show)){
                                    $show_popup = true;
                                }else{
                                    $show_popup = false;
                                }
                            }
                        }else{
                            $post = get_post($post_id);
                            $this_post_title = strval($post->post_title);
                            $except_posts = array();
                            $except_post_types = array();
                            $postType = $post->post_type;
                            
                            
                            
                            if (isset($options['except_posts']) && !empty($options['except_posts'])) {
                                $except_posts = $options['except_posts'];
                            }
                            if (isset($options['except_post_types']) && !empty($options['except_post_types'])) {
                                $except_post_types = $options['except_post_types'];
                            }
                            
                            $except_all_post_types  = ( isset( $options['all_posts'] ) && ! empty( $options['all_posts'] ) ) ?  $options['all_posts']  : array();
                            
                            if(in_array($post_id."", $except_posts)){
                                if(in_array($show_all, $show)){
                                    $show_popup = true;
                                }else{
                                    $show_popup = false;
                                }
                            }
                            elseif (!in_array( $this_post_title, $except_posts ) && in_array( $postType, $except_all_post_types )) {
                                if(in_array($show_all, $show)){
                                    $show_popup = true;
                                }else{
                                    $show_popup = false;
                                }
                            }

                            if ( $page_url == $home_url ) {
                                if(isset($options['show_on_home_page']) && $options['show_on_home_page'] == 'on'){
                                    $show_popup = true;
                                }else{
                                    $show_popup = false;
                                }
                            }
                        }

                        if( is_404() || is_category() || is_search() ) {
                            $show_popup = false;
                        }
                    }   
                }

                if ($show_popup) {
                    $shortcode2 = "[ays_pb id={$i['id']} w={$i['width']} h={$i['height']} ]";
                    $ays_search_shortcode = $this->ays_has_shortcode_in_posts($i['id']);
                    if ($ays_search_shortcode !== true){
                        echo do_shortcode($shortcode2);
                    }
                }
            }
        }
    }
	
	public function get_pb_by_id( $id ){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_pb WHERE id=" . absint( intval( $id ) );

        $result = $wpdb->get_row($sql, "ARRAY_A");

        return $result;
    }

    public function ays_pb_detect_mobile_device(){
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $flag      = false;
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
            $flag = true;
        }
        return $flag;
    }

    public function ays_pb_detect_tablet_device(){
        $flag = false;
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $flag = true;
        }

        return $flag;
    }

    private function array_split($array, $pieces) {
        if ($pieces < 2)
            return array($array);
        $newCount = ceil(count($array)/$pieces);
        $a = array_slice($array, 0, $newCount);
        $b = $this->array_split(array_slice($array, $newCount), $pieces-1);
        return array_merge(array($a),$b);
    }
        
    private function hex2rgba( $color, $opacity = false ) {

        $default = 'rgba(39, 174, 96, 0.5)';
        /**
         * Return default if no color provided
         */
        if( empty( $color ) ) {
            return $default;
        }
        /**
         * Sanitize $color if "#" is provided
         */
        if ( $color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        /**
         * Check if color has 6 or 3 characters and get values
         */
        if ( strlen($color) == 6 ) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        /**
         * [$rgb description]
         * @var array
         */
        $rgb =  array_map( 'hexdec', $hex );
        /**
         * Check if opacity is set(rgba or rgb)
         */
        if( $opacity ) {
            if( abs( $opacity ) > 1 )
                $opacity = 1.0;
                $output = 'rgba( ' . implode( "," ,$rgb ) . ',' . $opacity . ' )';
        } else {
            $output = 'rgb( ' . implode( "," , $rgb ) . ' )';
        }
        /**
         * Return rgb(a) color string
         */
        return $output;
    }

}
