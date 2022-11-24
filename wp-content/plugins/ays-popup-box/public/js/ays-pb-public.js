(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function (){
		// Answer Sound Muter
		$(document).on('click', '.ays_music_sound', function() {
			var $this = $(this);
			var audioEl = $(document).find('.ays_pb_sound').get(0);
			if($this.hasClass('ays_sound_active')){
				audioEl.volume = 0;
				$this.find('.ays_pb_fa_volume').remove();
				$this.html(pbLocalizeObj.icons.volume_mute_icon);
				$this.find('.ays_pb_fa_volume').addClass('ays_pb_fa_volume_off').removeClass('ays_pb_fa_volume');
				$this.removeClass('ays_sound_active');
			} else {
				audioEl.volume = 1;
				$this.find('.ays_pb_fa_volume_off').remove();
				$this.html(pbLocalizeObj.icons.volume_up_icon);
				$this.find('.ays_pb_fa_volume_off').addClass('ays_pb_fa_volume').removeClass('ays_pb_fa_volume_off');
				$this.addClass('ays_sound_active');
			}
		});

		$(document).on('click', '#ays_pb_dismiss_ad', function(){
			var expTime = $(this).parent().data('dismiss');
			var id = $(this).parent().data('id');

			if(expTime != ''){
				set_cookies('ays_pb_dismiss_ad_'+id, 'ays_pb_dismiss_ad_'+id, parseInt(expTime));
			}else{
				var expiryDate = new Date();
				expiryDate.setMonth(expiryDate.getMonth() + 1);
				set_cookies('ays_pb_dismiss_ad_'+id, 'ays_pb_dismiss_ad_'+id, expiryDate);
			}
			$(document).find('.ays-pb-modal-close_'+id).trigger('click');
		});

		function set_cookies( cname, cvalue, exdays ) {
			var expires = "expires=" +  (new Date(Date.now() + exdays)).toUTCString();  
				document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}
	});
})( jQuery );

window.onload = function(){
	var classList = document.body.classList;
	document.ontouchmove = function(e){
    	for( var i = 0; i < classList.length; i++ ){
    		if( classList[i] == 'pb_disable_scroll' ){
    			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
                    e.preventDefault(); 
    			}
    			break;
    		}else if( classList[i] == 'pb_enable_scroll' ){
    		    if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
    		        true;
    			}
    			break;
    		} 
    	}
	}
}