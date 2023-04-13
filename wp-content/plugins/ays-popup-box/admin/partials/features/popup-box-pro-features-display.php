<?php
    // $url = "https://ays-pro.com/wordpress/popup-box";
    // wp_redirect( $url );
    // exit;

?>
<div class="wrap">
    <div class="ays-pb-heading-box">
        <div class="ays-pb-wordpress-user-manual-box">
                <a href="https://ays-pro.com/wordpress-popup-box-plugin-user-manual" target="_blank"><?php echo __("View Documentation", "ays-popup-box"); ?></a>
        </div>
    </div>
    <h1 class="wp-heading-inline">
		<?php echo __( esc_html( get_admin_page_title() ), "ays-popup-box" ); ?>
    </h1>

    <div class="ays-pb-features-wrap">
        <div class="comparison">
            <table>
                <thead>
                <tr>
                    <th class="tl tl2" style="width: 350px;"></th>
                    <th class="product" style="background:#69C7F1; border-top-left-radius: 5px; border-left:0px;">
                            <span style="display: block">
                                <?php echo __( 'Personal', "ays-popup-box" ); ?></span>
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/avatars/personal_avatar.png'; ?>"
                             alt="Free" title="Free" width="100"/>
                    </th>
                    <th class="product" style="background:#69C7F1;">
                            <span style="display: block">
                                <?php echo __( 'Business', "ays-popup-box" ); ?></span>
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/avatars/business_avatar.png'; ?>"
                             alt="Business" title="Business" width="100"/>
                    </th>
                    <th class="product" style="border-top-right-radius: 5px; border-right:0px; background:#69C7F1;">
                            <span style="display: block">
                                <?php echo __( 'Developer', "ays-popup-box" ); ?></span>
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/avatars/pro_avatar.png'; ?>"
                             alt="Developer"
                             title="Developer" width="100"/>
                    </th>
                </tr>
                <tr>
                    <th></th>
                    <th class="price-info">
                        <div class="price-now"><span>
                                    <?php echo __( 'Free', "ays-popup-box" ); ?></span></div>
                    </th>
                    <th class="price-info">
                        <!-- <div class="price-now"><span style="text-decoration: line-through; color: red;">$49</span> -->
                        <!-- <div class="price-now"><span>$39</span> -->
                        <div class="price-now"><span>$49</span></div> 
                        <!-- <div class="price-now"><span style="color: red; font-size: 12px;">Until December 31</span> -->
                    </th>
                    <th class="price-info">
                        <!-- <div class="price-now"><span style="text-decoration: line-through; color: red;">$129</span> -->
                        <div class="price-now"><span>$129</span>
                        <!-- <div class="price-now"><span>$79</span></div> -->
                        <!-- <div class="price-now"><span style="color: red; font-size: 12px;">Until December 31</span>                                      -->
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Support for', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Support for', "ays-popup-box" ); ?>
                    </td>
                    <td>
						<?php echo __( '1 site', "ays-popup-box" ); ?>
                    </td>
                    <td>
						<?php echo __( '5 sites', "ays-popup-box" ); ?>
                    </td>
                    <td>
						<?php echo __( 'Unlimited sites', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
		                <?php echo __( 'Upgrade for', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Upgrade for', "ays-popup-box" ); ?>
                    </td>
                    <td>
		                <?php echo __( '1 months', "ays-popup-box" ); ?>
                    </td>
                    <td>
		                <?php echo __( '12 months', "ays-popup-box" ); ?>
                    </td>
                    <td>
		                <?php echo __( 'Lifetime', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
		                <?php echo __( 'Support for', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Support for', "ays-popup-box" ); ?>
                    </td>
                    <td>
		                <?php echo __( '1 months', "ays-popup-box" ); ?>
                    </td>
                    <td>
		                <?php echo __( '12 months', "ays-popup-box" ); ?>
                    </td>
                    <td>
		                <?php echo __( 'Lifetime', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
						<?php echo __( 'Usage for lifetime', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
						<?php echo __( 'Usage for lifetimes', "ays-popup-box" ); ?>
                    </td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
						<?php echo __( 'Session time option', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
						<?php echo __( 'Session time option', "ays-popup-box" ); ?>
                    </td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
		                <?php echo __( 'Responsive design', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
		                <?php echo __( 'Responsive design', "ays-popup-box" ); ?>
                    </td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
						<?php echo __( 'Scroll from top', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Scroll from top', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
		                <?php echo __( 'Styles', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Styles', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Display on pages', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Display on pages', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Delay', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Delay', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Open with click', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Open with click', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Custom content', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Custom content', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
		                <?php echo __( 'Popup box position', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Popup box position', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Multiple scheduling', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Multiple scheduling', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'PopupBox Reports', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'PopupBox Reports', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Enable for selected user OS', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Enable for selected user OS', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Enable for selected browsers', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Enable for selected browser', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Limitation count', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Limitation count', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Export/Import', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Export/Import', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Close by scrolling down', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Close by scrolling down', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Close by classname', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Close by classname', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Actions while clicking on the popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Actions while clicking on the popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Title style', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Title style', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Video theme', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Video theme', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Peachy theme', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Peachy theme', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Yellowish theme', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Yellowish theme', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Coral theme', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Coral theme', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'User role permission', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'User role permission', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Limit by country', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Limit by country', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'MailChimp integration', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'MailChimp integration', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Campaign Monitor integration', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Campaign Monitor integration', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'ActiveCampaign integration', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'ActiveCampaign integration', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'GetResponse integration', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'GetResponse integration', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'ConvertKit integration', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'ConvertKit integration', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Sendinblue integration', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Sendinblue integration', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'MailerLite integration', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'MailerLite integration', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Yes or No popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Yes or No popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Video popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Video popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Iframe popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Iframe popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Subscription popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Subscription popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Contact form popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Contact form popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Send file after subscription popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Send file after subscription popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Coupon popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Coupon popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Countdown popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Countdown popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Cookie popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Cookie popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Exit Intent Popup', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Exit Intent Popup', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'On Hover Trigger', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'On Hover Trigger', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Inactivity Trigger', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Inactivity Trigger', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'After visiting X pages Trigger', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'After visiting X pages Trigger', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Scrolling to Element Trigger', "ays-popup-box" ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Scrolling to Element Trigger', "ays-popup-box" ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                    <td><img src="<?php echo AYS_PB_ADMIN_URL . "./images/icons/check-mark.svg"?>"></td>
                </tr>
            
                <tr>
                    <td> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td><a href="https://wordpress.org/plugins/ays-popup-box/" class="price-buy">
							<?php echo __( 'Download', "ays-popup-box" ); ?><span class="hide-mobile"></span></a>
                    </td>
                    <td><a href="https://ays-pro.com/wordpress/popup-box" class="price-buy">
							<?php echo __( 'Buy now', "ays-popup-box" ); ?><span class="hide-mobile"></span></a></td>
                    <td><a href="https://ays-pro.com/wordpress/popup-box" class="price-buy">
							<?php echo __( 'Buy now', "ays-popup-box" ); ?><span class="hide-mobile"></span></a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>