<?php
/**
 * Created by PhpStorm.
 * User: biggie18
 * Date: 6/15/18
 * Time: 3:34 PM
 */
?>

<div class="wrap">
    <div class="ays-pb-heading-box">
        <div class="ays-pb-wordpress-user-manual-box">
                <a href="https://ays-pro.com/wordpress-popup-box-plugin-user-manual" target="_blank"><?php echo __("View Documentation", $this->plugin_name); ?></a>
        </div>
    </div>  
    <h1 class="wp-heading-inline">
        <?php
        echo __(esc_html(get_admin_page_title()),$this->plugin_name);
        echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action">' . __('Add New', $this->plugin_name) . '</a>', esc_attr( $_REQUEST['page'] ), 'add');
        ?>
    </h1>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <?php
                        $this->popup_categories_obj->views();
                    ?>
                    <form method="post">
                        <?php
                            $this->popup_categories_obj->prepare_items();
                            $this->popup_categories_obj->search_box('Search', $this->plugin_name);
                            $this->popup_categories_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>
