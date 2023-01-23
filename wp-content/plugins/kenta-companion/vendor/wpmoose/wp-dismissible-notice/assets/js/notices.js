jQuery(document).ready(function ($) {
    $('.wpmoose-notice .wpmoose-notice-close').click(function () {
        var $notice = $(this).parents('.wpmoose-notice');
        var dismiss_url = $notice.attr('data-wpmoose-dismiss-url');

        $notice.fadeOut('fast', function () {
            if (dismiss_url) {
                $.ajax({
                    url: dismiss_url,
                    complete: function () {
                    }
                });

                $notice.remove();
            }
        });
    });
});