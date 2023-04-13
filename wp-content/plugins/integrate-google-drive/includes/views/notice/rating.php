<div class="notice-image">
    <img src="<?php echo IGD_ASSETS . '/images/integrate-google-drive-logo.png'; ?>">
</div>

<div class="notice-main">
    <div class="notice-text">
        <p><?php _e( 'Hi there, it seems like Integrate Google Drive is bringing you some value, and that is pretty awesome! Can you please show us some love and rate Integrate Google Drive on WordPress?', 'integrate-google-drive' ); ?></p>
        <p><?php _e( 'It will take two minutes of your time. This will really encourage us to improve the plugin continuously and help us spread the world.', 'integrate-google-drive' ); ?></p>
    </div>

    <div class="notice-actions">
        <a class="hide_notice button button-primary" data-value="hide_notice"
           href="https://wordpress.org/support/plugin/integrate-google-drive/reviews/?filter=5#new-post"
           target="_blank"><?php _e( 'I\'d love to help', 'integrate-google-drive' ); ?> ⭐⭐⭐⭐⭐</a>
        <a href="#" class="remind_later button button-link-delete"><?php _e( 'Not this time', 'integrate-google-drive' ); ?></a>
        <a href="#" class="hide_notice button"
           data-value="hide_notice"><?php _e( 'I\'ve already rated you', 'integrate-google-drive' ); ?></a>
    </div>
</div>

<div class="notice-overlay-wrap">
    <div class="notice-overlay">
        <h4><?php _e( 'Would you like us to remind you about this later?', 'integrate-google-drive' ); ?></h4>

        <div class="notice-overlay-actions">
            <a href="#" data-value="3"><?php _e( 'Remind me in 3 days', 'integrate-google-drive' ); ?></a>
            <a href="#" data-value="10"><?php _e( 'Remind me in 10 days', 'integrate-google-drive' ); ?></a>
            <a href="#" data-value="hide_notice"><?php _e( 'Don\'t remind me about this', 'integrate-google-drive' ); ?></a>
        </div>

        <button type="button" class="close-notice">&times;</button>
    </div>
</div>

<script>

    //handle review notice remind_later
    jQuery('.igd-rating-notice .remind_later').on('click', function () {
        jQuery('.notice-overlay-wrap').css('display', 'flex');
    });

    jQuery('.igd-rating-notice .close-notice').on('click', function () {
        jQuery(this).parents('.notice-overlay-wrap').css('display', 'none');
    });

    jQuery('.igd-rating-notice .notice-overlay-actions a, .igd-rating-notice .notice-actions a.hide_notice, .igd-rating-notice .notice-dismiss').on('click', function () {
        jQuery(this).parents('.igd-rating-notice').slideUp();

        let value = jQuery(this).data('value');

        if (!value) {
            value = 7;
        }


        wp.ajax.post('igd_handle_notice', {
            type: 'rating',
            value
        });

    });
</script>
