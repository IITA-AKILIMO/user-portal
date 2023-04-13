<?php
if(isset($_GET['ays_pb_tab'])){
    $ays_pb_tab = sanitize_text_field($_GET['ays_pb_tab']);
}else{
    $ays_pb_tab = 'tab1';
}

$args = array(
    'public'   => true
);
$all_post_types = get_post_types( $args, 'objects' );

$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
$heading = '';
$loader_iamge  = '';
$id = ( isset( $_GET['popupbox'] ) ) ? absint( intval( $_GET['popupbox'] ) ) : null;
$user_id = get_current_user_id();
$user = get_userdata($user_id);
$author = array(
    'id' => $user->ID,
    'name' => $user->data->display_name
);
$options = array(
    'enable_background_gradient'  => 'off',
    'background_gradient_color_1' => '#000',
    'background_gradient_color_2' => '#fff',
    'pb_gradient_direction'       => 'vertical',
    'except_types'                => '',
    'except_posts'                => '',
    'close_button_delay'          => '0',
    'enable_pb_sound'             => 'off',
    'overlay_color'               => '#000',
    'animation_speed'             => '1',
    'pb_mobile'                   => 'off',
    'close_button_text'           => 'x',
    'mobile_width'                => '',
    "mobile_height"        	      => '',
    'mobile_max_width'            => '',
    'show_only_once'              => 'off',
    'close_popup_esc'             => 'off',
    'enable_pb_fullscreen'        => 'off',
    'close_button_size'           => '1',
    'close_button_image'          => '',
    'border_style'                => 'solid',
    'ays_pb_hover_show_close_btn' => 'off',
    'disable_scroll'              => 'off',
    'pb_bg_image_position'        => 'center-center',
    'pb_bg_image_sizing'          => 'cover',
    'video_theme_url'             => '',
    'pb_font_size'                => 13,
    'pb_font_size_for_mobile'     => 13,
    'enable_social_links'         => 'off',
    'social_links'                => array(
                                        'linkedin_link' => '',
                                        'facebook_link' => '',
                                        'twitter_link'  => '',
                                        'vkontakte_link'=> ''
                                    ),
    'social_buttons_heading'      => '',
    'enable_pb_title_text_shadow' => 'off',
    'pb_title_text_shadow'        => 'rgba(255,255,255,0)',
    'pb_title_text_shadow_x_offset'      => 2,
    'pb_title_text_shadow_y_offset'      => 2,
    'pb_title_text_shadow_z_offset'      => 0,
    'create_date'                 => current_time( 'mysql' ),
    'author'                      => $author,
    'enable_dismiss'              => 'off',
    'enable_dismiss_text'         => 'Dismiss ad',
    'enable_box_shadow'           => 'off',
    'box_shadow_color'            => '#000',
    'pb_box_shadow_x_offset'      => 0,
    'pb_box_shadow_y_offset'      => 0,
    'pb_box_shadow_z_offset'      => 15,
    'disable_scroll_on_popup'     => 'off',
    'hide_on_pc'                  => 'off',
    'hide_on_tablets'             => 'off',
    'pb_bg_image_direction_on_mobile' => 'on',
    'close_button_color'           => '#000000',
    'ays_pb_close_button_hover_color'=> '#000000',
    'blured_overlay'               => 'off',
);
$popupbox = array(
    "id"            	          => "",
    "title"         	          => "",
    "description"   	          => "Demo Description",
    "category_id"                 => "1",
    "autoclose"  		          => "20",
    "cookie"   			          => "0",
    "width"         	          => "400",
    "height"        	          => "500",
    "shortcode"			          => "",
    "bgcolor"        	          => "#ffffff",
    "header_bgcolor"   	          => "#ffffff",
    "textcolor"        	          => "#000000",
    "bordersize"      	          => "1",
    "bordercolor"     	          => "#ffffff",
    "border_radius"    	          => "4",
    "custom_class"                => "",
    "custom_css"                  => "",
    "custom_html"                 => "Here can be your custom HTML or Shortcode",
    "onoffswitch"                 => "On",
    "show_only_for_author"        => "off",
    "onoffoverlay"                => "On",
    "overlay_opacity"             => "0.5",
    "show_all"                    => "all",
    "delay"                       => "0",
    "scroll_top"                  => "0",
    "animate_in"                  => "fadeIn",
    "animate_out"                 => "fadeOut",
    "action_button"               => "",
    "view_place"                  => "",
    "action_button_type"          => "both",
    'users_role'                  => '',
    "modal_content"               => "",
    "view_type"                   => "default",
    "show_popup_title"            => "off",
    "show_popup_desc"             => "off",
    "close_button"                => "Off",
    "bg_image"                    => "",
    "log_user"                    => "On",
    "guest"                       => "On",
    'active_date_check'           => "off",
    'activeInterval'              => "",
    'deactiveInterval'            => "",
    'activeIntervalSec'           => "",
    'deactiveIntervalSec'         => "",
    "pb_position"                 => "center-center",
    "pb_margin"                   => "0",
    'options'                     => json_encode($options),
);
switch( $action ) {
    case 'add':
        $heading = 'Add new PopupBox';
        $loader_iamge = "<span class='display_none_inp'><img width='20' height='20' src=".AYS_PB_ADMIN_URL."/images/loaders/loading.gif></span>";
        break;
    case 'edit':
        $heading = 'Edit PopupBox';
         $loader_iamge = "<span class='display_none_inp'><img width='20' height='20' src=".AYS_PB_ADMIN_URL."/images/loaders/loading.gif></span>";
        $popupbox = $this->popupbox_obj->get_popupbox_by_id($id);
        break;
    case 'duplicate':
        $heading = 'Duplicate PopupBox';
        $loader_iamge = "<span class='display_none_inp'><img width='20' height='20' src=".AYS_PB_ADMIN_URL."/images/loaders/loading.gif></span>";
        $this->popupbox_obj->duplicate_popupbox($id);
        break;
}

$popup_categories = $this->popupbox_obj->get_popup_categories();
$settings_options = $this->settings_obj->ays_get_setting('options');
if($settings_options){
    $settings_options = json_decode($settings_options, true);
}else{
    $settings_options = array();
}
$ays_pb_sound = (isset($settings_options['ays_pb_sound']) && $settings_options['ays_pb_sound'] != '') ? true : false;
$ays_pb_sound_status = false;
if($ays_pb_sound){
    $ays_pb_sound_status = true;
}

$options = (isset($popupbox['options']) && $popupbox['options'] != "") ? json_decode($popupbox['options'], true) : array();
// Custom class for quiz container
$custom_class = (isset($popupbox['custom_class']) && $popupbox['custom_class'] != "") ? $popupbox['custom_class'] : '';
$users_role   = (isset($popupbox['users_role']) && $popupbox['users_role'] != "") ? json_decode($popupbox['users_role'], true) : array();

// General Settings | options
$gen_options = ($this->settings_obj->ays_get_setting('options') === false) ? array() : json_decode( stripcslashes($this->settings_obj->ays_get_setting('options') ), true);

if(isset($_POST["ays_submit"]) || isset($_POST["ays_submit_top"])){
    $_POST["id"] = $id;
    $this->popupbox_obj->add_or_edit_popupbox($_POST);
}

if(isset($_POST["ays_apply"]) || isset($_POST["ays_apply_top"])){
    $_POST["id"] = $id;
    $_POST["submit_type"] = 'apply';
    $this->popupbox_obj->add_or_edit_popupbox($_POST);
}
$options['enable_background_gradient'] = (!isset($options['enable_background_gradient'])) ? 'off' : $options['enable_background_gradient'];
$enable_background_gradient = (isset($options['enable_background_gradient']) && $options['enable_background_gradient'] == 'on') ? true : false;
$background_gradient_color_1 = (isset($options['background_gradient_color_1']) && $options['background_gradient_color_1'] != '') ? esc_attr( stripslashes( $options['background_gradient_color_1'] )) : '#000';
$background_gradient_color_2 = (isset($options['background_gradient_color_2']) && $options['background_gradient_color_2'] != '') ? esc_attr( stripslashes( $options['background_gradient_color_2'] )) : '#fff';
$pb_gradient_direction = (isset($options['pb_gradient_direction']) && $options['pb_gradient_direction'] != '') ? $options['pb_gradient_direction'] : 'vertical';


$close_button_delay =  (isset($options['close_button_delay']) && $options['close_button_delay'] != '') ? abs(intval($options['close_button_delay'])) : '0';

$onoffswitch       = (isset($popupbox["onoffswitch"]) && $popupbox["onoffswitch"] != "") ? $popupbox["onoffswitch"] : "on" ;
$onoffoverlay      = (isset($popupbox["onoffoverlay"]) && $popupbox["onoffoverlay"] != "") ? $popupbox["onoffoverlay"] : "on";
$overlay_opacity   = (isset($popupbox["overlay_opacity"]) && ($popupbox["overlay_opacity"])!= "") ? ($popupbox["overlay_opacity"]) : "0.5";
$log_user          = (isset($popupbox["log_user"]) && $popupbox["log_user"] != "") ? $popupbox["log_user"] : "off";
$guest             = (isset($popupbox["guest"]) && $popupbox["guest"] != "") ? $popupbox["guest"] : "off";
$show_popup_title  = (isset($popupbox["show_popup_title"]) && $popupbox["show_popup_title"] != "") ? $popupbox["show_popup_title"] : "off";
$show_popup_desc   = (isset($popupbox["show_popup_desc"]) && $popupbox["show_popup_desc"] != "") ? $popupbox["show_popup_desc"] : "off";
$close_button      = (isset($popupbox["close_button"]) && $popupbox["close_button"] != "") ? $popupbox["close_button"] : "";

if( isset( $popupbox['view_place'] ) && $popupbox['view_place'] != null){
    $id != null ? $view_place = explode( "***", $popupbox['view_place']) : $view_place = array();
}

// Border size
$border_size = (isset($popupbox['bordersize']) && $popupbox['bordersize'] != '') ? abs(intval(round($popupbox['bordersize']))) : '1';
$ays_pb_timer_position = (- absint(intval($border_size)) -40) . 'px';

// Box header background color
$header_bgcolor = (isset($popupbox['header_bgcolor']) && $popupbox['header_bgcolor'] != '') ? esc_attr( stripslashes( $popupbox['header_bgcolor'] )) : '#ffffff';

// Enable PopupBox sound option
$options['enable_pb_sound'] = isset($options['enable_pb_sound']) ? $options['enable_pb_sound'] : 'off';
$enable_pb_sound = (isset($options['enable_pb_sound']) && $options['enable_pb_sound'] == "on") ? true : false;

//Overlay Color
$overlay_color = (isset($options['overlay_color']) && $options['overlay_color'] != '') ? esc_attr( stripslashes( $options['overlay_color'] )) : '#000';

//Animation Speed
$animation_speed = (isset($options['animation_speed']) && $options['animation_speed'] !== '') ? abs($options['animation_speed']) : 1;

// Close Animation Speed
$close_animation_speed = (isset($options['close_animation_speed']) && $options['close_animation_speed'] !== '') ? abs($options['close_animation_speed']) : 1;

if(!isset($options["close_animation_speed"])){
    $close_animation_speed = $animation_speed;
}

//Hide popupbox on mobile
$ays_pb_mobile = (isset($options['pb_mobile']) && $options['pb_mobile'] == 'on') ? $options['pb_mobile'] : 'off';

//Close button text
$close_button_text = (isset($options['close_button_text']) && $options['close_button_text'] != '') ? $options['close_button_text'] : 'x';

//Close button hover text
$close_button_hover_text = (isset($options['close_button_hover_text']) && $options['close_button_hover_text'] != '') ? $options['close_button_hover_text'] : '';

// PopupBox width for mobile option
$mobile_width = (isset($options['mobile_width']) && $options['mobile_width'] != '') ? abs(intval($options['mobile_width'])) : '';

// PopupBox max-width for mobile option
$mobile_max_width = (isset($options['mobile_max_width']) && $options['mobile_max_width'] != '') ? abs(intval($options['mobile_max_width'])) : '';

//Close Button Position on Container
$close_button_position = (isset($options['close_button_position']) && $options['close_button_position'] != '') ? $options['close_button_position'] : 'right-top';

//Show PopupBox only once
$show_only_once = (isset($options['show_only_once']) && $options['show_only_once'] == 'on') ? 'on' : 'off';

//Show on home page
$show_on_home_page = (isset($options['show_on_home_page']) && $options['show_on_home_page'] == 'on') ? 'on' : 'off';

//Close popup by ESC 
$close_popup_esc  = (isset($options['close_popup_esc']) && $options['close_popup_esc'] == 'on') ? 'on' : 'off';

//popup size by percentage
$popup_width_by_percentage_px = (isset($options['popup_width_by_percentage_px']) && $options['popup_width_by_percentage_px'] != '') ? $options['popup_width_by_percentage_px'] : 'pixels';

//close popup by clicking overlay
$close_popup_overlay = (isset($options['close_popup_overlay']) && $options['close_popup_overlay'] == 'on') ? $options['close_popup_overlay'] : 'off';

//close button size
$ays_close_button_size = (isset($options['close_button_size']) && $options['close_button_size'] != '') ? abs(($options['close_button_size'])) : '1';

// Popupbox Position
$pb_position = (isset($popupbox['pb_position']) && $popupbox['pb_position'] != 'center-center') ? $popupbox['pb_position'] : 'center-center';

// Bg image positioning
$pb_bg_image_position = (isset($options['pb_bg_image_position']) && $options['pb_bg_image_position'] != '') ? $options['pb_bg_image_position'] : "center-center";

$pb_bg_image_sizing = (isset($options['pb_bg_image_sizing']) && $options['pb_bg_image_sizing'] != '') ? $options['pb_bg_image_sizing'] : "cover";

$title              = (isset($popupbox['title']) && $popupbox['title'] != "") ? stripslashes($popupbox['title'] ) : "Default title";
$description        = (isset($popupbox['description']) && $popupbox['description'] != "") ? $popupbox['description'] : "";
$show_all           = (isset($popupbox['show_all']) && $popupbox['show_all'] != "") ? $popupbox['show_all'] : "all";
$modal_content      = (isset($popupbox['modal_content']) && $popupbox['modal_content'] != "") ? $popupbox['modal_content'] : "";
$shortcode          = (isset($popupbox['shortcode']) && $popupbox['shortcode'] != "") ? $popupbox['shortcode'] : "";
$custom_html        = (isset($popupbox['custom_html']) && $popupbox['custom_html'] != "") ? $popupbox['custom_html'] : "";
$action_button_type = (isset($popupbox['action_button_type']) && $popupbox['action_button_type'] != "") ? $popupbox['action_button_type'] : "";
$action_button      = (isset($popupbox['action_button']) && $popupbox['action_button'] != "") ? $popupbox['action_button'] : "";
$autoclose          = (isset($popupbox['autoclose']) && $popupbox['autoclose'] != "") ? $popupbox['autoclose'] : "";
$cookie             = (isset($popupbox['cookie']) && $popupbox['cookie'] != "") ? $popupbox['cookie'] : "";
$view_type          = (isset($popupbox['view_type']) && $popupbox['view_type'] != "") ? $popupbox['view_type'] : "";
$bgcolor            = (isset($popupbox['bgcolor']) && $popupbox['bgcolor'] != "") ? esc_attr( stripslashes(  $popupbox['bgcolor'] )) : "";

//popup padding size by percentage
$popup_padding_by_percentage_px = (isset($options['popup_padding_by_percentage_px']) && $options['popup_padding_by_percentage_px'] != '') ? $options['popup_padding_by_percentage_px'] : 'pixels';

//popup content padding
if (isset($options["popup_content_padding"]) && ($options["popup_content_padding"]) >= 0) {
    $padding = ($options["popup_content_padding"]);
} else {
    if (($view_type == 'minimal')) {
        $padding = 0;        
    } else {
        $padding = 20;
    }
}

//popup content padding default value 
if (($view_type == 'minimal')) {
    $default_padding_value = 0;        
} else {
    $default_padding_value = 20;
}

switch ($view_type) {
    case "image":
        $ays_pb_themes_bg_images = AYS_PB_ADMIN_URL."/images/elefante.jpg";
        break;
    case "template":
        $ays_pb_themes_bg_images = AYS_PB_ADMIN_URL."/images/girl-scaled.jpg";
        break;  
    default:
        $ays_pb_themes_bg_images = "";
        break;
}

$bg_image  = (isset($popupbox['bg_image']) && $popupbox['bg_image'] != "") ? $popupbox['bg_image'] : $ays_pb_themes_bg_images;

$image_text_bg   = __('Add Image', "ays-popup-box");
$style_bg   = "display: none;";

if (isset($bg_image) && $bg_image != '' && !empty( $bg_image )) {
    $style_bg      = "display: block;";
    $image_text_bg = __('Edit Image', "ays-popup-box");
}

$textcolor          = (isset($popupbox['textcolor']) && $popupbox['textcolor'] != "") ? esc_attr( stripslashes( $popupbox['textcolor'] )) : "";
$bordercolor        = (isset($popupbox['bordercolor']) && $popupbox['bordercolor'] != "") ? esc_attr( stripslashes( $popupbox['bordercolor'] )) : "";
$border_radius      = (isset($popupbox['border_radius']) && $popupbox['border_radius'] != "") ? abs(intval(round($popupbox['border_radius']))) : "";
$animate_in         = (isset($popupbox['animate_in']) && $popupbox['animate_in'] != "") ? $popupbox['animate_in'] : "";
$animate_out        = (isset($popupbox['animate_out']) && $popupbox['animate_out'] != "") ? $popupbox['animate_out'] : "";
$width              = (isset($popupbox['width']) && $popupbox['width'] != 0) ? $popupbox['width'] : "";
$height             = (isset($popupbox['height']) && $popupbox['height'] != "") ? $popupbox['height'] : "";
$custom_css         = (isset($popupbox['custom_css']) && $popupbox['custom_css'] != "") ? stripslashes ( esc_attr($popupbox['custom_css'] ) ) : "";

//Schedule of Popup
$popupbox['active_date_check'] = isset($popupbox['active_date_check']) ? $popupbox['active_date_check'] : 'off';
$active_date_check = (isset($popupbox['active_date_check']) && $popupbox['active_date_check'] == 'on') ? true : false;
if ($active_date_check) {
    $activateTime    = strtotime($popupbox['activeInterval']);
    $activePopup     = date('Y-m-d H:i:s', $activateTime);
    $deactivateTime  = strtotime($popupbox['deactiveInterval']);
    $deactivePopup   = date('Y-m-d H:i:s', $deactivateTime);
} else {
    $activePopup   = current_time( 'mysql' );
    $deactivePopup = current_time( 'mysql' );

}

$posts = array();

$except_posts       = (isset($options['except_posts']) && $options['except_posts'] != "") ? ($options['except_posts']) : array();
$except_post_types  = (isset($options['except_post_types']) && $options['except_post_types'] != "") ? ($options['except_post_types']) : array();

if ($except_post_types) {
    $posts = get_posts(array(
        'post_type'   => $except_post_types,
        'post_status' => 'publish',
        'numberposts' => -1
    ));
}
//font-family option
$font_families = array(
    'inherit'             => __('Inherit', "ays-popup-box"),
    'arial'               => __('Arial', "ays-popup-box"),
    'arial black'         => __('Arial Black', "ays-popup-box"),
    'book antique'        => __('Book Antique', "ays-popup-box"),
    'courier new'         => __('Courier New', "ays-popup-box"),
    'cursive'             => __('Cursive', "ays-popup-box"),
    'fantasy'             => __('Fantasy', "ays-popup-box"),
    'georgia'             => __('Georgia', "ays-popup-box"),
    'helvetica'           => __('Helvetia', "ays-popup-box"),
    'impact'              => __('Impact', "ays-popup-box"),
    'lusida console'      => __('Lusida Console', "ays-popup-box"),
    'palatino linotype'   => __('Palatino Linotype', "ays-popup-box"),
    'tahoma'              => __('Tahoma', "ays-popup-box"),
    'times new roman'     => __('Times New Roman', "ays-popup-box"),
);
$font_family_option = (isset($options['pb_font_family']) && $options['pb_font_family'] != '') ? $options['pb_font_family'] : 'inherit';

//open full screen
$ays_enable_pb_fullscreen = (isset($options['enable_pb_fullscreen']) && $options['enable_pb_fullscreen'] == 'on') ? 'on' : 'off';

//video options
$video_text_bg   = __('Add Video', "ays-popup-box");
$style_video_bg  = "display: none;";
$ays_video_src = '';
$ays_video_theme_bg = (isset($options['video_theme_url']) && !empty($options['video_theme_url'])) ? $options['video_theme_url'] : "";
if (isset($options['video_theme_url']) && !empty($options['video_theme_url'])) {
    $style_video_bg      = "display: block;";
    $video_text_bg = __('Edit Video', "ays-popup-box");
    $ays_video_src = $ays_video_theme_bg;
}else{
    $ays_video_src = AYS_PB_ADMIN_URL.'/videos/video_theme.mp4';
}


//hide timer
$ays_pb_hide_timer = (isset($options['enable_hide_timer']) && $options['enable_hide_timer'] == 'on') ? 'on' : 'off';

if($ays_pb_hide_timer == 'on'){
    $ays_pb_timer_desc = "<p class='ays_pb_timer' style='visibility:hidden'>".__('This will close in',"ays-popup-box")." <span data-seconds='20'>20</span> ".__('seconds',"ays-popup-box")."</p>";
}else{
    $ays_pb_timer_desc = "<p class='ays_pb_timer' style='visibility:visible'>".__('This will close in',"ays-popup-box")." <span data-seconds='20'>20</span> ".__('seconds',"ays-popup-box")."</p>";
}

$ays_pb_autoclose_on_completion = (isset($options['enable_autoclose_on_completion']) && $options['enable_autoclose_on_completion'] == 'on') ? 'on' : 'off';

// Social Media links
$enable_social_links = (isset($options['enable_social_links']) && $options['enable_social_links'] == "on") ? true : false;
$social_links = (isset($options['social_links'])) ? $options['social_links'] : array(
    'linkedin_link'   => '',
    'facebook_link'   => '',
    'twitter_link'    => '',
    'vkontakte_link'  => '',
    'youtube_link'    => '',
    'instagram_link'  => '',
    'behance_link'    => '',
);
$linkedin_link = isset($social_links['linkedin_link']) && $social_links['linkedin_link'] != '' ? $social_links['linkedin_link'] : '';
$facebook_link = isset($social_links['facebook_link']) && $social_links['facebook_link'] != '' ? $social_links['facebook_link'] : '';
$twitter_link = isset($social_links['twitter_link']) && $social_links['twitter_link'] != '' ? $social_links['twitter_link'] : '';
$vkontakte_link = isset($social_links['vkontakte_link']) && $social_links['vkontakte_link'] != '' ? $social_links['vkontakte_link'] : '';
$youtube_link = isset($social_links['youtube_link']) && $social_links['youtube_link'] != '' ? $social_links['youtube_link'] : '';
$instagram_link = isset($social_links['instagram_link']) && $social_links['instagram_link'] != '' ? $social_links['instagram_link'] : '';
$behance_link = isset($social_links['behance_link']) && $social_links['behance_link'] != '' ? $social_links['behance_link'] : '';

// Heading for social buttons
$social_buttons_heading = (isset($options['social_buttons_heading']) && $options['social_buttons_heading'] != '') ? stripslashes( $options['social_buttons_heading'] ) : "";

//Enable for selected user OS
$ays_users_os_array = array(
    '/windows nt 10/i'      =>  __('Windows 10', "ays-popup-box"),
    '/windows nt 6.1/i'     =>  __('Windows 7', "ays-popup-box"),
    '/macintosh|mac os x/i' =>  __('Mac OS X', "ays-popup-box"),
    '/linux/i'              =>  __('Linux', "ays-popup-box"),
);

//Enable for selected browser
$ays_users_browser_array = array(
    '/chrome/i'    => __('Chrome', "ays-popup-box"),
    '/firefox/i'   => __('Firefox', "ays-popup-box"),
    '/safari/i'    => __('Safari', "ays-popup-box"),
    '/opera|OPR/i' => __('Opera', "ays-popup-box"),
);

$disable_height = '';
$disable_width  = '';
if($ays_enable_pb_fullscreen == 'on'){
    $disable_height = 'readonly';
    $disable_width  = 'readonly';
}else{
    $disable_height = '';
    $disable_width  = '';
}

//close button image
$close_btn_background_img  = (isset($options['close_button_image']) && $options['close_button_image'] != "") ? $options['close_button_image'] : "";
$close_btn_image = __('Add Image', "ays-popup-box");
$close_btn_style_bg = "display: none;";

if (isset($options['close_button_image']) && !empty($options['close_button_image'])) {
    $close_btn_style_bg  = "display: block;";
    $close_btn_image = __('Edit Image', "ays-popup-box");
    $close_btn_img_display = 'display:block;';
    $close_btn_text_display = 'display:none';
}else{
    $close_btn_img_display = 'display:none;';
    $close_btn_text_display = 'display:block';
}

$hide_close_btn = '';
if($close_button == 'on'){
    $hide_close_btn = 'display:none';
}else{
    $hide_close_btn = 'display:block';
}

$hide_title = '';
$hide_desc = '';

$header_height = (($show_popup_title !== "On") ?  "height: 0px !important" :  "");
$calck_template_footer = (($show_popup_title !== "On") ? "height: 100%;" :  "");
$header_padding = '';
if($show_popup_title == 'On'){
    $hide_title = 'display:block';
    $header_padding = 'display:flex;align-items:center;justify-content:center';
}else{
    $hide_title = 'display:none';
    $header_padding = 'height:0 !important';
}

if($show_popup_desc == 'On'){
    $hide_desc = 'display:block';
}else{
    $hide_desc = 'display:none';
}

//border style

$border_styles = array(
    'dotted'    =>  __('Dotted',"ays-popup-box"),
    'dashed'    =>  __('Dashed',"ays-popup-box"),
    'solid'     =>  __('Solid',"ays-popup-box"),
    'double'    =>  __('Double',"ays-popup-box"),
    'groove'    =>  __('Groove',"ays-popup-box"),
    'ridge'     =>  __('Ridge',"ays-popup-box"),
    'inset'     =>  __('Inset',"ays-popup-box"),
    'outset'    =>  __('Outset',"ays-popup-box"),
);

$ays_pb_border_style = (isset($options['border_style']) && $options['border_style'] != "") ? $options['border_style'] : "solid";

//ays_pb_hover_show_close_btn
$options['ays_pb_hover_show_close_btn'] = (isset($options['ays_pb_hover_show_close_btn']) && $options['ays_pb_hover_show_close_btn'] == "on") ? "on" : "off";
$ays_pb_hover_show_close_btn = (isset($options['ays_pb_hover_show_close_btn']) && $options['ays_pb_hover_show_close_btn'] == "on") ? true : false;


// Disable scrolling
$options['disable_scroll'] = isset($options['disable_scroll']) ? sanitize_text_field( $options['disable_scroll'] ) : 'off';
$disable_scroll  = (isset($options['disable_scroll']) && $options['disable_scroll'] == 'on') ? true : false;


// WP Editor height
$pb_wp_editor_height = (isset($gen_options['pb_wp_editor_height']) && $gen_options['pb_wp_editor_height'] != '') ? absint( sanitize_text_field($gen_options['pb_wp_editor_height']) ) : 150 ;

