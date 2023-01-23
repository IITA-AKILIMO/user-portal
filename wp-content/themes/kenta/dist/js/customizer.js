(() => {
    var __webpack_exports__ = {};
    if (wp.customize) {
        wp.customize.bind("ready", (function() {
            jQuery("#kenta_install_companion .button").click((function(ev) {
                ev.preventDefault();
                var $btn = jQuery(this);
                $btn.attr("disabled", "disabled");
                $btn.html('<span class="loader"></span><span>Processing</span>');
                jQuery.ajax({
                    url: $btn.attr("href"),
                    complete: function complete() {
                        window.location.reload();
                    }
                });
            }));
            jQuery("#kenta_update_dynamic_css_cache .button").click((function(ev) {
                ev.preventDefault();
                var $btn = jQuery(this);
                $btn.attr("disabled", "disabled");
                $btn.html('<span class="loader"></span><span>Processing</span>');
                jQuery.ajax({
                    url: $btn.attr("href"),
                    complete: function complete() {
                        window.location.reload();
                    }
                });
            }));
        }));
    }
})();