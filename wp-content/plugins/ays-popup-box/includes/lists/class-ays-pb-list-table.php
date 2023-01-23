<?php
ob_start();
class Ays_PopupBox_List_Table extends WP_List_Table {
    private $plugin_name;
    private $title_length;
    /** Class constructor */
    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
        $this->title_length = Ays_Pb_Admin::get_listtables_title_length('popups');
        parent::__construct( array(
            "singular" => __( "PopupBox", "ays-popup-box" ), //singular name of the listed records
            "plural"   => __( "PopupBoxes", "ays-popup-box" ), //plural name of the listed records
            "ajax"     => false //does this table support ajax?
        ) );
        add_action( "admin_notices", array( $this, "popupbox_notices" ) );

    }

    public function display_tablenav( $which ) {
        ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">
            
            <div class="alignleft actions">
                <?php $this->bulk_actions( $which ); ?>
            </div>
             
            <?php
            $this->extra_tablenav( $which );
            $this->pagination( $which );
            ?>
            <br class="clear" />
        </div>
        <?php
    }

      public function extra_tablenav( $which ){
        global $wpdb;
        $titles_sql = "SELECT {$wpdb->prefix}ays_pb_categories.title,{$wpdb->prefix}ays_pb_categories.id FROM {$wpdb->prefix}ays_pb_categories";
        $cat_titles = $wpdb->get_results($titles_sql);
        $cat_id = null;
        if( isset( $_GET['filterby'] )){
            $cat_id = absint( intval( $_GET['filterby'] ) );
        }
        $categories_select = array();
        foreach($cat_titles as $key => $cat_title){
            $selected = "";
            if($cat_id === intval($cat_title->id)){
                $selected = "selected";
            }
            $categories_select[$cat_title->id]['title'] = $cat_title->title;
            $categories_select[$cat_title->id]['selected'] = $selected;
            $categories_select[$cat_title->id]['id'] = $cat_title->id;
        }

        sort($categories_select);

        $ays_pb_status = null;
        if( isset( $_GET['filterbyStatus'] )){
            $ays_pb_status = ( $_GET['filterbyStatus'] );
        }

        ?>
        <div id="category-filter-div" class="alignleft actions bulkactions ays-pb-filter-by-category">
            <select name="filterby" id="bulk-action-selector-top">
                <option value=""><?php echo __('Select Category',"ays-popup-box")?></option>
                <?php
                    foreach($categories_select as $key => $cat_title){
                        echo "<option ".$cat_title['selected']." value='".$cat_title['id']."'>".$cat_title['title']."</option>";
                    }
                ?>
            </select>
            <input type="button" id="doaction" class="cat-filter-apply button" value="Filter">
        </div>
        <div id="status-filter-div" class="alignleft actions bulkactions ays-pb-filter-by-status">
            <select name="filterbyStatus" id="bulk-action-selector-top">
                <option value=""><?php echo __('Select Status',"ays-popup-box")?></option>
                <option <?php if($ays_pb_status == "On") echo "selected"; ?> value="On"><?php echo __('On',"ays-popup-box")?></option>
                <option <?php if($ays_pb_status == "Off") echo "selected"; ?> value="Off"><?php echo __('Off',"ays-popup-box")?></option>
            </select>
            <input type="button" id="doaction" class="status-filter-apply button" value="Filter">
        </div>
        
        <a style="" href="?page=<?php echo esc_attr( $_REQUEST['page'] ); ?>" class="button"><?php echo __( "Clear filters", "ays-popup-box" ); ?></a>
        <?php
    }


     protected function get_views() {
        $published_count = $this->published_popup_count();
        $unpublished_count = $this->unpublished_popup_count();
        $all_count = $this->all_record_count();
        $selected_all = "";
        $selected_off = "";
        $selected_on = "";
        if(isset($_GET['fstatus'])){
            switch($_GET['fstatus']){
                case "unpublished":
                    $selected_off = " style='font-weight:bold;' ";
                    break;
                case "published":
                    $selected_on = " style='font-weight:bold;' ";
                    break;
                default:
                    $selected_all = " style='font-weight:bold;' ";
                    break;
            }
        }else{
            $selected_all = " style='font-weight:bold;' ";
        }
        $status_links = array(
            "all" => "<a ".$selected_all." href='?page=".esc_attr( $_REQUEST['page'] )."'>". __( 'All', "ays-popup-box" )." (".$all_count.")</a>",
            "published" => "<a ".$selected_on." href='?page=".esc_attr( $_REQUEST['page'] )."&fstatus=published'>". __( 'Published', "ays-popup-box" )." (".$published_count.")</a>",
            "unpublished"   => "<a ".$selected_off." href='?page=".esc_attr( $_REQUEST['page'] )."&fstatus=unpublished'>". __( 'Unpublished', "ays-popup-box" )." (".$unpublished_count.")</a>"
        );
        return $status_links;
    }


    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_ays_popupboxes( $per_page = 20, $page_number = 1 , $search = '') {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_pb";


        $where = array();

        if( $search != '' ){
            $where[] = $search;
        }

        if(! empty( $_REQUEST['filterby'] ) && absint( sanitize_text_field( $_REQUEST['filterby'] ) ) > 0){
            $cat_id = absint( sanitize_text_field( $_REQUEST['filterby'] ) );
            $where[] = ' category_id = '.$cat_id.'';
        }

        if(! empty( $_REQUEST['filterbyStatus'] )){
            $ays_pb_status = esc_sql( sanitize_text_field( $_REQUEST['filterbyStatus'] ) );
            $where[] = " onoffswitch = '$ays_pb_status'";
        }

        if( isset( $_REQUEST['fstatus'] ) ){
            $status = esc_sql( sanitize_text_field( $_REQUEST['fstatus'] ) );

            if($status == 'published'){
                $status = 'On';
            }else {
                $status = 'Off';
            }

            if($status !== null){
                $where[] = " onoffswitch = '".$status."' ";
            }
        }

        if( ! empty($where) ){
            $sql .= " WHERE " . implode( " AND ", $where );
        }

        if ( ! empty( $_REQUEST['orderby'] ) ) {

            $order_by  = ( isset( $_REQUEST['orderby'] ) && sanitize_text_field( $_REQUEST['orderby'] ) != '' ) ? sanitize_text_field( $_REQUEST['orderby'] ) : 'id';
            $order_by .= ( ! empty( $_REQUEST['order'] ) && strtolower( $_REQUEST['order'] ) == 'asc' ) ? ' ASC' : ' DESC';

            $sql_orderby = sanitize_sql_orderby($order_by);

            if ( $sql_orderby ) {
                $sql .= ' ORDER BY ' . $sql_orderby;
            } else {
                $sql .= ' ORDER BY id DESC';
            }
        }else{
            $sql .= ' ORDER BY id DESC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= " OFFSET " . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, "ARRAY_A" );

        return $result;
    }

    private function get_max_id() {
        global $wpdb;
        $pb_table = $wpdb->prefix."ays_pb";

        $sql = "SELECT max(id) FROM {$pb_table}";

        $result = $wpdb->get_var($sql);

        return $result;
    }

    public static function published_popup_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_pb WHERE onoffswitch='On'";

        if( isset( $_GET['filterby'] ) && absint( sanitize_text_field( $_GET['filterby'] ) ) > 0){
            $cat_id = absint( sanitize_text_field( $_GET['filterby'] ) );
            $sql .= ' AND category_id = '.$cat_id.' ';
        }

        return $wpdb->get_var( $sql );
    }
    
    public static function unpublished_popup_count() {
        global $wpdb;
        
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_pb WHERE onoffswitch='Off'";

        if( isset( $_GET['filterby'] ) && absint( sanitize_text_field( $_GET['filterby'] ) ) > 0){
            $cat_id = absint( sanitize_text_field( $_GET['filterby'] ) );
            $sql .= ' AND category_id = '.$cat_id.' ';
        }

        return $wpdb->get_var( $sql );
    }

    public static function all_record_count() {
        global $wpdb;
        $filter = array();
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_pb WHERE 1=1";

        if( isset( $_GET['filterby'] ) && absint( sanitize_text_field( $_GET['filterby'] ) ) > 0){
            $cat_id = absint( sanitize_text_field( $_GET['filterby'] ) );
            $sql .= ' AND category_id = '.$cat_id.' ';
        }

        return $wpdb->get_var( $sql );
    }

    public function publish_unpublish_popupbox( $id, $action ) {
        global $wpdb;
        $pb_table = $wpdb->prefix."ays_pb";
       
        if ($id == null) {
            return false;
        }
        if ($action == 'unpublish') {
            $onoffswitch = 'Off';
            $message = 'unpublished';
        }else{
            $onoffswitch = 'On';
            $message = 'published';
        }

        $pb_result = $wpdb->update(
                $pb_table,
                array(
                    "onoffswitch" => $onoffswitch
                ),
                array( "id" => $id ),
                array( "%s" ),
                array( "%d" )
            );

        $url = esc_url_raw( remove_query_arg(array("action", "popupbox", "_wpnonce")) ) . "&status=" . $message . "&type=success";
        wp_redirect( $url );
    }

    public function duplicate_popupbox( $id ){
        global $wpdb;
        $pb_table = $wpdb->prefix."ays_pb";
        $popup = $this->get_popupbox_by_id($id);

        $user_id = get_current_user_id();
        $user = get_userdata($user_id);
        $author = json_encode(array(
            'id' => $user->ID."",
            'name' => $user->data->display_name
        ), JSON_UNESCAPED_SLASHES);

        $max_id = $this->get_max_id();

        $options = json_decode($popup['options'], true);

        $options['create_date'] = date("Y-m-d H:i:s");
        $options['author'] = $author;

        $result = $wpdb->insert(
            $pb_table,
            array(
                "title"         	            => "Copy - ".$popup['title'],
                "description"   	            => $popup['description'],
                "category_id"                   => $popup['category_id'],
                "autoclose"  		            => intval($popup['autoclose']),
                "cookie"   			            => intval($popup['cookie']),
                "width"         	            => intval($popup['width']),
                "height"        	            => intval($popup['height']),
                "bgcolor"        	            => stripslashes(sanitize_text_field($popup['bgcolor'])),
                "textcolor"        	            => stripslashes(sanitize_text_field($popup['textcolor'])),
                "bordersize"      	            => abs(intval($popup['bordersize'])),
                "bordercolor"     	            => stripslashes(sanitize_text_field($popup['bordercolor'])),
                "border_radius"    	            => abs(intval($popup['border_radius'])),
                "shortcode"        	            => $popup['shortcode'],
                "custom_class"                  => $popup['custom_class'],
                "custom_css"                    => $popup['custom_css'],
                "custom_html"                   => $popup['custom_html'],
                "onoffswitch"                   => $popup['onoffswitch'],
                "show_only_for_author"          => $popup['show_only_for_author'],
                "show_all"                      => $popup['show_all'],
                "delay"                         => abs(intval($popup['delay'])),
                "scroll_top"                    => intval($popup['scroll_top']),
                "animate_in"                    => $popup['animate_in'],
                "animate_out"                   => $popup['animate_out'],
                "action_button"                 => $popup['action_button'],
                "view_place"                    => $popup['view_place'],
                "action_button_type"            => $popup['action_button_type'],
                "modal_content"                 => $popup['modal_content'],
                "view_type"                     => $popup['view_type'],
                "onoffoverlay"                  => $popup['onoffoverlay'],
                "overlay_opacity"               => stripslashes(sanitize_text_field(($popup['overlay_opacity']))),
                "show_popup_title"              => $popup['show_popup_title'],
                "show_popup_desc"               => $popup['show_popup_desc'],
                "close_button"                  => $popup['close_button'],
                "header_bgcolor"  	            => stripslashes(sanitize_text_field($popup['header_bgcolor'])),
                "bg_image"  	                => $popup['bg_image'],
                "log_user"                      => $popup['log_user'],
                "guest"                         => $popup['guest'],
                "active_date_check"             => $popup['active_date_check'],
                "activeInterval"                => $popup['activeInterval'],
                "deactiveInterval"              => $popup['deactiveInterval'],
                "pb_position"                   => $popup['pb_position'],
                "pb_margin"                     => $popup['pb_margin'],
                "users_role"                    => $popup['users_role'],
                'options'                       => json_encode($options)
            ),
            array(
                '%s',   // Title
                '%s',   // description
                '%d',   // cat_id
                '%d',   //autoclose
                '%d',   // cookie
                '%d',   // width
                '%d',   // height
                '%s',   // bgcolor
                '%s',   // textcolor
                '%d',   // bordersize
                '%s',   // bordercolor
                '%d',   // border_radius
                '%s',   // shortcode
                '%s',   // custom_class
                '%s',   // custom_css
                '%s',   // custom_html
                '%s',   // onoffswitch
                '%s',   // show_only_for_author
                '%s',   // show_all
                '%d',   // delay
                '%d',   // scroll_top
                '%s',   // animate_in
                '%s',   // animate_out
                '%s',   // action_button
                '%s',   // view_place
                '%s',   // action_button_type
                '%s',   // modal_content
                '%s',   // view_type
                '%s',   // onoffoverlay
                '%f',   // overlay_opacity
                '%s',   // show_popup_title
                '%s',   // show_popup_desc
                '%s',   // close_button
                '%s',   // header_bgcolor
                '%s',   // bg_image
                '%s',   // log_user
                '%s',   // guest
                '%s',   // active_date_check
                '%s',   // activeInterval
                '%s',   // deactiveInterval
                '%s',   // pb_position
                '%d',   // pb_margin
                '%s',   // users_roles
                '%s',   // options
            )
        );
        if( $result >= 0 ){
            $message = "duplicated";
            $url = esc_url_raw( remove_query_arg(array('action', 'popupbox')  ) ) . '&status=' . $message;
            wp_redirect( $url );
        }

    }

    public function get_popupbox_by_id( $id ){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_pb WHERE id=" . absint( sanitize_text_field( $id ) ). " ORDER BY id ASC";

        $result = $wpdb->get_row($sql, "ARRAY_A");

        return $result;
    }

    public function add_or_edit_popupbox($data){

		global $wpdb;
		$pb_table = $wpdb->prefix . "ays_pb";

        //Id
		$id = ( $data["id"] != NULL ) ? absint( intval( $data["id"] ) ) : null;
    
        //Width
		$width = ( isset( $data['ays-pb']["width"] ) && $data['ays-pb']["width"] != '' ) ? absint( intval( $data['ays-pb']["width"] ) ) : 400;

        //Height
		$height = ( isset( $data['ays-pb']["height"] ) && $data['ays-pb']["height"] ) ? absint( intval( $data['ays-pb']["height"] ) ) : 500;

        //Autoclose
		$autoclose = ( isset( $data['ays-pb']["autoclose"] ) && $data['ays-pb']["autoclose"] != '' ) ? absint( intval( $data['ays-pb']["autoclose"] ) ) : '';

        //Show once per session
		$cookie = ( isset( $data['ays-pb']["cookie"] ) && $data['ays-pb']["cookie"] != '' ) ? absint( intval( $data['ays-pb']["cookie"] ) ) : 0;

        //Title
		$title = ( isset( $data['ays-pb']["popup_title"] ) && $data['ays-pb']["popup_title"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["popup_title"] )) : 'Demo Title';

        //Shortcode
		$shortcode = ( isset( $data['ays-pb']["shortcode"] ) && $data['ays-pb']["shortcode"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["shortcode"] )) : '';

        //Description
		$description = ( isset( $data['ays-pb']["popup_description"] ) && $data['ays-pb']["popup_description"] != '' ) ? stripslashes( $data['ays-pb']["popup_description"] ) : '';

        //Category Id 
        $popup_category_id = ( isset( $_POST['ays_popup_category'] ) && $_POST['ays_popup_category'] != '' ) ? absint( sanitize_text_field( $_POST['ays_popup_category'] ) ) : null;

        //Background Color
		$bgcolor = ( isset( $data['ays-pb']["bgcolor"] ) && $data['ays-pb']["bgcolor"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["bgcolor"] )) : '#FFFFFF';

        //Text Color
		$textcolor = ( isset( $data['ays-pb']["ays_pb_textcolor"] ) && $data['ays-pb']["ays_pb_textcolor"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["ays_pb_textcolor"] )) : '#000000';

        //Border Size
		$bordersize = ( isset( $data['ays-pb']["ays_pb_bordersize"] ) && $data['ays-pb']["ays_pb_bordersize"] != '' ) ? wp_unslash(sanitize_text_field(intval(round( $data['ays-pb']["ays_pb_bordersize"] )))) : 1;

        //Border Color
		$bordercolor = ( isset( $data['ays-pb']["ays_pb_bordercolor"] ) && $data['ays-pb']["ays_pb_bordercolor"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["ays_pb_bordercolor"] )) : '#ffffff';

        //Border Radius
		$border_radius = ( isset( $data['ays-pb']["ays_pb_border_radius"] ) && $data['ays-pb']["ays_pb_border_radius"] != '' ) ? wp_unslash(sanitize_text_field(intval(round(  $data['ays-pb']["ays_pb_border_radius"] )))) : 4;

        //Custom Class
        // $custom_class   = wp_unslash(sanitize_text_field( $data['ays-pb']["custom-class"] ));
		$custom_css = ( isset( $data['ays-pb']["custom-css"] ) && $data['ays-pb']["custom-css"] != '' ) ? wp_unslash(stripslashes( esc_attr( $data['ays-pb']["custom-css"] ) ) ) : '';

        //Custom Html
		$custom_html = ( isset( $data['ays-pb']["custom_html"] ) && $data['ays-pb']["custom_html"] != '' ) ? stripslashes( $data['ays-pb']["custom_html"] ) : '';

        //Show All
		$show_all = ( isset( $data['ays-pb']["show_all"] ) && $data['ays-pb']["show_all"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["show_all"] )) : 'all';

        //Animation Delay
		$delay = ( isset( $data['ays-pb']["delay"] ) && $data['ays-pb']["delay"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["delay"] )) : 0;
        
        //Scroll Top
		$scroll_top = ( isset( $data['ays-pb']["scroll_top"] ) && $data['ays-pb']["scroll_top"] != '' ) ? wp_unslash(sanitize_text_field(intval(round( $data['ays-pb']["scroll_top"] )))) : 0;

        //Animate In
		$animate_in = ( isset( $data['ays-pb']["animate_in"] ) && $data['ays-pb']["animate_in"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["animate_in"] )) : '';

        //Animate Out
		$animate_out = ( isset( $data['ays-pb']["animate_out"] ) && $data['ays-pb']["animate_out"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["animate_out"] )) : '';

        //Action Button
		$action_button = wp_unslash(sanitize_text_field( $data['ays-pb']["action_button"] ));

        //Action Button Type
		$action_button_type  = ( isset( $data['ays-pb']["action_button_type"] ) && $data['ays-pb']["action_button_type"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["action_button_type"] )) : 'both';

        //Modal Content
		$modal_content  = ( isset( $data['ays-pb']["modal_content"] ) && $data['ays-pb']["modal_content"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["modal_content"] )) : '';

        //View Type
		$view_type = ( isset( $data['ays-pb']["view_type"] ) && $data['ays-pb']["view_type"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["view_type"] )) : "";

        //Header BgColor
        $header_bgcolor = ( isset( $data['ays-pb']["header_bgcolor"] ) && $data['ays-pb']["header_bgcolor"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["header_bgcolor"] )) : '#ffffff';

        //Background Image
        $bg_image = ( isset( $data['ays_pb_bg_image'] ) && $data['ays_pb_bg_image'] != '' ) ? wp_http_validate_url( $data['ays_pb_bg_image'] ) : '';

        //Popup Position
        $pb_position = ( isset( $data['ays-pb']["pb_position"] ) && $data['ays-pb']["pb_position"] != '' ) ? wp_unslash(sanitize_text_field( $data['ays-pb']["pb_position"] )) : 'center-center';

        //Popup Margin
        $pb_margin = ( isset( $data['ays-pb']["pb_margin"] ) && $data['ays-pb']["pb_margin"] != '' ) ? wp_unslash(sanitize_text_field( intval( $data['ays-pb']["pb_margin"] ))) : '0';

        // Schedule Popup
        $active_date_check = (isset($data['active_date_check']) && $data['active_date_check'] == "on") ? 'on' : 'off';
        $activeInterval = isset($data['ays-active']) ? $data['ays-active'] : "";
        $deactiveInterval = isset($data['ays-deactive']) ? $data['ays-deactive'] : "";

        // Custom class for quiz container
        $custom_class = (isset($data['ays-pb']["custom-class"]) && $data['ays-pb']["custom-class"] != "") ? $data['ays-pb']["custom-class"] : '';
        $users_role = (isset($data['ays-pb']["ays_users_roles"]) && !empty($data['ays-pb']["ays_users_roles"])) ? $data['ays-pb']["ays_users_roles"] : array();

        // Background gradient
        $enable_background_gradient = ( isset( $data['ays_enable_background_gradient'] ) && $data['ays_enable_background_gradient'] == 'on' ) ? 'on' : 'off';
        $pb_background_gradient_color_1 = !isset($data['ays_background_gradient_color_1']) ? '' : stripslashes(sanitize_text_field($data['ays_background_gradient_color_1'] ));
        $pb_background_gradient_color_2 = !isset($data['ays_background_gradient_color_2']) ? '' : stripslashes(sanitize_text_field( $data['ays_background_gradient_color_2'] ));
        $pb_gradient_direction = !isset($data['ays_pb_gradient_direction']) ? '' : $data['ays_pb_gradient_direction'];

        //Posts
        $except_types          = isset($data['ays_pb_except_post_types']) ? ($data['ays_pb_except_post_types']) : array();
        $except_posts          = isset($data['ays_pb_except_posts']) ? ($data['ays_pb_except_posts']) : array();

        //Close button delay
        $close_button_delay = (isset($data['ays_pb_close_button_delay']) && $data['ays_pb_close_button_delay'] != '') ? abs(intval($data['ays_pb_close_button_delay'])) : '';

        // Enable PopupBox sound option
        $enable_pb_sound = (isset($data['ays_pb_enable_sounds']) && $data['ays_pb_enable_sounds'] == "on") ? 'on' : 'off';

        //Overlay Color
        $overlay_color = (isset($data['ays_pb_overlay_color']) && $data['ays_pb_overlay_color'] != '') ? stripslashes(sanitize_text_field( $data['ays_pb_overlay_color'] )) : '#000';

        //Animation speed
        $animation_speed = (isset($data['ays_pb_animation_speed']) && $data['ays_pb_animation_speed'] !== '') ? abs($data['ays_pb_animation_speed']) : 1;

        // Close Animation speed
        $close_animation_speed = (isset($data['ays_pb_close_animation_speed']) && $data['ays_pb_close_animation_speed'] !== '') ? abs($data['ays_pb_close_animation_speed']) : 1;

        //Hide popup on mobile
        $pb_mobile = (isset($data['ays_pb_mobile']) && $data['ays_pb_mobile'] == 'on') ? 'on' : 'off';

        //Close button text
        $close_button_text = (isset($data['ays_pb_close_button_text']) && $data['ays_pb_close_button_text'] != '') ? $data['ays_pb_close_button_text'] : 'x';

        // PopupBox width for mobile option
        $mobile_width = (isset($data['ays_pb_mobile_width']) && $data['ays_pb_mobile_width'] != "") ?abs(intval($data['ays_pb_mobile_width']))  : '';

        // PopupBox max-width for mobile option
        $mobile_max_width = (isset($data['ays_pb_mobile_max_width']) && $data['ays_pb_mobile_max_width'] != "") ? abs(intval($data['ays_pb_mobile_max_width']))  : '';

        // PopupBox height for mobile option
        $mobile_height = (isset($data['ays_pb_mobile_height']) && $data['ays_pb_mobile_height'] != "") ? abs(intval($data['ays_pb_mobile_height']))  : '';

        $close_button_position = (isset($data['ays_pb_close_button_position']) && $data['ays_pb_close_button_position'] != '') ? $data['ays_pb_close_button_position'] : 'right-top';

        //Show PopupBox only once
        $show_only_once = (isset($data['ays_pb_show_only_once']) && $data['ays_pb_show_only_once'] == 'on') ? 'on' : 'off';
       
        //Show only on home page
        $show_on_home_page = (isset($data['ays_pb_show_on_home_page']) && $data['ays_pb_show_on_home_page'] == 'on') ? 'on' : 'off';

        //close popup by esc
        $close_popup_esc = (isset($data['close_popup_esc']) && $data['close_popup_esc'] == 'on') ? 'on' : 'off';

        //popup width with percentage
        $popup_width_by_percentage_px = (isset($data['ays_popup_width_by_percentage_px']) && $data['ays_popup_width_by_percentage_px'] != '') ? $data['ays_popup_width_by_percentage_px'] : 'pixels';

        //font-family
        $pb_font_family = (isset($data['ays_pb_font_family']) && $data['ays_pb_font_family'] != '') ? $data['ays_pb_font_family'] : 'inherit';
        
        //close popup by clicking overlay
        $close_popup_overlay = (isset($data['close_popup_overlay']) && $data['close_popup_overlay'] == 'on') ? $data['close_popup_overlay'] : 'off';

       //open full screen
       $enable_pb_fullscreen = (isset($data['enable_pb_fullscreen']) && $data['enable_pb_fullscreen'] == 'on') ? 'on' : 'off';
       
       //hide timer
       $enable_hide_timer = (isset($data['ays_pb_hide_timer']) && $data['ays_pb_hide_timer'] == 'on') ? 'on' : 'off';

        // Social Media links
        $enable_social_links = (isset($data['ays_pb_enable_social_links']) && $data['ays_pb_enable_social_links'] == "on") ? 'on' : 'off';
        $ays_social_links = (isset($data['ays_social_links'])) ? $data['ays_social_links'] : array(
            'linkedin_link'   => '',
            'facebook_link'   => '',
            'twitter_link'    => '',
            'vkontakte_link'  => '',
            'youtube_link'    => '',
            'instagram_link'  => '',
            'behance_link'    => '',
        );
       
        $linkedin_link = isset($ays_social_links['ays_pb_linkedin_link']) && $ays_social_links['ays_pb_linkedin_link'] != '' ? $ays_social_links['ays_pb_linkedin_link'] : '';
        $facebook_link = isset($ays_social_links['ays_pb_facebook_link']) && $ays_social_links['ays_pb_facebook_link'] != '' ? $ays_social_links['ays_pb_facebook_link'] : '';
        $twitter_link = isset($ays_social_links['ays_pb_twitter_link']) && $ays_social_links['ays_pb_twitter_link'] != '' ? $ays_social_links['ays_pb_twitter_link'] : '';
        $vkontakte_link = isset($ays_social_links['ays_pb_vkontakte_link']) && $ays_social_links['ays_pb_vkontakte_link'] != '' ? $ays_social_links['ays_pb_vkontakte_link'] : '';
        $youtube_link = isset($ays_social_links['ays_pb_youtube_link']) && $ays_social_links['ays_pb_youtube_link'] != '' ? $ays_social_links['ays_pb_youtube_link'] : '';
        $instagram_link = isset($ays_social_links['ays_pb_instagram_link']) && $ays_social_links['ays_pb_instagram_link'] != '' ? $ays_social_links['ays_pb_instagram_link'] : '';
        $behance_link = isset($ays_social_links['ays_pb_behance_link']) && $ays_social_links['ays_pb_behance_link'] != '' ? $ays_social_links['ays_pb_behance_link'] : '';

        $social_links = array(
            'linkedin_link'   => $linkedin_link,
            'facebook_link'   => $facebook_link,
            'twitter_link'    => $twitter_link,
            'vkontakte_link'  => $vkontakte_link,
            'youtube_link'    => $youtube_link,
            'instagram_link'  => $instagram_link,
            'behance_link'    => $behance_link,
        );
       
       // Heading for social buttons
       $social_buttons_heading = (isset($data['ays_pb_social_buttons_heading']) && $data['ays_pb_social_buttons_heading'] != '') ? stripslashes($data['ays_pb_social_buttons_heading']) : "";
       
       //close button_size
       $close_button_size = (isset($data['ays_pb_close_button_size']) && $data['ays_pb_close_button_size'] != '' ) ? abs(sanitize_text_field($data['ays_pb_close_button_size'])) : '';
       
       //close button image
       $close_button_image = (isset($data['ays_pb_close_btn_bg_img']) && $data['ays_pb_close_btn_bg_img'] != '' ) ? $data['ays_pb_close_btn_bg_img'] : '';
      
       //border style
       $border_style = (isset($data['ays_pb_border_style']) && $data['ays_pb_border_style'] != '' ) ? $data['ays_pb_border_style'] : '';
       
       //Show close button by hovering Popup Container
       $ays_pb_hover_show_close_btn = (isset($data['ays_pb_show_close_btn_hover_container']) && $data['ays_pb_show_close_btn_hover_container'] == 'on' ) ? 'on' : 'off';

       // Disable scrolling
        $disable_scroll = (isset($data['disable_scroll']) && $data['disable_scroll'] == 'on') ? 'on' : 'off';

        // Bg image position
        $pb_bg_image_position     = (isset($data['ays_pb_bg_image_position']) && $data['ays_pb_bg_image_position'] != "") ? $data['ays_pb_bg_image_position'] : 'center center';

        $pb_bg_image_sizing    = (isset($data['ays_pb_bg_image_sizing']) && $data['ays_pb_bg_image_sizing'] != "") ? $data['ays_pb_bg_image_sizing'] : 'cover';

        //video options
        $video_theme_url = (isset($data['ays_video_theme_url']) && !empty($data['ays_video_theme_url'])) ? wp_http_validate_url($data['ays_video_theme_url']) : "";

        // Poll Min Height
        $pb_min_height = (isset($data['ays_pb_min_height']) && $data['ays_pb_min_height'] != '') ? absint(intval($data['ays_pb_min_height'])) : '';

        //Font size
        $pb_font_size = (isset($data['ays_pb_font_size']) && $data['ays_pb_font_size'] != '') ? absint($data['ays_pb_font_size']) : 16;
        //Font size
        $pb_font_size_for_mobile = (isset($data['ays_pb_font_size_for_mobile']) && $data['ays_pb_font_size_for_mobile'] != '') ? absint($data['ays_pb_font_size_for_mobile']) : 16;

        //Title Text Shadow
        $enable_pb_title_text_shadow = (isset($data['ays_enable_title_text_shadow']) && $data['ays_enable_title_text_shadow'] != '') ? 'on' : 'off';

        $pb_title_text_shadow = (isset($data['ays_title_text_shadow_color']) && $data['ays_title_text_shadow_color'] != '') ? sanitize_text_field($data['ays_title_text_shadow_color']) : 'rgba(255,255,255,0)';
        
        $pb_title_text_shadow_x_offset = (isset($data['ays_pb_title_text_shadow_x_offset']) && $data['ays_pb_title_text_shadow_x_offset'] != '') ? intval( $data['ays_pb_title_text_shadow_x_offset'] )  : 2;

        $pb_title_text_shadow_y_offset = (isset($data['ays_pb_title_text_shadow_y_offset']) && $data['ays_pb_title_text_shadow_y_offset'] != '') ? intval( $data['ays_pb_title_text_shadow_y_offset'] ) : 2;

        $pb_title_text_shadow_z_offset = (isset($data['ays_pb_title_text_shadow_z_offset']) && $data['ays_pb_title_text_shadow_z_offset'] != '') ? intval( $data['ays_pb_title_text_shadow_z_offset'] ) : 0;

       // --------- Check & get post type-----------         
            $post_type_for_allfeld = array();
            if (isset($data['ays_pb_except_post_types'])) {
                $all_post_types = $data['ays_pb_except_post_types'];              
                if (isset($data["ays_pb_except_posts"])) {
                    foreach ($all_post_types as $post_type) {
                        $all_posts = get_posts( array(
                        'numberposts' => -1,            
                        'post_type'   => $post_type,
                        'suppress_filters' => true,
                        ));

                        if (!empty($all_posts)) {
                            foreach ($all_posts as $posts_value) {
                                if (in_array($posts_value->ID, $data["ays_pb_except_posts"])) {
                                    $not_post_type = false;
                                    break;
                                }else{
                                    $not_post_type = true;
                                }                   
                            }

                            if ($not_post_type) {
                                $post_type_for_allfeld[] = $post_type;
                            }
                        }else{
                            $post_type_for_allfeld[] = $post_type;
                        }
                        
                    }
                }else{
                    $post_type_for_allfeld = $all_post_types;
                }
                
            }

        // --------- end Check & get post type-----------   
     
        $switch = (isset($data['ays-pb']["onoffswitch"]) &&  $data['ays-pb']["onoffswitch"] == 'on') ? 'On' : 'Off';
        $log_user = (isset($data['ays-pb']["log_user"]) &&  $data['ays-pb']["log_user"] == 'on') ? 'On' : 'Off';
        $guest = (isset($data['ays-pb']["guest"]) &&  $data['ays-pb']["guest"] == 'on') ? 'On' : 'Off';
        $switchoverlay = (isset($data['ays-pb']["onoffoverlay"]) &&  $data['ays-pb']["onoffoverlay"] == 'on') ? 'On' : 'Off';
        $overlay_opacity = ($switchoverlay == 'On') && isset($data['ays-pb']["overlay_opacity"]) ? stripslashes(sanitize_text_field( $data['ays-pb']['overlay_opacity'] )) : '0.5'; 
        $showPopupTitle = (isset($data["show_popup_title"]) &&  $data["show_popup_title"] == 'on') ? 'On' : 'Off';
        $showPopupDesc = (isset($data["show_popup_desc"]) &&  $data["show_popup_desc"] == 'on') ? 'On' : 'Off';
        
		if(isset($data['ays-pb']["close_button"]) && $data['ays-pb']["close_button"] == 'on'){
			$closeButton = 'on';
		}else{ $closeButton = 'off';}

        if($show_all == 'yes'){
            $view_place = '';
        }else{
            $view_place = isset($data['ays-pb']["ays_pb_view_place"]) ? sanitize_text_field( implode( "***", $data['ays-pb']["ays_pb_view_place"] ) ) : '';
        }
        $JSON_user_role = json_encode($users_role);

        $author = ( isset($data['ays_pb_author']) && $data['ays_pb_author'] != "" ) ? stripcslashes( sanitize_text_field( $data['ays_pb_author'] ) ) : '';

        // Change the author of the current pb
        $pb_create_author = ( isset($data['ays_pb_create_author']) && $data['ays_pb_create_author'] != "" ) ? absint( sanitize_text_field( $data['ays_pb_create_author'] ) ) : '';

        //PB creation date
        // $pb_create_date  = !isset($data['ays_pb_create_date']) ? '0000-00-00 00:00:00' : sanitize_text_field( $data['ays_pb_create_date'] );

        $pb_create_date = (isset($data['ays_pb_change_creation_date']) && $data['ays_pb_change_creation_date'] != '') ? sanitize_text_field($data['ays_pb_change_creation_date']) : current_time( 'mysql' ) ;

        // Change the author of the current pb
        $pb_create_author = ( isset($data['ays_pb_create_author']) && $data['ays_pb_create_author'] != "" ) ? absint( sanitize_text_field( $data['ays_pb_create_author'] ) ) : '';

        if ( $pb_create_author != "" && $pb_create_author > 0 ) {
            $user = get_userdata($pb_create_author);
            if ( ! is_null( $user ) && $user ) {
                $pb_author = array(
                    'id' => $user->ID."",
                    'name' => $user->data->display_name
                );

                $author = json_encode($pb_author, JSON_UNESCAPED_SLASHES);
            } else {
                $author_data = json_decode($author, true);
                $pb_create_author = (isset( $author_data['id'] ) && $author_data['id'] != "") ? absint( sanitize_text_field( $author_data['id'] ) ) : get_current_user_id();
            }
        }

        //Enable dismiss
        $enable_dismiss = ( isset($data['ays_pb_enable_dismiss']) && $data['ays_pb_enable_dismiss'] != "" ) ? 'on' : 'off';
        $enable_dismiss_text = ( isset($data['ays_pb_enable_dismiss_text']) && $data['ays_pb_enable_dismiss_text'] != "" ) ? stripslashes( sanitize_text_field($data['ays_pb_enable_dismiss_text']) ) : 'Dismiss ad';

        $enable_box_shadow = ( isset( $data['ays_pb_enable_box_shadow'] ) && $data['ays_pb_enable_box_shadow'] == 'on' ) ? 'on' : 'off';

        $box_shadow_color = (!isset($data['ays_pb_box_shadow_color'])) ? '#000' : sanitize_text_field( stripslashes($data['ays_pb_box_shadow_color']) );

        //  Box Shadow X offset
        $pb_box_shadow_x_offset = (isset($data['ays_pb_box_shadow_x_offset']) && $data['ays_pb_box_shadow_x_offset'] != '' && intval( $data['ays_pb_box_shadow_x_offset'] ) != 0) ? intval( $data['ays_pb_box_shadow_x_offset'] ) : 0;

        //  Box Shadow Y offset
        $pb_box_shadow_y_offset = (isset($data['ays_pb_box_shadow_y_offset']) && $data['ays_pb_box_shadow_y_offset'] != '' && intval( $data['ays_pb_box_shadow_y_offset'] ) != 0) ? intval( $data['ays_pb_box_shadow_y_offset'] ) : 0;

        //  Box Shadow Z offset
        $pb_box_shadow_z_offset = (isset($data['ays_pb_box_shadow_z_offset']) && $data['ays_pb_box_shadow_z_offset'] != '' && intval( $data['ays_pb_box_shadow_z_offset'] ) != 0) ? intval( $data['ays_pb_box_shadow_z_offset'] ) : 15;

        // Popup Name
        $popup_name = ( isset($data['ays_pb_popup_name']) && $data['ays_pb_popup_name'] != "" ) ? sanitize_text_field( $data['ays_pb_popup_name'] ) : '';

        //Disabel scroll on popup
        $disable_scroll_on_popup = ( isset( $data['ays_pb_disable_scroll_on_popup'] ) && $data['ays_pb_disable_scroll_on_popup'] != '' ) ? 'on' : 'off';
        
        //Hide on PC
        $hide_on_pc = ( isset( $data['ays_pb_hide_on_pc'] ) && $data['ays_pb_hide_on_pc'] == 'on' ) ? 'on' : 'off';

        //Hide on tablets
        $hide_on_tablets = ( isset( $data['ays_pb_hide_on_tablets'] ) && $data['ays_pb_hide_on_tablets'] == 'on' ) ? 'on' : 'off';

        //Background image position for mobile
        $pb_bg_image_direction_on_mobile = ( isset( $data['ays_pb_bg_image_direction_on_mobile'] ) && $data['ays_pb_bg_image_direction_on_mobile'] == 'on' ) ? 'on' : 'off';

        // Close button color
        $close_button_color = ( isset($data['ays_pb_close_button_color']) && $data['ays_pb_close_button_color'] != "" ) ? sanitize_text_field( $data['ays_pb_close_button_color'] ) : '#000000';

        // Close button hover color
        $close_button_hover_color = ( isset($data['ays_pb_close_button_hover_color']) && $data['ays_pb_close_button_hover_color'] != "" ) ? sanitize_text_field( $data['ays_pb_close_button_hover_color'] ) : '#000000';

        // Show only for author
        $show_only_for_author = ( isset($data['ays_pb_show_popup_only_for_author']) && $data['ays_pb_show_popup_only_for_author'] != "" ) ? 'on' : 'off';

        // Blured Overlay
        $blured_overlay = ( isset($data['ays_pb_blured_overlay']) && $data['ays_pb_blured_overlay'] != "" ) ? 'on' : 'off';

        $options = array(
            'enable_background_gradient'        => $enable_background_gradient,
            'background_gradient_color_1'       => $pb_background_gradient_color_1,
            'background_gradient_color_2'       => $pb_background_gradient_color_2,
            'pb_gradient_direction'             => $pb_gradient_direction,
            'except_post_types'                 => $except_types,
            'except_posts'                      => $except_posts,
            'all_posts'                         => (empty($post_type_for_allfeld) ? '' : $post_type_for_allfeld),
            'close_button_delay'                => $close_button_delay,
            'enable_pb_sound'                   => $enable_pb_sound,
            'overlay_color'                     => $overlay_color,
            'animation_speed'                   => $animation_speed,
            'close_animation_speed'             => $close_animation_speed,
            'pb_mobile'                         => $pb_mobile,
            'close_button_text'                 => $close_button_text,
            'mobile_width'                      => $mobile_width,
            'mobile_max_width'                  => $mobile_max_width,
            'mobile_height'                     => $mobile_height,
            'close_button_position'             => $close_button_position,
            'show_only_once'                    => $show_only_once,
            'show_on_home_page'                 => $show_on_home_page,
            'close_popup_esc'                   => $close_popup_esc,
            'popup_width_by_percentage_px'      => $popup_width_by_percentage_px,
            'pb_font_family'                    => $pb_font_family,
            'close_popup_overlay'               => $close_popup_overlay,
            'enable_pb_fullscreen'              => $enable_pb_fullscreen,
            'enable_hide_timer'                 => $enable_hide_timer,
            'enable_social_links'               => $enable_social_links,
            'social_links'                      => $social_links,
            'social_buttons_heading'            => $social_buttons_heading,
            'close_button_size'                 => $close_button_size,
            'close_button_image'                => $close_button_image,
            'border_style'                      => $border_style,
            'ays_pb_hover_show_close_btn'       => $ays_pb_hover_show_close_btn,
            'disable_scroll'                    => $disable_scroll,
            "pb_bg_image_position"              => $pb_bg_image_position,
            "pb_bg_image_sizing"                => $pb_bg_image_sizing,
            'video_theme_url'                   => $video_theme_url,
            'pb_min_height'                     => $pb_min_height,
            'pb_font_size'                      => $pb_font_size,
            'pb_font_size_for_mobile'           => $pb_font_size_for_mobile,
            'pb_title_text_shadow'              => $pb_title_text_shadow,
            'enable_pb_title_text_shadow'       => $enable_pb_title_text_shadow,
            'pb_title_text_shadow_x_offset'     => $pb_title_text_shadow_x_offset,
            'pb_title_text_shadow_y_offset'     => $pb_title_text_shadow_y_offset,  
            'pb_title_text_shadow_z_offset'     => $pb_title_text_shadow_z_offset,
            'create_date'                       => $pb_create_date,
            'create_author'                     => $pb_create_author,
            'author'                            => $author,
            'enable_dismiss'                    => $enable_dismiss,
            'enable_dismiss_text'               => $enable_dismiss_text,
            'enable_box_shadow'                 => $enable_box_shadow,
            'box_shadow_color'                  => $box_shadow_color,
            'pb_box_shadow_x_offset'            => $pb_box_shadow_x_offset,
            'pb_box_shadow_y_offset'            => $pb_box_shadow_y_offset,
            'pb_box_shadow_z_offset'            => $pb_box_shadow_z_offset,
            'disable_scroll_on_popup'           => $disable_scroll_on_popup,
            'hide_on_pc'                        => $hide_on_pc,
            'hide_on_tablets'                   => $hide_on_tablets,
            'pb_bg_image_direction_on_mobile'   => $pb_bg_image_direction_on_mobile,
            'close_button_color'                => $close_button_color,
            'close_button_hover_color'          => $close_button_hover_color,
            'blured_overlay'                    => $blured_overlay,
        );

        $submit_type = (isset($data['submit_type'])) ?  $data['submit_type'] : '';

		if( $id == null ){
			$pb_result = $wpdb->insert(
				$pb_table,
				array(
					"title"         	            => $title,
                    "popup_name"                    => $popup_name,
					"description"   	            => $description,
                    "category_id"                   => $popup_category_id,
					"autoclose"  		            => $autoclose,
					"cookie"   			            => $cookie,
					"width"         	            => $width,
					"height"        	            => $height,
					"bgcolor"        	            => $bgcolor,
                    "textcolor"        	            => $textcolor,
                    "bordersize"      	            => $bordersize,
                    "bordercolor"     	            => $bordercolor,
                    "border_radius"    	            => $border_radius,
					"shortcode"        	            => $shortcode,
                    "custom_class"                  => $custom_class,
					"custom_css"                    => $custom_css,
					"custom_html"                   => $custom_html,
					"onoffswitch"                   => $switch,
                    "show_only_for_author"          => $show_only_for_author,
					"show_all"                      => $show_all,
                    "delay"                         => $delay,
                    "scroll_top"                    => $scroll_top,
                    "animate_in"                    => $animate_in,
                    "animate_out"                   => $animate_out,
                    "action_button"                 => $action_button,
                    "view_place"                    => $view_place,
                    "action_button_type"            => $action_button_type,
                    "modal_content"                 => $modal_content,
                    "view_type"                     => $view_type,
                    "onoffoverlay"                  => $switchoverlay,
                    "overlay_opacity"               => $overlay_opacity,
                    "show_popup_title"              => $showPopupTitle,
                    "show_popup_desc"               => $showPopupDesc,
                    "close_button"                  => $closeButton,
                    "header_bgcolor"  	            => $header_bgcolor,
                    'bg_image'                      => $bg_image,
                    'log_user'                      => $log_user,
                    'guest'                         => $guest,
                    'active_date_check'             => $active_date_check,
                    'activeInterval'                => $activeInterval,
                    'deactiveInterval'              => $deactiveInterval,
                    "pb_position"                   => $pb_position,
                    "pb_margin"                     => $pb_margin,
                    "users_role"                    => $JSON_user_role,
                    "options"                       => json_encode($options),
				),
				array(
                '%s',   // Title
                '%s',   // Popup Name
                '%s',   // description
                '%d',   // cat_id
                '%d',   //autoclose
                '%d',   // cookie
                '%d',   // width
                '%d',   // height
                '%s',   // bgcolor
                '%s',   // textcolor
                '%d',   // bordersize
                '%s',   // bordercolor
                '%d',   // border_radius
                '%s',   // shortcode
                '%s',   // custom_class
                '%s',   // custom_css
                '%s',   // custom_html
                '%s',   // onoffswitch
                '%s',   // show_only_for_author
                '%s',   // show_all
                '%d',   // delay
                '%d',   // scroll_top
                '%s',   // animate_in
                '%s',   // animate_out
                '%s',   // action_button
                '%s',   // view_place
                '%s',   // action_button_type
                '%s',   // modal_content
                '%s',   // view_type
                '%s',   // onoffoverlay
                '%f',   // overlay_opacity
                '%s',   // show_popup_title
                '%s',   // show_popup_desc
                '%s',   // close_button
                '%s',   // header_bgcolor
                '%s',   // bg_image
                '%s',   // log_user
                '%s',   // guest
                '%s',   // active_date_check
                '%s',   // activeInterval
                '%s',   // deactiveInterval
                '%s',   // pb_position
                '%d',   // pb_margin
                '%s',   // users_roles
                '%s',   // options
            )
			);
			$message = "created";
		}else{
			$pb_result = $wpdb->update(
				$pb_table,
				array(
					"title"         	            => $title,
                    "popup_name"                    => $popup_name,
					"description"   	            => $description,
                    "category_id"                   => $popup_category_id,
					"autoclose"  		            => $autoclose,
					"cookie"   			            => $cookie,
					"width"         	            => $width,
					"height"        	            => $height,
					"bgcolor"        	            => $bgcolor,
                    "textcolor"        	            => $textcolor,
                    "bordersize"      	            => $bordersize,
                    "bordercolor"     	            => $bordercolor,
                    "border_radius"    	            => $border_radius,
					"shortcode"        	            => $shortcode,
                    "custom_class"                  => $custom_class,
					"custom_css"                    => $custom_css,
					"custom_html"                   => $custom_html,
					"onoffswitch"                   => $switch,
                    "show_only_for_author"          => $show_only_for_author,
					"show_all"                      => $show_all,
                    "delay"                         => $delay,
                    "scroll_top"                    => $scroll_top,
                    "animate_in"                    => $animate_in,
                    "animate_out"                   => $animate_out,
                    "action_button"                 => $action_button,
                    "view_place"                    => $view_place,
                    "action_button_type"            => $action_button_type,
                    "modal_content"                 => $modal_content,
                    "view_type"                     => $view_type,
                    "onoffoverlay"                  => $switchoverlay,
                    "overlay_opacity"               => $overlay_opacity,
                    "show_popup_title"              => $showPopupTitle,
                    "show_popup_desc"               => $showPopupDesc,
                    "close_button"                  => $closeButton,
                    "header_bgcolor"                => $header_bgcolor,
                    'bg_image'                      => $bg_image,
                    'log_user'                      => $log_user,
                    'guest'                         => $guest,
                    'active_date_check'             => $active_date_check,
                    'activeInterval'                => $activeInterval,
                    'deactiveInterval'              => $deactiveInterval,
                    "pb_position"                   => $pb_position,
                    "pb_margin"                     => $pb_margin,
                    "users_role"                    => $JSON_user_role,
                    "options"                       => json_encode($options),
				),
				array( "id" => $id ),
				array(
                '%s',   // Title
                '%s',   // Popup Name
                '%s',   // description
                '%d',   // cat_id
                '%d',   //autoclose
                '%d',   // cookie
                '%d',   // width
                '%d',   // height
                '%s',   // bgcolor
                '%s',   // textcolor
                '%d',   // bordersize
                '%s',   // bordercolor
                '%d',   // border_radius
                '%s',   // shortcode
                '%s',   // custom_class
                '%s',   // custom_css
                '%s',   // custom_html
                '%s',   // onoffswitch
                '%s',   // show_only_for_author
                '%s',   // show_all
                '%d',   // delay
                '%d',   // scroll_top
                '%s',   // animate_in
                '%s',   // animate_out
                '%s',   // action_button
                '%s',   // view_place
                '%s',   // action_button_type
                '%s',   // modal_content
                '%s',   // view_type
                '%s',   // onoffoverlay
                '%f',   // overlay_opacity
                '%s',   // show_popup_title
                '%s',   // show_popup_desc
                '%s',   // close_button
                '%s',   // header_bgcolor
                '%s',   // bg_image
                '%s',   // log_user
                '%s',   // guest
                '%s',   // active_date_check
                '%s',   // activeInterval
                '%s',   // deactiveInterval
                '%s',   // pb_position
                '%d',   // pb_margin
                '%s',   // users_roles
                '%s',   // options
            ),
				array( "%d" )
			);
			$message = "updated";
		}

        $ays_pb_tab = isset($data['ays_pb_tab']) ? $data['ays_pb_tab'] : 'tab1';
		if( $pb_result >= 0 ){
			if($submit_type != ''){
                if($id == null){
                    $url = esc_url_raw( add_query_arg( array(
                        "action"    => "edit",
                        "popupbox"      => $wpdb->insert_id,
                        "ays_pb_tab"  => $ays_pb_tab,
                        "status"    => $message
                    ) ) );
                }else{
                    $url = esc_url_raw( add_query_arg( array(
                        "ays_pb_tab"  => $ays_pb_tab,
                        "status"    => $message
                    ) ) );
            // $url = esc_url_raw( remove_query_arg(false) ) . 'ays_pb_tab='.$ays_pb_tab."&status=" . $message . "&type=success";
                }
                wp_redirect( $url );
            }else{
                $url = esc_url_raw( remove_query_arg(array("action", "popupbox")  ) ) . "&status=" . $message . "&type=success";
                wp_redirect( $url );
            }
		}
    }

    public function get_popup_categories(){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_pb_categories";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }



    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_popupboxes( $id ) {
        global $wpdb;
        $wpdb->delete(
            "{$wpdb->prefix}ays_pb",
            array("id" => $id),
            array("%d")
        );
    }


    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;

        $filter = array();
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_pb";

        if( isset( $_GET['filterby'] ) && absint( sanitize_text_field( $_GET['filterby'] ) ) > 0){
            $cat_id = absint( sanitize_text_field( $_GET['filterby'] ) );
            $filter[] = ' category_id = '.$cat_id.' ';
        }

        if( isset( $_REQUEST['fstatus'] ) && ! is_null( sanitize_text_field( $_REQUEST['fstatus'] ) ) ){
            $fstatus = esc_sql( sanitize_text_field( $_REQUEST['fstatus'] ) );

             if($fstatus == 'published'){
                $fstatus = 'On';
            }else {
                $fstatus = 'Off';
            }

            if($fstatus !== null){
                $filter[] = " onoffswitch = '".$fstatus."' ";
            }
        }

        $search = ( isset( $_REQUEST['s'] ) ) ? esc_sql( sanitize_text_field( $_REQUEST['s'] ) ) : false;
        if( $search ){
            $filter[] = sprintf(" title LIKE '%%%s%%' ", esc_sql( $wpdb->esc_like( $search ) ) );
        }
        
        if(count($filter) !== 0){
            $sql .= " WHERE ".implode(" AND ", $filter);
        }

        return $wpdb->get_var( $sql );
    }


    /** Text displayed when no customer data is available */
    public function no_items() {
       echo __( "There are no popupboxes yet.", "ays-popup-box" );
    }


    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case "title":
            case "popup_image":
            case "onoffswitch":
                return wp_unslash($item[ $column_name ]);
                break;
            case 'category_id':
            case 'modal_content':
            case 'view_type':
            case "shortcode":
            case "autor":
            case "create_date":
            case "id":
                return $item[ $column_name ];
                break;
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            "<input type='checkbox' name='bulk-delete[]' value='%s' />", $item["id"]
        );
    }


    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_title( $item ) {
        $delete_nonce = wp_create_nonce( $this->plugin_name . "-delete-popupbox" );
        $unpublish_nonce = wp_create_nonce( $this->plugin_name . "-unpublish-popupbox" );
        $publish_nonce = wp_create_nonce( $this->plugin_name . "-publish-popupbox" );
        
        if (isset($item['onoffswitch']) && $item['onoffswitch'] == 'On') {
            $publish_button = 'unpublish';
            $publish_button_val = sprintf( '<a href="?page=%s&action=%s&popupbox=%d&_wpnonce=%s">'. __('Unpublish', "ays-popup-box") .'</a>', esc_attr( $_REQUEST['page'] ), 'unpublish', absint( $item['id'] ), $unpublish_nonce );
        }else{
            $publish_button = 'publish';
            $publish_button_val = sprintf( '<a href="?page=%s&action=%s&popupbox=%d&_wpnonce=%s">'. __('Publish', "ays-popup-box") .'</a>', esc_attr( $_REQUEST['page'] ), 'publish', absint( $item['id'] ), $publish_nonce );
        }
        $popup_name = ( isset( $item["popup_name"] ) && $item["popup_name"] != "" ) ? stripslashes( sanitize_text_field ( $item["popup_name"] ) ) : stripslashes( sanitize_text_field ($item["title"]) );

        $popup_title_length = intval( $this->title_length );
        

        $restitle  = Ays_Pb_Admin::ays_pb_restriction_string("word",esc_attr($popup_name), $popup_title_length);

        $title = sprintf( "<a href='?page=%s&action=%s&popupbox=%d' title='%s'>%s</a>", esc_attr( $_REQUEST["page"] ), "edit", absint( $item["id"] ), esc_attr($popup_name), $restitle);

        $actions = array(
            "edit" => sprintf( "<a href='?page=%s&action=%s&popupbox=%d'>". __( 'Edit' ) ."</a>", esc_attr( $_REQUEST["page"] ), "edit", absint( $item["id"] ) ),
            'duplicate' => sprintf( '<a href="?page=%s&action=%s&popupbox=%d">'. __('Duplicate', "ays-popup-box") .'</a>', esc_attr( $_REQUEST['page'] ), 'duplicate', absint( $item['id'] ) ),

            $publish_button => $publish_button_val,

            'delete' => sprintf( '<a class="ays_pb_confirm_del" data-message="%s" href="?page=%s&action=%s&popupbox=%d&_wpnonce=%s">'. __('Delete', "ays-popup-box") .'</a>', $restitle , esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        );

        return $title . $this->row_actions( $actions );
    }

    function column_shortcode( $item ) {
        return sprintf("<input type='text' onClick='this.setSelectionRange(0, this.value.length)' readonly value='[ays_pb id=%s]' />", $item["id"]);
    } 

    function column_modal_content( $item ) {

        $modal_content = '';
        switch ($item['modal_content']) {
            case 'custom_html':
                $modal_content = __('Custom Content',"ays-popup-box");
                break;
            case 'shortcode':
                $modal_content = __('Shortcode',"ays-popup-box");
                break;
            case 'video_type':
                $modal_content = __('Video',"ays-popup-box");
                break;
            default:
                $modal_content = __('Custom Content',"ays-popup-box");
                break;
        }

        return $modal_content;
       
    }

    function column_view_type( $item ) {

        $view_type = '';
        switch ($item['view_type']) {
            case 'default':
                $view_type = __('Default',"ays-popup-box");
                break;
            case 'lil':
                $view_type = __('Red',"ays-popup-box");
                break;
            case 'image':
                $view_type = __('Modern',"ays-popup-box");
                break;
            case 'minimal':
                $view_type = __('Minimal',"ays-popup-box");
                break;
            case 'template':
                $view_type = __('Sale',"ays-popup-box");
                break;
            case 'mac':
                $view_type = __('MacOs window',"ays-popup-box");
                break;
            case 'ubuntu':
                $view_type = __('Ubuntu',"ays-popup-box");
                break;
            case 'winXP':
                $view_type = __('Windows XP',"ays-popup-box");
                break;
            case 'win98':
                $view_type = __('Windows 98',"ays-popup-box");
                break;
            case 'cmd':
                $view_type = __('Command Prompt',"ays-popup-box");
                break;
            default:
                $view_type = __('Default',"ays-popup-box");
                break;
        }

        return $view_type;
       
    }

    function column_category_id( $item ) {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_pb_categories WHERE id=" . absint( sanitize_text_field( $item["category_id"] ) );

        $category = $wpdb->get_row( $sql );

        $category_title = '';
        if($category !== null){
            $category_title = $category->title;
        }else{
            $category_title = '';
        }

        if($category !== null){

            $category_title = ( isset( $category->title ) && $category->title != "" ) ? sanitize_text_field( $category->title ) : "";

            if ( $category_title != "" ) {
                $category_title = sprintf( '<a href="?page=%s&action=edit&popup_category=%d" target="_blank">%s</a>', esc_attr( $_REQUEST['page'] ) . '-categories', $item["category_id"], $category_title);
            }
        }else{
            $category_title = "";
        }
        return $category_title;
    }

    function column_create_date( $item ) {
        
        $options = json_decode($item['options'], true);
        $date = isset($options['create_date']) && $options['create_date'] != '' ? $options['create_date'] : "0000-00-00 00:00:00";
        if(isset($options['author'])){
            if(is_array($options['author'])){
                $author = $options['author'];
            }else{
                $author = json_decode($options['author'], true);
            }
        }else{
            $author = array("name"=>"Unknown");
        }
        $text = "";
        if(Ays_Pb_Admin::validateDate($date)){
            $text .= "<p><b>Date:</b> ".$date."</p>";
        }
        if( isset( $author['name'] ) && $author['name'] !== "Unknown"){
            $text .= "<p><b>Author:</b> ".$author['name']."</p>";
        }
        return $text;
    }

    function column_popup_image( $item ) {
        global $wpdb;
        
        $popup_image = (isset( $item['bg_image'] ) && $item['bg_image'] != '') ? esc_url( $item['bg_image'] ) : '';

        $image_html     = array();
        $edit_page_url  = '';

        if($popup_image != ''){

            if ( isset( $item['id'] ) && absint( $item['id'] ) > 0 ) {
                $edit_page_url = sprintf( 'href="?page=%s&action=%s&popup=%d"', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ) );
            }

            $popup_image_url = $popup_image;
            $this_site_path = trim( get_site_url(), "https:" );
            if( strpos( trim( $popup_image_url, "https:" ), $this_site_path ) !== false ){ 
                $query = "SELECT * FROM `" . $wpdb->prefix . "posts` WHERE `post_type` = 'attachment' AND `guid` = '" . $popup_image_url . "'";
                $result_img =  $wpdb->get_results( $query, "ARRAY_A" );
                if( ! empty( $result_img ) ){
                    $url_img = wp_get_attachment_image_src( $result_img[0]['ID'], 'thumbnail' );
                    if( $url_img !== false ){
                        $popup_image_url = $url_img[0];
                    }
                }
            }

            $image_html[] = '<div class="ays-popup-image-list-table-column">';
                $image_html[] = '<a '. $edit_page_url .' class="ays-popup-image-list-table-link-column">';
                    $image_html[] = '<img src="'. $popup_image_url .'" class="ays-popup-image-list-table-img-column">';
                $image_html[] = '</a>';
            $image_html[] = '</div>';
        }

        $image_html = implode('', $image_html);

        return $image_html;
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            "cb"                => "<input type='checkbox' />",
            "title"             => __( "Title", "ays-popup-box" ),
            "popup_image"       => __( "Image", "ays-popup-box" ),
            'category_id'       => __( 'Category', "ays-popup-box" ),
            "onoffswitch"       => __( "Status", "ays-popup-box" ),
            "modal_content"     => __("Type", "ays-popup-box" ),
            "view_type"         => __("Template", "ays-popup-box" ),
            "create_date"       => __("Created", "ays-popup-box" ),
            // "shortcode"         => __( "Shortcode", "ays-popup-box" ),
            "id"                => __( "ID", "ays-popup-box" ),
        );

        return $columns;
    }


    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            "title"         => array( "title", true ),
            'category_id'   => array( 'category_id', true ),
            "modal_content" => array( "modal_content", true),
            "id"            => array( "id", true ),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = array(
            "bulk-delete"       =>  __('Delete', "ays-popup-box"),
            "bulk-published"    =>  __('Publish', "ays-popup-box"),
            "bulk-unpublished"  =>  __('Unpublish', "ays-popup-box"),

        );

        return $actions;
    }


    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {
        global $wpdb;

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( "popupboxes_per_page", 20 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( array(
            "total_items" => $total_items, //WE have to calculate the total number of items
            "per_page"    => $per_page //WE have to determine how many items to show on a page
        ) );

        $search = ( isset( $_REQUEST['s'] ) ) ? esc_sql( sanitize_text_field( $_REQUEST['s'] ) ) : false;
        $do_search = ( $search ) ? sprintf(" title LIKE '%%%s%%' ", esc_sql( $wpdb->esc_like( $search ) ) ) : '';

        $this->items = self::get_ays_popupboxes( $per_page, $current_page,$do_search );
    }

    public function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        $message = "deleted";
        if ( "delete" === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST["_wpnonce"] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . "-delete-popupbox" ) ) {
                die( "Go get a life script kiddies" );
            }
            else {
                self::delete_popupboxes( absint( $_GET["popupbox"] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $url = esc_url_raw( remove_query_arg(array("action", "popupbox", "_wpnonce")  ) ) . "&status=" . $message . "&type=success";
                wp_redirect( $url );
                exit();
            }

        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST["action"] ) && $_POST["action"] == "bulk-delete" )
            || ( isset( $_POST["action2"] ) && $_POST["action2"] == "bulk-delete" )
        ) {

            $delete_ids = ( isset( $_POST['bulk-delete'] ) && ! empty( $_POST['bulk-delete'] ) ) ? esc_sql( $_POST['bulk-delete'] ) : array();

            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                self::delete_popupboxes( $id );

            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url

            $url = esc_url_raw( remove_query_arg(array("action", "popupbox", "_wpnonce")  ) ) . "&status=" . $message . "&type=success";
            wp_redirect( $url );
            exit();
        }elseif ((isset($_POST['action']) && $_POST['action'] == 'bulk-published')
                  || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-published')
        ) {

            $published_ids = ( isset( $_POST['bulk-delete'] ) && ! empty( $_POST['bulk-delete'] ) ) ? esc_sql( $_POST['bulk-delete'] ) : array();

            // loop over the array of record IDs and mark as read them

            foreach ( $published_ids as $id ) {
                self::publish_unpublish_popupbox( $id , 'published' );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $url = esc_url_raw( remove_query_arg(array('action', 'question', '_wpnonce')  ) ) . '&status=published';
            wp_redirect( $url );
        } elseif ((isset($_POST['action']) && $_POST['action'] == 'bulk-unpublished')
                  || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-unpublished')
        ) {

            $unpublished_ids = ( isset( $_POST['bulk-delete'] ) && ! empty( $_POST['bulk-delete'] ) ) ? esc_sql( $_POST['bulk-delete'] ) : array();

            // loop over the array of record IDs and mark as read them

            foreach ( $unpublished_ids as $id ) {
                self::publish_unpublish_popupbox( $id , 'unpublish' );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $url = esc_url_raw( remove_query_arg(array('action', 'question', '_wpnonce')  ) ) . '&status=unpublished';
            wp_redirect( $url );
        }
    }

    public function popupbox_notices(){
        $status = (isset($_REQUEST["status"])) ? sanitize_text_field( $_REQUEST["status"] ) : "";
        $type = (isset($_REQUEST["type"])) ? sanitize_text_field( $_REQUEST["type"] ) : "";

        if ( empty( $status ) )
            return;

        if ( "created" == $status )
            $updated_message = esc_html( __( "PopupBox created.", "ays-popup-box" ) );
        elseif ( "updated" == $status )
            $updated_message = esc_html( __( "PopupBox saved.", "ays-popup-box" ) );
        elseif ( "deleted" == $status )
            $updated_message = esc_html( __( "PopupBox deleted.", "ays-popup-box" ) );
        elseif ( 'duplicated' == $status )
            $updated_message = esc_html( __( 'PopupBox duplicated.', "ays-popup-box" ) );
        elseif ( 'published' == $status )
            $updated_message = esc_html( __( 'PopupBox published.', "ays-popup-box" ) );
        elseif ( 'unpublished' == $status )
            $updated_message = esc_html( __( 'PopupBox unpublished.', "ays-popup-box" ) );
        elseif ( "error" == $status )
            $updated_message = __( "You're not allowed to add popupbox for more popupboxes please checkout to ", "ays-popup-box")."<a href='http://ays-pro.com/wordpress/facebook-popup-likebox' target='_blank'>PRO ".__("version", "ays-popup-box")."</a>.";

        if ( empty( $updated_message ) )
            return;

        ?>
        <div class="notice notice-<?php echo esc_attr($type); ?> is-dismissible">
            <p> <?php echo $updated_message; ?> </p>
        </div>
        <?php
    }
}