// Pop up Min Height
$pb_min_height = (isset($options['pb_min_height']) && $options['pb_min_height'] != '') ? absint(intval($options['pb_min_height'])) : '';

// Font Size 
$pb_font_size = (isset($options['pb_font_size']) && $options['pb_font_size'] != '') ? absint($options['pb_font_size']) : 13;
$pb_font_size_for_mobile = (isset($options['pb_font_size_for_mobile']) && $options['pb_font_size_for_mobile'] != '') ? absint($options['pb_font_size_for_mobile']) : 13;

// Title text shadow

$options['enable_pb_title_text_shadow'] = (isset($options['enable_pb_title_text_shadow']) && $options['enable_pb_title_text_shadow'] == 'on') ? 'on' : 'off'; 
$enable_pb_title_text_shadow = (isset($options['enable_pb_title_text_shadow']) && $options['enable_pb_title_text_shadow'] == 'on') ? true : false; 

$pb_title_text_shadow = (isset($options['pb_title_text_shadow']) && $options['pb_title_text_shadow'] != '') ? stripslashes( esc_attr( $options['pb_title_text_shadow'] ) ) : 'rgba(255,255,255,0)';

$pb_title_text_shadow_x_offset = (isset($options['pb_title_text_shadow_x_offset']) && $options['pb_title_text_shadow_x_offset'] != '') ? stripslashes( esc_attr( $options['pb_title_text_shadow_x_offset'] ) ) : 2;

$pb_title_text_shadow_y_offset = (isset($options['pb_title_text_shadow_y_offset']) && $options['pb_title_text_shadow_y_offset'] != '') ? stripslashes( esc_attr( $options['pb_title_text_shadow_y_offset'] ) ) : 2;

$pb_title_text_shadow_z_offset = (isset($options['pb_title_text_shadow_z_offset']) && $options['pb_title_text_shadow_z_offset'] != '') ? stripslashes( esc_attr( $options['pb_title_text_shadow_z_offset'] ) ) : 0;


// Change current pb creation date
$pb_create_date = (isset($options['create_date']) && $options['create_date'] != '') ? $options['create_date'] : current_time( 'mysql' );;

if(isset($options['author']) && $options['author'] != 'null'){
    if ( ! is_array( $options['author'] ) ) {
        $options['author'] = json_decode($options['author'], true);
        $pb_author = $options['author'];
    } else {
        $pb_author = array_map( 'stripslashes', $options['author'] );
    }
} else {
    $pb_author = array('name' => 'Unknown');
}

//Change Create Author
$change_pb_create_author = (isset($options['create_author']) && $options['create_author'] != '') ? absint( sanitize_text_field( $options['create_author'] ) ) : $user_id;

$category_id = ( isset( $popupbox['category_id'] ) && $popupbox['category_id'] != '' ) ? intval( $popupbox['category_id'] ) : 1;


$next_popup_id = "";
$prev_popup_id = "";
if ( isset( $id ) && !is_null( $id ) ) {
    $next_popup = $this->get_next_or_prev_row_by_id( $id, "next", "ays_pb" );
    $next_popup_id = (isset( $next_popup['id'] ) && $next_popup['id'] != "") ? absint( $next_popup['id'] ) : null;
   
    $prev_popup = $this->get_next_or_prev_row_by_id( $id, "prev", "ays_pb" );
    $prev_popup_id = (isset( $prev_popup['id'] ) && $prev_popup['id'] != "") ? absint( $prev_popup['id'] ) : null;
}

//Mobile height
$mobile_height = (isset($options['mobile_height']) && $options['mobile_height'] != "") ? $options['mobile_height'] : "";

//Enable dismiss
$options['enable_dismiss'] = (isset($options['enable_dismiss']) && $options['enable_dismiss'] == "on") ? "on" : "off";
$enable_dismiss = (isset($options['enable_dismiss']) && $options['enable_dismiss'] == "on") ? true : false;

$enable_dismiss_text = (isset($options['enable_dismiss_text']) && $options['enable_dismiss_text'] != "") ? esc_attr(stripslashes($options['enable_dismiss_text'])) : __("Dismiss ad", "ays-popup-box");

$not_default_view_types = array(
    'mac'       => 'mac',
    'ubuntu'    => 'ubuntu',
    'winXP'     => 'winXP',
    'win98'     => 'win98',
    'cmd'       => 'cmd',
);

$modal_content_name = '';
$video_tutorial = '';
switch ($modal_content) {
    case 'custom_html':
        $modal_content_name = __('Custom Content',"ays-popup-box");
        $video_tutorial = '';
        break;
    case 'shortcode':
        $modal_content_name = __('Shortcode',"ays-popup-box");
        $video_tutorial = '<span><a href="https://www.youtube.com/watch?v=q6ai1WhpLfc">'.__("Watch how to add a shortcode popup", "ays-popup-box").'</a></span>';
        break;
    case 'video_type':
        $modal_content_name = __('Video',"ays-popup-box");
        $video_tutorial = '<span><a href="https://www.youtube.com/watch?v=oOvHTcePpys">'.__("Watch how to add a video popup", "ays-popup-box").'</a></span>';
        break;
    default:
        $modal_content_name = __('Custom Content',"ays-popup-box");
        $video_tutorial = '';
        break;
}


//Box shadow
$options['enable_box_shadow'] = ( isset( $options['enable_box_shadow'] ) && $options['enable_box_shadow'] != '' ) ? $options['enable_box_shadow'] : 'off';
$enable_box_shadow = ( isset( $options['enable_box_shadow'] ) && $options['enable_box_shadow'] == 'on' ) ? true : false;

$box_shadow_color = (!isset($options['box_shadow_color'])) ? '#000' : esc_attr( stripslashes($options['box_shadow_color']) );

//  Box Shadow X offset
$pb_box_shadow_x_offset = (isset($options['pb_box_shadow_x_offset']) && $options['pb_box_shadow_x_offset'] != '' && intval( $options['pb_box_shadow_x_offset'] ) != 0) ? intval( $options['pb_box_shadow_x_offset'] ) : 0;

//  Box Shadow Y offset
$pb_box_shadow_y_offset = (isset($options['pb_box_shadow_y_offset']) && $options['pb_box_shadow_y_offset'] != '' && intval( $options['pb_box_shadow_y_offset'] ) != 0) ? intval( $options['pb_box_shadow_y_offset'] ) : 0;

//  Box Shadow Z offset
$pb_box_shadow_z_offset = (isset($options['pb_box_shadow_z_offset']) && $options['pb_box_shadow_z_offset'] != '' && intval( $options['pb_box_shadow_z_offset'] ) != 0) ? intval( $options['pb_box_shadow_z_offset'] ) : 15;

// Popup name
$popup_name = isset($popupbox['popup_name']) && $popupbox['popup_name'] ? stripslashes( esc_attr( $popupbox['popup_name'] ) ) : '';

//Disabel scroll on popup
$options['disable_scroll_on_popup'] = ( isset( $options['disable_scroll_on_popup'] ) && $options['disable_scroll_on_popup'] != '' ) ? $options['disable_scroll_on_popup'] : 'off';
$ays_pb_disable_scroll_on_popup = ( isset( $options['disable_scroll_on_popup'] ) && $options['disable_scroll_on_popup'] == 'on' ) ? true : false;

$ays_pb_wp_users = get_users(); 

//Hide on PC
$options['hide_on_pc'] = ( isset( $options['hide_on_pc'] ) && $options['hide_on_pc'] != "" ) ? $options['hide_on_pc'] : "off";
$ays_pb_hide_on_pc = ( isset( $options['hide_on_pc'] ) && $options['hide_on_pc'] == "on" ) ? true : false;

//Hide on tablets
$options['hide_on_tablets'] = ( isset( $options['hide_on_tablets'] ) && $options['hide_on_tablets'] != "" ) ? $options['hide_on_tablets'] : "off";
$ays_pb_hide_on_tablets = ( isset( $options['hide_on_tablets'] ) && $options['hide_on_tablets'] == "on" ) ? true : false;

//Background image position for mobile
$options['pb_bg_image_direction_on_mobile'] = ( isset( $options['pb_bg_image_direction_on_mobile'] ) && $options['pb_bg_image_direction_on_mobile'] == "on" ) ? $options['pb_bg_image_direction_on_mobile'] : "off";
$pb_bg_image_direction_on_mobile = ( isset( $options['pb_bg_image_direction_on_mobile'] ) && $options['pb_bg_image_direction_on_mobile'] == "on" ) ? true : false;

//Close button color
$empty_closebtn_color = $textcolor;
if($view_type == 'lil'){
    $empty_closebtn_color = '#ffffff';
}
$close_button_color = (isset($options['close_button_color']) && $options['close_button_color'] != "") ? esc_attr( stripslashes( $options['close_button_color'] )) : $empty_closebtn_color;

$close_button_hover_color = (isset($options['close_button_hover_color']) && $options['close_button_hover_color'] != "") ? esc_attr( stripslashes( $options['close_button_hover_color'] )) : $close_button_color;

$popupbox['show_only_for_author'] = ( isset( $popupbox['show_only_for_author'] ) && $popupbox['show_only_for_author'] == "on") ? $popupbox['show_only_for_author'] : 'off';
$show_only_for_author = ( isset( $popupbox['show_only_for_author']) && $popupbox['show_only_for_author'] == "on") ? true : false;

$options['blured_overlay'] = ( isset( $options['blured_overlay'] ) && $options['blured_overlay'] == "on") ? $options['blured_overlay'] : 'off';
$blured_overlay = ( isset( $options['blured_overlay']) && $options['blured_overlay'] == "on") ? true : false;

$show_popup_triggers_tooltip = array(
    'pageLoaded'            => 'On page load - Trigger displays the popup automatically on the page load. Define the time delay of the popup in Open Delay option.',
    'clickSelector'         => 'On click - Trigger displays a popup on your site when the user clicks on a targeted CSS element(s). Define the CSS element in the CSS selector(s) option.',
    'both'                  => 'Both (On page load & On click) - Popup will be shown both on page load and click.',
);

$get_all_popups = Ays_Pb_Data::get_popups();
?>

<style>
    .ays_menu_badge{
    color: #fff;
    display: inline-block;
    font-size: 10px;

    text-align: center;
    background: #ca4a1f;
    margin-left: 5px;
    border-radius: 20px;
    padding: 2px 5px;
    }

    /* #adminmenu  a.toplevel_page_ays-pb div.wp-menu-image img {
    width: 32px;
    padding: 3px 0 0;
    transition: .3s ease-in-out;
    } */

    .ays_fa-close-button:before{
        content: "<?php echo $close_button_text ?>";
    }

    .ays_image_window p.ays_pb_timer{
        bottom: <?php echo $ays_pb_timer_position; ?>;
    }

    .ays-pb-live-container .ays-close-button-text, 
    .ays-pb-live-container.ays_image_window header .ays-close-button-text,
    .ays-pb-live-container.ays_template_window header .ays-close-button-text{
        transform:scale(<?php echo $ays_close_button_size; ?>);
        color:<?php echo $close_button_color; ?>;
    }

    .close-lil-btn:hover{
        transform: rotate(180deg) scale(<?php echo $ays_close_button_size; ?>)
    }

