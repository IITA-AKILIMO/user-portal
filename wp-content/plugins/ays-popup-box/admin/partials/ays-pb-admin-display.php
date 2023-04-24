<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/admin/partials
 */
$action = ( isset($_GET['action']) ) ? $_GET['action'] : '';
$id     = ( isset($_GET['popupbox']) ) ? $_GET['popupbox'] : null;
$popup_max_id = Ays_Pb_Data::get_max_id();

if($action == 'duplicate'){
$this->popupbox_obj->duplicate_popupbox($id);
}
if($action == 'unpublish' || $action == 'publish'){
$this->popupbox_obj->publish_unpublish_popupbox($id,$action);
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <div class="ays-pb-heading-box">
        <div class="ays-pb-wordpress-user-manual-box">
                <a href="https://ays-pro.com/wordpress-popup-box-plugin-user-manual" target="_blank"><?php echo __("View Documentation", "ays-popup-box"); ?></a>
        </div>
    </div>
    <h1 class="wp-heading-inline">
        <?php
        echo esc_html(get_admin_page_title());
        echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action ays-pb-add-new-button">'. __( "Add New", "ays-popup-box" ) .'</a>', esc_attr( $_REQUEST['page'] ), 'add');
        ?>
    </h1>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <?php
                        $this->popupbox_obj->views();
                    ?>
                    <form method="post">
                        <?php
                        $this->popupbox_obj->prepare_items();
                        $search = __( "Search", "ays-popup-box" );
                        $this->popupbox_obj->search_box($search, "ays-popup-box");
                        $this->popupbox_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
    <!-- <h1 class="wp-heading-inline"> -->
        <?php
        // echo esc_html(get_admin_page_title());
        // echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action ays-pb-add-new-button">'. __( "Add New", "ays-popup-box" ) .'</a>', esc_attr( $_REQUEST['page'] ), 'add');
        ?>
    <!-- </h1> -->
    <?php if($popup_max_id <= 1): ?>
            <div class="ays-pb-create-pb-video-box" style="">
                <div class="ays-pb-create-pb-youtube-video-button-box ays-pb-create-pb-youtube-video-button-box-top">
                    <?php echo sprintf(  '<a href="?page=%s&action=%s" class="page-title-action ays-pb-add-new-button-video">'. __( "Add New", "ays-popup-box" ) .'</a>', esc_attr( $_REQUEST['page'] ), 'add');?>
                </div>
                <div class="ays-pb-create-pb-title">
                    <h4><?php echo __( "Create Your First Popup in Under One Minute", "ays-popup-box" ); ?></h4>
                </div>
                <div class="ays-pb-create-pb-youtube-video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/_VEAGGzKe_g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="ays-pb-create-pb-youtube-video-button-box">
                    <?php echo sprintf(  '<a href="?page=%s&action=%s" class="page-title-action ays-pb-add-new-button-video">'. __( "Add New", "ays-popup-box" ) .'</a>', esc_attr( $_REQUEST['page'] ), 'add');?>
                </div>
            </div>
        <?php else: ?>
            <div class="ays-pb-create-pb-video-box" style="height: 83px;margin:0;">
                <div class="ays-pb-create-pb-youtube-video">
                    <?php echo sprintf(  '<a href="?page=%s&action=%s" class="page-title-action ays-pb-add-new-button-video">'. __( "Add New", "ays-popup-box" ) .'</a>', esc_attr( $_REQUEST['page'] ), 'add');?>
                </div>
                <div class="ays-pb-create-pb-youtube-video">
                    <a href="https://www.youtube.com/watch?v=_VEAGGzKe_g" target="_blank" title="YouTube video player" >How to create Popup in Under One Minute</a>
                </div>
                <!-- <div class="ays-pb-create-pb-youtube-video">
                    <?php echo sprintf(  '<a href="?page=%s&action=%s" class="page-title-action ays-pb-add-new-button-video">'. __( "Add New", "ays-popup-box" ) .'</a>', esc_attr( $_REQUEST['page'] ), 'add');?>
                </div> -->
            </div>
        <?php endif ?>
</div>