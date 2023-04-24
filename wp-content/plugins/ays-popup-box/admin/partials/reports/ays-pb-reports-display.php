<?php
	
?>
<div class="wrap ays_results_table">
    <h1 class="wp-heading-inline">
        <?php
        echo __(esc_html(get_admin_page_title()),"ays-popup-box");
        ?>
    </h1>
    <div class="nav-tab-wrapper">
        <a href="#tab1" class="nav-tab nav-tab-active"><?php echo __('Reports',"ays-popup-box")?></a>
        <a href="#tab2" class="nav-tab"><?php echo __('Statistics',"ays-popup-box")?></a>
    </div>
    <style>
        .column-unread,
        .column-id {
            text-align: center !important;
        }
        .column-id a,.column-unread a {
            display: inline-block !important;
            padding: 5px 70px;
        }

        .unread-result-badge {
            margin: 5px auto;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ccc;
        }

        .unread-result-badge.unread-result {
            background-color: #ffc107;
        }
    </style>
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
            <img src="<?php echo AYS_PB_ADMIN_URL .'/images/features/popup-reports-pro.png'?>" alt="PopupBox Position" style="width:100%;" >
        </div>
    </div>
    <div id="tab2" class="ays-pb-tab-content" style="margin-top: 15px;">
        <div class="col-sm-12">
            <div class="pro_features">
                <div>
                    <p>
                        <?php echo __("This feature is available only in ", "ays-popup-box"); ?>
                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", "ays-popup-box"); ?></a>
                    </p>
                </div>
            </div>
            <img src="<?php echo AYS_PB_ADMIN_URL .'/images/features/statistics-pro.png'?>" alt="PopupBox Statistics" style="width:100%;" >
        </div>
    </div>
</div>


