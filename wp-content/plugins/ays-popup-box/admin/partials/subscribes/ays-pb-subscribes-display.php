<?php
	
?>
<div class="wrap ays_results_table">
    <h1 class="wp-heading-inline">
        <?php
        echo __(esc_html(get_admin_page_title()),"ays-popup-box");
        ?>
    </h1>
    <div class="nav-tab-wrapper">
        <a href="#tab1" class="nav-tab nav-tab-active"><?php echo __('Subscribers',"ays-popup-box")?></a>
    </div>

    <div id="tab1" class="ays-pb-tab-content ays-pb-tab-content-active" style="margin-top: 15px;">
        <div class="col-sm-12">
            <div class="pro_features">
                <div>
                    <p>
                        <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                    </p>
                </div>
            </div>
            <img src="<?php echo AYS_PB_ADMIN_URL .'/images/features/popup-subscribes-pro.png'?>" alt="PopupBox Position" style="width:100%;" >
        </div>
    </div>
</div>


