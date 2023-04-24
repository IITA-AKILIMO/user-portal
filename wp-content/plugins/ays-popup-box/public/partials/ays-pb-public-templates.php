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
 * @subpackage Ays_Pb/public/partials
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Pb_Public_Templates {

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

    private $close_icon='<svg class="ays_pb_material_close_icon" xmlns="https://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#000000" alt="Pop-up Close"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
    private $close_circle_icon='<svg class="ays_pb_material_close_circle_icon" xmlns="https://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" alt="Pop-up Close"><path d="M0 0h24v24H0V0z" fill="none" opacity=".87"/><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.59-13L12 10.59 8.41 7 7 8.41 10.59 12 7 15.59 8.41 17 12 13.41 15.59 17 17 15.59 13.41 12 17 8.41z"/></svg>';
    private $volume_up_icon='<svg class="ays_pb_fa_volume" xmlns="https://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="36"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>';
    
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

	}

	
	public function ays_pb_template_default( $attr ){
        $id                             = $attr["id"];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr($attr["textcolor"]));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;
        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

		$author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,            
        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        $pb_title_text_shadow_x_offset = (isset($options->pb_title_text_shadow_x_offset) && $options->pb_title_text_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_x_offset ) ) : 2;

        $pb_title_text_shadow_y_offset = (isset($options->pb_title_text_shadow_y_offset) && $options->pb_title_text_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_y_offset ) ) : 2;

        $pb_title_text_shadow_z_offset = (isset($options->pb_title_text_shadow_z_offset) && $options->pb_title_text_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_z_offset ) ) : 0;
        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: '.$pb_title_text_shadow_x_offset.'px '.$pb_title_text_shadow_y_offset.'px '.$pb_title_text_shadow_z_offset.'px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }
        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        
        $ays_pb_close_button_text = '';
        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        //close button image
        $close_btn_background_img  = (isset($options->close_button_image) && $options->close_button_image != "") ? esc_url($options->close_button_image) : "";
       
        if(isset($options->close_button_image) && !empty($options->close_button_image)){
            $ays_pb_close_button_text .= "<img class='close_btn_img' src='".$close_btn_background_img."' width='30' height='30'>";
        }else{
            if($ays_pb_close_button_val === 'x'){
                $ays_pb_close_button_text .= $this->close_icon;
            }else{
                $ays_pb_close_button_text .= "<span class='ays_fa-close-button'></span>";
            }
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";

        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';



        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '.$pb_bg_image_sizing.';
                                background-position: '. $pb_bg_image_position .';';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }

        //popup full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                $close_button_position = "top: 10px; left: 10px;";
                $close_button_position_script = "";
                break;
            case "left-bottom":
                $close_button_position = "";
                $close_button_position_script = "
                setTimeout(function(){
                    var aysConteiner       = parseInt(".$ays_pb_height.");
                    var h2Height           = $(document).find('.ays-pb-modal_".$id." h2').outerHeight(true);
                    var hrHeight           = $(document).find('.ays-pb-modal_".$id." hr').outerHeight(true);
                    var descriptionHeight  = $(document).find('.ays-pb-modal_".$id." .ays_pb_description').outerHeight(true);
                    var timerHeight        = $(document).find('.ays-pb-modal_".$id." .ays_pb_timer_".$id."').outerHeight(true);
                    var customHtml         = $(document).find('.ays-pb-modal_".$id." .ays_content_box').outerHeight(true);

                     if(h2Height == undefined){
                        h2Height = 0;
                     }
                     if(hrHeight == undefined){
                        hrHeight = 0;
                     }
                     if(descriptionHeight == undefined){
                        descriptionHeight = 0;
                     }
                     if(timerHeight == undefined){
                        timerHeight = 0;
                     }
                     if(customHtml == undefined){
                        customHtml = 0;
                     }
                    var aysConteinerHeight = (h2Height + descriptionHeight + timerHeight + customHtml + hrHeight + 40);
                    if(aysConteinerHeight < aysConteiner){
                        if('".$ays_pb_full_screen."' == 'on'){
                            aysConteinerHeight =  (aysConteiner + 75) + 'px';
                        }else{
                            aysConteinerHeight =  (aysConteiner) + 'px';
                        }
                    }
                    $(document).find('.ays-pb-modal_".$id." .ays-pb-modal-close_".$id."').css({'top': aysConteinerHeight, 'left': '10px'});
                },200);";
                break;
            case "right-bottom":
                $close_button_position = "";
                $close_button_position_script = "
                setTimeout(function(){
                    var aysConteiner       = parseInt(".$ays_pb_height.");
                    var h2Height           = $(document).find('.ays-pb-modal_".$id." h2').outerHeight(true);
                    var hrHeight           = $(document).find('.ays-pb-modal_".$id." hr').outerHeight(true);
                    var descriptionHeight  = $(document).find('.ays-pb-modal_".$id." .ays_pb_description').outerHeight(true);
                    var timerHeight        = $(document).find('.ays-pb-modal_".$id." .ays_pb_timer_".$id."').outerHeight(true);
                    var customHtml         = $(document).find('.ays-pb-modal_".$id." .ays_content_box').outerHeight(true);
                    if(h2Height == undefined){
                        h2Height = 0;
                    }
                    if(hrHeight == undefined){
                        hrHeight = 0;
                    }
                    if(descriptionHeight == undefined){
                        descriptionHeight = 0;
                    }
                    if(timerHeight == undefined){
                        timerHeight = 0;
                    }
                    if(customHtml == undefined){
                        customHtml = 0;
                    }
                    var aysConteinerHeight = (h2Height + descriptionHeight + timerHeight + hrHeight + customHtml + 40);
                    
                    if(aysConteinerHeight < aysConteiner){
                        if('".$ays_pb_full_screen."' == 'on'){
                            aysConteinerHeight =  (aysConteiner + 75) + 'px';
                        }else{
                            aysConteinerHeight =  (aysConteiner) + 'px';
                        }
                    }
                    $(document).find('.ays-pb-modal_".$id." .ays-pb-modal-close_".$id."').css({'top': aysConteinerHeight, 'right': '10px'});
                },100);";
                break;
            default:
                $close_button_position = "top: 10px; right: 4%;";
                $close_button_position_script = "";
        }
        
        if($ays_pb_title != ''  && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if(intval($ays_pb_delay) == 0 && intval($ays_pb_scroll_top) == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        //popup width percentage
        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
            $pb_width = '100%';
            $ays_pb_height = 'auto';
        }else{
            $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
            $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        //popup padding percentage
        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
        

        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';

        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }

        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }

        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        $ays_social_links = '';

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        //close button size 
        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                            ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }

        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }
        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");
        
        //Close button color
        $close_button_color = (isset($options->close_button_color) && $options->close_button_color != "") ? esc_attr( stripslashes( $options->close_button_color ) ) : $ays_pb_textcolor;

        //Close button hover color
        $close_button_color = (isset($options->close_button_color) && $options->close_button_color != "") ? esc_attr( stripslashes( $options->close_button_color ) ) : $ays_pb_textcolor;

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $popupbox_view = "
                <div class='ays-pb-modal ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open." ".$ays_pb_disable_scroll_on_popup_class."' {$ays_pb_flag} style='{$ays_pb_bg_image};width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px  $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};{$box_shadow};' >
                    $ays_pb_sound_mute
                    $ays_pb_title
                    $ays_pb_description".
             (($show_desc !== "On" && $show_title !== "On") ?  '' :  '<hr/>')
                    
                    ."<div class='ays_content_box' style='padding: {$pb_padding}'>".
                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                    ."</div>
                    {$ays_social_links}
                    <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                        <button id='ays_pb_dismiss_ad'>
                            ".$enable_dismiss_text."
                        </button>
                    </div>
                    $ays_pb_timer_desc
                    <label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close ".$closeButton." ays-pb-modal-close_".$id." ays-pb-close-button-delay ays_pb_pause_sound_".$id."' style='color: $close_button_color !important; font-family:$ays_pb_font_family;{$close_button_position};transform:scale({$close_btn_size})' data-toggle='tooltip' title='$ays_pb_close_button_hover_text'>". $ays_pb_close_button_text ."</label>
                </div>
                <script>
                    (function($){
                        ".$close_button_position_script."
                    })(jQuery);
                </script>";

		return $popupbox_view;
	}

    public function ays_pb_template_macos($attr){
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;
        
        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }
        
        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';
        
        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        $pb_title_text_shadow_x_offset = (isset($options->pb_title_text_shadow_x_offset) && $options->pb_title_text_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_x_offset ) ) : 2;

        $pb_title_text_shadow_y_offset = (isset($options->pb_title_text_shadow_y_offset) && $options->pb_title_text_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_y_offset ) ) : 2;

        $pb_title_text_shadow_z_offset = (isset($options->pb_title_text_shadow_z_offset) && $options->pb_title_text_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_z_offset ) ) : 0;
        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: '.$pb_title_text_shadow_x_offset.'px '.$pb_title_text_shadow_y_offset.'px '.$pb_title_text_shadow_z_offset.'px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";
        
        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        
        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '.$pb_bg_image_sizing.';
                                background-position: '. $pb_bg_image_position .';';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != ''   && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }

        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }
        
        //popup width percentage
        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }        

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'> $ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size): '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }

        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }
        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $mac_view = "<div class='ays_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open." ".$ays_pb_disable_scroll_on_popup_class."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; {$ays_pb_bg_image}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};{$box_shadow}'>
                         <div class='ays_topBar'>
                            <div class='".$closeButton."' data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>
                            <label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close ays_close ays-pb-modal-close_".$id." ays-pb-close-button-delay ays_pb_pause_sound_".$id."'></label>
                            </div>
                            <div>
                            <a class='ays_hide'></a>
                            </div>
                            <div>
                            <a class='ays_fullScreen'></a>
                            </div>
                            $ays_pb_title
                         </div> 
                            $ays_pb_description                   
                         <hr/>
                         <div class='ays_text'>
                         $ays_pb_sound_mute
                            <div class='ays_text-inner'>
                                <div class='ays_content_box' style='padding: {$pb_padding}'>".
                                    (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                ."</div>
                            </div>
                         </div>  
                         {$ays_social_links}  
                         <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                            <button id='ays_pb_dismiss_ad'>
                                ".$enable_dismiss_text."
                            </button>
                        </div>            
                         $ays_pb_timer_desc
                    </div>
                <script>
                (function($){
                    $('.ays_hide').on('click', function() {
                      $('.ays_window').css({
                        height: '{$ays_pb_height}px',
                        width: '{$pb_width}',
                        padding: '{$pb_padding}'
                      });
                    });

                    $('.ays_fullScreen').on('click', function() {
                      $('.ays_window').css({
                        height: '100vh',
                        width: '100vw',
                      });
                    });
                })(jQuery);
                </script>";
        return $mac_view;
    }
    
    public function ays_pb_template_cmd($attr){        
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;


        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        $pb_title_text_shadow_x_offset = (isset($options->pb_title_text_shadow_x_offset) && $options->pb_title_text_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_x_offset ) ) : 2;

        $pb_title_text_shadow_y_offset = (isset($options->pb_title_text_shadow_y_offset) && $options->pb_title_text_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_y_offset ) ) : 2;

        $pb_title_text_shadow_z_offset = (isset($options->pb_title_text_shadow_z_offset) && $options->pb_title_text_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_z_offset ) ) : 0;
        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: '.$pb_title_text_shadow_x_offset.'px '.$pb_title_text_shadow_y_offset.'px '.$pb_title_text_shadow_z_offset.'px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";
        
        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '.$pb_bg_image_sizing.';
                                background-position: '. $pb_bg_image_position .';';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != ''  && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }
        
        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }

        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }

        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }

        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }

        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';
       
        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }

        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }
        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $cmd_view = "<div class='ays_cmd_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open." ".$ays_pb_disable_scroll_on_popup_class."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; {$ays_pb_bg_image};  color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};{$box_shadow} !important;'>
                        <header class='ays_cmd_window-header'>
                            <div class='ays_cmd_window_title'>$ays_pb_title</div>
                            <nav class='ays_cmd_window-controls'>
                                <!--<span class='ays_cmd_control-item ays_cmd_control-minimize ays_cmd_js-minimize'>‒</span>
                                <span class='ays_cmd_control-item ays_cmd_control-maximize ays_cmd_js-maximize'>□</span>
                                <label for='ays-pb-modal-checkbox_".$id."' class='ays_cmd_control-item ays_cmd_control-close ays-pb-modal-close_".$id."'><span class='ays_cmd_control-item ays_cmd_control-close ays_cmd_js-close'>˟</span></label>-->
                                <ul class='ays_cmd_window-controls-ul'>
                                    <li><span class='ays_cmd_control-item ays_cmd_control-minimize ays_cmd_js-minimize'>‒</span></li>
                                    <li><span class='ays_cmd_control-item ays_cmd_control-maximize ays_cmd_js-maximize'>□</span></li>
                                    <li><label for='ays-pb-modal-checkbox_".$id."' class='ays_cmd_control-item ".$closeButton." ays_cmd_control-close ays-pb-modal-close_".$id." ays-pb-close-button-delay' data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'><span class='ays_cmd_control-item ays_cmd_control-close ays_cmd_js-close ays_pb_pause_sound_".$id."'>x</span></label></li>
                                </ul>
                            </nav>
                        </header>
                        <div class='ays_cmd_window-cursor'>
                            <span class='ays_cmd_i-cursor-indicator'>></span>
                            <span class='ays_cmd_i-cursor-underscore'></span>
                            <input type='text' disabled class='ays_cmd_window-input ays_cmd_js-prompt-input' />
                        </div>
                        $ays_pb_description
                        $ays_pb_sound_mute
                        <main class='ays_cmd_window-content'>
                            <div class='ays_text'>
                                <div class='ays_text-inner'>
                                <div class='ays_content_box' style='padding: {$pb_padding}'>".
                                    (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                ."</div>
                                </div>
                             </div>             
                             {$ays_social_links} 
                            <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                <button id='ays_pb_dismiss_ad'>
                                    ".$enable_dismiss_text."
                                </button>
                            </div>           
                             $ays_pb_timer_desc
                        </main>
                    </div>
                    <script>
                        (function($){
                            var prompt = {
                                window: $('.ays_cmd_window,.ays_window'),
                                shortcut: $('.ays_cmd_prompt-shortcut'),
                                input: $('.ays_cmd_js-prompt-input'),

                                init: function() {
                                    $('.ays_cmd_js-minimize').click(prompt.minimize);
                                    $('.ays_cmd_window_title').click(prompt.minimize);
                                    $('.ays_cmd_js-maximize').click(prompt.maximize);
                                    $('.ays_cmd_js-close').click(prompt.close);
                                    $('.ays_cmd_js-open').click(prompt.open);
                                    prompt.input.focus();
                                    prompt.input.blur(prompt.focus);
                                },
                                    focus: function() {
                                    prompt.input.focus();
                                },
                                minimize: function() {        
                                    prompt.window.removeClass('ays_cmd_window--maximized');
                                    prompt.window.toggleClass('ays_cmd_window--minimized');
                                },
                                maximize: function() {
                                    prompt.window.removeClass('ays_cmd_window--minimized');
                                    prompt.window.toggleClass('ays_cmd_window--maximized');
                                    prompt.focus();
                                    $(document).find('.ays_cmd_window,.ays_window').css('bottom', 0);
                                },
                                close: function() {
                                    prompt.window.addClass('ays_cmd_window--destroyed');
                                    prompt.window.removeClass('ays_cmd_window--maximized ays_cmd_window--minimized');
                                    prompt.shortcut.removeClass('ays_cmd_hidden');
                                    prompt.input.val('');
                                },
                                open: function() {
                                    prompt.window.removeClass('ays_cmd_window--destroyed');
                                    prompt.shortcut.addClass('ays_cmd_hidden');
                                    prompt.focus();
                                }
                            };
                            $(document).ready(prompt.init);
                        })(jQuery);
                    </script>";
        return $cmd_view;
    }   

    public function ays_pb_template_ubuntu($attr){        
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;


        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        $pb_title_text_shadow_x_offset = (isset($options->pb_title_text_shadow_x_offset) && $options->pb_title_text_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_x_offset ) ) : 2;

        $pb_title_text_shadow_y_offset = (isset($options->pb_title_text_shadow_y_offset) && $options->pb_title_text_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_y_offset ) ) : 2;

        $pb_title_text_shadow_z_offset = (isset($options->pb_title_text_shadow_z_offset) && $options->pb_title_text_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_z_offset ) ) : 0;
        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: '.$pb_title_text_shadow_x_offset.'px '.$pb_title_text_shadow_y_offset.'px '.$pb_title_text_shadow_z_offset.'px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '.$pb_bg_image_sizing.';
                                background-position: '. $pb_bg_image_position .';';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }

        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }
        

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size): '1';
        
        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }

        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $ubuntu_view = "<div class='ays_ubuntu_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open." ".$ays_pb_disable_scroll_on_popup_class."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; {$ays_pb_bg_image};  background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};{$box_shadow}'>
                      <div class='ays_ubuntu_topbar'>
                        <div class='ays_ubuntu_icons'>
                          <div class='ays_ubuntu_close  ".$closeButton." ays-pb-close-button-delay' data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>
                            <label for='ays-pb-modal-checkbox_".$id."' class='ays_ubuntu_close ays-pb-modal-close_".$id." ays_pb_pause_sound_".$id."'></label>
                          </div>
                          <div class='ays_ubuntu_hide'></div>
                          <div class='ays_ubuntu_maximize'></div>
                        </div>
                        $ays_pb_title
                      </div>
                      <div class='ays_ubuntu_tools'>
                        <ul>
                            <li>".__("File")."</li>
                            <li>".__("Edit", "ays-popup-box")."</li>
                            <li>".__("Go", "ays-popup-box")."</li>
                            <li>".__("Bookmarks", "ays-popup-box")."</li>
                            <li>".__("Tools", "ays-popup-box")."</li>
                            <li>".__("Help", "ays-popup-box")."</li>
                        </ul>
                      </div>
                      $ays_pb_sound_mute
                      
                      <div class='ays_ubuntu_window_content'>
                            $ays_pb_description".
            (($show_desc !== "On") ?  '' :  '<hr/>')
                            ."<div class='ays_content_box' style='padding: {$pb_padding}';>".
                                (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                            ."</div>
                            {$ays_social_links}
                            <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                <button id='ays_pb_dismiss_ad'>
                                    ".$enable_dismiss_text."
                                </button>
                            </div>
                      </div>
                      <div class='ays_ubuntu_folder-info ays_pb_timer_".$id."'>
                      $ays_pb_timer_desc
                      </div>
                    </div>
                    <script>
                        (function($){
                            var prompt = {
                                window: $('.ays_ubuntu_window'),

                                init: function() {
                                    $('.ays_ubuntu_hide').click(prompt.minimize);
                                    $('.ays_ubuntu_maximize').click(prompt.maximize);
                                },
                                minimize: function() {        
                                    prompt.window.removeClass('ays_ubuntu_window--maximized');
                                    prompt.window.toggleClass('ays_ubuntu_window--minimized');
                                },
                                maximize: function() {
                                    prompt.window.removeClass('ays_ubuntu_window--minimized');
                                    prompt.window.toggleClass('ays_ubuntu_window--maximized');
                                    $(document).find('.ays_ubuntu_window').css('bottom', 0);
                                }
                            };
                            $(document).ready(prompt.init);
                        })(jQuery);
                    </script>";
        return $ubuntu_view;
    }   

    public function ays_pb_template_winxp($attr){
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        $pb_title_text_shadow_x_offset = (isset($options->pb_title_text_shadow_x_offset) && $options->pb_title_text_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_x_offset ) ) : 2;

        $pb_title_text_shadow_y_offset = (isset($options->pb_title_text_shadow_y_offset) && $options->pb_title_text_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_y_offset ) ) : 2;

        $pb_title_text_shadow_z_offset = (isset($options->pb_title_text_shadow_z_offset) && $options->pb_title_text_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_z_offset ) ) : 0;
        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: '.$pb_title_text_shadow_x_offset.'px '.$pb_title_text_shadow_y_offset.'px '.$pb_title_text_shadow_z_offset.'px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }
        
        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '.$pb_bg_image_sizing.';
                                background-position: '. $pb_bg_image_position .';';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != '' && $show_title == "On"){
           // $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;'>$ays_pb_title</h2>";
            $ays_pb_title = "<h2 style='color: white !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }

        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        $x_close_button = '<svg xmlns="https://www.w3.org/2000/svg" height="24px" viewBox="0 0 32 32" width="24px" fill="#ffffff" alt="Pop-up Close"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $ubuntu_view = "<div class='ays_winxp_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open." ".$ays_pb_disable_scroll_on_popup_class."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};{$box_shadow};'>
                            <div class='ays_winxp_title-bar'>
                                <div class='ays_winxp_title-bar-title'>
                                    $ays_pb_title
                                </div>
                                <div class='ays_winxp_title-bar-close ".$closeButton." ays-pb-close-button-delay' data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>
                                    <label for='ays-pb-modal-checkbox_".$id."' class='ays_winxp_close  ays-pb-modal-close_".$id." ays_pb_pause_sound_".$id."'>".$x_close_button."</label>
                                </div>
                                <div class='ays_winxp_title-bar-max ays_pb_fa ays_pb_far far' aria-hidden='true'>
                                    <img src='" .  AYS_PB_ADMIN_URL . "/images/icons/window-maximize.svg'>
                                </div>
                                <div class='ays_winxp_title-bar-min'></div>
                            </div>
                            <div class='ays_winxp_content' style='background-color: $ays_pb_bgcolor; {$ays_pb_bg_image}; '>
                                $ays_pb_sound_mute
                                <div>
                                    $ays_pb_description".
            (($show_title !== "On") ?  '' :  '<hr/>')
                                ."</div>
                                <div class='ays_content_box' style='padding: {$pb_padding}'>".
                                    (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                ."</div>
                                {$ays_social_links}
                                <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                    <button id='ays_pb_dismiss_ad'>
                                        ".$enable_dismiss_text."
                                    </button>
                                </div>
                                $ays_pb_timer_desc
                            </div>
                      </div>
                    <script>
                        (function($){
                            var prompt = {
                                window: $('.ays_winxp_window'),

                                init: function() {
                                    $('.ays_winxp_title-bar-min').click(prompt.minimize);
                                    $('.ays_winxp_title-bar-max').click(prompt.maximize);
                                },
                                minimize: function() {        
                                    prompt.window.removeClass('ays_winxp_window--maximized');
                                    prompt.window.toggleClass('ays_winxp_window--minimized');
                                },
                                maximize: function() {
                                    prompt.window.removeClass('ays_winxp_window--minimized');
                                    prompt.window.toggleClass('ays_winxp_window--maximized');
                                    $(document).find('.ays_winxp_window').css('bottom', 0);
                                }
                            };
                            $(document).ready(prompt.init);
                        })(jQuery);
                    </script>";
        return $ubuntu_view;
    }  

    public function ays_pb_template_win98($attr){        
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        $pb_title_text_shadow_x_offset = (isset($options->pb_title_text_shadow_x_offset) && $options->pb_title_text_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_x_offset ) ) : 2;

        $pb_title_text_shadow_y_offset = (isset($options->pb_title_text_shadow_y_offset) && $options->pb_title_text_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_y_offset ) ) : 2;

        $pb_title_text_shadow_z_offset = (isset($options->pb_title_text_shadow_z_offset) && $options->pb_title_text_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_z_offset ) ) : 0;
        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: '.$pb_title_text_shadow_x_offset.'px '.$pb_title_text_shadow_y_offset.'px '.$pb_title_text_shadow_z_offset.'px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";
        
        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        if($ays_pb_close_button_val === 'x'){
            $ays_pb_close_button_text = 'x';
        }else{
            $ays_pb_close_button_text = $ays_pb_close_button_val;
        }

        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '.$pb_bg_image_sizing.';
                                background-position: '. $pb_bg_image_position .';';
        } elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: white !important;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
           if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            } 
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }
        
        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }

        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $ubuntu_view = "<div class='ays_win98_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open." ".$ays_pb_disable_scroll_on_popup_class."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; padding: {$pb_padding}; background-color: $ays_pb_bgcolor; {$ays_pb_bg_image};  color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};{$box_shadow};'>
                            <header class='ays_win98_head' style='background-color: $ays_pb_bgcolor;'>
                                <div class='ays_win98_header'>
                                    <div class='ays_win98_title'>
                                        $ays_pb_title
                                    </div>
                                    <div class='ays_win98_btn-close ".$closeButton." ays-pb-close-button-delay'  data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays_pb_pause_sound_".$id."'><span >". $ays_pb_close_button_text ."</span></label></div>
                                </div>
                            </header>
                            <div class='ays_win98_main'>
                                $ays_pb_sound_mute
                                <div class='ays_win98_content'>
                                    $ays_pb_description".
            (($show_title !== "On") ?  '' :  '<hr/>')
            ."                               
                                    <div class='ays_content_box' style='padding: {$pb_padding}'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                    ."</div>
                                    {$ays_social_links}
                                    <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                        <button id='ays_pb_dismiss_ad'>
                                            ".$enable_dismiss_text."
                                        </button>
                                    </div>
                                    $ays_pb_timer_desc
                                </div>
                            </div>
                        </div>";
        return $ubuntu_view;
    }

    public function ays_pb_template_lil($attr){

        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        $pb_title_text_shadow_x_offset = (isset($options->pb_title_text_shadow_x_offset) && $options->pb_title_text_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_x_offset ) ) : 2;

        $pb_title_text_shadow_y_offset = (isset($options->pb_title_text_shadow_y_offset) && $options->pb_title_text_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_y_offset ) ) : 2;

        $pb_title_text_shadow_z_offset = (isset($options->pb_title_text_shadow_z_offset) && $options->pb_title_text_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow_z_offset ) ) : 0;
        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: '.$pb_title_text_shadow_x_offset.'px '.$pb_title_text_shadow_y_offset.'px '.$pb_title_text_shadow_z_offset.'px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        $ays_pb_close_button_text = '';
        $close_lil_btn_class = '';
        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        //close button image
        $close_btn_background_img  = (isset($options->close_button_image) && $options->close_button_image != "") ? $options->close_button_image : "";
       
        if(isset($options->close_button_image) && !empty($options->close_button_image)){
            $ays_pb_close_button_text .= "<img class='close_btn_img' src='".$close_btn_background_img."' width='50' height='50'>";
        }else{
            if($ays_pb_close_button_val === 'x'){
                $ays_pb_close_button_text .= 'x';
                $close_lil_btn_class = '';
            }else{
                $ays_pb_close_button_text .= $ays_pb_close_button_val;
                $close_lil_btn_class = 'close-lil-btn-text';
            }
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";

        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '.$pb_bg_image_sizing.';
                                background-position: '. $pb_bg_image_position .';';
        }elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        else{
            $ays_pb_bg_image = '';
        }

        //popup full screen 
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                $close_button_position = "top: 10px; left: 10px;";
                break;
            case "left-bottom":
                if($ays_pb_full_screen == 'on'){

                    $close_button_top = absint(intval($ays_pb_height)) + 58 + (2 * absint(intval($ays_pb_bordersize)));
                }else{
                    
                    $close_button_top = absint(intval($ays_pb_height)) - 38 - (2 * absint(intval($ays_pb_bordersize)));
                }
                $close_button_position = "top: ". $close_button_top ."px; left: 10px;";
                break;
            case "right-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_top = absint(intval($ays_pb_height)) + 58 + (2 * absint(intval($ays_pb_bordersize)));
                }else{
                    $close_button_top = absint(intval($ays_pb_height)) - 38 - (2 * absint(intval($ays_pb_bordersize)));
                }
                $close_button_position = "top: ". $close_button_top ."px; right: 10px; bottom: auto; left: auto;";
                break;
            default:
                $close_button_position = "top: 10px; right: 4%;";
        }


        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }


        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }        

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }

        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");
        
        //Close button color
        $close_button_color = (isset($options->close_button_color) && $options->close_button_color != "") ? esc_attr( stripslashes( $options->close_button_color ) ) : $ays_pb_textcolor;

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $ubuntu_view = "    <div class='ays_lil_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open." ".$ays_pb_disable_scroll_on_popup_class."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px;font-family:{$ays_pb_font_family};{$ays_pb_bg_image};{$box_shadow};'>
                                 <header class='ays_lil_head' style='background-color: ".(($show_title !== "On") ?  "" :  "$ays_pb_header_bgcolor").";'>
                                    $ays_pb_sound_mute
                                    <div class='ays_lil_header'>
                                        <div class='ays_lil_title'>
                                            $ays_pb_title
                                        </div>
                                        <div class='ays_lil_btn-close ".$closeButton." ays-pb-close-button-delay'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id."' ><a class='close-lil-btn ays_pb_pause_sound_".$id." ".$close_lil_btn_class."' style='background-color:".$ays_pb_textcolor." !important; color: ".$close_button_color." ; font-family:{$ays_pb_font_family};{$close_button_position};transform:scale({$close_btn_size})'  data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>". $ays_pb_close_button_text ."</a></label></div>
                                    </div>
                                </header>
                                <div class='ays_lil_main'>
                                    <div class='ays_lil_content'>
                                        $ays_pb_description                           
                                        <div class='ays_content_box' style='padding: {$pb_padding};'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                        ."</div>
                                        {$ays_social_links}
                                        <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                            <button id='ays_pb_dismiss_ad'>
                                                ".$enable_dismiss_text."
                                            </button>
                                        </div>
                                        $ays_pb_timer_desc
                                    </div>
                                </div>
                            </div>";
        return $ubuntu_view;
    }

    public function ays_pb_template_image($attr){

        $ays_pb_bg_image_image_default = 'background-image: url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg");
                                          background-repeat: no-repeat;
                                          background-size: cover;';

        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : $ays_pb_bg_image_image_default;
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: 2px 2px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        $ays_pb_close_button_text = '';
        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        //close button image
        $close_btn_background_img  = (isset($options->close_button_image) && $options->close_button_image != "") ? $options->close_button_image : "";
       
        if(isset($options->close_button_image) && !empty($options->close_button_image)){
            $ays_pb_close_button_text .= "<img class='close_btn_img' src='".$close_btn_background_img."' width='30' height='30'>";
        }else{
            if($ays_pb_close_button_val === 'x'){
                $ays_pb_close_button_text .= 'x';
            }else{
                $ays_pb_close_button_text .= $ays_pb_close_button_val;
            }
        }
        
        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";

        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== '' && $ays_pb_bg_image != $ays_pb_bg_image_image_default){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;';
        }else{
            $ays_pb_bg_image = $ays_pb_bg_image_image_default;
        }

        //popup full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "right:97% !important;";
                }else{
                    $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "left-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: 97% !important;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "right-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: ".(-$ays_pb_bordersize)."px;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; right: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            default:
                $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; right: ".(-$ays_pb_bordersize)."px;";
        }

        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $image_header_height = (($show_title !== "On") ?  "height: 0% !important" :  "");
        $image_content_height = (($image_header_height !== "") ?  "max-height: 98% !important" :  "");

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }
        $ubuntu_view = "";
        
        //pb full screen
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
            $pb_width = '100%';
            $ays_pb_height = 'auto';
            $ubuntu_view .= "
                <style>
                    .ays_image_window .ays_image_main .ays_image_content>p:last-child {
                        position: unset !important;
                    }
                    .close-image-btn {
                        top: 9px !important;
                        right: 20px !important;
                    }
                </style>
           ";
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }
        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='bottom:". (-30 - $ays_pb_bordersize) ."px'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }
        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }

        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $ubuntu_view .= "   <div class='ays_image_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important;font-family:{$ays_pb_font_family}; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px; {$ays_pb_bg_image}; background-size: {$pb_bg_image_sizing}; background-position: {$pb_bg_image_position};{$box_shadow}; animation-fill-mode: forwards;' data-name='modern_minimal'>
                                 <header class='ays_image_head' style='{$image_header_height}'>
                                    <div class='ays_image_header'>
                                        $ays_pb_sound_mute
                                        <div class='ays_popup_image_title'>
                                            $ays_pb_title
                                        </div>
                                        <div class='ays_image_btn-close ".$closeButton."'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays-pb-close-button-delay' ><label class='close-image-btn ays_pb_pause_sound_".$id."' style='color: ".$ays_pb_textcolor." ; font-family:{$ays_pb_font_family};{$close_button_position};transform:scale({$close_btn_size})'  data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>". $ays_pb_close_button_text ."</label></label></div>
                                    </div>
                                </header>
                                <div class='ays_image_main ".$ays_pb_disable_scroll_on_popup_class."' style='{$image_content_height}' >
                                    <div class='ays_image_content'>
                                        $ays_pb_description                           
                                        <div class='ays_content_box' style='padding: {$pb_padding};'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                        ."</div>
                                        {$ays_social_links}
                                        <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                            <button id='ays_pb_dismiss_ad'>
                                                ".$enable_dismiss_text."
                                            </button>
                                        </div>
                                        $ays_pb_timer_desc
                                    </div>
                                </div>
                            </div>";
        return $ubuntu_view;
    }

    public function ays_pb_template_template($attr){

        $ays_pb_bg_image_template_default = 'background-image: url("https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg");
                                             background-repeat: no-repeat;
                                             background-size: cover;';

        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title           		= stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description     		= $attr["description"];
        $ays_pb_bgcolor					= stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor		    = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" )? $attr["bg_image"] : $ays_pb_bg_image_template_default;
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: 2px 2px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }        

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        $ays_pb_close_button_text = '';
        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        //close button image
        $close_btn_background_img  = (isset($options->close_button_image) && $options->close_button_image != "") ? $options->close_button_image : "";
       
        if(isset($options->close_button_image) && !empty($options->close_button_image)){
            $ays_pb_close_button_text .= "<img class='close_btn_img' src='".$close_btn_background_img."' width='30' height='30'>";
        }else{
            if($ays_pb_close_button_val === 'x'){
                $ays_pb_close_button_text .= 'x';
            }else{
                $ays_pb_close_button_text .= $ays_pb_close_button_val;
            }
        }

        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';
        
        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== '' && $ays_pb_bg_image != $ays_pb_bg_image_template_default){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: cover;';
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                $close_button_position = "top: 14px; left: 14px;";
                break;
            case "left-bottom":
                $close_button_position = "bottom: 0; left: 14px;";
                break;
            case "right-bottom":
                $close_button_position = "bottom: 0; right: 14px;";
                break;
            default:
                $close_button_position = "top: 14px; right: 14px;";
        }

        if ($background_gradient == 'on') {
            $bg_gradient_container = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
            $ays_pb_bgcolor = "transparent";
        } else {
            $bg_gradient_container = "unset";
        }

        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }
        
        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $header_height = (($show_title !== "On") ?  "height: 0px !important" :  "");
        $calck_template_fotter = (($show_title !== "On") ? "height: 100%;" :  "");

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }

        //pb full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
           $pb_width = '100%';
           $ays_pb_height = 'auto';
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '20';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '20px';
        }        

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_template_header_bgcolor = '';
        
        if(substr($ays_pb_header_bgcolor,-2, 1) == '0' && substr($ays_pb_header_bgcolor,-15,4) == 'rgba'){
            $ays_template_header_bgcolor = $ays_pb_bgcolor;
        }else{
            $ays_template_header_bgcolor = $ays_pb_header_bgcolor;
        } 

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }

        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");
        
        //Close button color
        $close_button_color = (isset($options->close_button_color) && $options->close_button_color != "") ? esc_attr( stripslashes( $options->close_button_color ) ) : $ays_pb_textcolor;

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $ubuntu_view = "   <div class='ays_template_window ".$ays_pb_disable_scroll_on_popup_class." ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width};  height: {$pb_height}; color: $ays_pb_textcolor !important; font-family:{$ays_pb_font_family};border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor;{$bg_gradient_container} border-radius: {$ays_pb_border_radius}px; {$box_shadow};'>
                                 <header class='ays_template_head' style='{$header_height};background-color: {$ays_template_header_bgcolor}'>
                                    <div class='ays_template_header'>
                                        <div class='ays_template_title'>
                                            $ays_pb_title
                                        </div>
                                        <div class='ays_template_btn-close ".$closeButton." '>
                                            <label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays-pb-close-button-delay' >
                                                <label class='close-template-btn ays_pb_pause_sound_".$id."' style='color: ".$close_button_color." ;font-family:{$ays_pb_font_family}; {$close_button_position};transform:scale({$close_btn_size})' data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>". $ays_pb_close_button_text ."</label>
                                            </label>
                                        </div>
                                    </div>
                                </header>
                                <footer class='ays_template_footer ' style='background-color: $ays_pb_bgcolor; {$calck_template_fotter} '>
                                    <div class='ays_bg_image_box' style='{$ays_pb_bg_image} background-size: {$pb_bg_image_sizing}; background-position: {$pb_bg_image_position}'></div>
                                    <div class='ays_template_content ' style=''>
                                        $ays_pb_sound_mute
                                        $ays_pb_description 
                                        <div class='ays_content_box ays_template_main ".$ays_pb_disable_scroll_on_popup_class."' style='padding: {$pb_padding};'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                        ."</div>
                                        {$ays_social_links}
                                        <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                            <button id='ays_pb_dismiss_ad'>
                                                ".$enable_dismiss_text."
                                            </button>
                                        </div>
                                        $ays_pb_timer_desc
                                        </div>
                                </footer>
                            </div>";
        return $ubuntu_view;
    }


    public function ays_pb_template_minimal($attr){

        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title                   = stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description             = $attr["description"];
        $ays_pb_bgcolor                 = stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor          = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : stripslashes(esc_attr( $attr["bordercolor"] ));
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";
        $ays_pb_bg_image                = (isset($attr["bg_image"]) && $attr['bg_image'] != "" ) ? $attr["bg_image"] : "";
        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
        $user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';

        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: 2px 2px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }
        
        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        $ays_pb_close_button_text = '';
        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        //close button image
        $close_btn_background_img  = (isset($options->close_button_image) && $options->close_button_image != "") ? $options->close_button_image : "";
       
        if(isset($options->close_button_image) && !empty($options->close_button_image)){
            $ays_pb_close_button_text .= "<img class='close_btn_img' src='".$close_btn_background_img."' width='30' height='30'>";
        }else{
            if($ays_pb_close_button_val === 'x'){
                $ays_pb_close_button_text .= $this->close_circle_icon;
            }else{
                $ays_pb_close_button_text .= $ays_pb_close_button_val;
            }
        }

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";

        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';
        

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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
        if($ays_pb_bg_image !== ''){
            $ays_pb_bg_image = 'background-image: url('.$ays_pb_bg_image.');
                                background-repeat: no-repeat;
                                background-size: '. $pb_bg_image_sizing .';
                                background-position: '. $pb_bg_image_position .';';
        }elseif ($background_gradient == 'on' && $ays_pb_bg_image == '') {
            $ays_pb_bg_image = "background-image: linear-gradient(".$pb_gradient_direction.",".$background_gradient_color_1.",".$background_gradient_color_2.");";
        }
        else{
            $ays_pb_bg_image = '';
        }




        //popup full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "right:97% !important;";
                }else{
                    $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "left-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: 97% !important;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "right-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: ".(-$ays_pb_bordersize)."px;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; right: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            default:
                $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; right: ".(-$ays_pb_bordersize)."px;";
        }

        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $image_header_height = (($show_title !== "On") ?  "height: 0% !important" :  "");
        $image_content_height = (($image_header_height !== "") ?  "max-height: 100% !important" :  "");

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }
        $ubuntu_view = "";
        
        //pb full screen
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
            $pb_width = '100%';
            $ays_pb_height = 'auto';
            $ubuntu_view .= "
                <style>
                    .ays_minimal_window .ays_minimal_main .ays_minimal_content>p:last-child {
                        position: unset !important;
                    }
                    .close-minimal-btn {
                        top: 9px !important;
                        right: 20px !important;
                    }
                </style>
           ";
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        $ays_pb_padding = (isset($options->popup_content_padding) && $options->popup_content_padding != '') ? $options->popup_content_padding : '0';
        //popup padding percentage
        $popup_padding_by_percentage_px = (isset($options->popup_padding_by_percentage_px) && $options->popup_padding_by_percentage_px != '') ? $options->popup_padding_by_percentage_px : 'pixels';
        if(isset($ays_pb_padding) && $ays_pb_padding != ''){
            if ($popup_padding_by_percentage_px && $popup_padding_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_padding)) > 100 ) {
                    $pb_padding = '100%';
                }else{
                    $pb_padding = $ays_pb_padding . '%';
                }
            }else{
                $pb_padding = $ays_pb_padding . 'px';
            }
        }else{
            $pb_padding = '0';
        }        

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';
    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='bottom:". (-30 - $ays_pb_bordersize) ."px'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }

        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        }

        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        //Disabel scroll on popup
        $options->disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup != '' ) ? $options->disable_scroll_on_popup : 'off';
        $ays_pb_disable_scroll_on_popup = ( isset( $options->disable_scroll_on_popup ) && $options->disable_scroll_on_popup == 'on' ) ? true : false;

        $ays_pb_disable_scroll_on_popup_class = '';
        if($ays_pb_disable_scroll_on_popup){
            $ays_pb_disable_scroll_on_popup_class = 'ays-pb-disable-scroll-on-popup';
        }

        $ubuntu_view .= "   <div class='ays_minimal_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important;font-family:{$ays_pb_font_family}; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px; {$ays_pb_bg_image};{$box_shadow};' data-name='modern_minimal'>
                                 <header class='ays_minimal_head' style='{$image_header_height}'>
                                    <div class='ays_minimal_header'>
                                        $ays_pb_sound_mute
                                        <div class='ays_popup_minimal_title'>
                                            $ays_pb_title
                                        </div>
                                        <div class='ays_minimal_btn-close ".$closeButton."'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays-pb-close-button-delay' ><label class='close-minimal-btn ays_pb_pause_sound_".$id."' style='color: ".$ays_pb_textcolor." ; font-family:{$ays_pb_font_family};{$close_button_position};transform:scale({$close_btn_size})'  data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>". $ays_pb_close_button_text ."</label></label></div>
                                    </div>
                                </header>
                                <div class='ays_minimal_main ".$ays_pb_disable_scroll_on_popup_class."' style='{$image_content_height}' >
                                    <div class='ays_minimal_content'>
                                        $ays_pb_description                           
                                        <div class='ays_content_box' style='padding: {$pb_padding};'>".
                                        (($ays_pb_modal_content == 'shortcode') ? do_shortcode($ays_pb_shortcode) : Ays_Pb_Public::ays_autoembed($ays_pb_custom_html))
                                        ."</div>
                                        {$ays_social_links}
                                        <div class='ays-pb-dismiss-ad {$show_dismiss}' data-dismiss='' data-id='{$id}'>
                                            <button id='ays_pb_dismiss_ad'>
                                                ".$enable_dismiss_text."
                                            </button>
                                        </div>
                                        $ays_pb_timer_desc
                                    </div>
                                </div>
                            </div>";
        return $ubuntu_view;
    }

    public function ays_pb_template_video($attr){
        $id                             = $attr['id'];
        $ays_pb_shortcode               = $attr["shortcode"];
        $ays_pb_width                   = $attr["width"];
        $ays_pb_height                  = $attr["height"];
        $ays_pb_autoclose               = $attr["autoclose"];
        $ays_pb_title                   = stripslashes(esc_attr( $attr["title"] ));
        $ays_pb_description             = $attr["description"];
        $ays_pb_bgcolor                 = stripslashes(esc_attr( $attr["bgcolor"] ));
        $ays_pb_header_bgcolor          = $attr["header_bgcolor"];
        $ays_pb_animate_in              = $attr["animate_in"];
        $show_desc                      = $attr["show_popup_desc"];
        $show_title                     = $attr["show_popup_title"];
        $closeButton                    = $attr["close_button"];
        $ays_pb_custom_html             = $attr["custom_html"];
        $ays_pb_action_buttons_type     = $attr["action_button_type"];
        $ays_pb_modal_content           = $attr["modal_content"];
        $ays_pb_delay                   = intval($attr["delay"]);
        $ays_pb_scroll_top              = intval($attr["scroll_top"]);
        $ays_pb_textcolor               = (!isset($attr["textcolor"])) ? "#000000" : stripslashes(esc_attr( $attr["textcolor"] ));
        $ays_pb_bordersize              = (!isset($attr["bordersize"])) ? 0 : $attr["bordersize"];
        $ays_pb_bordercolor             = (!isset($attr["bordercolor"])) ? "#000000" : $attr["bordercolor"];
        $ays_pb_border_radius           = (!isset($attr["border_radius"])) ? "4" : $attr["border_radius"];
        $custom_class                   = (isset($attr['custom_class']) && $attr['custom_class'] != "") ? $attr['custom_class'] : "";

        $ays_pb_delay_second            = (isset($ays_pb_delay) && ! empty($ays_pb_delay) && $ays_pb_delay > 0) ? ($ays_pb_delay / 1000) : 0;

        $options = (object)array();
        if ($attr['options'] != '' || $attr['options'] != null) {
            $options = json_decode($attr['options']);
        }

        $user_data = wp_get_current_user();

        $user_display_name = ( isset( $user_data->display_name ) && $user_data->display_name != '' ) ? stripslashes( $user_data->display_name ) : '';

        $user_email = ( isset( $user_data->user_email ) && $user_data->user_email != '' ) ? stripslashes( $user_data->user_email ) : '';

        $pb_user_information = Ays_Pb_Data::get_user_profile_data();
		$user_first_name = (isset( $pb_user_information['user_first_name'] ) && $pb_user_information['user_first_name']  != "") ? $pb_user_information['user_first_name'] : '';	
		$user_last_name = (isset( $pb_user_information['user_last_name'] ) && $pb_user_information['user_last_name']  != "") ? $pb_user_information['user_last_name'] : '';
		$user_wordpress_roles = (isset( $pb_user_information['user_wordpress_roles'] ) && $pb_user_information['user_wordpress_roles']  != "") ? $pb_user_information['user_wordpress_roles'] : '';
        $user_nickname = (isset( $pb_user_information['user_nickname'] ) && $pb_user_information['user_nickname']  != "") ? $pb_user_information['user_nickname'] : '';
        
        $author = ( isset( $options->author ) && $options->author != "" ) ? json_decode( $options->author ) : '';
        $current_popup_author = ( isset( $author->name ) && $author->name != "" ) ? $author->name : '';

        $creation_date = ( isset( $options->create_date ) && $options->create_date != "" ) ? date_i18n( get_option( 'date_format' ), strtotime( $options->create_date ) ) : '';

        $message_data = array(
            'popup_title'            => $ays_pb_title,
            'user_name'              => $user_display_name,
            'user_email'             => $user_email,
            'user_first_name'        => $user_first_name,
            'user_last_name'         => $user_last_name,
            'current_popup_author'   => $current_popup_author,
            'user_wordpress_roles'   => $user_wordpress_roles,
            'creation_date'          => $creation_date,
            'user_nickname'          => $user_nickname,        );

        $ays_pb_custom_html = Ays_Pb_Data::replace_message_variables( $ays_pb_custom_html, $message_data );

        // Titile text shadow
        $options->enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? 'on' : 'off'; 
        $enable_pb_title_text_shadow = (isset($options->enable_pb_title_text_shadow) && $options->enable_pb_title_text_shadow == 'on') ? true : false; 
        $pb_title_text_shadow = (isset($options->pb_title_text_shadow) && $options->pb_title_text_shadow != '') ? stripslashes( esc_attr( $options->pb_title_text_shadow ) ) : 'rgba(255,255,255,0)';

        if( $enable_pb_title_text_shadow ){
            $title_text_shadow = 'text-shadow: 2px 2px '.$pb_title_text_shadow;
        }else{
            $title_text_shadow = "";
        }

        // Box shadow
        $options->enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? 'on' : 'off'; 
        $enable_box_shadow = (isset($options->enable_box_shadow) && $options->enable_box_shadow == 'on') ? true : false; 
        $pb_box_shadow = (isset($options->box_shadow_color) && $options->box_shadow_color != '') ? stripslashes( esc_attr( $options->box_shadow_color ) ) : '#000';

        $pb_box_shadow_x_offset = (isset($options->pb_box_shadow_x_offset) && $options->pb_box_shadow_x_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_x_offset ) ) : 2;

        $pb_box_shadow_y_offset = (isset($options->pb_box_shadow_y_offset) && $options->pb_box_shadow_y_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_y_offset ) ) : 2;

        $pb_box_shadow_z_offset = (isset($options->pb_box_shadow_z_offset) && $options->pb_box_shadow_z_offset != '') ? stripslashes( esc_attr( $options->pb_box_shadow_z_offset ) ) : 0;
        if( $enable_box_shadow ){
            $box_shadow = 'box-shadow: '.$pb_box_shadow_x_offset.'px '.$pb_box_shadow_y_offset.'px '.$pb_box_shadow_z_offset.'px '.$pb_box_shadow;
        }else{
            $box_shadow = "";
        }

        //popup box font-family
        $ays_pb_font_family  = (isset($options->pb_font_family) && $options->pb_font_family != '') ? $options->pb_font_family : '';

        // Font Size 
        $pb_font_size = (isset($options->pb_font_size) && $options->pb_font_size != '') ? absint($options->pb_font_size) : 13;
        $ays_pb_close_button_text = '';
        $ays_pb_close_button_val = (isset($options->close_button_text) && $options->close_button_text != '') ? $options->close_button_text : 'x';
        //close button image
        $close_btn_background_img  = (isset($options->close_button_image) && $options->close_button_image != "") ? $options->close_button_image : "";
       
        if(isset($options->close_button_image) && !empty($options->close_button_image)){
            $ays_pb_close_button_text .= "<img class='close_btn_img' src='".$close_btn_background_img."' width='30' height='30'>";
        }else{
            if($ays_pb_close_button_val === 'x'){
                $ays_pb_close_button_text .= 'x';
            }else{
                $ays_pb_close_button_text .= $ays_pb_close_button_val;
            }
        }

        //close button image
        $autoclose_on_video_completion = (isset($options->enable_autoclose_on_completion) && $options->enable_autoclose_on_completion == 'on') ? 'on' : 'off';

        //close button hover text
        $ays_pb_close_button_hover_text = (isset($options->close_button_hover_text) && $options->close_button_hover_text != '') ? $options->close_button_hover_text : "";
        
        //Bg image position
        $pb_bg_image_position = (isset($options->pb_bg_image_position) && $options->pb_bg_image_position != "") ? str_ireplace('-', ' ', $options->pb_bg_image_position) : 'center center';

        $pb_bg_image_sizing = (isset($options->pb_bg_image_sizing) && $options->pb_bg_image_sizing != "") ? $options->pb_bg_image_sizing : 'cover';

        //Background Gradient
        $background_gradient = (!isset($options->enable_background_gradient)) ? 'off' : $options->enable_background_gradient;
        $pb_gradient_direction = (!isset($options->pb_gradient_direction)) ? 'horizontal' : $options->pb_gradient_direction;
        $background_gradient_color_1 = (!isset($options->background_gradient_color_1)) ? "#000000" : $options->background_gradient_color_1;
        $background_gradient_color_2 = (!isset($options->background_gradient_color_2)) ? "#fff" : $options->background_gradient_color_2;
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

        //popup full screen
        $ays_pb_full_screen  = (isset($options->enable_pb_fullscreen) && $options->enable_pb_fullscreen == 'on') ? 'on' : 'off';

        //Close button position
        $close_button_position = (isset($options->close_button_position) && $options->close_button_position != '') ? $options->close_button_position : 'right-top';
        switch($close_button_position) {
            case "left-top":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "right:97% !important;";
                }else{
                    $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "left-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: 97% !important;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; left: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            case "right-bottom":
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "top: 95% !important; right: ".(-$ays_pb_bordersize)."px;";
                }else{
                    $close_btn_pos = -35 - absint(intval($ays_pb_bordersize));
                    $close_button_position = "bottom: ".$close_btn_pos."px; right: ".(-$ays_pb_bordersize)."px;";
                }
                break;
            default:
                if($ays_pb_full_screen == 'on'){
                    $close_button_position = "right:15px;";
                }else{
                    $close_button_position = "top: ". (-25 - $ays_pb_bordersize) ."px; right: ".(-$ays_pb_bordersize)."px;";
                }
                
        }

        if($ays_pb_title != '' && $show_title == "On"){
            $ays_pb_title = "<h2 style='color: $ays_pb_textcolor !important;font-family:$ays_pb_font_family;{$title_text_shadow}'>$ays_pb_title</h2>";
        } else {$ays_pb_title = "";}

        if ($ays_pb_autoclose > 0) {
            if ($ays_pb_delay != 0 && ($ays_pb_autoclose < $ays_pb_delay_second || $ays_pb_autoclose >= $ays_pb_delay_second) ) {
                $ays_pb_autoclose += floor($ays_pb_delay_second);
            }
        }

        if($ays_pb_description != '' && $show_desc == "On"){
            $content_desktop = Ays_Pb_Public::ays_autoembed( $ays_pb_description );
            $ays_pb_description = "<div class='ays_pb_description' style='font-size:{$pb_font_size}px'>".$content_desktop."</div>";
        }else{
           $ays_pb_description = ""; 
        }
        if($ays_pb_action_buttons_type == 'both' || $ays_pb_action_buttons_type == 'pageLoaded'){
            if($ays_pb_delay == 0 && $ays_pb_scroll_top == 0){
                $ays_pb_animate_in_open = $ays_pb_animate_in;
            }else{
                $ays_pb_animate_in_open = "";
            }
            $ays_pb_flag = "data-ays-flag='false'";
        }
        if($ays_pb_action_buttons_type == 'clickSelector'){
            $ays_pb_animate_in_open = $ays_pb_animate_in;
            $ays_pb_flag = "data-ays-flag='true'";
        }
        if ( $closeButton == "on" ){
            $closeButton = "ays-close-button-on-off";
        } else { $closeButton = ""; }

        $image_header_height = (($show_title !== "On") ?  "height: 0% !important" :  "");
        $image_content_height = (($image_header_height !== "") ?  "max-height: 98% !important" :  "");

        //popup width percentage

        $popup_width_by_percentage_px = (isset($options->popup_width_by_percentage_px) && $options->popup_width_by_percentage_px != '') ? $options->popup_width_by_percentage_px : 'pixels';
        if(isset($ays_pb_width) && $ays_pb_width != ''){
            if ($popup_width_by_percentage_px && $popup_width_by_percentage_px == 'percentage') {
                if (absint(intval($ays_pb_width)) > 100 ) {
                    $pb_width = '100%';
                }else{
                    $pb_width = $ays_pb_width . '%';
                }
            }else{
                $pb_width = $ays_pb_width . 'px';
            }
        }else{
            $pb_width = '100%';
        }
        $ubuntu_view = "";
        
        //pb full screen
        $pb_height = '';
        if($ays_pb_full_screen == 'on'){
            $pb_width = '100%';
            $ays_pb_height = 'auto';
            $ubuntu_view .= "
                <style>
                    .ays_video_window .ays_video_main .ays_video_content>p:last-child {
                        position: unset !important;
                    }
                    .close-video-btn {
                        top: 9px !important;
                        right: 20px !important;
                    }
                </style>
           ";
        }else{
           $pb_width  = $popup_width_by_percentage_px == 'percentage' ? $ays_pb_width . '%' : $ays_pb_width . 'px';
           $pb_height = $ays_pb_height . 'px';
        }

        if($pb_width == '0px' ||  $pb_width == '0%'){       
            $pb_width = '100%';
        }

        if($pb_height == '0px'){       
            $pb_height = '500px';
        }

        //hide timer
        $enable_hide_timer  = (isset($options->enable_hide_timer) && $options->enable_hide_timer == 'on') ? 'on' : 'off';

    
        if($enable_hide_timer == 'on'){
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style='visibility:hidden'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }else{
            $ays_pb_timer_desc = "<p class='ays_pb_timer ays_pb_timer_".$id."' style=' position: absolute; right: 0; left: 0; margin: auto; bottom:". ($ays_pb_bordersize - 50) ."px'>".__("This will close in ", "ays-popup-box")." <span data-seconds='$ays_pb_autoclose' data-ays-seconds='{$attr["autoclose"]}'>$ays_pb_autoclose</span>".__(" seconds", "ays-popup-box")."</p>";
        }

        // Social Media links
        $enable_social_links = (isset($options->enable_social_links) && $options->enable_social_links == "on") ? true : false;
        $social_links = (isset($options->social_links)) ? $options->social_links : array(
            'linkedin_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
            'vkontakte_link' => '',
            'youtube_link' => '',
            'instagram_link' => '',
            'behance_link' => '',
        );
        $ays_social_links_array = array();
        
        if($social_links != ''){
            $social_link_arr = (array)$social_links;
        }else{
            $social_link_arr = $social_links;
        }

        $linkedin_link = isset($social_link_arr['linkedin_link']) && $social_link_arr['linkedin_link'] != '' ? $social_link_arr['linkedin_link'] : '';
        $facebook_link = isset($social_link_arr['facebook_link']) && $social_link_arr['facebook_link'] != '' ? $social_link_arr['facebook_link'] : '';
        $twitter_link = isset($social_link_arr['twitter_link']) && $social_link_arr['twitter_link'] != '' ? $social_link_arr['twitter_link'] : '';
        $vkontakte_link = isset($social_link_arr['vkontakte_link']) && $social_link_arr['vkontakte_link'] != '' ? $social_link_arr['vkontakte_link'] : '';
        $youtube_link = isset($social_link_arr['youtube_link']) && $social_link_arr['youtube_link'] != '' ? $social_link_arr['youtube_link'] : '';
        $instagram_link = isset($social_link_arr['instagram_link']) && $social_link_arr['instagram_link'] != '' ? $social_link_arr['instagram_link'] : '';
        $behance_link = isset($social_link_arr['behance_link']) && $social_link_arr['behance_link'] != '' ? $social_link_arr['behance_link'] : '';
        
        if($linkedin_link != ''){
            $ays_social_links_array['Linkedin']['link'] = $linkedin_link;
            $ays_social_links_array['Linkedin']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/linkedin.svg">';
        }
        if($facebook_link != ''){
            $ays_social_links_array['Facebook']['link'] = $facebook_link;
            $ays_social_links_array['Facebook']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/facebook.svg">';
        }
        if($twitter_link != ''){
            $ays_social_links_array['Twitter']['link'] = $twitter_link;
            $ays_social_links_array['Twitter']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/twitter.svg">';
        }
        if($vkontakte_link != ''){
            $ays_social_links_array['VKontakte']['link'] = $vkontakte_link;
            $ays_social_links_array['VKontakte']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/vk.svg">';
        }
        if($youtube_link != ''){
            $ays_social_links_array['Youtube']['link'] = $youtube_link;
            $ays_social_links_array['Youtube']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/youtube.svg">';
        }
        
        if($instagram_link != ''){
            $ays_social_links_array['Instagram']['link'] = $instagram_link;
            $ays_social_links_array['Instagram']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/instagram.svg">';
        }

        if($behance_link != ''){
            $ays_social_links_array['Behance']['link'] = $behance_link;
            $ays_social_links_array['Behance']['img'] = '<img src="'.AYS_PB_PUBLIC_URL.'/images/icons/behance.svg">';
        }

        $ays_social_links = '';

        // Heading for social buttons
        $social_buttons_heading = (isset($options->social_buttons_heading) && $options->social_buttons_heading != '') ? stripslashes( Ays_Pb_Public::ays_autoembed( $options->social_buttons_heading ) ) : "";

        if($enable_social_links){
            $ays_social_links .= "<div class='ays-pb-social-buttons-content'>";
                $ays_social_links .= "<div class='ays-pb-social-buttons-heading'>".$social_buttons_heading."</div>";
                $ays_social_links .= "<div class='ays-pb-social-shares'>";
                    foreach($ays_social_links_array as $media => $link){
                        $ays_social_links .= "<!-- Branded " . $media . " button -->
                            <a  href='" . $link['link'] . "'
                                target='_blank'
                                title='" . $media . " link'>
                                <div class='ays-pb-share-btn-icon'>".$link['img']."</div>
                            </a>";
                    }
                        
                        // "<!-- Branded Facebook button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-facebook'
                        //     href='" . . "'
                        //     title='Share on Facebook'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>
                        // <!-- Branded Twitter button -->
                        // <a class='ays-share-btn ays-share-btn-branded ays-share-btn-twitter'
                        //     href='" . . "'
                        //     title='Share on Twitter'>
                        //     <span class='ays-share-btn-icon'></span>
                        // </a>";
                $ays_social_links .= "</div>";
            $ays_social_links .= "</div>";
        }
        
        $close_btn_size = (isset($options->close_button_size) && $options->close_button_size != '') ? abs($options->close_button_size) : '1';

        //border style 
        $border_style = (isset($options->border_style) && $options->border_style != '') ? $options->border_style : 'solid';

        $ays_pb_sound_mute = '';

        if($ays_pb_action_buttons_type == 'clickSelector' || $ays_pb_action_buttons_type == 'both'){
            if(isset($options->enable_pb_sound) && $options->enable_pb_sound == "on"){
                $ays_pb_sound_mute .= "<span class='ays_music_sound ays_sound_active'>
                                        ".$this->volume_up_icon."
                                    </span>";
            }else{
                $ays_pb_sound_mute = '';
            }
        }else{
            $ays_pb_sound_mute = '';
        }

        if(isset($options->video_theme_url) && !empty($options->video_theme_url)){
            $ays_pb_video_src = $options->video_theme_url;
        }else{
            $ays_pb_video_src = AYS_PB_ADMIN_URL.'/videos/video_theme.mp4';
        }
        
        //Enable dismiss
        $enable_dismiss = ( isset($options->enable_dismiss) && $options->enable_dismiss == "on" ) ? true : false;
        $show_dismiss = 'ays_pb_display_none';
        if( $enable_dismiss ){
            $show_dismiss = '';
        } 
               
        $enable_dismiss_text = (isset($options->enable_dismiss_text) && $options->enable_dismiss_text != "") ? esc_html(stripslashes($options->enable_dismiss_text)) : __("Dismiss ad", "ays-popup-box");

        $ubuntu_view .= "   <div class='ays_video_window ays-pb-modal_".$id." ".$custom_class." ".$ays_pb_animate_in_open."' {$ays_pb_flag} style='width: {$pb_width}; height: {$pb_height}; background-color: $ays_pb_bgcolor; color: $ays_pb_textcolor !important;font-family:{$ays_pb_font_family}; border: {$ays_pb_bordersize}px $border_style $ays_pb_bordercolor; border-radius: {$ays_pb_border_radius}px; {$box_shadow}; ' data-name='modern_video'>
                                 <header class='ays_video_head'>
                                    <div class='ays_video_header'>
                                        $ays_pb_sound_mute
                                        
                                        <div class='ays_video_btn-close ".$closeButton."'><label for='ays-pb-modal-checkbox_".$id."' class='ays-pb-modal-close_".$id." ays-pb-close-button-delay' ><label class='close-image-btn ays_pb_pause_sound_".$id."' style='color: ".$ays_pb_textcolor." ; font-family:{$ays_pb_font_family};{$close_button_position};transform:scale({$close_btn_size})'  data-toggle='tooltip' title='" . $ays_pb_close_button_hover_text . "'>". $ays_pb_close_button_text ."</label></label></div>
                                    </div>
                                </header>
                                <div class='ays_video_main' >
                                     <div class='ays_video_content'>
                                        <video controls src='".$ays_pb_video_src."' class='wp-video-shortcode' style='border-radius:".$attr['border_radius']."px'></video>
                                        <input type='hidden' class='autoclose_on_video_completion_check' value='".$autoclose_on_video_completion."'>
                                    </div>
                                </div>
                                $ays_pb_timer_desc
                            </div>";
        return $ubuntu_view;
    }
}