</style>
<?php 
// Getting all WP Roles
global $wp_roles;
$ays_users_roles = $wp_roles->roles;
$ays_pb_page_url = sprintf('?page=%s', 'ays-pb');
?>
<div class="wrap">
    <div class="container-fluid">
        <form method="post" name="popup_attributes" id="ays_pb_form">
            <input type="hidden" name="ays_pb_tab" value="<?php echo esc_attr($ays_pb_tab); ?>">
            <input type="hidden" class="pb_wp_editor_height" value="<?php echo $pb_wp_editor_height; ?>">
            <input type="hidden" name="ays_pb_create_date" value="<?php echo $pb_create_date; ?>">
            <input type="hidden" name="ays_pb_author" value="<?php echo esc_attr(json_encode($pb_author, JSON_UNESCAPED_SLASHES)); ?>">
            <div class="ays-pb-heading-box">
                <div class="ays-pb-wordpress-user-manual-box">
                        <a href="https://ays-pro.com/wordpress-popup-box-plugin-user-manual" target="_blank"><?php echo __("View Documentation", "ays-popup-box"); ?></a>
                </div>
            </div>
            <h1 class="wp-heading-inline" style="display:flex; flex-wrap: wrap;">
                <?php
                    echo $heading;
                    // $save_attributes = array('id' => 'ays-button-top-apply');
                    $save_attributes = array(
                        'id' => 'ays-button-top-apply',
                        'title' => 'Ctrl + s',
                        'data-toggle' => 'tooltip',
                        'data-delay'=> '{"show":"300"}'
                    );
                    $save_close_attributes = array('id' => 'ays-button-top');
                    submit_button(__('Save and close', "ays-popup-box"), 'primary', 'ays_submit_top', false, $save_close_attributes);
                    submit_button(__('Save', "ays-popup-box"), '', 'ays_apply_top', false, $save_attributes);
                ?>
                <a href="<?php echo $ays_pb_page_url; ?>" class="button" style="margin-left:10px;" ><?php echo __('Cancel',"ays-popup-box");?></a>
                <?php
                    echo $loader_iamge;
                ?>
            </h1>
            <div>
                <div class="ays-pb-subtitle-main-box">
                    <p class="ays_pb_subtitle">
                        <?php if(isset($id) && count($get_all_popups) > 1):?>
                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/angle-down.svg"?>" class="ays-pb-open-popups-list">
                        <?php endif; ?>
                        <strong class="ays_pb_title_in_top"><?php echo esc_html( $title ); ?></strong>
                    </p>
                    <?php if(isset($id) && count($get_all_popups) > 1):?>
                        <div class="ays-pb-popups-data">
                            <?php $var_counter = 0; foreach($get_all_popups as $var => $var_name): if( intval($var_name['id']) == $id ){continue;} $var_counter++; ?>
                                <label class="ays-pb-message-vars-each-data-label">
                                    <input type="radio" class="ays-pb-popups-each-data-checker" hidden id="ays_pb_message_var_count_<?php echo esc_attr($var_counter)?>" name="ays_pb_message_var_count">
                                    <div class="ays-pb-popups-each-data">
                                        <input type="hidden" class="ays-pb-popups-each-var" value="<?php echo esc_attr($var); ?>">
                                        <a href="?page=ays-pb&action=edit&popupbox=<?php echo esc_attr($var_name['id']); ?>" target="_blank" class="ays-pb-go-to-popups"><span><?php echo stripslashes(esc_attr($var_name['title'])); ?></span></a>
                                    </div>
                                </label>              
                            <?php endforeach ?>
                        </div>                        
                    <?php endif; ?>
                </div>
                <p class="ays-pb-type-name">
                    <span style="display:block;" class="ays-pb-small-hint-text"><?php echo esc_html( $modal_content_name ); ?></span>
                    <?php if(isset($id)): ?> 
                    <span style="display:block;" class="ays-pb-small-hint-text"><?php echo "id: " . esc_html( $id ); ?></span>
                    <?php endif; ?>
                </p>
                <p class="ays-pb-type-video">
                   <?php echo $video_tutorial;?>
                </p>
            </div>  
            <hr>
            <div class="ays-pb-top-menu-wrapper">
                <div class="ays_pb_menu_left" data-scroll="0"><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/angle-left.svg"?>"></div>
                <div class="ays-pb-top-menu">
                    <div class="nav-tab-wrapper ays-pb-top-tab-wrapper">
                        <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_pb_tab == 'tab1') ? 'nav-tab-active' : ''; ?>"><?php echo __("General", "ays-popup-box"); ?></a>
                        <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_pb_tab == 'tab2') ? 'nav-tab-active' : ''; ?>"><?php echo __("Settings", "ays-popup-box"); ?></a>
                        <a href="#tab3" data-tab="tab3" class="nav-tab <?php echo ($ays_pb_tab == 'tab3') ? 'nav-tab-active' : ''; ?>"><?php echo __("Styles", "ays-popup-box"); ?></a>
                        <a href="#tab4" data-tab="tab4" class="nav-tab <?php echo ($ays_pb_tab == 'tab4') ? 'nav-tab-active' : ''; ?>"><?php echo __("Limitation Users", "ays-popup-box"); ?></a>
                        <a href="#tab5" data-tab="tab5" class="nav-tab <?php echo ($ays_pb_tab == 'tab5') ? 'nav-tab-active' : ''; ?>"><?php echo __("Integrations", "ays-popup-box"); ?></a>
                    </div>
                </div>
                <div class="ays_pb_menu_right" data-scroll="-1"><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/angle-right.svg"?>"></div>
            </div>
            <div id="tab1" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab1') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('General Settings', "ays-popup-box") ?></p>
                <hr/>
                <!-- Enable popup start-->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-onoffswitch">
                            <span><?php echo __('Enable popup', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                                title="<?php echo __('Turn on the popup for the website based on your configured options.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label class="ays-pb-enable-switch">
                            <input type="checkbox" name="<?php echo $this->plugin_name; ?>[onoffswitch]" class="ays-pb-onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-onoffswitch" <?php if($onoffswitch == 'On'){ echo 'checked';} else { echo '';} ?>>
                            <div class="ays-pb-enable-switch-slider ays-pb-enable-switch-round">
                                <!--ADDED HTML -->
                                <span class="ays-pb-enable-switch-on"><?php echo __( 'ON', "ays-popup-box" ); ?></span>
                                <span class="ays-pb-enable-switch-off"><?php echo __( 'OFF', "ays-popup-box" ); ?></span>
                                <!--END-->
                            </div>
                        </label>
                    </div>
                </div>
                <!-- Enable popup end-->
                <hr> 
                <!-- Enable popup for author only start-->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_show_popup_only_for_author">
                            <span><?php echo __('Enable popup only for author', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If this option is enabled only the author of the popup will be able to see it.', "ays-popup-box") ?>"> 
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="checkbox" name="ays_pb_show_popup_only_for_author" class="" id="ays_pb_show_popup_only_for_author" <?php echo $show_only_for_author ? 'checked' : ''; ?>>
                    </div>
                </div>
                <!-- Enable popup for author only end-->
                <hr> 
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-popup_title">
                            <span><?php echo __('Popup title', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('The option is not being displayed on the front-end by default. Please activate it from the Styles tab.', "ays-popup-box") ?>">
                               <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="<?php echo $this->plugin_name; ?>-popup_title"  class="ays-text-input" name="<?php echo $this->plugin_name; ?>[popup_title]" value="<?php echo esc_attr( $title ); ?>" />
                    </div>
                </div>
                <div class="form-group row" id="ays_shortcode" style="display: none;">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-shortcode">
                            <span><?php echo __('Shortcode ', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('You can pop up any form by inserting its shortcode. Please copy and paste the shortcode from another plugin to display it in a popup. For example, Contact forms, surveys, polls, quizzes, Google map, etc.', "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="<?php echo $this->plugin_name; ?>-shortcode" name="<?php echo $this->plugin_name; ?>[shortcode]"  class="ays-text-input" value="<?php echo htmlentities($shortcode); ?>" />
                    </div>
                </div>
                <div class="form-group row ays-field" id="ays_custom_html" style="display: none;">
                    <div class="col-sm-3">
                        <label>
                            <span>
                                <span><?php echo __('Custom Content', "ays-popup-box"); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Create fully customized popup content with the help of HTML.", "ays-popup-box"); ?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <?php
                            $content = stripslashes(($custom_html));
                            $editor_id = 'custom-html';
                            $settings = array('editor_height'=> $pb_wp_editor_height,'textarea_name'=> $this->plugin_name.'[custom_html]', 'editor_class'=>'ays-textarea', 'media_buttons' => true);
                            wp_editor($content,$editor_id,$settings);
                        ?>
                    </div>
                    
                   
                </div>
                <hr style="<?php echo ('video' == $view_type) ? '' : 'display:none;'; ?>">
                <!-- video option start -->
                <div class="form-group row ays_pb_add_new_video"  style="<?php echo ('video' == $view_type) ? '' : 'display:none;'; ?>" >
                    <div class="col-sm-3">
                        <label for='ays_pb_video_theme'>
                            <?php echo __('Video', "ays-popup-box"); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top"
                                title="<?php echo __("Add video to the popup.", "ays-popup-box"); ?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <a href="javascript:void(0)" class="button ays-pb-add-bg-video">
                            <?php echo $video_text_bg; ?>
                        </a>
                        <div class="col-sm-8" style="<?php echo $style_video_bg; ?>">
                            <div class="ays-pb-bg-video-container">
                            <span class="ays-remove-bg-video"></span>
                            <video src="<?php echo $ays_video_theme_bg?>" id="ays_pb_video_theme_video"></video>
                            <input type="hidden" name="ays_video_theme_url" id="ays_pb_video_theme" value="<?php echo $ays_video_theme_bg ; ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row ays-field" id="ays-popup-box-description">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-popup_description">
                            <span><?php echo __('Popup description', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The option is not being displayed on the front-end by default. Please activate it from the Styles tab.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <?php
                            $content = stripslashes(($description));
                            $editor_id = $this->plugin_name.'-popup_description';
                            $settings = array('editor_height'=> $pb_wp_editor_height,'textarea_name'=> $this->plugin_name.'[popup_description]', 'editor_class'=>'ays-textarea', 'media_buttons' => true);
                            wp_editor($content,$editor_id,$settings);
                        ?>
                    </div>                                       
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-show_all_yes">
                            <span><?php echo __('Display', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" data-html="true"
                                title="<?php
                                    echo __('Define the pages your popup will be loaded on.',"ays-popup-box");
                                ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label class="ays-pb-label-style" for="<?php echo $this->plugin_name; ?>-show_all_yes"><?php echo __("All pages", "ays-popup-box"); ?>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-show_all_yes"  class="" name="<?php echo $this->plugin_name; ?>[show_all]" value="all" <?php if($show_all == 'yes' || $show_all == 'all'){ echo 'checked';} else { echo '';} ?> />
                        </label>
                        <label class="ays-pb-label-style" for="<?php echo $this->plugin_name; ?>-show_all_except"><?php echo __("Except", "ays-popup-box"); ?>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-show_all_except"  class="" name="<?php echo $this->plugin_name; ?>[show_all]" value="except" <?php if($show_all == 'except'){ echo 'checked';} else { echo '';} ?>/>
                        </label>
                        <label class="ays-pb-label-style" for="<?php echo $this->plugin_name; ?>-show_all_selected"><?php echo __("Include", "ays-popup-box"); ?>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-show_all_selected"  class="" name="<?php echo $this->plugin_name; ?>[show_all]" value="selected" <?php if($show_all == 'selected' || $show_all == 'no'){ echo 'checked';} else { echo '';} ?>/>
                        </label>
                        <a class="ays_help" style="font-size:15px;" data-toggle="tooltip" data-html="true"
                            title="<?php
                                echo __('Choose the method of calculation.',"ays-popup-box") .
                                "<ul style='list-style-type: circle;padding-left: 20px;'>".
                                    "<li>". __('All pages - The popup will display on all pages.',"ays-popup-box") ."</li>".
                                    "<li>". __('Except - Choose the post/page and post/page types excluding the popup.',"ays-popup-box") ."</li>".
                                    "<li>". __('Include - Choose the post/page and post/page types including the popup.',"ays-popup-box") ."</li>".
                                "</ul>";
                            ?>">
                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                        </a>
                    </div>
                </div>
                <div class="ays_pb_view_place_tr ays-field">
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_pb_post_types"><?php echo __("Post type", "ays-popup-box"); ?></label>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Select post types.', "ays-popup-box") ?>">
                               <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <select name="ays_pb_except_post_types[]" id="ays_pb_post_types" class="form-control"
                                    multiple="multiple">
                                <?php
                                    foreach ($all_post_types as $post_type) {
                                        if($except_post_types) {
                                            $checked = (in_array($post_type->name, $except_post_types)) ? "selected" : "";
                                        }else{
                                            $checked = "";
                                        }
                                        echo "<option value='{$post_type->name}' {$checked}>{$post_type->label}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_pb_posts"><?php echo __("Posts", "ays-popup-box"); ?></label>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Select posts.', "ays-popup-box") ?>">
                               <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <select name="ays_pb_except_posts[]" id="ays_pb_posts" class="form-control"
                                    multiple="multiple">
                                <?php
                                    foreach ( $posts as $post ) {
                                       
                                        $checked = (is_array($except_posts) && in_array($post->ID, $except_posts)) ? "selected" : "";
                                        echo "<option value='{$post->ID}' {$checked}>{$post->post_title}</option>";
                                    }

                                    if (!empty($view_place)) {
                                        $args = array(
                                            'post_type' => array('post', 'page'),
                                            'nopaging'  => true
                                        );
                                        // Custom query.
                                        $query = new WP_Query( $args );

                                        if($query->have_posts()){
                                            foreach ($query->posts as $key => $post){
                                                if(in_array($post->ID, $view_place)):
                                                    ?>
                                                    <option selected value="<?php echo $post->ID; ?>"><?php echo __(get_the_title($post->ID), "ays-popup-box"); ?></option> 
                                                <?php
                                                endif;
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <input type='hidden' id="ays_pb_except_posts_id">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_pb_show_on_home_page" style="margin-bottom:0px;">
                                <span><?php echo __('Show on Home page', "ays-popup-box"); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If the checkbox is ticked, then the popup will be loaded on the Home page too, in addition to the values given above.', "ays-popup-box"); ?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <p class="onoffswitch" style="margin: 0px;">
                                <input type="checkbox" name="ays_pb_show_on_home_page" class="ays-pb-onoffswitch-checkbox" id="ays_pb_show_on_home_page" <?php echo ($show_on_home_page == 'on') ? 'checked' : '' ?> >
                            </p>
                            <div class="ays-pb-youtube-video-link">
                                <!-- <div class="ays-pb-youtube-video-play-icon">
                                    <img src="<?php //echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                                </div>  -->
                                <div class="ays-pb-small-hint-text">
                                    <a href="https://youtu.be/wMv-H2jGTaI?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                                        <?php echo __( 'How to Create Homepage Popup', "ays-popup-box"  ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-action_button_type">
                            <span> <?php echo __('Popup trigger', "ays-popup-box"); ?></span>
                                <a class="ays_help" data-toggle="tooltip" data-html="true"
                                title="<?php
                                    echo htmlspecialchars(__('Choose the trigger causing the popup to open on certain events.',"ays-popup-box") .
                                    "<ul style='list-style-type: circle;padding-left: 20px;'>".
                                        "<li>". __('Onload',"ays-popup-box") ."</li>".
                                        "<li>". __('Onclick',"ays-popup-box") ."</li>".
                                        "<li>". __('Both(On page load & On click)',"ays-popup-box") ."</li>".
                                    "</ul>"
                                    );
                                ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="<?php echo $this->plugin_name; ?>-action_button_type" class="ays_pb_aysDropdown" name="<?php echo $this->plugin_name; ?>[action_button_type]">
                            <option <?php if(!isset($action_button_type)){ echo 'selected'; } echo 'both' == $action_button_type ? 'selected' : ''; ?> value="both"><?php echo __('Both'); ?></option>
                            <option <?php echo 'pageLoaded' == $action_button_type ? 'selected' : ''; ?> value="pageLoaded"><?php echo __('Onload'); ?></option>
                            <option <?php echo 'clickSelector' == $action_button_type ? 'selected' : ''; ?> value="clickSelector"><?php echo __('On Click'); ?></option>
                            <option value="exit_intent" disabled><?php echo __('On hover (Pro)'); ?></option>
                            <option value="exit_intent" disabled><?php echo __('Exit Intent (Pro)'); ?></option>
                            <option value="exit_intent" disabled><?php echo __('After visiting x pages (Pro)'); ?></option>
                            <option value="exit_intent" disabled><?php echo __('Inactivity (Pro)'); ?></option>
                            <option value="exit_intent" disabled><?php echo __('Scrolling to element (Pro)'); ?></option>
                        </select>
                        <a class="ays_help ays-pb-triggers-tooltip" data-toggle="tooltip" data-html="true" title="<?php
                            foreach ($show_popup_triggers_tooltip as $key => $show_popup_trigger_tooltip) {
                                if($key == $action_button_type){
                                    echo htmlspecialchars($show_popup_trigger_tooltip);
                                }
                            }
                        ?>">
                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                        </a>
                        <div class="ays-pb-youtube-video-link">
                            <!-- <div class="ays-pb-youtube-video-play-icon">
                                <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                            </div> -->
                            <div class="ays-pb-small-hint-text">
                            <a href="https://youtu.be/YTB5_J74AIg" target="_blank">
                                <?php echo __("View how to make popup on button click", "ays-popup-box");?>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="<?php echo ('clickSelector' == $action_button_type  || 'both' == $action_button_type)  ? '' : 'display_none'; ?>">
                <div class="form-group row ays-pb-open-click-hover" style="<?php echo ( 'clickSelector' == $action_button_type  || 'both' == $action_button_type)  ? '' : 'display:none;'; ?>">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-action_button">
                    <span>
                        <?php echo __('CSS selector(s) for trigger click', "ays-popup-box"); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Add your preferred CSS selector(s) if you have given “On click” or “Both” value to the “Popup trigger” option. For example #mybutton or .mybutton.", "ays-popup-box"); ?>">
                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                        </a>
                    </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="<?php echo $this->plugin_name; ?>-action_button" name="<?php echo $this->plugin_name; ?>[action_button]"  class="ays-text-input" value="<?php echo htmlentities($action_button); ?>" placeholder="#myButtonId, .myButtonClass, .myButton" />
                        <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __( 'Enter the class starting with a “ . ” and id with a “ # ”', "ays-popup-box" ); ?></span>
                    </div>
                </div>
                <hr/>
                <div class="pb_position_block">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="<?php echo $this->plugin_name; ?>-position">
                                <span><?php echo __('Popup position', "ays-popup-box"); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the position of the popup on the screen. ", "ays-popup-box"); ?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <table id="ays-pb-position-table" data-flag="popup_position">
                                <tr>
                                    <td data-value="left-top" data-id='1'></td>
                                    <td data-value="top-center"data-id='2'></td>
                                    <td data-value="right-top" data-id='3'></td>
                                </tr>
                                <tr>
                                    <td data-value="left-center" data-id='4'></td>
                                    <td id="pb_position_center" data-value="center-center" data-id='5'></td>
                                    <td data-value="right-center" data-id='6'></td>
                                </tr>
                                <tr>
                                    <td data-value="left-bottom" data-id='7'></td>
                                    <td data-value="center-bottom" data-id='8'></td>
                                    <td data-value="right-bottom" data-id='9'></td>
                                </tr>
                            </table>
                            <input type="hidden" name="<?php echo $this->plugin_name; ?>[pb_position]" class="ays-pb-position-val-class" id="ays-pb-position-val" value="<?php echo $pb_position; ?>" >
                        </div>
                    </div>
                    <hr class="ays_pb_hr_hide" />
                    <div id="popupMargin" class="form-group row">
                        <div class="col-sm-3">
                            <label for="<?php echo $this->plugin_name; ?>-pb_margin">
                                <span><?php echo __('Popup margin(px)', "ays-popup-box"); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the popup margin in pixels. It accepts only numerical values.", "ays-popup-box"); ?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="number" id="<?php echo $this->plugin_name; ?>-pb_margin" name="<?php echo $this->plugin_name; ?>[pb_margin]"  class="ays-pb-text-input ays-pb-text-input-short"  value="<?php echo !isset($popupbox['pb_margin']) ? '' : $popupbox['pb_margin']; ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab2" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab2') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('Popup opening', "ays-popup-box") ?></p>
                <hr>
                <!-- Opening delay starts -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-delay" style="margin-bottom:0px;">
                            <span><?php echo __('Open Delay (in milliseconds) ', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Open the popup when a visitor has viewed your website content for a specified period of time (in milliseconds). To disable the option leave it blank or set it to 0.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-delay" name="<?php echo $this->plugin_name; ?>[delay]"  class="ays-pb-text-input ays-pb-text-input-short"  value="<?php echo !isset($popupbox['delay']) ? '' : abs(intval($popupbox['delay'])); ?>">
                        <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __( '1 sec = 1000 ms', "ays-popup-box" ); ?></span>
                        <div class="ays-pb-youtube-video-link">
                            <!-- <div class="ays-pb-youtube-video-play-icon">
                                <img src="<?php //echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                            </div> -->
                            <div class="ays-pb-small-hint-text">
                                <a href="https://youtu.be/1ryQv9ojgMY?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                                    <?php echo __('How to Show Popup after a Time Delay', "ays-popup-box")?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Opening delay end -->
                <hr>
                <!-- Scroll from top starts -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-scroll_top">
                            <span><?php echo __('Open by Scrolling Down', "ays-popup-box"); ?></span>
                             <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the scroll length by pixels to open the popup when scrolling. To disable the option leave it blank or set it to 0.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-scroll_top" name="<?php echo $this->plugin_name; ?>[scroll_top]"  class="ays-pb-text-input ays-pb-text-input-short"  value="<?php echo !isset($popupbox['scroll_top']) ? '' : abs(intval(round($popupbox['scroll_top']))); ?>">
                        <div class="ays-pb-youtube-video-link">
                            <!-- <div class="ays-pb-youtube-video-play-icon">
                                <img src="<?php //echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                            </div> -->
                            <div class="ays-pb-small-hint-text">
                                <a href="https://www.youtube.com/watch?v=7Hh3jp0hMgM&list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                                    <?php echo __('How to Create a Login Form Popup', "ays-popup-box")?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Scroll from top end -->
                <hr>
                <p class="ays-subtitle"><?php echo  __('Popup Closing', "ays-popup-box") ?></p>
                <hr>
                <!-- close overlay by esc key start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_close_popup_esc">
                            <span><?php echo __('Close by pressing ESC', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If the option is enabled, the user can close the popup by pressing the ESC button from the keyboard.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="close_popup_esc" class="ays-pb-onoffswitch-checkbox" id="ays_close_popup_esc" <?php if($close_popup_esc == 'off'){ echo '';} else { echo 'checked';} ?>/>
                        </p>
                    </div>
                </div>
                <!-- close overlay by esc key end -->
                <hr>
                <!-- Close by clicking outside the box starts -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_close_popup_overlay" style="margin-bottom:0px;">
                            <span><?php echo __('Close by clicking outside the box', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If the option is enabled, the user can close the popup by clicking outside the box.  Notice: This option works only if the “Enable Overlay”option is ticked.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch" style="margin:0;">
                            <input type="checkbox" name="close_popup_overlay" class="ays-pb-onoffswitch-checkbox" id="ays_close_popup_overlay" <?php if($close_popup_overlay == 'off'){ echo '';} else { echo 'checked';} ?>/>
                        </p>
                        <div class="ays-pb-youtube-video-link">
                            <!-- <div class="ays-pb-youtube-video-play-icon">
                                <img src="<?php //echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                            </div> -->
                            <div class="ays-pb-small-hint-text">
                                <a href="https://youtu.be/iOP7rxNoc9E?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                                    <?php echo __('How to close Popup by clicking outside the box', "ays-popup-box")?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Close by clicking outside the box end -->                
                <hr>
                <!-- Hide close button start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-close-button">
                            <span> <?php echo __('Hide close button', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If the option is enabled, the close button of the popup will be disappeared. ", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-close-button"  name="<?php echo $this->plugin_name; ?>[close_button]" class="ays-pb-onoffswitch-checkbox" <?php if($close_button == 'on'){ echo 'checked';} else { echo '';} ?> />
                    </div>
                </div>
                <!-- Hide close button end -->
                <hr>
                <!-- Show close button by hovering over the popup start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_show_close_btn_hover_container">
                            <span> <?php echo __('Activate Close button while hovering on popup', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable this option to close the popup by hovering over the popup container.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="checkbox" id="ays_pb_show_close_btn_hover_container"  name="ays_pb_show_close_btn_hover_container" class="ays-pb-onoffswitch-checkbox" <?php echo $ays_pb_hover_show_close_btn ? "checked" : ''; ?> value='on' />
                    </div>
                </div>
                <!-- Show close button by hovering over the popup end -->
                <hr>
                <!-- Close button position start -->
                <div class="form-group row ays-pb-close-button-position-z-index">
                    <div class="col-sm-3">
                        <label for="ays-pb-close-button-position">
                            <span> <?php echo __('Close button position', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Select the place of the popup close button. ", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <!-- Added z-index for creation date -->
                    <div class="col-sm-9">
                        <select id="ays-pb-close-button-position" name="ays_pb_close_button_position" class="ays-pb-text-input ays-pb-text-input-short ays_pb_aysDropdown">
                            <option <?php echo ($close_button_position == 'right-top') ? 'selected' : ''; ?> value="right-top"><?php echo __('Right Top', "ays-popup-box"); ?></option>
                            <option <?php echo ($close_button_position == 'left-top') ? 'selected' : ''; ?> value="left-top"><?php echo __('Left Top', "ays-popup-box"); ?></option>
                            <option <?php echo ($close_button_position == 'left-bottom') ? 'selected' : ''; ?> value="left-bottom"><?php echo __('Left Bottom', "ays-popup-box"); ?></option>
                            <option <?php echo $close_button_position == 'right-bottom' ? 'selected' : ''; ?> value="right-bottom"><?php echo __('Right Bottom', "ays-popup-box"); ?></option>
                        </select>
                    </div>
                </div>
                <!-- Close button position end -->
                <hr>
                <!-- Close button text start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays-pb-close-button-text">
                            <span><?php echo __('Close button text', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the close button text. The default value is “x”.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" id="ays-pb-close-button-text" name="ays_pb_close_button_text" class="ays-pb-text-input ays-pb-text-input-short" value="<?php echo $close_button_text; ?>" />
                            </div>
                        </div>
                    </div> 
                </div>
                <!-- Close button text end -->
                <hr>
                <!-- Close button hover text start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays-pb-close-button-hover-text">
                            <span><?php echo __('Close button hover text', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Displays text when cursor is placed over the close button", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" id="ays-pb-close-button-hover-text" name="ays_pb_close_button_hover_text" class="ays-pb-text-input ays-pb-text-input-short" value="<?php echo $close_button_hover_text; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Close button hover text end -->
                <hr>
                <!-- Autoclose Delay (in seconds) start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-autoclose">
                            <span><?php echo __('Autoclose Delay (in seconds)', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Close the popup after a specified time delay (in seconds). To disable the option leave it blank or set it to 0.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-autoclose" name="<?php echo $this->plugin_name; ?>[autoclose]" class="ays-pb-text-input ays-pb-text-input-short" value="<?php echo $autoclose; ?>" />
                        <span style="display:block;" class="ays-pb-small-hint-text">Set 0 for disabling</span>  
                    </div> 
                </div>
                <!-- Autoclose Delay (in seconds) end -->
                <hr class="ays-pb-hide-timer-hr <?php echo ($autoclose == '0') ? 'display_none' : ''; ?>">
                <!-- hide timer -->
                <div class="form-group row" id="ays_pb_hide_timer_popup" style="<?php echo ($autoclose == '0') ? 'display:none;' : ''; ?>">
                    <div class="col-sm-3">
                        <label for="ays_pb_hide_timer">
                            <?php echo __('Hide timer', "ays-popup-box"); ?>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Hide the timer when the Autoclose Delay option is enabled.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input id="ays_pb_hide_timer" type="checkbox" class="ays_pb_hide_timer" name="ays_pb_hide_timer" <?php echo ($ays_pb_hide_timer == 'on' )? 'checked' : '' ?> value="on"/>
                    </div>
                </div>
                <!-- hide timer -->
                <hr style="<?php echo ($view_type == 'video') ? '' : 'display:none;'; ?>">
                <!-- Autoclose on video completion -->
                <div class="form-group row ays_pb_autoclose_on_completion_container" style="<?php echo ($view_type == 'video') ? '' : 'display:none;'; ?>">
                    <div class="col-sm-3">
                        <label for="ays_pb_autoclose_on_completion">
                            <?php echo __('Autoclose on video completion', "ays-popup-box"); ?>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Automatically close the popup after a video completion.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input id="ays_pb_autoclose_on_completion" type="checkbox" name="ays_pb_autoclose_on_completion" <?php echo ($ays_pb_autoclose_on_completion == 'on' )? 'checked' : '' ?> value="on"/>
                    </div>
                </div>
                <!-- Autoclose on video completion -->
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-close_button_delay">
                            <span><?php echo __('Close button delay (milliseconds)', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __(" Set delay in milliseconds for displaying the popup close button. To disable the option leave it blank or set it to 0.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-close_button_delay" name="ays_pb_close_button_delay"  class="ays-pb-text-input ays-pb-text-input-short"  value="<?php echo $close_button_delay; ?>" />
                        <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __( '1 sec = 1000 ms', "ays-popup-box" ); ?></span>
                    </div>
                </div>
                <hr>   
                <!-- close popup by scroll start-->
                <div class="col-sm-12 only_pro">
                    <div class="pro_features">
                        <div>
                            <p>
                                <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row ays-pb-pro-feature-row" style="margin-bottom:0;">
                        <div class="col-sm-3">
                            <label for="ays_close_popup_scroll" style="line-height: 50px;">
                                <span><?php echo __('Close the popup on scroll', "ays-popup-box"); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the scroll length by pixels to close the popup when scrolling.", "ays-popup-box"); ?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9" style="padding:10px 0;">
                                <input type="text" name="close_popup_scroll" class="ays-pb-onoffswitch-checkbox" id="ays_close_popup_scroll" value=""/>
                        </div>
                    </div>
                </div>
                <div class="ays-pb-youtube-video-link">
                    <div class="ays-pb-youtube-video-play-icon">
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                    </div>
                    <div class="ays-pb-small-hint-text">
                        <a href="https://youtu.be/oOvHTcePpys?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                            <?php echo __( 'Adding a Video or Iframe popup to your WordPress website', "ays-popup-box"  ); ?>
                        </a>
                    </div>
                </div>
                <!-- close popup by scroll end-->
                <hr>
                <!-- close popup by clicking submit btn by classname start -->
                <div class="col-sm-12 only_pro">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                                </p>
                            </div>
                        </div>
                    <div class="form-group row ays_toggle_parent" style="padding: 10px 0; margin:0;">
                        <div class="col-sm-3">
                            <label for="ays_close_popup_by_classname">
                                <?php echo __('Close by classname (onclick)', "ays-popup-box")?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Copy the given classname, assign it to any tag in the content as well as inside the popup. And the popup will close when the user clicks on the classname.Note: Save your popup before copying the given classname.',"ays-popup-box")?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-1">
                            <input type="checkbox" name="ays_enable_close_by_classname" class="ays-pb-onoffswitch-checkbox ays-enable-timer1 ays_toggle_checkbox" id="ays_close_popup_by_classname" checked/>
                        </div>
                        <div class="col-sm-8 ays_toggle_target ays_divider_left">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="text" name="ays_pb_close_by_classname_".$id id="ays_pb_close_by_classname" class="ays-enable-timerl ays-text-input" value="<?php echo "ays_pb_close_by_classname_".$id ;?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ays-pb-youtube-video-link">
                    <div class="ays-pb-youtube-video-play-icon">
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                    </div>
                    <div class="ays-pb-small-hint-text">
                        <a href="https://www.youtube.com/watch?v=z6TfjOR2CVM" target="_blank">
                            <?php echo __( 'How To Close Popup On Click by Classname', "ays-popup-box"  ); ?>
                        </a>
                    </div>
                </div>
                <!-- close popup by clicking submit btn by classname end -->
                <hr>
                <p class="ays-subtitle"><?php echo  __('Advanced Settings', "ays-popup-box") ?></p>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_popup_name">
                            <?php echo __('Popup name', "ays-popup-box"); ?>
                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Write the name of the particular Popup. The name will be shown in the Popup list table.',"ays-popup-box");?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="ays_pb_popup_name" name="ays_pb_popup_name" class="ays-text-input ays-pb-popup-name" value="<?php echo $popup_name; ?>">
                    </div>
                </div> <!-- Popup Name -->
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays-category">
                            <?php echo __('Popup category', "ays-popup-box"); ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Categorize your popup selecting from the premade categories.',"ays-popup-box")?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="ays-category" name="ays_popup_category" class="ays_pb_aysDropdown"> 
                            <?php
                            $cat = 0;
                            foreach ($popup_categories as $popup_category) {

                                $checked = (intval($popup_category['id']) == $category_id ) ? "selected" : "";
                                if ($cat == 0 && $category_id == 0) {
                                    $checked = 'selected';
                                }
                                echo "<option value='" . $popup_category['id'] . "' " . $checked . ">" . stripslashes($popup_category['title']) . "</option>";
                                $cat++;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-onoffoverlay">
                            <span><?php echo __('Enable Overlay', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable to show the overlay outside the popup.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9 ays_toggle_parent">
                        <div class="row">
                            <div class="col-sm-2">
                                <p class="onoffswitch">
                                    <input type="checkbox" name="<?php echo $this->plugin_name; ?>[onoffoverlay]" class="ays-pb-onoffswitch-checkbox ays_toggle_checkbox" id="<?php echo $this->plugin_name; ?>-onoffoverlay" <?php if($onoffoverlay == 'On'){ echo 'checked';} else { echo '';} ?> >
                                </p>
                            </div>
                            <div class="col-sm-7 ays_toggle_target ays_divider_left opacity_box" style=" <?php echo ( $onoffoverlay == 'On' ) ? '' : 'display:none'; ?>">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="ays-overlay-opacity" class="form-check-label">
                                                <?php echo __('Opacity:',"ays-popup-box")?>
                                            </label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="number" name="<?php echo $this->plugin_name; ?>[overlay_opacity]" id="ays-overlay-opacity" class="ays-text-input" value=<?php echo round($overlay_opacity, 1) ?> min="0" max="1" step="0.1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="<?php echo ($onoffoverlay == 'On') ? '' : 'display_none'; ?>">                
                <div class="form-group row ays-pb-blured-overlay" style="<?php echo ($onoffoverlay == 'On') ? '' : 'display:none;'; ?> ">
                    <div class="col-sm-3">
                        <label for="ays_pb_blured_overlay">
                            <span><?php echo __('Enable blured overlay', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable blurred overlay of the popup.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="ays_pb_blured_overlay" class="" id="ays_pb_blured_overlay" <?php echo $blured_overlay ? 'checked' : '' ?> >
                        </p>
                    </div>
                </div>
                <hr>                
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-ays_pb_cookie">
                            <span style="font-size: 15px;"><?php echo __("Display once per session", "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Define the interval between the popup sessions in minutes. To disable the option, set 0. E.g. set it to 1440 to show the popup once a day to each user.', "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" id="<?php echo $this->plugin_name; ?>-ays_pb_cookie" name="<?php echo $this->plugin_name; ?>[cookie]" class="ays-pb-text-input ays-pb-text-input-short" value="<?php echo $cookie; ?>" />
                    </div>
                </div>
                <hr>                
                <div class="form-group row ays_toggle_parent">
                    <div class="col-sm-3" style="padding-right: 0px;">
                        <label for="ays_enable_pb_sound">
                            <?php echo __('Enable popup sound',"ays-popup-box")?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('In case of enabling this option, insert and select the sound from the General Settings of Popup Box navigation menu. Note: This function only works with “On Click” or “Both” trigger types.',"ays-popup-box")?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="checkbox" id="ays_enable_pb_sound"
                               name="ays_pb_enable_sounds" class="ays_toggle_checkbox"
                               value="on" <?php echo $enable_pb_sound ? 'checked' : ''; ?>/>
                    </div>
                    <div class="col-sm-7 ays_toggle_target ays_divider_left" style="<?php echo $enable_pb_sound ? '' : 'display:none;' ?>">
                        <?php if($ays_pb_sound_status): ?>
                        <blockquote class=""><?php echo __('Sounds are selected. For change sounds go to', "ays-popup-box"); ?> <a href="?page=ays-pb-settings" target="_blank"><?php echo __('General Settings', "ays-popup-box"); ?></a> <?php echo __('page', "ays-popup-box"); ?></blockquote>
                        <?php else: ?>
                        <blockquote class=""><?php echo __('Sounds are not selected. For selecting sounds go to', "ays-popup-box"); ?> <a href="?page=ays-pb-settings" target="_blank"><?php echo __('General Settings', "ays-popup-box"); ?></a> <?php echo __('page', "ays-popup-box"); ?></blockquote>
                        <?php endif; ?>
                    </div>
                </div>
                <hr>
                <!-- Enable Social Media links start-->
                <div class="form-group row ays_toggle_parent">
                    <div class="col-sm-3">
                        <label for="ays_pb_enable_social_links">
                            <?php echo __('Enable Social Media links',"ays-popup-box")?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Display social media links at the bottom of your popup container.',"ays-popup-box")?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" class="ays-enable-timer1 ays_toggle_checkbox" id="ays_pb_enable_social_links"
                            name="ays_pb_enable_social_links"
                            value="on" <?php echo $enable_social_links ? 'checked' : '' ?>/>
                    </div>
                    <div class="col-sm-6 ays_toggle_target ays_divider_left <?php echo $enable_social_links ? '' : 'display_none' ?>">
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>
                                    <?php echo __('Heading for share buttons',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Text that will be displayed over share buttons.',"ays-popup-box"); ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                    $content = $social_buttons_heading;
                                    $editor_id = 'ays_pb_social_buttons_heading';
                                    $settings = array('editor_height' => $pb_wp_editor_height, 'textarea_name' => 'ays_pb_social_buttons_heading', 'editor_class' => 'ays-textarea', 'media_elements' => false);
                                    wp_editor($content, $editor_id, $settings);
                                ?>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_linkedin_link">
                                    <?php echo __('Linkedin link',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Linkedin profile or page link for showing at the end of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="ays-text-input" id="ays_pb_linkedin_link" name="ays_social_links[ays_pb_linkedin_link]"
                                    value="<?php echo $linkedin_link; ?>" />
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_facebook_link">
                                    <?php echo __('Facebook link',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Facebook profile or page link for showing at the end of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="ays-text-input" id="ays_pb_facebook_link" name="ays_social_links[ays_pb_facebook_link]"
                                    value="<?php echo $facebook_link; ?>" />
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_twitter_link">
                                    <?php echo __('Twitter link',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Twitter profile or page link for showing at the end of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="ays-text-input" id="ays_pb_twitter_link" name="ays_social_links[ays_pb_twitter_link]"
                                    value="<?php echo $twitter_link; ?>" />
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_vkontakte_link">
                                    <?php echo __('VKontakte link',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('VKontakte profile or page link for showing at the end of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="ays-text-input" id="ays_pb_vkontakte_link" name="ays_social_links[ays_pb_vkontakte_link]"
                                    value="<?php echo $vkontakte_link; ?>" />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_youtube_link">
                                    <?php echo __('Youtube link',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Youtube page link for showing at the end of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="ays-text-input" id="ays_pb_youtube_link" name="ays_social_links[ays_pb_youtube_link]"
                                    value="<?php echo $youtube_link; ?>" />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_instagram_link">
                                    <?php echo __('Instagram link',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Instagram page link for showing at the end of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="ays-text-input" id="ays_pb_instagram_link" name="ays_social_links[ays_pb_instagram_link]"
                                    value="<?php echo $instagram_link; ?>" />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_behance_link">
                                    <?php echo __('Behance link',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Behance page link for showing at the end of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="ays-text-input" id="ays_pb_behance_link" name="ays_social_links[ays_pb_behance_link]"
                                    value="<?php echo $behance_link; ?>" />
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- Enable Social Media links end-->
                <hr>
                <!-- scedule start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="active_date_check">
                            <?php echo __('Schedule the popup', "ays-popup-box"); ?>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Define the period of time when the popup will be active.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9 ays_toggle_parent">
                        <div class="row">
                            <div class="col-sm-3">
                                <input id="active_date_check" type="checkbox" class="active_date_check ays_toggle_checkbox"
                                       name="active_date_check" <?php echo $active_date_check ? 'checked' : '' ?>>
                            </div>
                            <div class="col-sm-9 ays_toggle_target ays_divider_left active_date" style="<?php echo $active_date_check ? '' : 'display:none' ?>">
                                <!-- --Aro Start--- -->
                                <!-- -1- -->
                                <div class="form-group">
                                     <div class="row"> 
                                        <div class="col-sm-3">
                                            <label class="form-check-label" for="ays-active"> <?php echo __('Start date:', "ays-popup-box"); ?> </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" class="ays-text-input ays-pb-text-input ays-pb-text-input-short ays_actDect ays_pb_act_dect" id="ays-active" name="ays-active"
                                                   value="<?php echo $activePopup; ?>" placeholder="<?php echo current_time( 'mysql' ); ?>">
                                                <div class="input-group-append">
                                                    <label for="ays-active" class="input-group-text">
                                                        <span><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/calendar.svg"?>"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- -2- -->
                                <div class="form-group">
                                     <div class="row"> 
                                        <div class="col-sm-3">
                                            <label class="form-check-label" for="ays-deactive"> <?php echo __('End date:', "ays-popup-box"); ?> </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" class="ays-text-input ays-pb-text-input ays-pb-text-input-short ays_actDect ays_pb_act_dect" id="ays-deactive" name="ays-deactive"
                                                   value="<?php echo $deactivePopup; ?>" placeholder="<?php echo current_time( 'mysql' ); ?>">
                                                <div class="input-group-append">
                                                    <label for="ays-deactive" class="input-group-text">
                                                        <span><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/calendar.svg"?>"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <!-- --Aro End--- -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- scedule start -->
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label>
                            <?php echo __('Change the popup creation date',"ays-popup-box"); ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Change the popup creation date to the preferred date.',"ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="input-group mb-3">
                            <input type="text" class="ays-text-input ays-pb-text-input ays-pb-text-input-short ays-pb-date-create" id="ays_pb_change_creation_date" name="ays_pb_change_creation_date" value="<?php echo $pb_create_date; ?>" placeholder="<?php echo current_time( 'mysql' ); ?>">
                            <div class="input-group-append">
                                <label for="ays_pb_change_creation_date" class="input-group-text">
                                    <span><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/calendar.svg"?>"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div> <!-- Change current pb creation date -->
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_create_author">
                            <?php echo __('Change the popup author',"ays-popup-box"); ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Change the popup author to the preferred one.Write the User ID in the field. To find the ID, go to the WordPress User's section and hover on the user. You can find the user ID in the link below. Please note, that in case you write an ID, by which there are no users found, the changes will not be applied and the previous author will remain the same.","ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                    <select id="ays_pb_create_author" class="" name="ays_pb_create_author">
                        <option value=""><?php echo __('Select User',"ays-popup-box")?></option>
                        <?php
                            foreach ($ays_pb_wp_users as $key => $user) :
                                $pb_user_id = ( isset( $user->ID ) && $user->ID != '') ? absint( sanitize_text_field( $user->ID ) ) : 0;
                                $pb_user_display_name = ( isset( $user->display_name ) && $user->display_name != '') ? stripslashes(esc_html( $user->display_name )) : '';
                                $selected = '';
                                if($pb_user_id == $change_pb_create_author){
                                    $selected = 'selected';
                                }
                        ?>  
                            <option value="<?php echo $pb_user_id;?>" <?php echo $selected; ?>>
                                <?php echo $pb_user_display_name; ?>
                            </option>
                        <?php
                            endforeach;
                        ?>
                    </select>
                    </div>
                </div> <!-- Change the author of the current popup box -->
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                         <label for="ays_pb_disable_scroll">
                            <span><?php echo __('Disable page scrolling', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The page will not be scrolled while the popup is displaying. Note: When the option is enabled, the system hides the scrolling of the HTML tag. As the scrolling is hidden, it is automatically scrolling the popup to the top and the plugin doesn't have a connection to this. ", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="disable_scroll" class="ays-pb-onoffswitch-checkbox" id="ays_pb_disable_scroll" <?php echo ($disable_scroll) ? 'checked' : ''; ?> />
                        </p>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                         <label for="ays_pb_enable_dismiss">
                            <span><?php echo __('Enable dismiss ad', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("After enabling this option the dismiss ad button will be displayed in the popup. After clicking on the button the ads will be dismissed for 1 month.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9 row ays_toggle_parent">
                        <div class="col-sm-3">
                            <input type="checkbox" name="ays_pb_enable_dismiss" class="ays_toggle_checkbox ays-pb-onoffswitch-checkbox" id="ays_pb_enable_dismiss" <?php echo ($enable_dismiss) ? 'checked' : ''; ?> />
                        </div>
                        <div class="form-group row col-sm-9 ays_toggle_target ays_divider_left" style=" <?php echo ( $enable_dismiss ) ? '' : 'display:none'; ?>" >
                            <div class="col-sm-3">
                                <label for="ays_pb_enable_dismiss_text">
                                    <span><?php echo __('Dismiss ad text', "ays-popup-box"); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Write the text that you want to be displayed on the dismiss ad button.", "ays-popup-box"); ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="ays_pb_enable_dismiss_text" class="ays-text-input" id="ays_pb_enable_dismiss_text" value="<?php echo $enable_dismiss_text; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                         <label for="ays_pb_disable_scroll_on_popup">
                            <span><?php echo __('Disable popup scrolling', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("After enabling this option the content in the popup will not be scrolled.", "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input type="checkbox" name="ays_pb_disable_scroll_on_popup" class="ays-pb-onoffswitch-checkbox" id="ays_pb_disable_scroll_on_popup" <?php echo ($ays_pb_disable_scroll_on_popup) ? 'checked' : ''; ?> />
                    </div>
                </div>
                <hr>
                <div class="col-sm-12">
                    <div class="pro_features">
                        <div>
                            <p>
                                <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row" style="padding: 10px 0; margin: 0px;">
                        <div class="col-sm-3">
                            <label for="active_date_check">
                                <?php echo __('Multiple Scheduling', "ays-popup-box"); ?>
                                <a class="ays_help ays-pb-help-pro" data-toggle="tooltip"
                                title="<?php echo __('The period of time when Popup will be active', "ays-popup-box") ?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_toggle_parent">
                            <div class="active_date_check_header">
                                <input id="" type="checkbox" class="active_date_check ays_toggle_checkbox" checked>
                                <a href="javascript:void(0)" class="ays_pb_plus_schedule ays_toggle_target ays_divider_left active_date">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/plus-square.svg"?>">
                                </a>
                           </div>
                            <div class="form-group ays_toggle_target ays_divider_left active_date">
                                <div class="row">
                                    <div class="col-sm-12 ays_schedule_parent">
                                        <div class="form-group ays_schedule_form">
                                            <label class="form-check-label active_deactive_date" for="ays_active"> 
                                                <?php echo __('Start date:', "ays-popup-box"); ?> 
                                                <div class="input-group-append">
                                                    <input type="text"class="ays_pb_act_dect">           
                                                    <label style="padding: 0 12px;" class="input-group-text">
                                                        <span><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/calendar.svg"?>"></span>
                                                    </label>
                                                </div>
                                            </label>
                                            <label class="form-check-label active_deactive_date"> 
                                                <?php echo __('End date:', "ays-popup-box"); ?> 
                                                <div class="input-group-append">
                                                    <input type="text" class="ays_pb_act_dect">
                                                    <label style="padding: 0 12px;" class="input-group-text">
                                                        <span><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/calendar.svg"?>"></span>
                                                    </label>
                                                </div>
                                            </label>
                                            <a href="javascript:void(0)" class="ays_pb_delete_schedule">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/times.svg"?>">
                                            </a>                                        
                                        </div>
                                        <div class="form-group ays_schedule_form">
                                            <label class="form-check-label active_deactive_date" for="ays_active"> 
                                                <?php echo __('Start date:', "ays-popup-box"); ?> 
                                                <div class="input-group-append">
                                                    <input type="text"class="ays_pb_act_dect">           
                                                    <label style="padding: 0 12px;" class="input-group-text">
                                                        <span><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/calendar.svg"?>"></span>
                                                    </label>
                                                </div>
                                            </label>
                                            <label class="form-check-label active_deactive_date"> 
                                                <?php echo __('End date:', "ays-popup-box"); ?> 
                                                <div class="input-group-append">
                                                    <input type="text" class="ays_pb_act_dect">
                                                    <label style="padding: 0 12px;" class="input-group-text">
                                                        <span><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/calendar.svg"?>"></span>
                                                    </label>
                                                </div>
                                            </label>
                                            <a href="javascript:void(0)" class="ays_pb_delete_schedule">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/times.svg"?>">
                                            </a>                                        
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ays-pb-youtube-video-link">
                    <div class="ays-pb-youtube-video-play-icon">
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                    </div>
                    <div class="ays-pb-small-hint-text">
                        <a href="https://youtu.be/yh8U4j7HsLE?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                            <?php echo __( "How to Add Countdown Timer Popup", "ays-popup-box"  ); ?>
                        </a>
                    </div>
                </div>
                <hr>
                <!-- Action on popup content click -->
                <div class="col-sm-12 only_pro">
                    <div class="pro_features">
                        <div>
                            <p>
                                <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row ays_toggle_parent" style="padding: 10px 0; margin:0px;">
                        <div class="col-sm-3">
                            <label for="ays_content_click">
                                <?php echo __(' Actions while clicking on the popup',"ays-popup-box")?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable closing the popup and/or redirecting to the custom URL in case of clicking on any area of the popup container.',"ays-popup-box")?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-1">
                            <input type="checkbox" id="ays_content_click" name="enable_content_click" class="ays_toggle_checkbox"
                                value="on" checked/>
                        </div>
                        <!-- close and redirect -->
                        <div class="col-sm-8 ays_toggle_target" style="display:block">
                            <!-- close -->
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <label for="ays_close_pb_content_click">
                                            <?php echo __('Enable closing',"ays-popup-box")?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If the option is enabled, then the popup will be closed if the user clicks on any area inside it.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="checkbox" id="ays_close_pb_content_click" name="enable_close_content_click"
                                            value="on" checked/>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <!-- redirect -->
                            <div class="col-sm-8 ays_toggle_parent_redirect">
                                <div class="form-group row">
                                    <div class="col-sm-5">
                                        <label for="ays_redirect_content_click">
                                            <?php echo __('Enable redirection',"ays-popup-box")?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable redirection to the custom URL when the user clicks on any area inside the popup.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" id="ays_redirect_content_click" name="enable_redirect_content_click"  class="ays_toggle_checkbox_redirect" value="on" checked/>
                                    </div>
                                    <div class="col-sm-6 ays_toggle_redirect" style="display:block;">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="ays_redirect_url_content_click"> <?php echo __('Redirection URL',"ays-popup-box")?>
                                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Provide the redirection URL.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" id="ays_redirect_url_content_click" name="redirect_url_content_click" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="ays_new_tab_content_click"> <?php echo __('Open in new tab',"ays-popup-box")?>
                                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('If the option is enabled, then the system will redirect the URL in a separate new tab.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" id="ays_new_tab_content_click" name="enable_new_tab_content_click" value="on" checked/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ays-pb-youtube-video-link">
                    <div class="ays-pb-youtube-video-play-icon">
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                    </div>
                    <div class="ays-pb-small-hint-text">
                        <a href="https://youtu.be/Puecfcp7JEs?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                            <?php echo __('Getting Started with WordPress Popup Box Plugin', "ays-popup-box")?>
                        </a>
                    </div>
                </div>
                <!-- action click end -->
                <!-- </div> -->
            </div>
            <div id="tab3" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab3') ? 'ays-pb-tab-content-active' : ''; ?>">
                <!-- <p class="ays-subtitle"><?php echo  __('Popup Styles', "ays-popup-box") ?></p> -->
                <hr/>
                <div class="ays_pb_themes <?php echo ('video' == $view_type) ? 'display_none_inp' : ''; ?>" >
                    <!-- <div class="row">
                        <div class="col-sm-12"> -->
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="<?php echo $this->plugin_name; ?>-view_type">
                                    <span>
                                        <?php echo __('Template', "ays-popup-box"); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose a pre-made popup template and customize it using options below.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                    </label>
                                </div>
                                <div class="col-sm-10 pb_theme_img_box">
                                    <div class="ays-pb-template-themes">
                                        <div class="ays-pb-template-content ays-pb-default-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('default' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                                    value="default" <?php echo ('default' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                        <p <?php echo ('default' == $view_type) ? 'class="apm_active_theme"' : '' ?> ><?php echo __('Default', "ays-popup-box") ?></p>
                                                        <p class="ays-pb-template-label-preview">
                                                            <a href="https://bit.ly/3yAJuOt" target="_blank">Preview</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-default-min.png' ?>" alt="<?php echo __('Default', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-red-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('lil' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]" value="lil" <?php echo ('lil' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                        <p <?php echo ('red' == $view_type) ? 'class="apm_active_theme"' : '' ?>><?php echo __('Red', "ays-popup-box") ?></p>
                                                        <p class="ays-pb-template-label-preview">
                                                            <a href="https://bit.ly/3Au6ss9" target="_blank">Preview</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-red-min.png' ?>"
                                                        alt="<?php echo __('Red', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-modern-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('image' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]" value="image" <?php echo ('image' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                    <p <?php echo ( 'image' == $view_type) ? 'class="apm_active_theme"' : '' ?>><?php echo __('Modern', "ays-popup-box") ?></p>
                                                        <p class="ays-pb-template-label-preview">
                                                            <a href="https://bit.ly/3bNERYh" target="_blank">Preview</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-modern-min.png' ?>" alt="<?php echo __('Modern', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-minimal-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('minimal' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]" value="minimal" <?php echo ('minimal' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                        <p <?php echo ( 'minimal' == $view_type) ? 'class="apm_active_theme"' : '' ?> ><?php echo __('Minimal', "ays-popup-box") ?></p>
                                                        <p class="ays-pb-template-label-preview" style="display:none;">
                                                            <a href="#">Preview</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-minimal.png' ?>" alt="<?php echo __('Minimal', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-sale-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('template' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]" value="template" <?php echo ('template' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                        <p <?php echo ( 'template' == $view_type) ? 'class="apm_active_theme"' : '' ?> ><?php echo __('Sale', "ays-popup-box") ?></p>
                                                        <p class="ays-pb-template-label-preview" style="display:none;">
                                                            <a href="#">Preview</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-sale-min.png' ?>" alt="<?php echo __('Sale', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- video theme -->
                                        <div class="ays-pb-template-content ays-pb-video-theme" style="display: none;">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('video' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" id="video_theme_view_type"  name="<?php echo $this->plugin_name; ?>[view_type]" value="video" <?php echo ('video' == $view_type ) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                        <p <?php echo ('video' == $view_type ) ? 'class="apm_active_theme"' : '' ?>><?php echo __('Video', "ays-popup-box") ?></p>
                                                        <p class="ays-pb-template-label-preview">
                                                            <a href="#">Preview</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/video_theme.png' ?>" alt="<?php echo __('Video', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays-pb-template-pro-themes">
                                        <div class="ays-pb-template-content ays-pb-peachy-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                    <p><?php echo __('Peachy', "ays-popup-box") ?></p>
                                                    <p>
                                                        <a href="https://bit.ly/3If66Hm" target="_blank" style="background:#d06b46;border: 1px solid #d06b46;">Demo</a>
                                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-peachy-min.png' ?>" alt="<?php echo __('Sale', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-yellowish-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                        <p><?php echo __('Yellowish', "ays-popup-box") ?></p>
                                                        <p>
                                                            <a href="https://bit.ly/3Iafmwy" target="_blank" style="background:#d06b46;border: 1px solid #d06b46;">Demo</a>
                                                            <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-yellowish-min.png' ?>" alt="<?php echo __('Sale', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-coral-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                    <p><?php echo __('Coral', "ays-popup-box") ?></p>
                                                    <p>
                                                        <a href="https://bit.ly/3AqvPLg" target="_blank" style="background:#d06b46;border: 1px solid #d06b46;">Demo</a>
                                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-coral-min.png' ?>" alt="<?php echo __('Coral', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="ays-pb-template-content ays-pb-frozen-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                    <p><?php echo __('Frozen', "ays-popup-box") ?></p>
                                                    <p>
                                                        <a href="https://bit.ly/3R5szuB" target="_blank" style="background:#d06b46;border: 1px solid #d06b46;">Demo</a>
                                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-frozen-min.png' ?>" alt="<?php echo __('Frozen', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-food-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                        <p><?php echo __('Food', "ays-popup-box") ?></p>
                                                        <p>
                                                            <a href="https://bit.ly/3Al4qKI" target="_blank" style="background:#d06b46;">Demo</a>
                                                            <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-food-min.png' ?>" alt="<?php echo __('Food', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-forest-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                    <p><?php echo __('Forest', "ays-popup-box") ?></p>
                                                    <p>
                                                        <a href="https://bit.ly/3acggfr" target="_blank" style="background:#d06b46; border: 1px solid #d06b46;">Demo</a>
                                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-forest-min.png' ?>" alt="<?php echo __('Forest', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="ays-pb-template-content ays-pb-book-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                    <p><?php //echo __('Book', "ays-popup-box") ?></p>
                                                    <p>
                                                        <a href="https://bit.ly/3acggfr" target="_blank" style="background:#d06b46; border: 1px solid #d06b46;">Demo</a>
                                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php //echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-book-min.png' ?>" alt="<?php //echo __('Book', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="ays-pb-template-content ays-pb-holiday-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-template-label">
                                                    <p><?php //echo __('Holiday', "ays-popup-box") ?></p>
                                                    <p>
                                                        <a href="https://bit.ly/3acggfr" target="_blank" style="background:#d06b46; border: 1px solid #d06b46;">Demo</a>
                                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank">Pro</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php //echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-holiday-min.png' ?>" alt="<?php //echo __('Holiday', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="ays-pb-template-themes-view-more-button-content">
                                        <hr class="ays-pb-template-themes-view-more-border">
                                        <div class="ays-pb-template-themes-view-more-button">
                                            <button class="ays-pb-template-themes-view-more-btn <?php echo !in_array( $view_type, $not_default_view_types ) ? '' : 'display_none'; ?>" type="button">View More</button>
                                            <button class="ays-pb-template-themes-hide-btn" style="<?php echo !in_array( $view_type, $not_default_view_types ) ? 'display:none' : 'display:block'; ?>" type="button">Hide</button>
                                        </div>
                                        <hr class="ays-pb-template-themes-view-more-border">
                                    </div>
                                    <div class="ays-pb-template-themes-view-more" style="<?php echo !in_array( $view_type, $not_default_view_types ) ? 'display:none' : 'display:flex'; ?>">
                                        <div class="ays-pb-template-content ays-pb-macos-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('mac' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                            value="mac" <?php echo ('mac' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                    <p <?php echo ('mac' == $view_type) ? 'class="apm_active_theme"' : '' ?>><?php echo __('MacOS window', "ays-popup-box") ?></p>
                                                    <p class="ays-pb-template-label-preview">
                                                        <a href="#">Preview</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-default.png' ?>" alt="<?php echo __('MacOS ', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-ubuntu-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('ubuntu' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                        <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]" value="ubuntu" <?php echo ('ubuntu' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                    <p <?php echo ('ubuntu' == $view_type) ? 'class="apm_active_theme"' : '' ?>><?php echo __('Ubuntu', "ays-popup-box") ?></p>
                                                    <p class="ays-pb-template-label-preview">
                                                        <a href="#">Preview</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-ubuntu-min.png' ?>" alt="<?php echo __('Ubuntu', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-winxp-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('winXP' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                            value="winXP" <?php echo ('winXP' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                    <p <?php echo ('win98' == $view_type) ? 'class="apm_active_theme"' : '' ?>><?php echo __('Windows XP', "ays-popup-box") ?></p>
                                                    <p class="ays-pb-template-label-preview">
                                                        <a href="#">Preview</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-windowsxp.png' ?>" alt="<?php echo __('Windows XP', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-win98-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('win98' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]"
                                                            value="win98" <?php echo ('win98' == $view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                    <p <?php echo ('win98' == $view_type) ? 'class="apm_active_theme"' : '' ?>><?php echo __('Windows 98', "ays-popup-box") ?></p>
                                                    <p class="ays-pb-template-label-preview">
                                                        <a href="#">Preview</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-windows 98.png' ?>" alt="<?php echo __('Windows 98', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-pb-template-content ays-pb-command-prompt-theme">
                                            <div class="ays-pb-template-overlay-preview">
                                                <div class="ays-pb-choose-template-div <?php echo ('cmd' != $view_type) ? 'display_none' : '' ?>">
                                                    <div class="ays-pb-template-checkbox">
                                                        <label class="ays-pb-template-checkbox-container">
                                                            <input type="radio" name="<?php echo $this->plugin_name; ?>[view_type]" value="cmd" <?php echo ('cmd' ==$view_type) ? 'checked' : '' ?>>
                                                            <span class="ays-pb-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ays-pb-template-choose-template-btn">
                                                        <button type="button">Choose Template</button>
                                                    </div>
                                                </div>
                                                <div class="ays-pb-template-label">
                                                    <p <?php echo ('cmd' == $view_type) ? 'class="apm_active_theme"' : '' ?>><?php echo __('Command prompt', "ays-popup-box") ?></p>
                                                    <p class="ays-pb-template-label-preview">
                                                        <a href="#">Preview</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb_theme_image_div col">
                                                <div class="ays-pb-template-img">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . '/images/themes/word-press-popup-maker-template-command-prompt.png' ?>" alt="<?php echo __('Command prompt', "ays-popup-box") ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </div>
                    </div> -->
                </div>
                <hr class="video_hr">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group row" id="ays-pb-show-title-description-box">
                            <div class="col-sm-4">
                                <label>
                                    <?php echo __("Display Content", "ays-popup-box");?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Show Popup head information- Enable to show the title and(or) the description inside the popup.", "ays-popup-box"); ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <label class="ays-pb-label-style"><?php echo __("Show title", "ays-popup-box");?>
                                    <input type="checkbox" class="ays_pb_title" name="show_popup_title" <?php if($show_popup_title == 'On'){ echo 'checked';} else { echo '';} ?>/>
                                </label>
                                <label class="ays-pb-label-style"><?php echo __("Show description", "ays-popup-box");?>
                                    <input type="checkbox" class="ays_pb_desc" name="show_popup_desc" <?php if($show_popup_desc == 'On'){ echo 'checked';} else { echo '';} ?>/>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <p class="ays-subtitle"><?php echo  __('Popup Dimensions', "ays-popup-box") ?></p>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for='<?php echo $this->plugin_name; ?>-width'>
                                    <?php echo __('Width', "ays-popup-box"); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the width of the popup in pixels. If you put 0 or leave it blank, the width will be 100%. It accepts only numerical values and you can choose whether to define the value by percentage or in pixels.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays-pb-width-content ays_divider_left">
                                <div>   
                                    <input type="number" id="<?php echo $this->plugin_name; ?>-width"  class="ays-pb-text-input ays-pb-text-input-short ays_pb_width"  name="<?php echo $this->plugin_name; ?>[width]" value="<?php echo $width; ?>" <?php echo $disable_width; ?>/>
                                    <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __("For 100% leave blank", "ays-popup-box");?></span>
                                </div>
                                <div class="ays_pb_width_by_percentage_px_box">
                                    <select name="ays_popup_width_by_percentage_px" id="ays_popup_width_by_percentage_px" class="ays_pb_aysDropdown ays-pb-percent">
                                        <option value="pixels" <?php echo $popup_width_by_percentage_px == "pixels" ? "selected" : ""; ?>>
                                            <?php echo __( "px", "ays-popup-box" ); ?>
                                        </option>
                                        <option value="percentage" <?php echo $popup_width_by_percentage_px == "percentage" ? "selected" : ""; ?>>
                                            <?php echo __( "%", "ays-popup-box" ); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- popuop width with percentage end -->
                        <hr>
                        <!-- mobile width with percentage -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays-pb-mobile-width">
                                    <?php echo  __('Mobile width',"ays-popup-box") ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify popup width for mobile in percentage. Note: This option works for the screens with less than 768 pixels width.", "ays-popup-box"); ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="ays-pb-mobile-width" class="ays-pb-text-input ays-pb-text-input-short" name="ays_pb_mobile_width" type="number" style="display:inline-block;" value="<?php echo $mobile_width; ?>" /> %
                                 <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __("For 100% leave blank", "ays-popup-box");?></span>
                            </div>
                        </div>
                        <hr>
                        <!-- mobile max-width with percentage -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays-pb-mobile-max-width">
                                    <?php echo  __('Max-width for mobile',"ays-popup-box") ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the max-width of the popup for mobile in percentage. Note: This option works for screens with less than 768 pixels width.", "ays-popup-box"); ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="ays-pb-mobile-max-width" class="ays-pb-text-input ays-pb-text-input-short" name="ays_pb_mobile_max_width" type="number" style="display:inline-block;" value="<?php echo $mobile_max_width; ?>"> %
                                <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __("For 100% leave blank", "ays-popup-box");?></span>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-height">
                                    <span><?php echo __('Height', "ays-popup-box"); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the height of the popup in pixels. Leave it blank or put 0 to select the default theme value.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="number" id="<?php echo $this->plugin_name; ?>-height"  class="ays-pb-text-input ays-pb-text-input-short ays_pb_height" name="<?php echo $this->plugin_name; ?>[height]" value="<?php echo $height; ?>" <?php echo $disable_height ;?>> 
                                <span><?php echo __( 'px', "ays-popup-box" ); ?></span>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_mobile_height">
                                    <span><?php echo __('Mobile height', "ays-popup-box"); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify popup height for mobile in pixels. Note: This option works for the screens with less than 768 pixels width.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="number" id="ays_pb_mobile_height"  class="ays-pb-text-input ays-pb-text-input-short ays-pb-mobile-height" name="ays_pb_mobile_height" value="<?php echo $mobile_height; ?>"/>
                                <span><?php echo __( 'px', "ays-popup-box" ); ?></span>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for='ays_pb_min_height'>
                                    <?php echo __('Popup min-height', "ays-popup-box"); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the popup's minimal height in pixels.","ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="number" class="ays-pb-text-input ays-pb-text-input-short" id='ays_pb_min_height' name='ays_pb_min_height' value="<?php echo $pb_min_height ?>" <?php echo $disable_height ;?>>
                                <span><?php echo __( 'px', "ays-popup-box" ); ?></span>
                            </div>
                        </div>
                        <hr>
                        <!-- open popup full screen -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="open_pb_fullscreen">
                                    <span><?php echo __('Full-screen mode', "ays-popup-box"); ?></span>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable this option to display the popup on a full screen.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="checkbox" id="open_pb_fullscreen" class="" name="enable_pb_fullscreen"  <?php echo $ays_enable_pb_fullscreen == 'on' ? 'checked' : ''; ?> />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row ays_pb_content_padding_option">
                            <div class="col-sm-4">
                                <label for='ays_popup_content_padding'>
                                    <?php echo __('Content padding', "ays-popup-box"); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the padding of the popup in pixels. It accepts only numerical values and you can choose whether to define the value by percentage or in pixels.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays-pb-padding-content ays_divider_left ays-pb-padding-content-default">
                                <div>   
                                    <input type="number" id="ays_popup_content_padding"  class="ays-pb-text-input ays-pb-text-input-short ays_pb_padding"  name="ays_popup_content_padding" value="<?php echo $padding; ?>"/>
                                    <p style="font-weight: 600;" class="ays-pb-small-hint-text">
                                        <?php echo __("Default value = ", "ays-popup-box");?>
                                        <span style="font-weight: 800;"><?php echo __($default_padding_value, "ays-popup-box");?></span>
                                    </p>
                                </div>
                                <div class="ays_pb_padding_by_percentage_px_box">
                                    <select name="ays_popup_padding_by_percentage_px" id="ays_popup_padding_by_percentage_px" class="ays_pb_aysDropdown ays-pb-percent">
                                        <option value="pixels" <?php echo $popup_padding_by_percentage_px == "pixels" ? "selected" : ""; ?>>
                                            <?php echo __( "px", "ays-popup-box" ); ?>
                                        </option>
                                        <option value="percentage" <?php echo $popup_padding_by_percentage_px == "percentage" ? "selected" : ""; ?>>
                                            <?php echo __( "%", "ays-popup-box" ); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="ays-subtitle"><?php echo  __('Text style', "ays-popup-box") ?></p>
                        <hr>
                        <!-- Popup Text Color End -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_textcolor">
                                    <span>
                                        <?php echo  __('Text color',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the text color written inside the popup.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_textcolor" type="text" class="ays_pb_color_input ays_pb_textcolor_change" name="<?php echo $this->plugin_name; ?>[ays_pb_textcolor]" value="<?php echo wp_unslash($textcolor); ?>" data-default-color="#000000" data-alpha="true">
                            </div>
                        </div>
                        <!-- Popup Text Color End -->
                        <hr>
                        <!-- Popup Font Family Start -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_font_family">
                                    <?php echo  __('Font family',"ays-popup-box") ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose the popup text font family.", "ays-popup-box"); ?>">
                                       <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <select id="ays_pb_font_family" class="ays_pb_aysDropdown" name="ays_pb_font_family">
                                <?php
                                    $selected  = "";
                                    foreach ($font_families as $key => $pb_font_family) {
                                        if(is_array($pb_font_family)){
                                            if (in_array($font_family_option,$pb_font_family)) {
                                               $selected = "selected";
                                            }
                                            else{
                                                $selected = "";
                                            }
                                        }else{
                                            if($pb_font_family == $font_family_option){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                        }
                                    
                                ?>
                                    <option value="<?php echo $pb_font_family ;?>" <?php echo $selected ;?>>
                                        <?php echo $pb_font_family; ?>
                                    </option>

                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <!-- Popup Font Family End -->
                        <hr>
                        <!-- Font Size start -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_font_size">
                                    <?php echo  __('Description font size',"ays-popup-box") ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the font size of the popup description in pixels.", "ays-popup-box"); ?>">
                                       <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="ays_pb_font_size_for_pc">
                                            <?php echo  __('On PC',"ays-popup-box") ?>  
                                                <a class="ays_help" data-toggle="tooltip" title="" data-original-title="Define the font size for PC devices.">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                </a>
                                            </label>
                                        </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="number" id="ays_pb_font_size_for_pc" class="ays-pb-text-input ays-pb-text-input-short" name="ays_pb_font_size" value="<?php echo $pb_font_size;?>"/>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="ays_pb_font_size_for_mobile">
                                            <?php echo  __('On mobile',"ays-popup-box") ?>  
                                                <a class="ays_help" data-toggle="tooltip" title="" data-original-title="Define the font size for mobile devices.">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                </a>
                                            </label>
                                        </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="number" id="ays_pb_font_size_for_mobile" class="ays-pb-text-input ays-pb-text-input-short" name="ays_pb_font_size_for_mobile" value="<?php echo $pb_font_size_for_mobile;?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Font Size end -->
                        <hr>
                        <!-- title styles start -->
                        <!-- title text shadow start -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_enable_title_text_shadow">
                                    <?php echo __('Title text shadow',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Add text shadow to the popup title.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                    <span style="<?php if($show_popup_title == 'On'){ echo 'display:none';} else { echo '';} ?>" class="ays-pb-small-hint-text ays-pb-title-shadow-small-hint"><?php echo __("This option is not available currently as the Show title Option is disable.", "ays-popup-box");?></span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left ays-pb-title-shadow">
                                <input type="checkbox" class="ays_toggle ays_toggle_slide" id="ays_enable_title_text_shadow" name="ays_enable_title_text_shadow" <?php echo ($enable_pb_title_text_shadow) ? 'checked' : ''; ?>/>
                                <label for="ays_enable_title_text_shadow" class="ays_switch_toggle">Toggle</label>
                                <div class="row ays_toggle_target" style="margin: 10px 0 0 0; padding-top: 10px; <?php echo ($enable_pb_title_text_shadow) ? '' : 'display:none;' ?>">
                                    <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                        <label for='ays_title_text_shadow_color'>
                                            <?php echo __('Color', "ays-popup-box"); ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify text shadow color.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                        <input type="text" class="ays-text-input" id='ays_title_text_shadow_color' data-alpha="true" name='ays_title_text_shadow_color' value="<?php echo $pb_title_text_shadow; ?>"/>
                                    </div>
                                    <!---->
                                    <hr class="ays_toggle_target" style="<?= $enable_pb_title_text_shadow ? '' : 'display:none'; ?>">
                                    <div class="form-group row ays_toggle_target" style="<?= $enable_pb_title_text_shadow ? '' : 'display:none' ?>">
                                        <div class="col-sm-12">
                                            <div class="col-sm-3" style="display: inline-block;">
                                                <span class="ays_pb_small_hint_text"><?php echo __('X', "ays-popup-box"); ?></span>
                                                <input type="number" class="ays-text-input ays-text-input-90-width ays-box-shadow-coord-change" id='ays_pb_title_text_shadow_x_offset' name='ays_pb_title_text_shadow_x_offset' value="<?php echo $pb_title_text_shadow_x_offset; ?>" />
                                            </div>
                                            <div class="col-sm-3 ays_divider_left" style="display: inline-block;">
                                                <span class="ays_pb_small_hint_text"><?php echo __('Y', "ays-popup-box"); ?></span>
                                                <input type="number" class="ays-text-input ays-text-input-90-width ays-box-shadow-coord-change" id='ays_pb_title_text_shadow_y_offset' name='ays_pb_title_text_shadow_y_offset' value="<?php echo $pb_title_text_shadow_y_offset; ?>" />
                                            </div>
                                            <div class="col-sm-3 ays_divider_left" style="display: inline-block;">
                                                <span class="ays_pb_small_hint_text"><?php echo __('Z', "ays-popup-box"); ?></span>
                                                <input type="number" class="ays-text-input ays-text-input-90-width ays-box-shadow-coord-change" id='ays_pb_title_text_shadow_z_offset' name='ays_pb_title_text_shadow_z_offset' value="<?php echo $pb_title_text_shadow_z_offset; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <!---->
                                </div>
                            </div>
                        </div>
                        <!-- title text shadow end -->
                        <hr>
                        <div class="col-sm-12 only_pro">
                            <div class="pro_features">
                                <div>
                                    <p>
                                        <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row" style="padding: 10px 0; margin:0px;">
                                <div class="col-sm-3">
                                    <label for="ays_enable_title_styles">
                                        <?php echo __('Title style',"ays-popup-box")?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable the option to customize the style of the popup title.',"ays-popup-box");?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-7 ays_divider_left">
                                    <input type="checkbox" class="ays_toggle ays_toggle_slide" id="ays_enable_title_styles"
                                        name="enable_title_styles" checked>
                                    <label for="ays_enable_title_styles" class="ays_switch_toggle">Toggle</label>
                                    <div class="row ays_toggle_target ays_pb_pro_feature" style="margin: 10px 0 0 0; padding-top: 10px;">
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_font_family'>
                                                    <?php echo __('Font family', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Choose your preferred font family from the suggested variants for the popup title.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <select name="title_font_family" id="ays_title_font_family" class="ays-text-input-max-width-100 ays_pb_aysDropdown">
                                                    <option>
                                                        <?php echo __('Arial', "ays-popup-box"); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_font_weight'>
                                                    <?php echo __('Font weight', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Define the boldness of the popup title.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <select name="title_font_weight" id="ays_title_font_weight" class="ays-text-input-max-width-100 ays_pb_aysDropdown">
                                                    <option>
                                                        <?php echo __('Normal', "ays-popup-box"); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_font_size'>
                                                    <?php echo __('Font size(px)', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Define the font size of the popup title in pixels.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <input type="number" id="ays_title_font_size" name="title_font_size" class="ays-text-input-max-width-100"> 
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_letter_spacing'>
                                                    <?php echo __('Letter spacing(px)', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Define the space between characters in a text of the popup title in pixels.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <input type="number" id="ays_title_letter_spacing" name="title_letter_spacing" class="ays-text-input-max-width-100"> 
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_line_height'>
                                                    <?php echo __('Line height', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Define the height of a line of the popup title.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <input type="number" id="ays_title_line_height" name="title_line_height" class="ays-text-input-max-width-100"> 
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_text_alignment'>
                                                    <?php echo __('Text alignment', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Choose the horizontal alignment of the text of the popup title.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <select name="title_text_alignment" id="ays_title_text_alignment" class="ays-text-input-max-width-100 ays_pb_aysDropdown">
                                                    <option>
                                                        <?php echo __('Center', "ays-popup-box"); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_text_transform'>
                                                    <?php echo __('Text transform', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" data-html="true" title="<?php echo "<p>" .
                                                    __('Choose the capitalization of the text of the popup title. ', "ays-popup-box" ) . " </p> 
                                                    <p style='text-indent:10px;margin:0;'> " .
                                                    __(' None - No capitalization. The text renders as it is.', "ays-popup-box" ) ." </p> 
                                                    <p style='text-indent:10px;margin:0;'> " .
                                                    __( 'Capitalize - Transforms the first character of each word to uppercase.', "ays-popup-box" ). " </p> 
                                                    <p style='text-indent:10px;margin:0;'> " .
                                                        __('Uppercase - Transforms all characters to uppercase.', "ays-popup-box" )." </p> 
                                                        <p style='text-indent:10px;margin:0;'> " .
                                                    __(' Lowercase - Transforms all characters to lowercase.    ',"ays-popup-box"). "</p>" ?>" 
            
                                                    >
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <select name="title_text_transform" id="ays_title_text_transform" class="ays-text-input-max-width-100 ays_pb_aysDropdown">
                                                    <option>
                                                        <?php echo __('None', "ays-popup-box"); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 ays_divider_top row" style="margin-top: 10px; padding-top: 10px;">
                                            <div class="col-sm-5">
                                                <label for='ays_title_text_transform'>
                                                    <?php echo __('Text decoration', "ays-popup-box"); ?>
                                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Choose the kind of decoration added to text of the popup title.',"ays-popup-box")?>">
                                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                    </a>
                                                </label>
                                            </div>
                                            <div class="col-sm-7 ays_divider_left">
                                                <select name="title_text_decoration" id="ays_title_text_decoration" class="ays-text-input-max-width-100 ays_pb_aysDropdown">
                                                    <option>
                                                        <?php echo __('None', "ays-popup-box"); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ays-pb-youtube-video-link">
                            <div class="ays-pb-youtube-video-play-icon">
                                <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                            </div>
                            <div class="ays-pb-small-hint-text">
                                <a href="https://youtu.be/R-KO73oxWqY?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                                    <?php echo __( "How to Create OPT-IN Popups", "ays-popup-box"  ); ?>
                                </a>
                            </div>
                        </div>
                        <!-- title styles end -->
                        <hr> 
                        <p class="ays-subtitle"><?php echo  __('Opening and Closing effects', "ays-popup-box") ?></p>
                        <hr>    
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_animation_speed">
                                    <span>
                                        <?php echo  __('Opening animation speed',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the entry effect speed of the popup in seconds.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-4 ays_divider_left">
                                <input id="ays_pb_animation_speed" type="number" class="ays-pb-text-input ays-pb-text-input-short" name="ays_pb_animation_speed" value="<?php echo $animation_speed; ?>" step="0.1" <?php echo $animate_in == 'none' ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_close_animation_speed">
                                    <span>
                                        <?php echo  __('Closing animation speed',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the ending animation speed of the popup in seconds.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="ays_pb_close_animation_speed" type="number" class="ays-pb-text-input ays-pb-text-input-short" name="ays_pb_close_animation_speed" value="<?php echo $close_animation_speed; ?>" step="0.1" <?php echo $animate_out == 'none' ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-animate_out">
                                    <span>
                                        <?php echo  __('Closing animation',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose the exit effect for the popup closing.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <select id="<?php echo $this->plugin_name; ?>-animate_out" class="ays-pb-text-input ays-pb-text-input-short ays_pb_aysDropdown" name="<?php echo $this->plugin_name; ?>[animate_out]">
                                    <optgroup label="Fading Exits">
                                        <option <?php echo  $animate_out == 'fadeOut' ? 'selected' : ''; ?> value="fadeOut">Fade Out</option>
                                        <option <?php echo  $animate_out == 'fadeOutDown' ? 'selected' : ''; ?> value="fadeOutDown">Fade Out Down</option>
                                        <option <?php echo  $animate_out == 'fadeOutDownBig' ? 'selected' : ''; ?> value="fadeOutDownBig">Fade Out Down Big</option>
                                        <option <?php echo  $animate_out == 'fadeOutLeft' ? 'selected' : ''; ?> value="fadeOutLeft">Fade Out Left</option>
                                        <option <?php echo  $animate_out == 'fadeOutLeftBig' ? 'selected' : ''; ?> value="fadeOutLeftBig">Fade Out Left Big</option>
                                        <option <?php echo  $animate_out == 'fadeOutRight' ? 'selected' : ''; ?> value="fadeOutRight">Fade Out Right</option>
                                        <option <?php echo  $animate_out == 'fadeOutRightBig' ? 'selected' : ''; ?> value="fadeOutRightBig">Fade Out Right Big</option>
                                        <option <?php echo  $animate_out == 'fadeOutUp' ? 'selected' : ''; ?> value="fadeOutUp">Fade Out Up</option>
                                        <option <?php echo  $animate_out == 'fadeOutUpBig' ? 'selected' : ''; ?> value="fadeOutUpBig">Fade Out Up Big</option>
                                    </optgroup>
                                    <optgroup label="Bouncing Exits">
                                        <option <?php echo 'bounceOut' == $animate_out ? 'selected' : ''; ?> value="bounceOut">Bounce Out</option>
                                        <option <?php echo 'bounceOutDown' == $animate_out ? 'selected' : ''; ?> value="bounceOutDown">Bounce Out Down</option>
                                        <option <?php echo 'bounceOutLeft' == $animate_out ? 'selected' : ''; ?> value="bounceOutLeft">Bounce Out Left</option>
                                        <option <?php echo 'bounceOutRight' == $animate_out ? 'selected' : ''; ?> value="bounceOutRight">Bounce Out Right</option>
                                        <option <?php echo 'bounceOutUp' == $animate_out ? 'selected' : ''; ?> value="bounceOutUp">Bounce Out Up</option>
                                    </optgroup>
                                    <optgroup label="Sliding Exits">
                                        <option <?php echo 'slideOutUp' == $animate_out ? 'selected' : ''; ?> value="slideOutUp">Slide Out Up</option>
                                        <option <?php echo 'slideOutDown' == $animate_out ? 'selected' : ''; ?> value="slideOutDown">Slide Out Down</option>
                                        <option <?php echo 'slideOutLeft' == $animate_out ? 'selected' : ''; ?> value="slideOutLeft">Slide Out Left</option>
                                        <option <?php echo 'slideOutRight' == $animate_out ? 'selected' : ''; ?> value="slideOutRight">Slide Out Right</option>
                                    </optgroup>
                                    <optgroup label="Zoom Exits">
                                        <option <?php echo 'zoomOut' == $animate_out ? 'selected' : ''; ?> value="zoomOut">Zoom Out</option>
                                        <option <?php echo 'zoomOutDown' == $animate_out ? 'selected' : ''; ?> value="zoomOutDown">Zoom Out Down</option>
                                        <option <?php echo 'zoomOutLeft' == $animate_out ? 'selected' : ''; ?> value="zoomOutLeft">Zoom Out Left</option>
                                        <option <?php echo 'zoomOutRight' == $animate_out ? 'selected' : ''; ?> value="zoomOutRight">Zoom Out Right</option>
                                        <option <?php echo 'zoomOutUp' == $animate_out ? 'selected' : ''; ?> value="zoomOutUp">Zoom Out Up</option>
                                    </optgroup>
                                    <optgroup label="Rotating Exits">
                                        <option <?php echo 'rotateOut' == $animate_out ? 'selected' : ''; ?> value="rotateOut">Rotating Out</option>
                                        <option <?php echo 'rotateOutDownLeft' == $animate_out ? 'selected' : ''; ?> value="rotateOutDownLeft">Rotating Out Down Left</option>
                                        <option <?php echo 'rotateOutDownRight' == $animate_out ? 'selected' : ''; ?> value="rotateOutDownRight">Rotating Out Down Right</option>
                                        <option <?php echo 'rotateOutUpLeft' == $animate_out ? 'selected' : ''; ?> value="rotateOutUpLeft">Rotating Out Up Left</option>
                                        <option <?php echo 'rotateOutUpRight' == $animate_out ? 'selected' : ''; ?> value="rotateOutUpRight">Rotating Out Up Right</option>
                                    </optgroup>
                                    <optgroup label="Fliping Exits">
                                        <option <?php echo 'flipOutY' == $animate_out ? 'selected' : ''; ?> value="flipOutY">Flip Out Y</option>
                                        <option <?php echo 'flipOutX' == $animate_out ? 'selected' : ''; ?> value="flipOutX">Flip Out X</option>
                                    </optgroup>
                                    <option <?php echo  $animate_out == 'none' ? 'selected' : ''; ?> value="none">None</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row" >
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-animate_in">
                                    <span>
                                        <?php echo  __('Opening animation',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose the entry effect for the popup opening.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <select id="<?php echo $this->plugin_name; ?>-animate_in" class="ays-pb-text-input ays-pb-text-input-short ays_pb_aysDropdown" name="<?php echo $this->plugin_name; ?>[animate_in]">
                                    <optgroup label="Fading Entrances">
                                        <option <?php echo 'fadeIn' == $animate_in ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                                        <option <?php echo 'fadeInDown' == $animate_in ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                                        <option <?php echo 'fadeInDownBig' == $animate_in ? 'selected' : ''; ?> value="fadeInDownBig">Fade In Down Big</option>
                                        <option <?php echo 'fadeInLeft' == $animate_in ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                                        <option <?php echo 'fadeInLeftBig' == $animate_in ? 'selected' : ''; ?> value="fadeInLeftBig">Fade In Left Big</option>
                                        <option <?php echo 'fadeInRight' == $animate_in ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                                        <option <?php echo 'fadeInRightBig' == $animate_in ? 'selected' : ''; ?> value="fadeInRightBig">Fade In Right Big</option>
                                        <option <?php echo 'fadeInUp' == $animate_in ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                                        <option <?php echo 'fadeInUpBig' == $animate_in ? 'selected' : ''; ?> value="fadeInUpBig">Fade In Up Big</option>
                                    </optgroup>
                                    <optgroup label="Bouncing Entrances">
                                        <option <?php echo 'bounceIn' == $animate_in ? 'selected' : ''; ?> value="bounceIn">Bounce In</option>
                                        <option <?php echo 'bounceInDown' == $animate_in ? 'selected' : ''; ?> value="bounceInDown">Bounce In Down</option>
                                        <option <?php echo 'bounceInLeft' == $animate_in ? 'selected' : ''; ?> value="bounceInLeft">Bounce In Left</option>
                                        <option <?php echo 'bounceInRight' == $animate_in ? 'selected' : ''; ?> value="bounceInRight">Bounce In Right</option>
                                        <option <?php echo 'bounceInUp' == $animate_in ? 'selected' : ''; ?> value="bounceInUp">Bounce In Up</option>
                                    </optgroup>
                                    <optgroup label="Sliding Entrances">
                                        <option <?php echo 'slideInUp' == $animate_in ? 'selected' : ''; ?> value="slideInUp">Slide In Up</option>
                                        <option <?php echo 'slideInDown' == $animate_in ? 'selected' : ''; ?> value="slideInDown">Slide In Down</option>
                                        <option <?php echo 'slideInLeft' == $animate_in ? 'selected' : ''; ?> value="slideInLeft">Slide In Left</option>
                                        <option <?php echo 'slideInRight' == $animate_in ? 'selected' : ''; ?> value="slideInRight">Slide In Right</option>
                                    </optgroup>
                                    <optgroup label="Zoom Entrances">
                                        <option <?php echo 'zoomIn' == $animate_in ? 'selected' : ''; ?> value="zoomIn">Zoom In</option>
                                        <option <?php echo 'zoomInDown' == $animate_in ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option>
                                        <option <?php echo 'zoomInLeft' == $animate_in ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option>
                                        <option <?php echo 'zoomInRight' == $animate_in ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option>
                                        <option <?php echo 'zoomInUp' == $animate_in ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option>
                                    </optgroup>
                                    <optgroup label="Rotating Entrances">
                                        <option <?php echo 'rotateIn' == $animate_in ? 'selected' : ''; ?> value="rotateIn">Rotating In</option>
                                        <option <?php echo 'rotateInDownLeft' == $animate_in ? 'selected' : ''; ?> value="rotateInDownLeft">Rotating In Down Left</option>
                                        <option <?php echo 'rotateInDownRight' == $animate_in ? 'selected' : ''; ?> value="rotateInDownRight">Rotating In Down Right</option>
                                        <option <?php echo 'rotateInUpLeft' == $animate_in ? 'selected' : ''; ?> value="rotateInUpLeft">Rotating In Up Left</option>
                                        <option <?php echo 'rotateInUpRight' == $animate_in ? 'selected' : ''; ?> value="rotateInUpRight">Rotating In Up Right</option>
                                    </optgroup>
                                    <optgroup label="Fliping Entrances">
                                        <option <?php echo 'flipInY' == $animate_in ? 'selected' : ''; ?> value="flipInY">Flip In Y</option>
                                        <option <?php echo 'flipInX' == $animate_in ? 'selected' : ''; ?> value="flipInX">Flip In X</option>
                                    </optgroup>
                                    <option <?php echo  $animate_in == 'none' ? 'selected' : ''; ?> value="none">None</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <p class="ays-subtitle"><?php echo  __('Background style', "ays-popup-box") ?></p>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-bgcolor">
                                    <span>
                                        <?php echo __('Background color', "ays-popup-box"); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the background color of the popup.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="text" id="<?php echo $this->plugin_name; ?>-bgcolor"  data-alpha="true" class="ays_pb_color_input ays_pb_bgcolor_change ays_pb_background_color" name="<?php echo $this->plugin_name; ?>[bgcolor]" value="<?php echo $bgcolor; ?>"  data-default-color="#FFFFFF"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for='ays-pb-bg-image'>
                                    <?php echo __('Background Image', "ays-popup-box"); ?>
                                    <a class="ays_help" data-toggle="tooltip" data-placement="top"
                                       title="<?php echo __("Add a background image to the popup. Note: If you want to apply background color, remove the image or don't add it.", "ays-popup-box"); ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <div>
                                    <a href="javascript:void(0)" class="button ays-pb-add-bg-image" data-add='false'>
                                        <?php echo $image_text_bg; ?>                                    
                                    </a>
                                </div>
                                <div style="<?php echo $style_bg; ?>">
                                    <div class="ays-pb-bg-image-container">
                                        <span class="ays-remove-bg-img"></span>
                                        <img src="<?php echo $bg_image ; ?>" id="ays-pb-bg-img"/>
                                        <input type="hidden" name="ays_pb_bg_image" id="ays-pb-bg-image" value="<?php echo $bg_image; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_bg_image_position">
                                    <?php echo __( "Background image position", "ays-popup-box" ); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Select the position of the background image of the popup.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="pb_position_block col-sm-6 ays_divider_left">
                                <table id="ays_pb_bg_image_position_table" data-flag="bg_image_position">
                                    <tr>
                                        <td data-value="left-top" data-id='1'></td>
                                        <td data-value="top-center"data-id='2'></td>
                                        <td data-value="right-top" data-id='3'></td>
                                    </tr>
                                    <tr>
                                        <td data-value="left-center" data-id='4'></td>
                                        <td id="pb_position_center" data-value="center-center" data-id='5'></td>
                                        <td data-value="right-center" data-id='6'></td>
                                    </tr>
                                    <tr>
                                        <td data-value="left-bottom" data-id='7'></td>
                                        <td data-value="center-bottom" data-id='8'></td>
                                        <td data-value="right-bottom" data-id='9'></td>
                                    </tr>
                                </table>
                                <input type="hidden" name="ays_pb_bg_image_position" id="ays_pb_bg_image_position" value="<?php echo $pb_bg_image_position; ?>" class="ays-pb-position-val-class">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_bg_image_sizing">
                                    <?php echo __('Background image sizing', "ays-popup-box" ); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Define the background image size if needed.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <select name="ays_pb_bg_image_sizing" id="ays_pb_bg_image_sizing" class="ays-text-input ays-pb-text-input ays-pb-text-input-short ays_pb_aysDropdown" style="display:block;">
                                    <option value="cover" <?php echo $pb_bg_image_sizing == 'cover' ? 'selected' : ''; ?>><?php echo __( "Cover", "ays-popup-box" ); ?></option>
                                    <option value="contain" <?php echo $pb_bg_image_sizing == 'contain' ? 'selected' : ''; ?>><?php echo __( "Contain", "ays-popup-box" ); ?></option>
                                    <option value="none" <?php echo $pb_bg_image_sizing == 'none' ? 'selected' : ''; ?>><?php echo __( "None", "ays-popup-box" ); ?></option>
                                    <option value="unset" <?php echo $pb_bg_image_sizing == 'unset' ? 'selected' : ''; ?>><?php echo __( "Unset", "ays-popup-box" ); ?></option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!-- TP Changes  -->
                        <!--  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays-enable-background-gradient">
                                    <?php echo __('Background gradient',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Add background gradient for the popup, choose gradient color stops and direction.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left ayspb-enable-background-gradient">
                                <input type="checkbox" class="ays_toggle ays_toggle_slide"
                                        id="ays-enable-background-gradient"
                                        name="ays_enable_background_gradient"
                                        <?php echo ($enable_background_gradient) ? 'checked' : ''; ?>/>
                                <label for="ays-enable-background-gradient" class="ays_switch_toggle">Toggle</label>
                                <div class="row ays_toggle_target" style="margin: 10px 0 0 0; padding-top: 10px; <?php echo ($enable_background_gradient) ? '' : 'display:none;' ?>">
                                    <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                        <label for='ays-background-gradient-color-1'>
                                            <?php echo __('Color 1', "ays-popup-box"); ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Select the first color stop.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                        <input type="text" class="ays-text-input" id='ays-background-gradient-color-1' data-alpha="true" name='ays_background_gradient_color_1' value="<?php echo $background_gradient_color_1; ?>"/>
                                    </div>
                                    <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                        <label for='ays-background-gradient-color-2'>
                                            <?php echo __('Color 2', "ays-popup-box"); ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Select the second color stop.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                        <input type="text" class="ays-text-input" id='ays-background-gradient-color-2' data-alpha="true" name='ays_background_gradient_color_2' value="<?php echo $background_gradient_color_2; ?>"/>
                                    </div>
                                    <div class="col-sm-12 ays_divider_top" style="margin-top: 10px; padding-top: 10px;">
                                        <label for="ays_pb_gradient_direction">
                                            <?php echo __('Gradient direction',"ays-popup-box")?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('The direction of the color gradient',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                        <select id="ays_pb_gradient_direction" name="ays_pb_gradient_direction" class="ays-text-input ays_pb_aysDropdown">
                                            <option <?php echo ($pb_gradient_direction == 'vertical') ? 'selected' : ''; ?> value="vertical"><?php echo __( 'Vertical', "ays-popup-box"); ?></option>
                                            <option <?php echo ($pb_gradient_direction == 'horizontal') ? 'selected' : ''; ?> value="horizontal"><?php echo __( 'Horizontal', "ays-popup-box"); ?></option>
                                            <option <?php echo ($pb_gradient_direction == 'diagonal_left_to_right') ? 'selected' : ''; ?> value="diagonal_left_to_right"><?php echo __( 'Diagonal left to right', "ays-popup-box"); ?></option>
                                            <option <?php echo ($pb_gradient_direction == 'diagonal_right_to_left') ? 'selected' : ''; ?> value="diagonal_right_to_left"><?php echo __( 'Diagonal right to left', "ays-popup-box"); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <!--  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-header_bgcolor">
                                    <span>
                                        <?php echo __('Header background color', "ays-popup-box"); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the background color of the box's header. Note: It works with the following themes: Red, Sale.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="text" id="<?php echo $this->plugin_name; ?>-header_bgcolor"  data-alpha="true" class="ays_pb_color_input ays_pb_header_bgcolor_change" name="<?php echo $this->plugin_name; ?>[header_bgcolor]" value="<?php echo $header_bgcolor; ?>"  Fdata-default-color="#FFFFF"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_overlay_color">
                                    <span>
                                        <?php echo  __('Overlay color',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the overlay color.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="<?php echo $this->plugin_name; ?>-overlay_color" type="text" data-alpha = "true" class="color-picker ays_pb_color_input ays_pb_overlay_color_change" name="ays_pb_overlay_color" value="<?php echo $overlay_color; ?>" data-default-color="#000">
                            </div>
                        </div>
                        <hr>
                        <p class="ays-subtitle"><?php echo  __('Border style', "ays-popup-box") ?></p>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_bordersize">
                                    <span>
                                        <?php echo  __('Border Width',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the border size of the popup in pixels.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_bordersize" type="number" class="ays-pb-text-input ays-pb-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_pb_bordersize]" value="<?php echo wp_unslash($border_size); ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_border_style">
                                    <span>
                                        <?php echo  __('Border style',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose your preferred style of the border.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <select name="ays_pb_border_style" id="ays_pb_border_style" class="ays_pb_aysDropdown">
                                <?php
                                    $selected  = "";
                                    foreach ($border_styles as $key => $border_style) {
                                        if(is_array($border_style)){
                                            if (in_array($ays_pb_border_style,$border_style)) {
                                               $selected = "selected";
                                            }
                                            else{
                                                $selected = "";
                                            }
                                        }else{
                                            if($border_style == $ays_pb_border_style){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                        }
                                    
                                ?>
                                    <option value="<?php echo $border_style ;?>" <?php echo $selected ;?>>
                                        <?php echo $border_style; ?>
                                    </option>

                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_bordercolor">
                                    <span>
                                        <?php echo  __('Border color',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the border color of the popup.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_bordercolor" class="ays_pb_color_input ays_pb_bordercolor_change" type="text" name="<?php echo $this->plugin_name; ?>[ays_pb_bordercolor]" value="<?php echo wp_unslash($bordercolor); ?>" data-default-color="#FFFFFF" data-alpha="true">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="<?php echo $this->plugin_name; ?>-ays_pb_border_radius">
                                    <span>
                                        <?php echo  __('Border radius',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Specify the radius of the border. Allows adding rounded corners to the popup. ", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="<?php echo $this->plugin_name; ?>-ays_pb_border_radius" type="number" class="ays-pb-text-input ays-pb-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_pb_border_radius]" value="<?php echo wp_unslash($border_radius); ?>">
                            </div>
                        </div>
                        <hr>
                        <p class="ays-subtitle"><?php echo  __('Button Style', "ays-popup-box") ?></p>
                        <hr>
                        <div class="col-sm-12">
                            <div class="pro_features">
                                <div>
                                    <p>
                                        <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                                    </p>
                                </div>
                            </div>
                            <!-- Buttons Size start-->
                            <div class="form-group" id="ays_pb_button_size_content" style="margin:0;">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="ays_pb_buttons_size">
                                            <?php echo __('Button size',"ays-popup-box")?>
                                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('The default sizes of buttons.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7 ays_divider_left">
                                        <select class="ays-text-input ays-pb-text-input ays-pb-text-input-short ays_pb_aysDropdown" id="ays_pb_buttons_size" name="ays_pb_buttons_size">
                                            <option value="small">
                                                <?php echo __('Small',"ays-popup-box")?>
                                            </option>
                                            <option value="medium">
                                                <?php echo __('Medium',"ays-popup-box")?>
                                            </option>
                                            <option value="large">
                                                <?php echo __('Large',"ays-popup-box")?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <hr> <!-- Button text Color -->
                                <div class="form-group row ays-pb-button-color-content" id="ays-pb-button-color-content-first">
                                    <div class="col-sm-3">
                                        <label for='ays_pb_button_text_color'>
                                            <?php echo __('Button text color', "ays-popup-box"); ?>
                                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Specify the text color of buttons inside the popup.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7 ays_divider_left">
                                        <input type="text" class="ays-text-input" id='ays_pb_button_text_color' data-alpha="true" name='ays_pb_button_text_color' value="#000"/>
                                    </div>
                                </div> 
                                <hr> <!-- Button Bg Color -->
                                <div class="form-group row <?php echo $modal_content == 'yes_or_no' ? 'display_none' : ''; ?> ays-pb-button-color-content">
                                    <div class="col-sm-3">
                                        <label for='ays_pb_button_background_color'>
                                            <?php echo __('Button background color', "ays-popup-box"); ?>
                                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Specify the backgound color of buttons inside the popup.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7 ays_divider_left">
                                        <input type="text" class="ays-text-input" id='ays_pb_button_background_color' data-alpha="true" name='ays_pb_button_background_color'value="#13aff0"/>
                                    </div>
                                </div> <!-- Buttons BG Color -->
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for='ays_pb_buttons_font_size'>
                                            <?php echo __('Button font-size', "ays-popup-box"); ?> (px)
                                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('The font size of the buttons in pixels in the popup. It accepts only numeric values.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7 ays_divider_left">
                                        <input type="number" class="ays-text-input ays-pb-text-input ays-pb-text-input-short" id='ays_pb_buttons_font_size'name='ays_pb_buttons_font_size' value="17"/>
                                    </div>
                                </div> <!-- Buttons font size -->
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for='ays_pb_buttons_width'>
                                            <?php echo __('Button width', "ays-popup-box"); ?> (px)
                                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Set the button width in pixels. For an initial width, leave the field blank.', "ays-popup-box"); ?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7 ays_divider_left">
                                        <input type="number" class="ays-text-input ays-pb-text-input ays-pb-text-input-short" id='ays_pb_buttons_width'name='ays_pb_buttons_width' value="">
                                        <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __('For an initial width, leave the field blank.', "ays-popup-box"); ?></span>
                                    </div>
                                </div> <!-- Buttons font size -->
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="ays_pb_buttons_padding">
                                            <?php echo __('Button padding',"ays-popup-box")?> (px)
                                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Padding of buttons.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7 ays_divider_left">
                                        <div class="col-sm-5" style="display: inline-block; padding-left: 0;">
                                            <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __('Left / Right',"ays-popup-box")?></span>
                                            <input type="number" class="ays-text-input" id='ays_pb_buttons_left_right_padding' name='ays_pb_buttons_left_right_padding' value="20" style="width: 100px;" />
                                        </div>
                                        <div class="col-sm-5 ays_divider_left ays-buttons-top-bottom-padding-box" style="display: inline-block;">
                                            <span style="display:block;" class="ays-pb-small-hint-text"><?php echo __('Top / Bottom',"ays-popup-box")?></span>
                                            <input type="number" class="ays-text-input" id='ays_pb_buttons_top_bottom_padding' name='ays_pb_buttons_top_bottom_padding' value="10" style="width: 100px;" />
                                        </div>
                                    </div>
                                </div> <!-- Buttons padding -->
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="ays_pb_buttons_border_radius">
                                            <?php echo __('Button border-radius', "ays-popup-box"); ?> (px)
                                            <a class="ays_help ays-pb-help-pro" data-toggle="tooltip" title="<?php echo __('Popup buttons border-radius in pixels. It accepts only numeric values.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7 ays_divider_left">
                                        <input type="number" class="ays-text-input ays-pb-text-input ays-pb-text-input-short" id="ays_pb_buttons_border_radius" name="ays_pb_buttons_border_radius" value="3"/>
                                    </div>
                                </div> <!-- Buttons border radius -->
                            </div>
                            <!-- Buttons Size End -->
                        </div>
                        <div class="ays-pb-youtube-video-link">
                            <div class="ays-pb-youtube-video-play-icon">
                                <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                            </div>
                            <div class="ays-pb-small-hint-text">
                                <a href="https://youtu.be/BdwSmLbsCC4?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                                    <?php echo __('How to Add Contact Form Popup in WordPress', "ays-popup-box")?>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <!-- close button image start  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_close_button_image">
                                    <span>
                                        <?php echo  __('Close button image',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Add an image which will be displayed instead of the close button.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <a href="javascript:void(0)" class="button ays_pb_add_close_btn_bg_image">
                                    <?php echo $close_btn_image; ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-8" style="<?php echo $close_btn_style_bg; ?>">
                            <div class="ays_pb_close_btn_bg_img">
                                <span class="ays_remove_bg_img"></span>
                                <img src="<?php echo $close_btn_background_img ; ?>" id="ays_close_btn_bg_img"/>
                                <input type="hidden" name="ays_pb_close_btn_bg_img" id="close_btn_bg_img"
                                       value="<?php echo $close_btn_background_img; ?>"/>
                            </div>
                        </div>
                        <!-- close button image end  -->
                        <hr>
                        <!-- close button color start  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_close_button_color">
                                    <span>
                                        <?php echo  __('Close button color',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the close button color.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="text" id="ays_pb_close_button_color"  data-alpha="true" class="" name="ays_pb_close_button_color" value="<?php echo $close_button_color; ?>"  Fdata-default-color="#000000">
                            </div>
                        </div>
                        <!-- close button color end  -->
                        <hr>
                        <!-- close button hover color start  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_close_button_hover_color">
                                    <span>
                                        <?php echo  __('Close button hover color',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the close button color on hover.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="text" id="ays_pb_close_button_hover_color"  data-alpha="true" class="" name="ays_pb_close_button_hover_color" value="<?php echo $close_button_hover_color; ?>"  Fdata-default-color="#000000">
                            </div>
                        </div>
                        <!-- close button hover color end  -->
                        <hr>
                        <!-- close button size start  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_close_button_size">
                                    <span>
                                        <?php echo  __('Close button size',"ays-popup-box") ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Define the close button size in pixels.", "ays-popup-box"); ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input id="ays_pb_close_button_size" type="number" class="ays-pb-text-input ays-pb-text-input-short" name="ays_pb_close_button_size" value="<?php echo $ays_close_button_size; ?>">
                            </div>
                        </div>
                        <!-- close button size end  -->
                        <hr>    
                        <p class="ays-subtitle"><?php echo  __('Advanced style', "ays-popup-box") ?></p>
                        <hr>             
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_enable_box_shadow">
                                    <?php echo __('Box shadow',"ays-popup-box"); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Allow popup container box shadow.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left ays-pb-box-shadow">
                                <input type="checkbox" class="ays_toggle ays_toggle_slide" id="ays_pb_enable_box_shadow" name="ays_pb_enable_box_shadow" <?php echo ($enable_box_shadow == 'on') ? 'checked' : ''; ?>/>
                                <label for="ays_pb_enable_box_shadow" class="ays_switch_toggle">Toggle</label>
                                <div class="col-sm-12 ays_toggle_target ays_divider_top" style="margin-top: 10px; padding-top: 10px; <?php echo ($enable_box_shadow == 'on') ? '' : 'display:none;' ?>">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="ays_pb_box_shadow_color">
                                                <?php echo __('Box shadow color',"ays-popup-box")?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('The color of the shadow of the popup container',"ays-popup-box" ); ?>">
                                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                                </a>
                                            </label>
                                            <input type="text" class="ays-text-input" id='ays_pb_box_shadow_color' name='ays_pb_box_shadow_color' data-alpha="true" data-default-color="#000000" value="<?php echo $box_shadow_color; ?>"/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-4" style="display: inline-block;">
                                            <input type="number" class="ays-text-input ays-text-input-90-width" id='ays_pb_box_shadow_x_offset' name='ays_pb_box_shadow_x_offset' value="<?php echo $pb_box_shadow_x_offset; ?>" />
                                            <span class="ays_pb_small_hint_text"><?php echo __('X', "ays-popup-box"); ?></span>
                                        </div>
                                        <div class="col-sm-4 ays_divider_left" style="display: inline-block;">
                                            <input type="number" class="ays-text-input ays-text-input-90-width" id='ays_pb_box_shadow_y_offset' name='ays_pb_box_shadow_y_offset' value="<?php echo $pb_box_shadow_y_offset; ?>" />
                                            <span class="ays_pb_small_hint_text"><?php echo __('Y', "ays-popup-box"); ?></span>
                                        </div>
                                        <div class="col-sm-4 ays_divider_left" style="display: inline-block;">
                                            <input type="number" class="ays-text-input ays-text-input-90-width" id='ays_pb_box_shadow_z_offset' name='ays_pb_box_shadow_z_offset' value="<?php echo $pb_box_shadow_z_offset; ?>" />
                                            <span class="ays_pb_small_hint_text"><?php echo __('Z', "ays-popup-box"); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- popup box shadow -->
                        <hr>    
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="ays_pb_bg_image_direction_on_mobile">
                                    <?php echo __('Background image style on mobile',"ays-popup-box"); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('On mobile mode the background image will change it style and it will be displayed at the top of the text. Note: It will work only for the Sale template.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="checkbox" class="" id='ays_pb_bg_image_direction_on_mobile' name='ays_pb_bg_image_direction_on_mobile' value="on" <?php echo $pb_bg_image_direction_on_mobile ? 'checked' : ''; ?>>
                            </div>
                        </div> <!-- Image position for mobile -->
                        <hr>    
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="custom_class">
                                    <?php echo __('Custom class for Popup container ',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Use your custom HTML class for adding your custom styles to popup container.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="text" class="ays-pb-text-input ays-pb-text-input-short" name="<?php echo $this->plugin_name; ?>[custom-class]" id="custom_class" placeholder="myClass myAnotherClass..." value="<?php echo $custom_class; ?>">
                                <!-- ays-text-input  - input Class -->
                                <!--  ays_divider_left  - input-i Div-i Class left border-i hamar-->
                            </div>
                        </div>
                        <hr>
                        <div class="ays-field">
                            <label for="<?php echo $this->plugin_name; ?>-custom-css">
                                <span><?php echo __('Custom CSS', "ays-popup-box"); ?></span>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Field for entering your own CSS code.',  "ays-popup-box")?>">
                                    <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                </a>
                            </label>
                            <textarea id="<?php echo $this->plugin_name; ?>-custom-css"  class="ays-textarea" name="<?php echo  $this->plugin_name; ?>[custom-css]"><?php echo $custom_css; ?></textarea>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="custom_class">
                                    <?php echo __('Reset styles',"ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Reset popup styles to default values',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6 ays_divider_left">
                                <input type="button" class="ays-pb-reset-styles button btn" value="Reset">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="popup_preview" >
                            <p style="font-weight: normal; font-style: italic; font-size: 14px; color: grey; margin:0; padding:0;"><?php echo __("See PopupBox in live preview", "ays-popup-box"); ?></p>
                            <div class='ays-pb-modals'>
                                <input type='hidden' id='ays_pb_modal_animate_in'>
                                <input type='hidden' id='ays_pb_modal_animate_out'>
                                <input id='ays-pb-modal-checkbox' class='ays-pb-modal-check' type='checkbox' checked/>
                                <div class='ays-pb-modal ays-pb-live-container ays_bg_image_box' id="ays-pb-live-container">
                                    <label class='ays-pb-modal-close ays-close-button-on-off ays_pb_modal_close_default close_btn_label ays-close-button-text' style='<?php echo $hide_close_btn; ?>'>
                                        <img class='close_btn_img' src='<?php echo $close_btn_background_img; ?>' width='30' height='30' style='<?php echo $close_btn_img_display; ?>'>
                                        <?php
                                                if ($close_button_text === 'x') {
                                                    echo "<img src='" . AYS_PB_ADMIN_URL . "./images/icons/times-2x.svg' class='close_btn_text fa-2x' style='".$close_btn_text_display."'>";
                                                }else{
                                                   echo $close_button_text;
                                                }
                                        ?>
                                    </label>

                                    <h2 class="ays_title" style='<?php echo $hide_title ;?>'></h2>
                                    <p class="desc" style='font-size:<?php echo $pb_font_size?>px;'></p>
                                    <hr class="title_hr" style="<?php echo $hide_title ;?>" />
                                    <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                    <?php echo $ays_pb_timer_desc; ?>
                                </div>
                                <div class='ays-pb-live-container ays_window ays_bg_image_box'>
                                    <div class='ays_topBar'>
                                        <label class='ays-pb-modal-close ays_close ays-close-button-on-off' style='<?php echo $hide_close_btn; ?>'><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/times-2x.svg"?>" class="fa-2x"></label>
                                        <a class='ays_hide'></a>
                                        <a class='ays_fullScreen'></a>
                                        <h2 class="ays_title" style='<?php echo $hide_title ;?>'></h2>
                                    </div>
                                    <hr />
                                    <div class='ays_text'>
                                        <div class='ays_text-inner'>
                                            <p class="desc" style='font-size:<?php echo $pb_font_size?>px <?php echo $hide_desc ;?>'></p>
                                            <hr />
                                            <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                        </div>
                                    </div>
                                    <?php echo $ays_pb_timer_desc; ?>
                                </div>
                                <div class='ays-pb-live-container ays_cmd_window ays_bg_image_box'>
                                    <header class='ays_cmd_window-header'>
                                        <div class='ays_cmd_window_title'><h2 class="ays_title" style='<?php echo $hide_title ;?>'></h2></div>
                                        <nav class='ays_cmd_window-controls'>
                                            <span class='ays_cmd_control-item ays_cmd_control-minimize ays_cmd_js-minimize'>‒</span>
                                            <span class='ays_cmd_control-item ays_cmd_control-maximize ays_cmd_js-maximize'>□</span>
                                            <label for='ays-pb-modal-checkbox' class='ays_cmd_control-item ays_cmd_control-close ays-close-button-on-off'><span class='ays_cmd_control-close ays_cmd_js-close'>˟</span></label>
                                        </nav>
                                    </header>
                                    <div class='ays_cmd_window-cursor'>
                                        <span class='ays_cmd_i-cursor-indicator'>></span>
                                        <span class='ays_cmd_i-cursor-underscore'></span>
                                        <input type='text' disabled class='ays_cmd_window-input ays_cmd_js-prompt-input' />
                                    </div>
                                    <main class='ays_cmd_window-content'>
                                        <div class='ays_text'>
                                            <div class='ays_text-inner'>
                                                <p class="desc" style='font-size:<?php echo $pb_font_size?>px  <?php echo $hide_desc ;?>'></p>
                                                <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                            </div>
                                        </div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </main>
                                </div>
                                <div class='ays-pb-live-container ays_ubuntu_window ays_bg_image_box'>
                                    <div class='ays_ubuntu_topbar'>
                                        <div class='ays_ubuntu_icons'>
                                            <div class='ays_ubuntu_close ays-close-button-on-off'></div>
                                            <div class='ays_ubuntu_hide'></div>
                                            <div class='ays_ubuntu_maximize'></div>
                                        </div>
                                        <h2 class="ays_title" style='<?php echo $hide_title ;?>'></h2>
                                    </div>
                                    <div class='ays_ubuntu_tools'>
                                        <ul>
                                            <li><span>File</span></li>
                                            <li><span>Edit</span></li>
                                            <li><span>Go</span></li>
                                            <li><span>Bookmarks</span></li>
                                            <li><span>Tools</span></li>
                                            <li><span>Help</span></li>
                                        </ul>
                                    </div>
                                    <div class='ays_ubuntu_window_content'>
                                        <p class="desc" style='font-size:<?php echo $pb_font_size?>px <?php echo $hide_desc ;?>'></p>
                                        <hr />
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                    </div>
                                    <div class='ays_ubuntu_folder-info'>
                                    <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class=' ays_winxp_window '>
                                    <div class='ays_winxp_title-bar'>
                                        <div class='ays_winxp_title-bar-title'>
                                            <h2 class="ays_title" style='<?php echo $hide_title ;?>'></h2>
                                        </div>
                                        <div class='ays_winxp_title-bar-close ays-close-button-on-off'>
                                            <label for='ays-pb-modal-checkbox' class='ays_winxp_close ays-pb-modal-close'></label>
                                        </div>
                                        <div class='ays_winxp_title-bar-max'></div>
                                        <div class='ays_winxp_title-bar-min'></div>
                                    </div>
                                    <div class='ays_winxp_content ays-pb-live-container ays_bg_image_box'>
                                        <p class="desc" style='font-size:<?php echo $pb_font_size?>px <?php echo $hide_desc ;?>'></p>
                                        <hr />
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_win98_window ays_bg_image_box'>
                                    <header class='ays_win98_head'>
                                        <div class='ays_win98_header'>
                                            <div class='ays_win98_title'>
                                                <h2 class="ays_title" style='<?php echo $hide_title ;?>'></h2>
                                            </div>
                                            <div class='ays_win98_btn-close ays-close-button-on-off'><label for='ays-pb-modal-checkbox' class='ays-pb-modal-close'><span class="ays-close-button-text"><?php echo $close_button_text ?></span></label></div>
                                        </div>
                                    </header>
                                    <div class='ays_win98_main '>
                                        <div class='ays_win98_content'>
                                            <p class="desc" style='font-size:<?php echo $pb_font_size?>px <?php echo $hide_desc ;?>'></p>
                                            <hr />
                                            <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                            <?php echo $ays_pb_timer_desc; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_lil_window ays_bg_image_box' data-name="red">
                                    <header class='ays_lil_head'>
                                    <label class='close-lil-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_label' style='<?php echo $hide_close_btn; ?>'>
                                        <img class='close-image-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_img' src='<?php echo $close_btn_background_img; ?>' width='50' height='50' style='<?php echo $close_btn_img_display; ?>'/>
                                        <a class='ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_text' style='<?php echo $close_btn_text_display ?>'>        
                                            <?php echo $close_button_text; ?>
                                            
                                        </a>
                                    </label>
                                        <h2 class="ays_title_lil ays_title" style='<?php echo $hide_title ;?>'></h2>
                                    </header>
                                    <div class='ays_lil_content'>
                                        <p class="desc" style='font-size:<?php echo $pb_font_size?>px margin: 0; <?php echo $hide_desc ;?>'></p>
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_image_window ays_bg_image_box' id="ays-image-window">
                                    <header class='ays_image_head'>
                                        <label for='ays-pb-modal-checkbox' class='close_btn_label' style='<?php echo $hide_close_btn; ?>'>
                                            
                                                <img class='close-image-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_img' src='<?php echo $close_btn_background_img; ?>' width='30' height='30' style='<?php echo $close_btn_img_display; ?>' />
                                                <a class='close-image-btn ays-close-button-on-off ays-close-button-text ays-close-button-take-text-color close_btn_text' style='<?php echo $close_btn_text_display;?>'>
                                                    <?php echo $close_button_text;?>
                                                </a>
                                        <h2 class="ays_title_image ays_title" style='<?php echo $hide_title ;?>'></h2>
                                        <p class="desc" style='font-size:<?php echo $pb_font_size?>px margin: 0; <?php echo $hide_desc ;?>'></p>
                                    </header>
                                    <div class='ays_image_content '>
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_minimal_window ays_bg_image_box' id="ays-minimal-window">
                                    <header class='ays_minimal_head'>
                                        <label for='ays-pb-modal-checkbox' class='close_btn_label' style='<?php echo $hide_close_btn; ?>'>
                                            
                                                <img class='close-image-btn close-minimal-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_img' src='<?php echo $close_btn_background_img; ?>' width='30' height='30' style='<?php echo $close_btn_img_display; ?>' />
                                                <a class='close-image-btn ays-close-button-on-off ays-close-button-text ays-close-button-take-text-color close_btn_text' style='<?php echo $close_btn_text_display;?>'>
                                                     <?php
                                                if ($close_button_text === 'x') {
                                                    echo "<img src='" . AYS_PB_ADMIN_URL . "./images/icons/times-circle.svg'>";
                                                }else{
                                                    echo $close_button_text;
                                                }
                                        ?>
                                                </a>
                                        <h2 class="ays_title_minimal ays_title" style='<?php echo $hide_title ;?>'></h2>
                                        <p class="desc" style='font-size:<?php echo $pb_font_size?>px margin: 0; <?php echo $hide_desc ;?>'></p>
                                    </header>
                                    <div class='ays_image_content '>
                                        <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                        <?php echo $ays_pb_timer_desc; ?>
                                    </div>
                                </div>
                                <div class='ays-pb-live-container ays_template_window '>
                                    <header class='ays_template_head' style='<?php echo $header_height;?>;<?php echo $header_padding; ?>'>
                                        <label for='ays-pb-modal-checkbox' class='close_btn_label' style='margin-bottom:0;<?php echo $hide_close_btn; ?>'>
                                            <img class='close-template-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_img' src='<?php echo $close_btn_background_img; ?>' width='30' height='30' style='<?php echo $close_btn_img_display ?>'/>
                                            <a class='close-template-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_text' style='<?php echo $close_btn_text_display;?>'>
                                                <?php echo $close_button_text; ?>
                                            </a>
                                        </label>
                                        <h2 class="ays_title_template ays_title" style='<?php echo $hide_title ;?>'></h2>
                                    </header>
                                    <footer class='ays_template_footer' style='<?php echo $calck_template_footer; ?>'>
                                        <div class="ays_bg_image_box"></div>
                                        <div class='ays_template_content '>
                                            <p class="desc" style='font-size:<?php echo $pb_font_size?>px margin: 0; <?php echo $hide_desc ;?>'></p>
                                            <div class="ays_modal_content"><span><?php echo __("Here can be custom HTML or shortcode", "ays-popup-box"); ?></span></div>
                                            <?php echo $ays_pb_timer_desc; ?>
                                        </div>
                                    </footer>
                                </div>
                                <!-- video theme -->
                                <div class='ays-pb-live-container ays_video_window'>
                                    <div class='ays_video_head'>
                                        <label for='ays-pb-modal-checkbox ' class="close_btn_label" style='margin-bottom:0;<?php echo $hide_close_btn; ?>'>
                                            <img class='close-video-btn ays-close-button-take-text-color ays-close-button-on-off ays-close-button-text close_btn_img' src='<?php echo $close_btn_background_img; ?>' width='30' height='30' style='<?php echo $close_btn_img_display ?>'/>
                                            <a class="close-video-btn ays-close-button-on-off ays-close-button-text close_btn_text" style='<?php echo $close_btn_text_display;?>'><?php echo $close_button_text ?></a></label>
                                    </div>
                                    <div class="ays_modal_content ays_video_content"> 
                                        <video controls src="<?php echo $ays_video_src; ?>" class="video_theme" style="border-radius:<?php echo wp_unslash( $border_radius );?>px; width:680px;" ></video>
                                        <span><?php //echo __("Here can be custom Video or shortcode", "ays-popup-box"); ?></span>
                                    </div>
                                    <div class="ays_pb_timer_container">
                                        <p class='ays_pb_timer'><?php echo __("This will close in ", "ays-popup-box"); ?><span data-seconds='20'>20</span> <?php echo __("seconds", "ays-popup-box"); ?></p>
                                    </div>
                                    <input type="hidden" value="<?php echo AYS_PB_ADMIN_URL.'/videos/video_theme.mp4'; ?>">
                                </div>

                                <div id='ays-pb-screen-shade'></div>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
            <!-- Limitation user start -->
            <div id="tab4" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab4') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('Limitation of Users', "ays-popup-box") ?></p>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_show_only_once">
                            <span><?php echo __('Display popup once per user', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable this option to display the popup once per visitor.', "ays-popup-box"); ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="ays_pb_show_only_once" class="ays-pb-onoffswitch-checkbox" id="ays_pb_show_only_once" <?php echo ($show_only_once == 'on') ? 'checked' : '' ?> >
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-log-user">
                            <span><?php echo __('Display for logged-in users', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Enable this option to display the popup for logged-in users.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="<?php echo $this->plugin_name; ?>[log_user]" class="ays-pb-onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-log-user" <?php if($log_user == 'On'){ echo 'checked';} else { echo '';} ?> />
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-guest">
                            <span><?php echo __('Display for guests', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Enable this option to display the popup for guest visitors.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="<?php echo $this->plugin_name; ?>[guest]" class="ays-pb-onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-guest" <?php if($guest == 'On'){ echo 'checked';} else { echo '';} ?> />
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays-pb-mobile">
                            <span><?php echo __('Hide popup on mobile', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Disable the popup on mobile devices.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="ays_pb_mobile" class="ays-pb-onoffswitch-checkbox" id="ays-pb-mobile" value='on' <?php if($ays_pb_mobile == 'on'){ echo 'checked';} else { echo '';} ?> />
                        </p>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_hide_on_pc">
                            <span><?php echo __('Hide popup on PC', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Disable the popup on pc.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="ays_pb_hide_on_pc" class="ays-pb-onoffswitch-checkbox" id="ays_pb_hide_on_pc" value='on' <?php echo $ays_pb_hide_on_pc ? 'checked' : ''; ?> />
                        </p>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_pb_hide_on_tablets">
                            <span><?php echo __('Hide popup on tablets', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Disable the popup on tablets.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="ays_pb_hide_on_tablets" class="ays-pb-onoffswitch-checkbox" id="ays_pb_hide_on_tablets" value='on' <?php echo $ays_pb_hide_on_tablets ? 'checked' : ''; ?> />
                        </p>
                    </div>
                </div>
                <hr>
                <div class="form-group row" style="margin:0;">
                    <div class="col-sm-12 only_pro">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top:1rem; margin-bottom:0;"> 
                            <div class="col-sm-3">
                                <label for="ays_enable_tackers_count">
                                    <?php echo __('Disable by view count', "ays-popup-box")?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Disable the popup after certain views.',"ays-popup-box")?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-1">
                                <input type="checkbox" class="ays-enable-timer1 ays_toggle_checkbox" id="ays_enable_tackers_count"/>
                            </div>
                            <div class="col-sm-8 ays_toggle_target ays_divider_left">
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="ays_tackers_count">
                                            <?php echo __('Count',"ays-popup-box")?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Specify the count of views.',"ays-popup-box")?>">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="number" id="ays_tackers_count" class="ays-enable-timerl ays-text-input">
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>    
                </div>
                <div class="ays-pb-youtube-video-link">
                    <div class="ays-pb-youtube-video-play-icon">
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                    </div>
                    <div class="ays-pb-small-hint-text">
                        <a href="https://youtu.be/aFrtPsznVx4?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                            <?php echo __( 'How to Add a Google Map Popup to Your WordPress Website', "ays-popup-box"  ); ?>
                        </a>
                    </div>
                </div>
                <hr/>
                 <!-- Tigran -->
                 <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-users_role">
                            <span><?php echo __('Display for certain user roles', "ays-popup-box"); ?></span>
                            <a class="ays_help" data-toggle="tooltip"
                               title="<?php echo __('Show the popup only to certain user role(s) mentioned in the list. Leave it blank for showing the popup to all user roles.', "ays-popup-box") ?>">
                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9 ays-pb-users-roles ays_pb_users_roles">
                        <select name="<?php echo $this->plugin_name; ?>[ays_users_roles][]" id="ays_users_roles" multiple class="">
                            <?php
                            foreach ($ays_users_roles as $key => $user_role) {
                                $selected_role = "";
                                if(is_array($users_role)){
                                    if(in_array($user_role['name'], $users_role)){
                                        $selected_role = 'selected';
                                    }else{
                                        $selected_role = '';
                                    }
                                }else{
                                    if($users_role == $user_role['name']){
                                        $selected_role = 'selected';
                                    }else{
                                        $selected_role = '';
                                    }
                                }
                                echo "<option value='" . $user_role['name'] . "' " . $selected_role . ">" . $user_role['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <hr/>

                <!-- Tigran -->
                <div class="form-group row" style="margin:0;">
                    <div class="col-sm-12 only_pro">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top: 1rem;">
                            <div class="col-sm-3">
                                <label for="ays-pb-users-os">
                                    <span><?php echo __('Display for certain OS', "ays-popup-box"); ?></span>
                                    <a class="ays_help" data-toggle="tooltip"
                                       title="<?php echo __('Set on which operating systems your popup will be displayed.', "ays-popup-box") ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-9 ays-pb-users-roles">
                                <select id="ays-pb-users-os" multiple class="ays_pb_aysDropdown">
                                    <?php
                                    foreach ($ays_users_os_array as $key => $user_os) {
                                        echo "<option value='" . $user_os . "' selected>" . $user_os . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="ays-pb-users-browser">
                                    <span><?php echo __('Display for certain browser', "ays-popup-box"); ?></span>
                                    <a class="ays_help ays-pb-help-pro" data-toggle="tooltip"
                                       title="<?php echo __('Show the popup only to visitors using certain browser(s) mentioned in the list. Leave it blank for showing the popup to all browsers users.', "ays-popup-box") ?>">
                                        <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-9 ays-pb-users-roles">
                                <select id="ays-pb-users-browser" multiple class="ays_pb_aysDropdown">
                                    <?php
                                    foreach ($ays_users_browser_array as $key => $user_browser) {
                                        echo "<option value='" . $user_browser . "' selected>" . $user_browser . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ays-pb-youtube-video-link">
                    <div class="ays-pb-youtube-video-play-icon">
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                    </div>
                    <div class="ays-pb-small-hint-text">
                        <a href="https://youtu.be/UCk-qohzhIU?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                            <?php echo __('Build a WordPress Popup on Page Load | Without Coding Skills 2022', "ays-popup-box")?>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="form-group row" style="margin:0px;">
                    <div class="col-sm-12 only_pro" style="padding:25px 15px;">
                        <div class="pro_features">
                                <div>
                                    <p>
                                        <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                                    </p>
                                </div>
                            </div>
                        <div class="form-group row ">
                            <div class="col-sm-3">
                                <label for="enable_limit_by_country">
                                    <?php echo __('Limit by country', "ays-popup-box"); ?> 
                                        <a class="ays_help" data-toggle="tooltip"
                                            title="<?php echo __('Show the popup only to visitors using certain browser(s) mentioned in the list. Leave it blank for showing the popup to all browsers users.', "ays-popup-box") ?>">
                                            <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/info-circle.svg"?>">
                                        </a>
                                </label>
                            </div>
                            <div class="col-sm-1">
                                <input type="checkbox" class="ays-enable-timer1">
                            </div>
                            <div class="col-sm-8 ays_toggle_target ays_divider_left">
                                <select class="ays-text-input ays-pb-text-input ays-pb-text-input-short ays_pb_aysDropdown" style="width: 15vw;">                            
                                        <option>USA</option>
                                </select>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="ays-pb-youtube-video-link">
                    <div class="ays-pb-youtube-video-play-icon">
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/icons/play.png' ?>">
                    </div>
                    <div class="ays-pb-small-hint-text">
                        <a href="https://youtu.be/q6ai1WhpLfc?list=PL4ufu1uAjjWQTYn0O_72TLzmqgmVIYKI2" target="_blank">
                            <?php echo __( "How to Pop up Any Plugin's Content via Shortcode", "ays-popup-box"  ); ?>
                        </a>
                    </div>
                </div>
                <hr/>
            </div>
            <!-- Limitation user end -->
            <!-- Integrations start -->
            <div id="tab5" class="ays-pb-tab-content  <?php echo ($ays_pb_tab == 'tab5') ? 'ays-pb-tab-content-active' : ''; ?>">
                <p class="ays-subtitle"><?php echo  __('Integrations', "ays-popup-box") ?></p>
                <blockquote class="ays-pb-integration-tab-note">
                    <p><?php echo __('The Integrations tab works only with Contact Form, Subscription and Send File after subscription types',"ays-popup-box");?>
                </blockquote>
                <hr/>
                <?php 
                    $args = apply_filters( 'ays_pb_popup_page_integrations_options', array(), $options );
                    do_action( 'ays_pb_popup_page_integrations', $args );
                ?>
            </div>
            </div>
           <!-- Integrations end -->
            <div style="clear:both;" ></div>
            <hr/>
            <!-- <div class="form-group row ays-pb-general-bundle-container">
                <div class="col-sm-12 ays-pb-general-bundle-box">
                    <div class="ays-pb-general-bundle-row ays-pb-general-bundle-image-row">
                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank"><img src="<?php //echo AYS_PB_ADMIN_URL; ?>/images/black_friday_banner_logo.png"></a>
                    </div> 
                    <div class="ays-pb-general-bundle-row">
                        <div class="ays-pb-general-bundle-text">
                            <?php //echo __( "Don't miss your", "ays-popup-box" ); ?>
                            <span><?php //echo __( "20% Christmas sale", "ays-popup-box" ); ?></span>
                            <?php //echo __( "for Ays Pro products!", "ays-popup-box" ); ?>
                            <?php //echo __( "Do not miss Black Friday discount on", "ays-popup-box" ); ?>
                            <span class="ays-pb-general-bundle-color">
                                <a href="https://ays-pro.com/wordpress/popup-box" class="ays-pb-general-bundle-link-color" target="_blank"><?php //echo __( "Popup Box", "ays-popup-box" ); ?></a>
                            </span> <?php //echo __( "plugin!", "ays-popup-box" ); ?> 
                        </div>
                        <p><?php //echo __("It's the GIFT season so take one from us.", "ays-popup-box" ); ?></p>
                        <div class="ays-pb-general-bundle-sale-text ays-pb-general-bundle-color">
                            <div><a href="https://ays-pro.com/wordpress/popup-box" class="ays-pb-general-bundle-link-color" target="_blank"><?php //echo __( "Discount 20% OFF", "ays-popup-box" ); ?></a></div>
                        </div>
                    </div>
                    <div class="ays-pb-general-bundle-row">
                        <a href="https://ays-pro.com/wordpress/popup-box" class="ays-pb-general-bundle-button" target="_blank">Get Now!</a>
                    </div>
                </div>
            </div> -->
            <div class="ays-pb-bottom-buttons-content">      
                <h1 style="display:flex">
                    <?php
                    wp_nonce_field('pb_action', 'pb_action');
                    $save_close_bottom_attributes = array('id' => 'ays-button');
                    // $save_bottom_attributes = array('id' => 'ays-button-apply');
                    $save_bottom_attributes = array(
                        'id' => 'ays-button-apply',
                        'title' => 'Ctrl + s',
                        'data-toggle' => 'tooltip',
                        'data-delay'=> '{"show":"300"}'
                    );
                    submit_button(__('Save and close', "ays-popup-box"), 'primary', 'ays_submit', false, $save_close_bottom_attributes);
                    submit_button(__('Save', "ays-popup-box"), '', 'ays_apply', false, $save_bottom_attributes);
                    ?>
                    <a href="<?php echo $ays_pb_page_url; ?>" class="button" style="margin-left:10px;" ><?php echo __('Cancel',"ays-popup-box");?></a>
                    <?php
                        echo $loader_iamge;
                    ?>
                </h1>
                <div class="ays-pb-prev-next-button-content">
                    <?php
                        if ( $prev_popup_id != "" && !is_null( $prev_popup_id ) ) {

                            $other_attributes = array(
                                'id' => 'ays-popups-prev-button',
                                'href' => sprintf( '?page=%s&action=%s&popupbox=%d', esc_attr( $_REQUEST['page'] ), 'edit', absint( $prev_popup_id ) ),
                                'data-message' => __( 'Are you sure you want to go to the previous popup page?', "ays-popup-box"),
                            );
                            submit_button(__('Prev popup', "ays-popup-box"), 'button button-primary ays-button ays-popup-prev-popup-button', 'ays_popup_prev_button', false, $other_attributes);
                        }
                        if ( $next_popup_id != "" && !is_null( $next_popup_id ) ) {
                        
                            $other_attributes = array(
                                'id' => 'ays-popups-next-button',
                                'href' => sprintf( '?page=%s&action=%s&popupbox=%d', esc_attr( $_REQUEST['page'] ), 'edit', absint( $next_popup_id )),
                                'data-message' => __( 'Are you sure you want to go to the next popup page?', "ays-popup-box"),
                            );
                            submit_button(__('Next Popup', "ays-popup-box"), 'button button-primary ays-button', 'ays_popup_next_button', false, $other_attributes);
                        }
                    ?>
                </div>
            </div>
            <?php if($id === null): ?>
                <div class="ays_pb_layer_container">
                    <div class="ays_pb_layer_content">
                        <div class="ays_pb_layer_box">
                            <div class="ays-pb-close-layer">
                                <div class="ays-pb-choose-type">
                                    <p style="margin: 0;">Choose Your Popup Type</p>
                                </div>
                                <div class="ays-pb-close-type">
                                    <a href="?page=ays-pb">
                                        <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/cross.png">
                                    </a>
                                </div>
                            </div>
                            <div class="ays_pb_layer_box_blocks">
                                <label class='ays-pb-dblclick-layer'>
                                    <input id="<?php echo $this->plugin_name; ?>-modal_content_custom_html" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" class="ays-pb-content-type" value="custom_html" <?php if($modal_content == 'custom_html'){ echo 'checked';} else { echo '';} ?>>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/file-code.svg"?>">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_title">
                                            <div class="ays-pb-type-name">
                                                <p style="margin:0px; font-size:20px;"><?php echo  __('Custom Content', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-view-demo-content">
                                                <a href="https://bit.ly/3Au6ss9" target="_blank">View demo</a>
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>
                                    </div>
                                </label>

                                <label class='ays-pb-dblclick-layer'>
                                    <input id="<?php echo $this->plugin_name; ?>-modal_content_shortcode" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" class="ays-pb-content-type" value="shortcode"
                                        <?php
                                        if(($modal_content) == '' || $modal_content == null){
                                            echo '';
                                        }
                                        if(isset($modal_content) && $modal_content == 'shortcode')
                                        { echo 'checked';}
                                        else
                                        { echo '';} ?>>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <span class="ays_pb_layer_item_logo_shortcode">[/]</span>
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_title">
                                            <div class="ays-pb-type-name">
                                                <p style="margin:0px; font-size:20px;"><?php echo __('Shortcode', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-view-demo-content">
                                                <a href="https://bit.ly/3yAJuOt" target="_blank">View demo</a>
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>
                                    </div>
                                </label>

                                <label class='ays-pb-dblclick-layer'>
                                    <input id="<?php echo $this->plugin_name; ?>-modal_content_video_type" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" class="ays-pb-content-type" value="video_type" <?php if($modal_content == 'video_type'){ echo 'checked';} else { echo '';} ?>>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                             <div class="ays_pb_layer_item_logo_overlay">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/video.svg"?>">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_title">
                                            <div class="ays-pb-type-name">
                                                <p style="margin:0px; font-size:20px;"><?php echo  __('Video', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-view-demo-content">
                                                <a href="https://bit.ly/3P42n1R" target="_blank">View demo</a>
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label>

                            </div>
                             <div class="ays_pb_layer_box_blocks">
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Subscription', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3R5szuB" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/envelope.svg"?>">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  

                                    </div>

                                </label>

                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Yes or No', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3AqvPLg" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                             <div class="ays_pb_layer_item_logo_overlay">
                                                <img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check.svg"?>">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label>

                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Embed( Iframe )', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3bNERYh" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/coding.png">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                            </div>
                            <div class="ays_pb_layer_box_blocks">
                                 <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Contact form', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3acggfr" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/comments.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 

                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Subscribe and get file', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3Al4qKI" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/file-upload.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Coupon', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3Iafmwy" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src= "<?php echo AYS_PB_ADMIN_URL ;?>/images/icons/coupon.svg" style="width:40px;height:40px;">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                            </div>
                            <div class="ays_pb_layer_box_blocks">
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Countdown', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3If66Hm" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src= "<?php echo AYS_PB_ADMIN_URL ;?>/images/icons/countdown.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Accept Cookie', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3IayfiQ" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src= "<?php echo AYS_PB_ADMIN_URL ;?>/images/icons/cookie.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Download', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3RrgTmh" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src= "<?php echo AYS_PB_ADMIN_URL ;?>/images/icons/download.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                            </div>
                            <div class="ays_pb_layer_box_blocks">
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Woocommerce', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <!-- <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3c1MkmM" target="_blank"> View Demo </a>
                                                </div> -->
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src= "<?php echo AYS_PB_ADMIN_URL ;?>/images/icons/woo.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Login Form', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3o6QBIg" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src= "<?php echo AYS_PB_ADMIN_URL ;?>/images/icons/sign-in.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                                <label class="only_pro">
                                    <div class="pro_features ays-pb-type-pro">
                                        <div class="ays-pb-crown-content">
                                            <img src="<?php echo AYS_PB_ADMIN_URL; ?>/images/icons/crown.png">
                                        </div>
                                        <div class="ays-pb-pro-link-content">
                                            <div class="ays-pb-pro-type-name-content">
                                                <p class="ays-pb-pro-type-name"><?php echo  __('Google Map', "ays-popup-box") ?></p>
                                            </div>
                                            <div class="ays-pb-pro-links-content">
                                                <div class="ays-pb-view-demo-pro-content">
                                                    <a href="https://bit.ly/3c1MkmM" target="_blank"> View Demo </a>
                                                </div>
                                                <div class="ays-pb-upgarde-now-pro-content">
                                                    <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("Upgrade Now", "ays-popup-box"); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays_pb_layer_item">
                                        <div class="ays_pb_layer_item_logo">
                                            <div class="ays_pb_layer_item_logo_overlay">
                                                <img src= "<?php echo AYS_PB_ADMIN_URL ;?>/images/icons/map-marker.svg">
                                            </div>
                                        </div>
                                        <div class="ays_pb_layer_item_description"></div>  
                                    </div>
                                </label> 
                            </div>
                        </div>
                    </div>
                    <div class="ays_pb_select_button_layer">
                        <div class="ays_pb_select_button_item">
                            <input type="button" class="ays_pb_layer_button" name="" value="Select" disabled> 
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="ays_pb_layer_box" style="display: none;"> 
                    <label>
                        <div class="ays_pb_layer_item">
                            <?php echo __('Shortcode', "ays-popup-box") ?>
                            <input id="<?php echo $this->plugin_name; ?>-modal_content_shortcode" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" value="shortcode" <?php
                            if(($modal_content) == '' || $modal_content == null){
                                echo '';
                            }
                            if(isset($modal_content) && $modal_content == 'shortcode')
                            { echo 'checked';}
                            else
                            { echo '';} ?>>
                        </div>
                    </label>
                                        

                    <label>
                        <div class="ays_pb_layer_item">
                            <?php echo  __('Custom Content', "ays-popup-box") ?>
                            <input id="<?php echo $this->plugin_name; ?>-modal_content_custom_html" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" value="custom_html" <?php if($modal_content == 'custom_html'){ echo 'checked';} else { echo '';} ?>>
                      </div>
                    </label>  

                    <label>
                        <div class="ays_pb_layer_item">
                            <?php echo  __('Video', "ays-popup-box") ?>
                                <input id="<?php echo $this->plugin_name; ?>-modal_content_video_type" type="radio" name="<?php echo $this->plugin_name; ?>[modal_content]" value="video_type" <?php if($modal_content == 'video_type'){ echo 'checked';} else { echo '';} ?>>
                        </div>
                    </label>                       
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script>
        jQuery(document).ready(function(){
            var pbId = '<?php echo $id; ?>';
            jQuery(document).find('.disabled_textarea').attr('disabled', 'disabled');
            if(jQuery("#<?php echo $this->plugin_name; ?>-show_all_no").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-show_all_no").prop('checked')){
                jQuery('.ays_pb_view_place_tr').show(250);
            }
            if(jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").prop('checked')){
                jQuery('.ays_pb_view_place_tr').hide(250);
            }
            if(jQuery("#<?php echo $this->plugin_name; ?>-modal_content_custom_html").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-modal_content_custom_html").prop('checked') && (pbId !== '')){
                jQuery('#ays_custom_html').show();
                jQuery('#ays_shortcode').hide();
                jQuery('#ays_custom_html').before('<hr>');
            }
            if(jQuery("#<?php echo $this->plugin_name; ?>-modal_content_shortcode").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-modal_content_shortcode").prop('checked') && (pbId !== '')){
                jQuery('#ays_custom_html').hide();
                jQuery('#ays_shortcode').show();
                jQuery('#ays_shortcode').before('<hr>');
            }

            if(jQuery("#<?php echo $this->plugin_name; ?>-modal_content_video_type").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-modal_content_video_type").prop('checked') && (pbId !== '')){
                jQuery('#ays_custom_html').hide();
                jQuery('.ays_pb_themes').hide();
                jQuery('.video_hr').hide();
                jQuery('#video_theme_view_type').prop('checked',true);
                jQuery(document).find(".ays_video_window").css('display', 'block');
                jQuery(document).find(".ays_video_window").addClass('ays_active');
                jQuery(document).find(".ays-pb-modal, .ays_window , .ays_cmd_window , .ays_ubuntu_window , .ays_winxp_window , .ays_win98_window , .ays_lil_window , .ays_image_window , .ays_minimal_window, .ays_template_window").css('display', 'none');
            }
        });
        jQuery("#<?php echo $this->plugin_name; ?>-show_all_except").on('click', function(){
            jQuery('.ays_pb_view_place_tr').show(250);
        });
        jQuery("#<?php echo $this->plugin_name; ?>-show_all_selected").on('click', function(){
            jQuery('.ays_pb_view_place_tr').show(250);
        });
        jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").on('click', function(){
            jQuery('.ays_pb_view_place_tr').hide(250);
        });
    </script>
    <script>
        (function ($) {
            $(document).ready(function () {
                var a = $('.ays_help_desc');
                var ays_pb_view_type;
                var default_template_img;
                var modal_content = '<?php echo $modal_content; ?>';
                var checked = $(document).find('input#ays-enable-background-gradient').prop('checked');
                let pb_gradient_direction = $(document).find('#ays_pb_gradient_direction').val();
                var pb_bg_image_position_val = $(document).find('#ays_pb_bg_image_position').val();
                var pb_bg_image_position = pb_bg_image_position_val.replace('-', ' ');

                var pb_bg_image_sizing = $(document).find('#ays_pb_bg_image_sizing').val();

                var bg_img_val = '';
                if($(document).find('input#ays-pb-bg-image').val() == '') {
                    if(checked){
                        bg_img_val = $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
                    }else{
                        bg_img_val = $(document).find('.ays-pb-live-container').css({'background-image': "none"});
                    }
                }else{
                    bg_img_val = $(document).find('.ays-pb-live-container').not('.ays_template_window').css({'background-image': 'url('+$("#<?php echo $this->plugin_name; ?>-bg-image").val()+ ')'});
                }

                var pbTitleVal = $(document).find('#ays-pb-popup_title').val();
                var pbTitle = aysPopupstripHTML( pbTitleVal );

                var textShadowColor = $('#ays_title_text_shadow_color').val();
                var textShadowX = $("#ays_pb_title_text_shadow_x_offset").val();
                var textShadowY = $("#ays_pb_title_text_shadow_y_offset").val();
                var textShadowZ = $("#ays_pb_title_text_shadow_z_offset").val();

                var boxShadowColor = $('#ays_pb_box_shadow_color').val();
                var boxShadowX = $("#ays_pb_box_shadow_x_offset").val();
                var boxShadowY = $("#ays_pb_box_shadow_y_offset").val();
                var boxShadowZ = $("#ays_pb_box_shadow_z_offset").val();
                
                switch ($("input[name='<?php echo $this->plugin_name; ?>[view_type]']:checked").val()) {
                    case 'default':
                        $(document).find(".ays-pb-modal").css('display', 'block');
                        $(document).find(".ays-pb-modal").addClass('ays_active');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        changeCloseButtonPosition();
                        ays_pb_view_type = '.ays-pb-modal';
                        
                        // $(document).find('.ays-pb-modal h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'mac':
                        $(document).find(".ays_window").css('display', 'block');
                        $(document).find(".ays_window").addClass('ays_active');;
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        ays_pb_view_type = '.ays_window';
                        
                        // $(document).find('.ays_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'cmd':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'block');
                        $(document).find(".ays_cmd_window").addClass('ays_active');;
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        ays_pb_view_type = '.ays_cmd_window';
                        
                        // $(document).find('.ays_cmd_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'ubuntu':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'block');
                        $(document).find(".ays_ubuntu_window").addClass('ays_active');;
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        ays_pb_view_type = '.ays_ubuntu_window';
                        
                        // $(document).find('.ays_ubuntu_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'winXP':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'block');
                        $(document).find(".ays_winxp_window").addClass('ays_active');;
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        $(document).find('.ays_winxp_content').css({
                            'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val()
                        });
                        ays_pb_view_type = '.ays_winxp_window';
                        
                        // $(document).find('.ays_winxp_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'win98':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'block');
                        $(document).find(".ays_win98_window").addClass('ays_active');;
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        ays_pb_view_type = '.ays_win98_window';
                        
                        // $(document).find('.ays_win98_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'lil':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'block');
                        $(document).find(".ays_lil_window").addClass('ays_active');;
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        ays_pb_view_type = '.ays_lil_window';
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        $(document).find('.ays_lil_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                        // $(document).find('.ays_lil_head .ays-close-button-take-text-color').css('color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + " !important");
                        $(document).find('.ays_lil_head .ays-close-button-take-text-color').css('background-color', $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important');
                        changeCloseButtonPosition();
                        // $(document).find('.ays_lil_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'image':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'block');
                        $(document).find(".ays_image_window").addClass('ays_active');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        ays_pb_view_type = '.ays_image_window';
                        if ($("#<?php echo $this->plugin_name; ?>-bg-image").val() == '') {
                            default_template_img = 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg")';
                        }else{
                            default_template_img = 'url(' + $("#<?php echo $this->plugin_name; ?>-bg-image").val() + ')';
                        }
                        $(document).find('.ays_bg_image_box').css({
                            'background-image' : default_template_img,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        changeCloseButtonPosition();
                        
                        // $(document).find('.ays_image_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'minimal':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'block');
                        $(document).find(".ays_minimal_window").addClass('ays_active');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        ays_pb_view_type = '.ays_minimal_window';

                        $(document).find('.ays_bg_image_box').css({
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        changeCloseButtonPosition();
                        
                        // $(document).find('.ays_minimal_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'template':
                        $(document).find(".ays-pb-modal").css('display', 'none');
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'block');
                        $(document).find(".ays_template_window").addClass('ays_active');;
                        ays_pb_view_type = '.ays_template_window';
                        $(document).find('.ays_template_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                        if ($("#<?php echo $this->plugin_name; ?>-bg-image").val() == '') {
                            default_template_img = 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg")';
                        }else{
                            default_template_img = 'url(' + $("#<?php echo $this->plugin_name; ?>-bg-image").val() + ')';
                        }
                        $(document).find('.ays_bg_image_box').css({
                            'background-image' : default_template_img,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        changeCloseButtonPosition();
                        
                        // $(document).find('.ays_template_window h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                    case 'video':
                        if(modal_content == 'video_type'){
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'block');
                            $(document).find(".ays_video_window").addClass('ays_active');
                            $(document).find(".ays_yellowish_window").css('display', 'none');
                            $(document).find(".ays_coral_window").css('display', 'none');
                            $(document).find(".ays_peachy_window").css('display', 'none');
                            $(document).find('#ays-popup-box-description').hide();
                            $(document).find('#ays-popup-box-description').prev('hr').hide();
                            $(document).find('#ays-pb-show-title-description-box').hide();
                            $(document).find('#ays-pb-show-title-description-box').next('hr').hide();
                            ays_pb_view_type = '.ays_video_window';
                            $(document).find('.ays_bg_image_box').css({
                                bg_img_val,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                        }
                        changeCloseButtonPosition();
                        
                        break;
                    default:
                        $(document).find(".ays-pb-modal").css('display', 'block');
                        $(document).find(".ays-pb-modal").addClass('ays_active');;
                        $(document).find(".ays_window").css('display', 'none');
                        $(document).find(".ays_cmd_window").css('display', 'none');
                        $(document).find(".ays_ubuntu_window").css('display', 'none');
                        $(document).find(".ays_winxp_window").css('display', 'none');
                        $(document).find(".ays_win98_window").css('display', 'none');
                        $(document).find(".ays_lil_window").css('display', 'none');
                        $(document).find(".ays_image_window").css('display', 'none');
                        $(document).find(".ays_minimal_window").css('display', 'none');
                        $(document).find(".ays_template_window").css('display', 'none');
                        $(document).find(".ays_video_window").css('display', 'none');
                        $(document).find('.ays_bg_image_box').css({
                            bg_img_val,
                            'background-repeat' : 'no-repeat',
                            'background-size' : pb_bg_image_sizing,
                            'background-position' : pb_bg_image_position
                        });
                        changeCloseButtonPosition();
                        ays_pb_view_type = '.ays-pb-modal';
                        
                        // $(document).find('.ays-pb-modal h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                        break;
                }

                $(document).on('click','input[name="<?php echo $this->plugin_name; ?>[view_type]"], .ays-pb-template-choose-template-btn',function () {
                    var bgImage = $("#<?php echo $this->plugin_name; ?>-bg-image").val();
                    var bgGradient = $("#ays-enable-background-gradient").prop('checked');
                    var pb_bg_image_position = $(document).find('#ays_pb_bg_image_position').val();
                    var pb_bg_image_sizing = $(document).find('#ays_pb_bg_image_sizing').val();

                    var bg_image_css = '';
                    if(bgImage != ''){
                        bg_image_css ='url(' + bgImage + ')';
                    }else if (bgGradient) {
                        var bgGradientColor1 = $("#ays-background-gradient-color-1").val();
                        var bgGradientColor2 = $("#ays-background-gradient-color-2").val();
                        var bgGradientDir = $("#ays-background-gradient-color-2").val();
                        var pb_gradient_direction;
                        switch(bgGradientDir) {
                            case "horizontal":
                                pb_gradient_direction = "to right";
                                break;
                            case "diagonal_left_to_right":
                                pb_gradient_direction = "to bottom right";
                                break;
                            case "diagonal_right_to_left":
                                pb_gradient_direction = "to bottom left";
                                break;
                            default:
                                pb_gradient_direction = "to bottom";
                        }
                        bg_image_css = 'linear-gradient('+pb_gradient_direction+', '+bgGradientColor1+', '+bgGradientColor2;
                    }

                    var pbTitleVal = $(document).find('#ays-pb-popup_title').val();
                    var pbTitle = aysPopupstripHTML( pbTitleVal );

                    switch ($("input[name='<?php echo $this->plugin_name; ?>[view_type]']:checked").val()) {
                        case 'default':
                            $(document).find(".ays-pb-modal").css('display', 'block');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays-pb-modal';

                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                // $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());

                                if($("#ays-pb-close-button-text").val() == 'x'){
                                     $(ays_pb_view_type + ' .ays-close-button-text').html("<img src='<?php echo AYS_PB_ADMIN_URL ?>" + "/images/icons/times-2x.svg' class='fa-2x'>");
                                }else{
                                    $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                                }
                            });
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                    $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                                }else{
                                    $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                                }
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                if($(document).find('#ays_enable_box_shadow').prop('checked')){
                                    $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                                }else{
                                    $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                                }
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }

                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px',
                                'font-family': $('#ays_pb_font_family').val(),
                            });
                            var closeBtnDefaultColor = $(document).find('#ays_pb_close_button_color').val('#000');
                            // $(document).find('#ays_pb_close_button_color').wpColorPicker(closeBtnDefaultColor);
                            changeCloseButtonPosition();
                            
                            break;
                        case 'mac':
                            $(document).find(".ays_window").css('display', 'block');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none')
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px"+ $('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }

                            break;
                        case 'cmd':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'block');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays_cmd_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            
                            break;
                        case 'ubuntu':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'block');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays_ubuntu_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            
                            break;
                        case 'winXP':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'block');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays_winxp_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(ays_pb_view_type + ' .ays_winxp_content').css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val()
                            });
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            $(ays_pb_view_type).css({
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            
                            break;
                        case 'win98':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'block');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays_win98_window';
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            
                            break;
                        case 'lil':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'block');
                            ays_pb_view_type = '.ays_lil_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            $(document).find('.ays_lil_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                            $(document).find('.ays_lil_head .ays-close-button-take-text-color').css('background-color', $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important');
                            // $(document).find('.ays_lil_head .ays-close-button-take-text-color').css('color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + " !important");
                            changeCloseButtonPosition();
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            $(document).find("#ays_pb_close_button_color").val('#ffffff');
                            var closeBtnDefaultColor = $(document).find('#ays_pb_close_button_color').val('#fff');
                            // $(document).find('#ays_pb_close_button_color').wpColorPicker(closeBtnDefaultColor);
                            break;
                        case 'image':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'block');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays_image_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            var bg_img_default = $("#<?php echo $this->plugin_name; ?>-bg-image").val();
                            if(!bg_img_default)
                                bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg";
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : 'url('+ bg_img_default +')',
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            changeCloseButtonPosition();
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            var closeBtnDefaultColor = $(document).find('#ays_pb_close_button_color').val('#000');
                            // $(document).find('#ays_pb_close_button_color').wpColorPicker(closeBtnDefaultColor);
                            break;
                        case 'minimal':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'block');
                            $(document).find(".ays_minimal_window").addClass('ays_active');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            ays_pb_view_type = '.ays_minimal_window';

                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );

                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                if($("#ays-pb-close-button-text").val() == 'x'){
                                     $(ays_pb_view_type + ' .ays-close-button-text').html("<img src='<?php echo AYS_PB_ADMIN_URL ?>" + "/images/icons/times-circle.svg'>");
                                }else{
                                    $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                                }
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });

                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : bg_image_css,
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            changeCloseButtonPosition();
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            var closeBtnDefaultColor = $(document).find('#ays_pb_close_button_color').val('#000');
                            // $(document).find('#ays_pb_close_button_color').wpColorPicker(closeBtnDefaultColor);
                            break;
                        case 'template':
                            $(document).find(".ays-pb-modal").css('display', 'none');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'block');
                            ays_pb_view_type = '.ays_template_window';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            $(document).find('.ays_template_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + ' !important');
                            var bg_img_default = $("#<?php echo $this->plugin_name; ?>-bg-image").val();
                            if(!bg_img_default)
                                bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg";
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : 'url(' + bg_img_default + ')',
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            changeCloseButtonPosition();
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            var closeBtnDefaultColor = $(document).find('#ays_pb_close_button_color').val('#000');
                            // $(document).find('#ays_pb_close_button_color').wpColorPicker(closeBtnDefaultColor);
                            break;
                        case 'video':
                            if(modal_content == 'video_type'){
                                $(document).find(".ays-pb-modal").css('display', 'none');
                                $(document).find(".ays_window").css('display', 'none');
                                $(document).find(".ays_cmd_window").css('display', 'none');
                                $(document).find(".ays_ubuntu_window").css('display', 'none');
                                $(document).find(".ays_winxp_window").css('display', 'none');
                                $(document).find(".ays_win98_window").css('display', 'none');
                                $(document).find(".ays_lil_window").css('display', 'none');
                                $(document).find(".ays_image_window").css('display', 'none');
                                $(document).find(".ays_minimal_window").css('display', 'none');
                                $(document).find(".ays_template_window").css('display', 'none');
                                $(document).find(".ays_video_window").css('display', 'block');
                                ays_pb_view_type = '.ays_video_window';
                                $(document).find('.ays_bg_image_box').css({
                                    'background-image' : bg_image_css,
                                    'background-repeat' : 'no-repeat',
                                    'background-size' : pb_bg_image_sizing,
                                    'background-position' : pb_bg_image_position
                                });
                                $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                                $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                                $(document).find("#ays-pb-close-button-text").on('change', function () {
                                    $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                                });
                                $(ays_pb_view_type).css({
                                
                                    'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                    'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                    'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                                });
                            }
                            changeCloseButtonPosition();
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            var closeBtnDefaultColor = $(document).find('#ays_pb_close_button_color').val('#000');
                            // $(document).find('#ays_pb_close_button_color').wpColorPicker(closeBtnDefaultColor);
                            break;
                        default:
                            $(document).find(".ays-pb-modal").css('display', 'block');
                            $(document).find(".ays_window").css('display', 'none');
                            $(document).find(".ays_cmd_window").css('display', 'none');
                            $(document).find(".ays_ubuntu_window").css('display', 'none');
                            $(document).find(".ays_winxp_window").css('display', 'none');
                            $(document).find(".ays_win98_window").css('display', 'none');
                            $(document).find(".ays_lil_window").css('display', 'none');
                            $(document).find(".ays_image_window").css('display', 'none');
                            $(document).find(".ays_minimal_window").css('display', 'none');
                            $(document).find(".ays_template_window").css('display', 'none');
                            $(document).find(".ays_video_window").css('display', 'none');
                            $(document).find('.ays_bg_image_box').css({
                                'background-image' : 'url(' + $("#<?php echo $this->plugin_name; ?>-bg-image").val() + ')',
                                'background-repeat' : 'no-repeat',
                                'background-size' : pb_bg_image_sizing,
                                'background-position' : pb_bg_image_position
                            });
                            ays_pb_view_type = '.ays-pb-modal';
                            $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                            $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );
                            $(document).find("#ays-pb-close-button-text").on('change', function () {
                                $(ays_pb_view_type + ' .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                            });
                            $(ays_pb_view_type).css({
                                'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                                'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                                'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                                'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px','font-family': $('#ays_pb_font_family').val(),
                            });
                            changeCloseButtonPosition();
                            if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                            }

                            if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                                $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                            }else{
                                $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                            }
                            var closeBtnDefaultColor = $(document).find('#ays_pb_close_button_color').val('#000');
                            // $(document).find('#ays_pb_close_button_color').wpColorPicker(closeBtnDefaultColor);
                            break;
                    }
                });
                $('[data-toggle="tooltip"]').tooltip({
                    template: '<div class="tooltip ays-pb-custom-class-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                });
                $(ays_pb_view_type).css({
                    'background-color': $("#<?php echo $this->plugin_name; ?>-bgcolor").val(),
                    'color': $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important',
                    'border': $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val(),
                    'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px',
                    'font-family': $('#ays_pb_font_family').val(),
                });

                $(document).find(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                $(document).find(ays_pb_view_type + ' .ays_title').html( pbTitle );

                $(document).find("#<?php echo $this->plugin_name; ?>-popup_title").on('change', function () {
                    var pbTitleVal = $(this).val();
                    var pbTitle = aysPopupstripHTML( pbTitleVal );

                    $(ays_pb_view_type + ' .ays_title').html( pbTitle );
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-popup_description").on('change', function () {
                    $(ays_pb_view_type + ' .desc').html($("#<?php echo $this->plugin_name; ?>-popup_description").val());
                });
                $(document).find("#ays-pb-close-button-text").on('change', function () {
                    let $this      = $(document).find('.ays-pb-modal .ays-close-button-text');
                    let buttonText = $(this).val();
                    if (buttonText == '') {
                        buttonText = 'x'
                    }
                    $(document).find('.ays-close-button-text').html(buttonText);
                    if ($this.hasClass('fa-2x')) {
                        if (buttonText == 'x' || buttonText == '') {
                            if ($this.hasClass('ays_fa-close-button')) {
                                $this.removeClass('ays_fa-close-button');
                            }
                            setTimeout(function(){
                                $(document).find('.ays-pb-modal .ays-close-button-text').html('');
                            },500);
                            $this.html("<img src='<?php echo AYS_PB_ADMIN_URL ?>" + "/images/icons/times-2x.svg' class='fa-2x'>");
                        }else{
                            $this.removeClass('ays_fa-close-button');
                        }
                    }
                    if ((buttonText == 'x' || buttonText == '') && $(document).find('a.close-lil-btn').hasClass('close-lil-btn-text')) {
                        $(document).find('a.close-lil-btn').removeClass('close-lil-btn-text');
                    }
                    else if (!$(document).find('a.close-lil-btn').hasClass('close-lil-btn-text')){
                        if (buttonText != '') {
                            $(document).find('a.close-lil-btn').addClass('close-lil-btn-text');
                        }
                    }
                    if($("#ays-pb-close-button-text").val() == 'x'){
                          $(document).find('.ays_minimal_window .ays-close-button-text').html("<img src='<?php echo AYS_PB_ADMIN_URL ?>" + "/images/icons/times-circle.svg'>");
                    }else{
                         $(document).find('.ays_minimal_window .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                    }

                    if($("#ays-pb-close-button-text").val() == 'x'){
                         $(document).find('.ays-pb-modal .ays-close-button-text').html("<img src='<?php echo AYS_PB_ADMIN_URL ?>" + "/images/icons/times-2x.svg' class='fa-2x'>");
                    }else{
                         $(document).find('.ays-pb-modal .ays-close-button-text').html($("#ays-pb-close-button-text").val());
                    }

                });

                $(document).find("#ays-pb-close-button-position").on('change',function(){
                    changeCloseButtonPosition()
                });

                function changeCloseButtonPosition(){
                    let position = $(document).find('#ays-pb-close-button-position').val();
                    let ays_pb_radius = Math.abs($(document).find('#ays-pb-ays_pb_bordersize').val());
                    let checkedTheme = $(document).find("input[name='<?php echo $this->plugin_name; ?>[view_type]']:checked").val();
                    let tb,tb_value,rl,rl_value,auto_1,auto_2,res;
                    let ays_pb_checked_theme_class = '';
                    switch(checkedTheme){
                        case "lil": //top 3 right 3 
                            ays_pb_checked_theme_class = ".ays_lil_window .close-lil-btn";
                            switch(position){
                                case "left-top":
                                    tb = "top"; tb_value = "10px";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    tb = "top"; tb_value = "10px";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "image"://top -20px right 0
                            ays_pb_checked_theme_class = ".ays_image_window .close-image-btn";
                             switch(position){
                                case "left-top":
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "minimal"://top -20px right 0
                            ays_pb_checked_theme_class = ".ays_minimal_window .close-image-btn";
                             switch(position){
                                case "left-top":
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "template"://top 0 right 7px 
                            ays_pb_checked_theme_class = ".ays_template_window .close-template-btn";
                            switch(position){
                                case "left-top":
                                    tb = "top"; tb_value = "14px";
                                    rl = "left"; rl_value = "14px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    tb = "bottom"; tb_value = "7px";
                                    rl = "left"; rl_value = "14px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    tb = "bottom"; tb_value = "7px";
                                    rl = "right"; rl_value = "14px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    tb = "top"; tb_value = "14px";
                                    rl = "right"; rl_value = "14px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "video"://top -20px right 0
                            ays_pb_checked_theme_class = ".ays_video_window .close-video-btn";
                             switch(position){
                                case "left-top":
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "left"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    res = -20 - ays_pb_radius;
                                    tb = "bottom"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    res = -20 - ays_pb_radius;
                                    tb = "top"; tb_value = res+"px";
                                    rl = "right"; rl_value = -ays_pb_radius+"px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        case "default"://top 0 right 10px 
                            ays_pb_checked_theme_class = ".ays-pb-modal .ays-pb-modal-close";
                            switch(position){
                                case "left-top":
                                    tb = "top"; tb_value = "0";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'right';
                                    break;
                                case "left-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "left"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'right';
                                    break;
                                case "right-bottom":
                                    tb = "bottom"; tb_value = "10px";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'top'; auto_2 = 'left';
                                    break;
                                default:
                                    tb = "top"; tb_value = "0";
                                    rl = "right"; rl_value = "10px";
                                    auto_1 = 'bottom'; auto_2 = 'left';
                            }
                            break;
                        default:
                            ays_pb_checked_theme_class = '';
                            tb = "top"; tb_value = "0";
                            rl = "right"; rl_value = "0";
                            auto_1 = 'bottom'; auto_2 = 'left';
                    }
                    $(document).find(ays_pb_checked_theme_class).css(tb,tb_value).css(rl,rl_value).css(auto_1,'auto').css(auto_2,'auto');
                }

                var optionsForBgColor = {
                    change: function (e) {
                        if (ays_pb_view_type == '.ays_winxp_window') {
                            $(ays_pb_view_type + ' .ays_winxp_content').css('background-color', e.target.value);
                        } else {
                            $(ays_pb_view_type).css('background-color', e.target.value);
                        }
                    }
                }

                var optionsForTextColor = {
                    change: function (e) {
                        // var redDataName = $(ays_pb_view_type).attr('data-name');
                        // if(redDataName != 'red'){
                        //     $(document).find('.ays-close-button-take-text-color').css('color', e.target.value + " !important");
                        // }else{
                        //     $(document).find('.ays-close-button-take-text-color').css('background-color', e.target.value + " !important");

                        // }
                        $(ays_pb_view_type).css('color', e.target.value + " !important");
                    }
                }

                var optionsForBorderColor = {
                    change: function (e) {
                        $(ays_pb_view_type).css('border-color', e.target.value);
                    }
                }

                var optionsForOverlayColor = {
                    change: function (e) {
                            $(document).find('.ays-pb-modals').css('background-color', e.target.value + " !important");
                    }
                }

                var optionsForTextShadowColor = {
                    change: function (e) {
                        var x = $("#ays_pb_title_text_shadow_x_offset").val();
                        var y = $("#ays_pb_title_text_shadow_y_offset").val();
                        var z = $("#ays_pb_title_text_shadow_z_offset").val();
                        $(document).find(ays_pb_view_type+' h2.ays_title').css("text-shadow", x+"px "+y+"px "+z+"px "+e.target.value);
                    }
                }

                var optionsForBoxShadowColor = {
                    change: function (e) {
                        var x = $("#ays_pb_box_shadow_x_offset").val();
                        var y = $("#ays_pb_box_shadow_y_offset").val();
                        var z = $("#ays_pb_box_shadow_z_offset").val();
                        $(document).find(ays_pb_view_type).css("box-shadow", x+"px "+y+"px "+z+"px "+e.target.value);
                    }
                }

                $(document).find('table#ays_pb_bg_image_position_table tr td').on('click', function(e){
                    var bg_image_position_val= $(document).find('#ays_pb_bg_image_position').val();
                    var bg_image_position = bg_image_position_val.replace( '-', ' ' );
                    
                    $(document).find(ays_pb_view_type).css({'background-position':bg_image_position});
                });

                var optionsForBgHeader = {
                    change: function (e) {
                        $(document).find('.ays_lil_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val()+ " !important");
                        $(document).find('.ays_template_head').css('background-color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val()+ " !important");
                        // $(document).find('.ays-close-button-take-text-color').css('color', $("#<?php echo $this->plugin_name; ?>-header_bgcolor").val() + " !important");
                    }
                }

                function aysPopupstripHTML( dirtyString ) {
                    var container = document.createElement('div');
                    var text = document.createTextNode(dirtyString);
                    container.appendChild(text);

                    return container.innerHTML; // innerHTML will be a xss safe string
                }

                $(document).find('.ays_pb_bgcolor_change').wpColorPicker(optionsForBgColor);
                $(document).find('.ays_pb_textcolor_change').wpColorPicker(optionsForTextColor);
                $(document).find('.ays_pb_bordercolor_change').wpColorPicker(optionsForBorderColor);
                $(document).find('.ays_pb_overlay_color_change').wpColorPicker(optionsForOverlayColor);
                $(document).find('#<?php echo $this->plugin_name; ?>-header_bgcolor').wpColorPicker(optionsForBgHeader);
                $(document).find('#ays_title_text_shadow_color').wpColorPicker(optionsForTextShadowColor);
                $(document).find('#ays_pb_box_shadow_color').wpColorPicker(optionsForBoxShadowColor);

                if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                    if($(document).find('#ays_enable_title_text_shadow').prop('checked')){
                    $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
                }else{
                    $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                }
                }else{
                    $(document).find(ays_pb_view_type+' h2.ays_title').css('text-shadow', 'unset');
                }

                if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                    if($(document).find('#ays_pb_enable_box_shadow').prop('checked')){
                    $(document).find(ays_pb_view_type).css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
                }else{
                    $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                }
                }else{
                    $(document).find(ays_pb_view_type).css('box-shadow', 'unset');
                }
                
                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").on('change', function () {
                    $(ays_pb_view_type).css('color', $("#<?php echo $this->plugin_name; ?>-ays_pb_textcolor").val() + ' !important');
                });

                $(document).find("#ays_pb_title_text_shadow_x_offset").on('change', function () {
                    var textShadowColor = $('#ays_title_text_shadow_color').val();
                    var x = $(this).val();
                    var y = $("#ays_pb_title_text_shadow_y_offset").val();
                    var z = $("#ays_pb_title_text_shadow_z_offset").val();
                    $(document).find(ays_pb_view_type+' h2.ays_title').css("text-shadow", x+"px "+y+"px "+z+"px " +textShadowColor);
                });
                $(document).find("#ays_pb_title_text_shadow_y_offset").on('change', function () {
                    var textShadowColor = $('#ays_title_text_shadow_color').val();
                    var x = $('#ays_pb_title_text_shadow_x_offset').val();
                    var y = $(this).val();
                    var z = $("#ays_pb_title_text_shadow_z_offset").val();
                    $(document).find(ays_pb_view_type+' h2.ays_title').css("text-shadow", x+"px "+y+"px "+z+"px "+textShadowColor);
                });
                $(document).find("#ays_pb_title_text_shadow_z_offset").on('change', function () {
                    var textShadowColor = $('#ays_title_text_shadow_color').val();
                    var x = $('#ays_pb_title_text_shadow_x_offset').val();
                    var y = $("#ays_pb_title_text_shadow_y_offset").val();
                    var z = $(this).val();
                    $(document).find(ays_pb_view_type+' h2.ays_title').css("text-shadow", x+"px "+y+"px "+z+"px "+textShadowColor);
                });

                $(document).find("#ays_pb_box_shadow_x_offset").on('change', function () {
                    var boxShadowColor = $('#ays_box_shadow_color').val();
                    var x = $(this).val();
                    var y = $("#ays_pb_box_shadow_y_offset").val();
                    var z = $("#ays_pb_box_shadow_z_offset").val();
                    $(document).find(ays_pb_view_type).css("box-shadow", x+"px "+y+"px "+z+"px " +boxShadowColor);
                });

                $(document).find("#ays_pb_box_shadow_y_offset").on('change', function () {
                    var boxShadowColor = $('#ays_box_shadow_color').val();
                    var x = $('#ays_pb_box_shadow_x_offset').val();
                    var y = $(this).val();
                    var z = $("#ays_pb_box_shadow_z_offset").val();
                    $(document).find(ays_pb_view_type).css("box-shadow", x+"px "+y+"px "+z+"px "+boxShadowColor);
                });

                $(document).find("#ays_pb_box_shadow_z_offset").on('change', function () {
                    var boxShadowColor = $('#ays_box_shadow_color').val();
                    var x = $('#ays_pb_box_shadow_x_offset').val();
                    var y = $("#ays_pb_box_shadow_y_offset").val();
                    var z = $(this).val();
                    $(document).find(ays_pb_view_type).css("box-shadow", x+"px "+y+"px "+z+"px "+boxShadowColor);
                });

                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").on('change', function () {
                    let ays_pb_radius = Math.abs($(this).val());
                    let ays_pb_bottom = (-40 - ays_pb_radius);
                    let closeBtnPosition = $(document).find('#ays-pb-close-button-position').val();
                    let tb,tb_value,rl,rl_value,auto_1,auto_2,res;
                    $(ays_pb_view_type).css('border', $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val());
                    $(document).find('.ays-pb-live-container.ays_image_window .ays_pb_timer').css('bottom', ays_pb_bottom+'px');
                    $(document).find('.ays-pb-live-container.ays_minimal_window .ays_pb_timer').css('bottom', ays_pb_bottom+'px');
                    switch(closeBtnPosition){
                         case "left-top":
                            res = -20 - ays_pb_radius;
                            tb = "top"; tb_value = res+"px";
                            rl = "left"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'bottom'; auto_2 = 'right';
                            break;
                        case "left-bottom":
                            res = -20 - ays_pb_radius;
                            tb = "bottom"; tb_value = res+"px";
                            rl = "left"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'top'; auto_2 = 'right';
                            break;
                        case "right-bottom":
                            res = -20 - ays_pb_radius;
                            tb = "bottom"; tb_value = res+"px";
                            rl = "right"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'top'; auto_2 = 'left';
                            break;
                        default:
                            res = -20 - ays_pb_radius;
                            tb = "top"; tb_value = res+"px";
                            rl = "right"; rl_value = -ays_pb_radius+"px";
                            auto_1 = 'bottom'; auto_2 = 'left';
                    }
                    $(document).find('.ays-pb-live-container .close-image-btn').css(tb,tb_value).css(rl,rl_value).css(auto_1,'auto').css(auto_2,'auto');

                });
                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").on('change', function () {
                    $(ays_pb_view_type).css('border-radius', $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px');
                    $(document).find('.ays_video_content>video').css('border-radius', $("#<?php echo $this->plugin_name; ?>-ays_pb_border_radius").val() + 'px');
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-animate_in").on('change', function () {
                    if($(this).val() == 'none'){
                        $(document).find('#ays_pb_animation_speed').prop( "disabled", true );
                    }else{
                        $(document).find('#ays_pb_animation_speed').prop( "disabled", false );
                    }
                    let animation_speed = Math.abs($(document).find('#ays_pb_animation_speed').val() ) +"s";
                    $(ays_pb_view_type).css('animation', $("#<?php echo $this->plugin_name; ?>-animate_in").val() + " " + animation_speed);
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-animate_out").on('change', function () {
                    if($(this).val() == 'none'){
                        $(document).find('#ays_pb_close_animation_speed').prop( "disabled", true );
                    }else{
                        $(document).find('#ays_pb_close_animation_speed').prop( "disabled", false );
                    }
                    let animation_speed = Math.abs($(document).find('#ays_pb_close_animation_speed').val() ) +"s";
                    $(ays_pb_view_type).css('animation', $("#<?php echo $this->plugin_name; ?>-animate_out").val() + " " + animation_speed);
                });
                $(document).find("#ays_pb_font_family").on('change', function () {
                    $(ays_pb_view_type).css('font-family', $('#ays_pb_font_family').val());
                });
                $(document).find("#ays_pb_font_size").on('change', function () {
                    $(ays_pb_view_type).find('p.desc').css('font-size', $('#ays_pb_font_family').val()+'px !important');
                });
                $(document).find("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").on('change', function () {
                    $(ays_pb_view_type).css('border', $("#<?php echo $this->plugin_name; ?>-ays_pb_bordersize").val() + "px "+$('#ays_pb_border_style').val()+ $("#<?php echo $this->plugin_name; ?>-ays_pb_bordercolor").val());
                });
                $(document).find("#ays-active ,#ays-deactive").on('click',function(){
                    $(document).find("#ui-datepicker-div").css('z-index', '10010');
                });
                $(document).find("#ays_pb_close_button_size").on('change',function(){
                    $close_btn_size = $(document).find("#ays_pb_close_button_size").val();
                    if($close_btn_size == 0){
                        $close_btn_size = $(document).find("#ays_pb_close_button_size").val(1);
                        $(document).find('.ays-close-button-text').css({'transform': 'scale('+$close_btn_size+')'});
                    }else{
                        $(document).find('.ays-close-button-text').css({'transform': 'scale('+$close_btn_size+')'});
                    }
                });
                $(document).find('.close-lil-btn').hover(function(){
                    $close_btn_size = $(document).find("#ays_pb_close_button_size").val();
                    $('.close-lil-btn').css({'transform':'rotate(180deg) scale('+$close_btn_size+')'});
                },function(){
                    $close_btn_size = $(document).find("#ays_pb_close_button_size").val();
                    $('.close-lil-btn').css({'transform':'scale('+$close_btn_size+')'});
                });
                <?php if ($close_button == "on"){
                    echo  '$(document).find(".ays-close-button-on-off").css("display","none")' ;
                } ?>
                $(document).find("#ays_pb_close_button_color").on('change',function(){
                    $close_btn_color = $(document).find("#ays_pb_close_button_color").val();
                    $(document).find('.ays-close-button-text').css({'color': $close_btn_color});
                });
            });
        })(jQuery);
    </script>