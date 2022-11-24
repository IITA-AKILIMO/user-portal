(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
        var checkCountdownIsExists = $(document).find('#ays-pb-countdown-main-container');
        if ( checkCountdownIsExists.length > 0 ) {
            var second  = 1000,
                minute  = second * 60,
                hour    = minute * 60,
                day     = hour * 24;

            var countdownEndTime ="NOV 25, 2022 23:59:59",
            // countdownEndTime = pb.pbBannerDate,
            countDown = new Date(countdownEndTime).getTime(),
            x = setInterval(function() {

                var now = new Date().getTime(),
                    distance = countDown - now;
                
                var countDownDays    = document.getElementById("ays-pb-countdown-days");
                var countDownHours   = document.getElementById("ays-pb-countdown-hours");
                var countDownMinutes = document.getElementById("ays-pb-countdown-minutes");
                var countDownSeconds = document.getElementById("ays-pb-countdown-seconds");

                if(countDownDays !== null || countDownHours !== null || countDownMinutes !== null || countDownSeconds !== null){
                    // countDownDays.innerText     = Math.floor(distance / (day)).toLocaleString(undefined,{minimumIntegerDigits: 2})+" : ",
                    // countDownHours.innerText    = Math.floor((distance % (day)) / (hour)).toLocaleString(undefined,{minimumIntegerDigits: 2})+" : ",
                    // countDownMinutes.innerText  = Math.floor((distance % (hour)) / (minute)).toLocaleString(undefined,{minimumIntegerDigits: 2})+" : ",
                    // countDownSeconds.innerText  = Math.floor((distance % (minute)) / second).toLocaleString(undefined,{minimumIntegerDigits: 2});

                    countDownDays.innerText = Math.floor(distance / (day)),
                    countDownHours.innerText = Math.floor((distance % (day)) / (hour)),
                    countDownMinutes.innerText = Math.floor((distance % (hour)) / (minute)),
                    countDownSeconds.innerText = Math.floor((distance % (minute)) / second);

                }
                

                //do something later when date is reached
                if (distance < 0) {
                    var headline  = document.getElementById("ays-pb-countdown-headline"),
                        countdown = document.getElementById("ays-pb-countdown"),
                        content   = document.getElementById("ays-pb-countdown-content");

                    // headline.innerText = "Sale is over!";
                    countdown.style.display = "none";
                    content.style.display = "block";

                    clearInterval(x);
                }
            }, 1000);
        }
    });
})( jQuery );