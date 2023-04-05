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
        $('.apm-pro-feature-link').on('click', goToPro);
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function(e){            
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.nav-tab-wrapper a.nav-tab').each(function(){
            if( $(this).hasClass('nav-tab-active') ){
                $(this).removeClass('nav-tab-active');
            }
            });
            $(this).addClass('nav-tab-active');
                $(document).find('.ays-pb-tab-content').each(function(){
                if( $(this).hasClass('ays-pb-tab-content-active') )
                    $(this).removeClass('ays-pb-tab-content-active');
            });
            $(document).find("[name='ays_pb_tab']").val(active_tab);
            $('.ays-pb-tab-content' + elemenetID).addClass('ays-pb-tab-content-active');
            e.preventDefault();
        });
         
        $(document).find('.ays_pb_color_input').wpColorPicker();
        $(document).find('#ays_pb_button_text_color').wpColorPicker();
        $(document).find('#ays_pb_close_button_color').wpColorPicker();
        $(document).find('#ays_pb_close_button_hover_color').wpColorPicker();
        $(document).find('#ays_pb_box_shadow_color').wpColorPicker();
        $(document).find('#ays_pb_button_background_color').wpColorPicker();
         
        // $(document).find('.ays-pb-tab-content select').select2();
        $(document).find('#ays_users_roles').select2();
        var ays_pb_view_place = $(document).find('#ays-pb-ays_pb_view_place').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });
         
        $(document).find('.ays_view_place_clear').on('click', function(){
            ays_pb_view_place.val(null).trigger('change');
        });

        
        $(document).on('click', '.cat-filter-apply', function(e){
            e.preventDefault();
            let catFilter = $(document).find('select[name="filterby"]').val();
            let link = location.href;
            let linkFisrtPart = link.split('?')[0];
            let linkModified = link.split('?')[1].split('&');
            for(let i = 0; i < linkModified.length; i++){
                if(linkModified[i].split("=")[0] == "filterby"){
                    linkModified.splice(i, 1);
                }
            }
            link = linkFisrtPart + "?" + linkModified.join('&');
            if( catFilter != '' ){
                catFilter = "&filterby="+catFilter;
                document.location.href = link+catFilter;
            }else{
                document.location.href = link;
            }
        });

        $(document).on('click', '.status-filter-apply', function(e){
            e.preventDefault();
            let statusFilter = $(document).find('select[name="filterbyStatus"]').val();
            let link = location.href;
            let linkFisrtPart = link.split('?')[0];
            let linkModified = link.split('?')[1].split('&');
            for(let i = 0; i < linkModified.length; i++){
                if(linkModified[i].split("=")[0] == "filterbyStatus"){
                    linkModified.splice(i, 1);
                }
            }
            link = linkFisrtPart + "?" + linkModified.join('&');
            if( statusFilter != '' ){
                statusFilter = "&filterbyStatus="+statusFilter;
                document.location.href = link+statusFilter;
            }else{
                document.location.href = link;
            }
        });
        
        $(document).on('click', '.ays-remove-bg-img', function () {
            $('img#ays-pb-bg-img').attr('src', '');
            $('input#ays-pb-bg-image').val('');
            $('.ays-pb-bg-image-container').parent().fadeOut();
            $('.ays-pb-bg-image-container').parents("#ays-popup-box-background-image").fadeOut();
            $('a.ays-pb-add-bg-image').text('Add Image');
            $('a.ays-pb-add-bg-image').attr('data-add', false);
            $('.box-apm').css('background-image', 'unset');
            $('.ays_bg_image_box').css('background-image', 'unset');
            $('.ays_lil_window').css('background-image', 'unset');
            if ($(document).find('#ays-enable-background-gradient').prop('checked')) {
                toggleBackgrounGradient();
            }
            if ($(document).find(".ays_template_window").is(":visible")) {
                var bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/girl-scaled.jpg";
                $(document).find('.ays_bg_image_box').css({
                    'background-image' : 'url(' + bg_img_default + ')',
                    'background-repeat' : 'no-repeat',
                    'background-size' : 'cover',
                    'background-position' : 'center center'
                });
            }
            if ($(document).find(".ays_image_window").is(":visible")) {
                var bg_img_default="https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg";
                $(document).find('.ays_bg_image_box').css({
                    'background-image' : 'url(' + bg_img_default + ')',
                    'background-repeat' : 'no-repeat',
                    'background-size' : 'cover',
                    'background-position' : 'center center'
                });
            }
        });
        $(document).on('click', '.ays_remove_bg_img', function () {
            $('img#ays_close_btn_bg_img').attr('src', '');
            $('input#close_btn_bg_img').val('');
            $('.ays_pb_close_btn_bg_img').parent().fadeOut();
            $('a.ays_pb_add_close_btn_bg_image').text('Add Image');

            $(document).find('img.close_btn_img').css('display','none');
            $(document).find('label.close_btn_label > .close_btn_text').css('display','block');

        });

        $(document).on('click', 'a.ays-pb-add-bg-video', function (e) {
            openMediaUploaderVideo(e, $(this));
        });
        $(document).on('click','.ays-remove-bg-video', function () {
            $('video#ays_pb_video_theme_video').attr('src', '');
            $('input#ays_pb_video_theme').val('');
            $('.ays-pb-bg-video-container').parent().fadeOut();
            $('a.ays-pb-add-bg-video').text('Add Video');
            var bg_video_default = $(document).find('.ays_video_window > input').val();
            if ($(document).find(".ays_video_window").hasClass('ays_active')) {
                $(document).find('.video_theme').attr('src',bg_video_default);
            }
        });

        let heart_interval = setInterval(function () {
            $(document).find('.ays_heart_beat i.ays_fa').toggleClass('ays_pulse');
        }, 1000);

        var ays_pb_overlay_color = $(document).find('#ays-pb-overlay_color').val();
        $(document).find('.ays-pb-modals').css("background-color", ays_pb_overlay_color);

        let ays_pb_box_gradient_color1_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        let ays_pb_box_gradient_color2_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        $(document).find('#ays_pb_gradient_direction').on('change', function () {
            toggleBackgrounGradient();
        });

        $(document).find('#ays-background-gradient-color-1').wpColorPicker(ays_pb_box_gradient_color1_picker);
        $(document).find('#ays-background-gradient-color-2').wpColorPicker(ays_pb_box_gradient_color2_picker);

        $(document).find('input#ays-enable-background-gradient').on('change', function () {
            toggleBackgrounGradient()
        });
        toggleBackgrounGradient();
        function toggleBackgrounGradient() {
                let pb_gradient_direction = $(document).find('#ays_pb_gradient_direction').val();
                var checked = $(document).find('input#ays-enable-background-gradient').prop('checked');
                switch(pb_gradient_direction) {
                    case "horizontal":
                        pb_gradient_direction = "to right";
                        break;
                    case "diagonal_left_to_right":
                        pb_gradient_direction = "to bottom right";
                        break;
                    case "diagonal_right_to_left":
                        pb_gradient_direction = "to bottom left";
                        break;
                    default:
                        pb_gradient_direction = "to bottom";
                }
            if($(document).find('input#ays-pb-bg-image').val() == '') {
                if(checked){
                    $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
                     $(document).find('#ays-image-window').css({'background-image': 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg','background-size': 'cover','background-repeat': 'no-repeat','background-position': 'center'});
                }else{
                        $(document).find('.ays-pb-live-container').css({'background-image': "none"});
                        $(document).find('#ays-image-window').css({'background-image': 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg','background-size': 'cover','background-repeat': 'no-repeat','background-position': 'center'});
                }
            }
            // else if ($(document).find(".ays_template_window").hasClass("ays_active") 
            //     && $(document).find('input#ays-enable-background-gradient').attr('checked') == 'checked' 
            //     && $(document).find('input#ays-pb-bg-image').val() != '') {
            //      $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
     
            // }
        }


         
        $(document).on('change', '.ays_toggle', function (e) {
            let state = $(this).prop('checked');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        $(this).parent().find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        $(this).parent().find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        $(this).parent().find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        $(this).parent().find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            let state = $(this).prop('checked');
            let parent = $(this).parents('.ays_toggle_parent');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        $(document).find('#ays-pb-popup_title').on('input', function(e){
            var pbTitleVal = $(this).val();
            var pbTitle = aysPopupstripHTML( pbTitleVal );
            $(document).find('.ays_pb_title_in_top').html( pbTitle );
        });


        function aysPopupstripHTML( dirtyString ) {
            var container = document.createElement('div');
            var text = document.createTextNode(dirtyString);
            container.appendChild(text);

            return container.innerHTML; // innerHTML will be a xss safe string
        }

        $(document).find('#ays_pb_form').on('submit', function(e){
            
            if($(document).find('#ays-pb-popup_title').val() == ''){
                $(document).find('#ays-pb-popup_title').val('Demo Title').trigger('input');
            }

            var $this = $(this)[0];
            if($(document).find('#ays-pb-popup_title').val() != ""){
                $this.submit();
            }else{
                e.preventDefault();
                $this.submit();
            }
        });

        $(document).find('#ays_pb_posts').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });

        $(document).find('#ays_pb_create_author').select2({
            placeholder: 'Select users',
            minimumInputLength: 1,
            allowClear: true,
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return pb.pleaseEnterMore;
                }
            },
            ajax: {
                url: pb.ajax,
                dataType: 'json',
                data: function (response) {
                    var checkedUsers = $(document).find('#ays_pb_create_author').val();
                    return {
                        action: 'ays_pb_create_author',
                        search: response.term,
                        val: checkedUsers,
                    };
                },
            }
        });
        var ays_pb_post_types = $(document).find('#ays_pb_post_types').select2({
            placeholder: 'Select page',
            multiple: true,
            matcher: searchForPage
        });

        $(document).on('change', '#ays_pb_post_types', function () {

            var selected = $('.select2-selection__choice');
            var arr = pb.post_types;
            
            var types_arr = [];
            for (var i = 0; i < selected.length; i++) {
                var name = selected[i].innerText;
                name = name.substring(1, name.length);
                for (var j = 0; j < arr.length; j++) {
                    if (name == arr[j][1]) {
                        types_arr.push(arr[j][0])
                    }
                }
            }
            var get_hidden_val = $('#ays_pb_except_posts_id');
            var posts = $(document).find('#ays_pb_posts option:selected');
            var posts_ids = [];
            posts.each(function(){
                posts_ids.push($(this).attr('value'));
            });
            posts_ids = posts_ids.join(',');
            get_hidden_val.val(posts_ids);
            $.ajax({
                url: pb.ajax,
                method: 'post',
                dataType: 'text',
                data: {
                    action: 'get_selected_options_pb',
                    data: types_arr,
                },
                success: function (resp) {
                    var inp = $('#ays_pb_posts');
                    var data = JSON.parse(resp);
                    inp.html('');
                    inp.val(null).trigger('change');

                    var new_hidden_val = get_hidden_val.val();
                    var get_hidden_val_arr = new_hidden_val.split(',');

                    for (var i = 0; i < data.length; i++) {
                        inp.append("<option value='" + data[i][0] + "'>" + data[i][1] + "</option>");
                    }
                   
                    for(var k = 0; k < get_hidden_val_arr.length; k++){
                        inp.select2( "val", get_hidden_val_arr );
                    }
                },
            });

        });

        $(document).find('.ays_pb_act_dect, #ays_pb_change_creation_date').datetimepicker({
            controlType: 'select',
            oneLine: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });

        $(document).on('click', 'a.add-pb-bg-music', function (e) {
            openMusicMediaUploader(e, $(this));
        });     

        function openMusicMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload music',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'audio'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                element.next().attr('src', attachment.url);
                element.parent().find('input.ays_pb_bg_music').val(attachment.url);
                element.parent().find('.ays_pb_sound_close_btn').show();
            }).open();
            return false;
        }  

        $(document).find('.ays_pb_sound_opening_btn').on('click', function(){
            var pb_opening_audio = $('.ays-bg-opening-music-audio');
            var pb_opening_audio_src = pb_opening_audio.prop('src','');
            $('input.ays_pb_bg_music_opening_input').val('');
            $('.ays_pb_sound_opening_btn').hide();          
            
        }); 
        $(document).find('.ays_pb_sound_closing_btn').on('click', function(){
            var pb_opening_audio = $('.ays-bg-closing-music-audio');
            var pb_opening_audio_src = pb_opening_audio.prop('src',''); 
            $('input.ays_pb_bg_music_closing_input').val('');
            $('.ays_pb_sound_closing_btn').hide();               
        }); 

        // $(document).find('#ays_popup_width_by_percentage_px').select2({
        //     minimumResultsForSearch: -1
        // }) 

        $(document).find('#open_pb_fullscreen').on('click',function(){
            var inpFullScreenChecked = $(document).find('#open_pb_fullscreen').prop('checked');
            if(inpFullScreenChecked){
                $(document).find('.ays_pb_width').prop( "readonly", true );
                $(document).find('.ays_pb_height').prop( "readonly", true );
            }else{
                $(document).find('.ays_pb_width').prop( "readonly", false );
                $(document).find('.ays_pb_height').prop( "readonly", false );
            }
        })

        $(document).find('.ays_pb_hide_timer').on('click',function(){
            var inpHideTimer = $(document).find('.ays_pb_hide_timer').prop('checked');
            if(inpHideTimer){
                $(document).find('.ays_pb_timer').css( {"visibility":"hidden" });
            }else{
                $(document).find('.ays_pb_timer').css( {"visibility":"visible" });
            }
        })

        $(document).find('#ays-pb-close-button').on('change',function(){
            var inpHideCloseBtn = $(document).find('#ays-pb-close-button').prop('checked');
            if(inpHideCloseBtn){
                $(document).find('.close_btn_label').css( {"display":"none" });
            }else{
                $(document).find('.close_btn_label').css( {"display":"block" });
            }
        })


        $(document).find('.ays_pb_layer_button').on('click',function(){
            $('.ays_pb_layer_container').css({'position':'unset' , 'display':'none'});

            var checkedInp = $('.ays_pb_layer_box input:checked').val();

            switch ( checkedInp ) {
                    case 'shortcode':
                        $('#ays_custom_html').hide();
                        $('#ays_shortcode').show();
                        $('#ays_shortcode').before('<hr>');
                        $(document).find('.ays-pb-type-name > span').text('shortcode');
                        $(document).find('.ays-pb-type-video').append('<span><a href="https://www.youtube.com/watch?v=q6ai1WhpLfc">Watch how to add a shortcode popup</a></span>');
                        break;
                    case 'custom_html':
                        $('#ays_custom_html').show();
                        $('#ays_shortcode').hide();
                        $('#ays_shortcode').before('<hr>');
                        $(document).find('.ays-pb-type-name > span').text('Custom Content');
                        $(document).find('.ays-pb-type-video').append('<span></span>');
                        break;
                    case 'video_type':
                        $('#ays_custom_html').hide();
                        $('.ays_pb_themes').hide();
                        $('.video_hr').hide();
                        $('#video_theme_view_type').prop('checked',true);
                        $(document).find(".ays_video_window").css('display', 'block');
                        $(document).find(".ays_video_window").addClass('ays_active');
                        $(document).find(".ays-pb-modal, .ays_window , .ays_cmd_window , .ays_ubuntu_window , .ays_winxp_window , .ays_win98_window , .ays_lil_window , .ays_image_window , .ays_template_window ").css('display', 'none');
                        $(document).find(".ays_pb_add_new_video").show();
                        $('.ays_pb_add_new_video').before('<hr>');
                        $(document).find('.ays-pb-type-name > span').text('Video');
                        $(document).find('.ays-pb-type-video').append('<span><a href="https://www.youtube.com/watch?v=oOvHTcePpys">Watch how to add a video popup</a></span>');

                        break;
                    default: 
                        $('#ays_custom_html').show();
                        $('#ays_shortcode').hide();
                        $('#ays_custom_html').before('<hr>');
                        $(document).find('.ays-pb-type-name > span').text('Custom Content');
                        break;
            } 
        });

        // Code Mirror
             
        setTimeout(function(){
            if($(document).find('#ays-pb-custom-css').length > 0){
                let CodeEditor = null;
                if(wp.codeEditor){
                    CodeEditor = wp.codeEditor.initialize($(document).find('#ays-pb-custom-css'), cm_settings);
                }
                if(CodeEditor !== null){
                    CodeEditor.codemirror.on('change', function(e, ev){
                        $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                        $(document).find('#ays-pb-custom-css').val(CodeEditor.codemirror.display.input.div.innerText);
                            
                    });
                }
            

            }
        }, 500);
       
        $(document).find('a[href="#tab3"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#ays-pb-custom-css').length > 0){
                    var ays_pb_custom_css = $(document).find('#ays-pb-custom-css').html();
                    if(wp.codeEditor){
                        $(document).find('#ays-pb-custom-css').next('.CodeMirror').remove();
                        var CodeEditor = wp.codeEditor.initialize($(document).find('#ays-pb-custom-css'), cm_settings);

                        CodeEditor.codemirror.on('change', function(e, ev){
                            $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                            $(document).find('#ays-pb-custom-css').val(CodeEditor.codemirror.display.input.div.innerText);
                        });
                        ays_pb_custom_css = CodeEditor.codemirror.getValue();
                        $(document).find('#ays-pb-custom-css').html(ays_pb_custom_css);
                    }
                }
            }, 500);
           
        });

        $(document).find('.ays-pb-open-popups-list').on('click', function(e){
            $(this).parents(".ays-pb-subtitle-main-box").find(".ays-pb-popups-data").toggle('fast');
        });

        $(document).on( "click" , function(e){

            if($(e.target).closest('.ays-pb-subtitle-main-box').length != 0){
                
            } 
            else{
                $(document).find(".ays-pb-subtitle-main-box .ays-pb-popups-data").hide('fast');
            }

         });

        $(document).find(".ays-pb-go-to-popups").on("click" , function(e){
            e.preventDefault();
            var confirmRedirect = window.confirm('Are you sure you want to redirect to another popup? Note that the changes made in this popup will not be saved.');
            if(confirmRedirect){
                window.location = $(this).attr("href");
            }
        });

        $(document).find('.ays_pb_title').on('change',function(){
            var inpHideTitle = $(document).find('.ays_pb_title').prop('checked');
            if(inpHideTitle){
                $(document).find('.ays_title').css( {"display":"block" });
                $(document).find('.ays_template_head').css( {"height":"15%","display":"flex", "justify-content":"center","align-items":"center"});
                $(document).find('.ays_template_footer').css( {"height":"100%" });
                $(document).find('.title_hr').css( {"display":"block" });
            }else{
                $(document).find('.ays_title').css( {"display":"none" });
                $(document).find('.ays_template_head').css( {"height":"0"});
                $(document).find('.ays_template_footer').css( {"height":"85%" });
                $(document).find('.title_hr').css( {"display":"none" });
            }
        })
        
        $(document).find('.ays_pb_desc').on('change',function(){
            var inpHideDesc = $(document).find('.ays_pb_desc').prop('checked');
            if(inpHideDesc){
                $(document).find('.desc').css( {"display":"block" });
            }else{
                $(document).find('.desc').css( {"display":"none" });
            }
        })

        $(document).find('#ays_pb_border_style').on('change',function(){
            var borderStyle = $(document).find('#ays_pb_border_style').val();
            $(document).find('.ays-pb-live-container').css('border-style',borderStyle);
        })

        // $(document).find('input#ays-enable-background-gradient').on('change',function(){
        //     var backgroundGradient = $(document).find('input#ays-enable-background-gradient').prop('checked');
        //     if(backgroundGradient){
        //         var pb_gradient_direction = $(document).find('#select2-ays_pb_gradient_direction-container').val();
        //         $(document).find('.ays-pb-live-container').css({'background-image': "linear-gradient(" + pb_gradient_direction + ", " + $(document).find('input#ays-background-gradient-color-1').val() + ", " + $(document).find('input#ays-background-gradient-color-2').val()+")"});
        //     }else{
        //         var bgColor = $(document).find('.ays_pb_background_color').val();
        //         $(document).find('.ays-pb-live-container').css('background', bgColor);
        //         $(document).find('#ays-image-window').css({'background-image': 'url("https://quiz-plugin.com/wp-content/uploads/2020/02/elefante.jpg','background-size': 'cover','background-repeat': 'no-repeat','background-position': 'center'});
        //     }
        // })


        let toggle_ddmenu = $(document).find('.toggle_ddmenu');
        toggle_ddmenu.on('click', function () {
            let ddmenu = $(this).next();
            let state = ddmenu.attr('data-expanded');
            switch (state) {
                case 'true':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(0deg)'
                    });
                    ddmenu.attr('data-expanded', 'false');
                    break;
                case 'false':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(90deg)'
                    });
                    ddmenu.attr('data-expanded', 'true');
                    break;
            }
        });


        $(document).find('table#ays-pb-position-table tr td, table#ays_pb_bg_image_position_table tr td').on('click', function(e){
            var val = $(this).data('value');
            var flag = $(this).parents('table').data('flag');
            $(this).parents('.pb_position_block').find('.ays-pb-position-val-class').val(val);

            if(flag == 'popup_position'){
                aysCheckPopupPosition();
            }else if(flag == 'bg_image_position'){
                aysCheckBgImagePosition();
            }
        });

        aysCheckPopupPosition();
        function aysCheckPopupPosition(){
            var hiddenVal = $(document).find('.pb_position_block #ays-pb-position-val').val();

            if (hiddenVal == "" || hiddenVal == 0) {
                var $this = $(document).find('table#ays-pb-position-table tr td[data-value="center-center"');
            }else{
                var $this = $(document).find('table#ays-pb-position-table tr td[data-value='+ hiddenVal +']');
            }

            if (hiddenVal == 'center-center' || hiddenVal == ''){
                $(document).find("#popupMargin").hide(500);
                $(document).find(".ays_pb_hr_hide").hide(500);
            }
            else{
                $(document).find("#popupMargin").show(500);
                $(document).find(".ays_pb_hr_hide").show(500);
            }

            $(document).find('table#ays-pb-position-table td').removeAttr('style');
            $this.css('background-color','#a2d6e7');
        }

        aysCheckBgImagePosition();
        function aysCheckBgImagePosition(){
            var hiddenVal = $(document).find('.pb_position_block #ays_pb_bg_image_position').val();
            
            if (hiddenVal == "") {
                var $this = $(document).find('table#ays_pb_bg_image_position_table tr td[data-value="center-center"');
            }else{
                var $this = $(document).find('table#ays_pb_bg_image_position_table tr td[data-value='+ hiddenVal +']');
            }

            $(document).find('table#ays_pb_bg_image_position_table td').removeAttr('style');
            $this.css('background-color','#a2d6e7');
        }

        $(document).find('.ays_pb_layer_box_blocks label.ays-pb-dblclick-layer').on('dblclick',function(){
            $(this).parents('.ays_pb_layer_container').find('.ays_pb_select_button_layer input.ays_pb_layer_button').trigger('click');
        });
        $(document).find('.ays-pb-content-type').on('change',function(){
            $(this).parents('.ays_pb_layer_container').find('.ays_pb_select_button_layer input.ays_pb_layer_button').prop('disabled',false);
        });


        var wp_editor_height = $(document).find('.quiz_wp_editor_height');

        if ( wp_editor_height.length > 0 ) {
            var wp_editor_height_val = wp_editor_height.val();
            if ( wp_editor_height_val != '' && wp_editor_height_val != 0 ) {
                var ays_pb_wp_editor = setInterval( function() {
                    if (document.readyState === 'complete') {
                        $(document).find('.wp-editor-wrap .wp-editor-container iframe , .wp-editor-container textarea.wp-editor-area').css({
                            "height": wp_editor_height_val + 'px'
                        });
                        clearInterval(ays_pb_wp_editor);
                    }
                } , 500);
            }
        }

        $(document).on('change', '#ays_pb_bg_image_position', function () {
            $(document).find('.ays-pb-live-container').css('background-position',$(this).val());
            $(document).find('.ays-pb-live-container .ays_bg_image_box').css('background-position',$(this).val());
        });

        $(document).on('change', '#ays_pb_bg_image_sizing', function () {
            $(document).find('.ays-pb-live-container').css('background-size',$(this).val());
            $(document).find('.ays-pb-live-container .ays_bg_image_box').css('background-size',$(this).val());
        });

        $(document).find('#ays_enable_title_text_shadow').on('change', function(){
            var textShadowColor = $('#ays_title_text_shadow_color').val();
            var textShadowX = $("#ays_pb_title_text_shadow_x_offset").val();
            var textShadowY = $("#ays_pb_title_text_shadow_y_offset").val();
            var textShadowZ = $("#ays_pb_title_text_shadow_z_offset").val();
            if($(this).prop('checked')){
                $(document).find('h2.ays_title').css('text-shadow' , textShadowX+'px '+textShadowY +'px '+textShadowZ+'px '+textShadowColor);
            }else{
                $(document).find('h2.ays_title').css('text-shadow', 'unset');
            }
        });

        $(document).find('#ays_pb_enable_box_shadow').on('change', function(){
            var boxShadowColor = $('#ays_pb_box_shadow_color').val();
            var boxShadowX = $("#ays_pb_box_shadow_x_offset").val();
            var boxShadowY = $("#ays_pb_box_shadow_y_offset").val();
            var boxShadowZ = $("#ays_pb_box_shadow_z_offset").val();
            if($(this).prop('checked')){
                $(document).find('div.ays-pb-live-container').css('box-shadow' , boxShadowX+'px '+boxShadowY +'px '+boxShadowZ+'px '+boxShadowColor);
            }else{
                $(document).find('div.ays-pb-live-container').css('box-shadow', 'unset');
            }
        });

        $(document).find('#ays-pb-autoclose').on('input', function(){
            var autocloseCount = $(this).val();
    
            if(autocloseCount == 0){
                $(this).parents('.ays-pb-tab-content').find(".ays-pb-hide-timer-hr").hide(250);
                $(this).parents('.ays-pb-tab-content').find("#ays_pb_hide_timer_popup").hide(250);
            }else{
                $(this).parents('.ays-pb-tab-content').find(".ays-pb-hide-timer-hr").show(250);
                $(this).parents('.ays-pb-tab-content').find("#ays_pb_hide_timer_popup").css('display', 'flex');
            }
        });

        $(document).on('click', 'button.ays-pb-template-themes-view-more-btn', function(){
            $(this).next().css('display', 'block');
            $(this).css('display', 'none');
            $(document).find('div.ays-pb-template-themes-view-more').css('animation', '5s ease 0s 1 normal none running fadeIntDown');
            $(document).find('div.ays-pb-template-themes-view-more').css('display', 'flex');
        });

        $(document).on('click', 'button.ays-pb-template-themes-hide-btn', function(){
            $(this).prev().css('display', 'block');
            $(this).css('display', 'none');
            $(document).find('div.ays-pb-template-themes-view-more').css('animation', '5s ease 0s 1 normal none running fadeOutUp');
            $(document).find('div.ays-pb-template-themes-view-more').css('display', 'none');
        });

        $('.ays-pb-template-overlay-preview').hover(
            function() {
                $(this).find('div.ays-pb-choose-template-div').css("display","block");
            },
            function() {
                var checkedTheme = $(this).find('.ays-pb-choose-template-div').find('.ays-pb-template-checkbox-container > input').prop('checked');
                if(checkedTheme){
                    $(this).find('.ays-pb-choose-template-div').css( 'display', 'block' );
                }else{
                    $(this).find('div.ays-pb-choose-template-div').css("display","none");
                }
            }
        );

        $(document).on('click', '.ays-pb-template-choose-template-btn, .ays-pb-template-checkbox input', function(){
            var checked = $(this).parents('.ays-pb-choose-template-div').find('.ays-pb-template-checkbox input').prop('checked', true);
            if(checked){
                var checkedTheme = $("input[name='ays-pb[view_type]']:checked").val();
                var backroundImageTag = $(document).find('#ays-pb-bg-img');
                var backroundImageInput = $(document).find('#ays-pb-bg-image');
                var backroundImageContent = $(document).find('.ays-pb-bg-image-container').parent();
                var addImage = $(document).find('.ays-pb-add-bg-image');
                var addedImg = $('a.ays-pb-add-bg-image').attr('data-add');

                if(!addedImg || addedImg == 'false'){
                    if( backroundImageInput.val() == pb.AYS_PB_ADMIN_URL + "/images/elefante.jpg" && checkedTheme != 'image' && checkedTheme == 'template'){
                        backroundImageTag.attr( 'src', pb.AYS_PB_ADMIN_URL + "/images/girl-scaled.jpg" );
                        backroundImageInput.val(pb.AYS_PB_ADMIN_URL + "/images/girl-scaled.jpg");
                        backroundImageContent.css( 'display', 'flex' );
                        addImage.html( pb.editImage );
                    }else if(backroundImageInput.val() == pb.AYS_PB_ADMIN_URL + "/images/girl-scaled.jpg" && checkedTheme != 'template' && checkedTheme == 'image'){
                        backroundImageTag.attr( 'src', pb.AYS_PB_ADMIN_URL + "/images/elefante.jpg" );
                        backroundImageInput.val(pb.AYS_PB_ADMIN_URL + "/images/elefante.jpg");
                        backroundImageContent.css( 'display', 'flex' );
                        addImage.html( pb.editImage );
                    }else{
                        backroundImageTag.attr( 'src', '' );
                        backroundImageInput.val('');
                        backroundImageContent.css( 'display', 'none' );
                        addImage.html( pb.addImage );
                    }
                }                
            }
        });

        // $(document).on('click', '.ays-pb-template-checkbox input', function(){
        //     var checked = $(this).parents('.ays-pb-choose-template-div').find('.ays-pb-template-checkbox input').prop('checked', true);
        //     if(checked){
        //         var checkedTheme = $("input[name='ays-pb[view_type]']:checked").val();
        //         var backroundImageTag = $(document).find('#ays-pb-bg-img');
        //         var backroundImageInput = $(document).find('#ays-pb-bg-image');
        //         var backroundImageContent = $(document).find('.ays-pb-bg-image-container').parent();
        //         var addImage = $(document).find('.ays-pb-add-bg-image');
        //         var addedImg = $('a.ays-pb-add-bg-image').attr('data-add');

        //         if(!addedImg || addedImg == 'false'){
        //             if( backroundImageInput.val() == pb.AYS_PB_ADMIN_URL + "/images/elefante.jpg" && checkedTheme != 'image' && checkedTheme == 'template'){
        //                 console.log(555);
        //                 backroundImageTag.attr( 'src', pb.AYS_PB_ADMIN_URL + "/images/girl-scaled.jpg" );
        //                 backroundImageInput.val(pb.AYS_PB_ADMIN_URL + "/images/girl-scaled.jpg");
        //                 backroundImageContent.css( 'display', 'flex' );
        //                 addImage.html( pb.editImage );
        //             }else if(backroundImageInput.val() == pb.AYS_PB_ADMIN_URL + "/images/girl-scaled.jpg" && checkedTheme != 'template' && checkedTheme == 'image'){
        //                 backroundImageTag.attr( 'src', pb.AYS_PB_ADMIN_URL + "/images/elefante.jpg" );
        //                 backroundImageInput.val(pb.AYS_PB_ADMIN_URL + "/images/elefante.jpg");
        //                 backroundImageContent.css( 'display', 'flex' );
        //                 addImage.html( pb.editImage );
        //             }else{
        //                 backroundImageTag.attr( 'src', '' );
        //                 backroundImageInput.val('');
        //                 backroundImageContent.css( 'display', 'none' );
        //                 addImage.html( pb.addImage );
        //             }
        //         }                
        //     }
        // });

        if($(document).find('.ays-pb-top-menu').width() <= $(document).find('div.ays-pb-top-tab-wrapper').width()){
            $(document).find('.ays_pb_menu_left').css('display', 'flex');
            $(document).find('.ays_pb_menu_right').css('display', 'flex');
        }
        $(window).resize(function(){
            if($(document).find('.ays-pb-top-menu').width() < $(document).find('div.ays-pb-top-tab-wrapper').width()){
                $(document).find('.ays_pb_menu_left').css('display', 'flex');
                $(document).find('.ays_pb_menu_right').css('display', 'flex');
            }else{
                $(document).find('.ays_pb_menu_left').css('display', 'none');
                $(document).find('.ays_pb_menu_right').css('display', 'none');
                $(document).find('div.ays-pb-top-tab-wrapper').css('transform', 'translate(0px)');
            }
        });
        var menuItemWidths0 = [];
        var menuItemWidths = [];

        $(document).find('.ays-pb-top-tab-wrapper').each(function(){
            var $this = $(this);
            menuItemWidths0.push($this.outerWidth());
        });

        for(var i = 0; i < menuItemWidths0.length; i+=2){
            if(menuItemWidths0.length <= i+1){
                menuItemWidths.push(menuItemWidths0[i]);
            }else{
                menuItemWidths.push(menuItemWidths0[i]+menuItemWidths0[i+1]);
            }
        }
        var menuItemWidth = 0;
        for(var i = 0; i < menuItemWidths.length; i++){
            menuItemWidth += menuItemWidths[i];
        }
        
        menuItemWidth = menuItemWidth / menuItemWidths.length;
    
        $(document).on('click', '.ays_pb_menu_left', function(){
            var scroll = parseInt($(this).attr('data-scroll'));
            scroll -= menuItemWidth;
            if(scroll < 0){
                scroll = 0;
            }
            $(document).find('div.ays-pb-top-tab-wrapper').css('transform', 'translate(-'+scroll+'px)');
            $(this).attr('data-scroll', scroll);
            $(document).find('.ays_pb_menu_right').attr('data-scroll', scroll);
        });
        $(document).on('click', '.ays_pb_menu_right', function(){
            var scroll = parseInt($(this).attr('data-scroll'));
            var howTranslate = $(document).find('div.ays-pb-top-tab-wrapper').width() - $(document).find('.ays-pb-top-menu').width();
            howTranslate += 7;
            if(scroll == -1){
                scroll = menuItemWidth;
            }

            scroll += menuItemWidth;
            if(scroll > howTranslate){
                scroll = Math.abs(howTranslate);
            }
            $(document).find('div.ays-pb-top-tab-wrapper').css('transform', 'translate(-'+scroll+'px)');
            $(this).attr('data-scroll', scroll);
            $(document).find('.ays_pb_menu_left').attr('data-scroll', scroll);
        });

        $(document).on('click', '.ays_pb_title', function(){
            var _this = $(this);

            if(_this.prop('checked')){
               $(document).find('.ays-pb-title-shadow-small-hint').css('display', 'none');
            }else{
                $(document).find('.ays-pb-title-shadow-small-hint').css('display', 'block');
            }
        });

        $(document).find('.ays_pb_aysDropdown').aysDropdown();
        $(document).find('[data-toggle="dropdown"]').dropdown();

        $(document).on('change', '#ays-pb-onoffoverlay', function(){
            var checked = $(this).prop('checked');

            if( checked ){
                $(document).find('.ays-pb-blured-overlay').css( 'display', 'flex' ); 
                $(document).find('.ays-pb-blured-overlay').prev('hr').css( 'display', 'flex' ); 
            }else{
                $(document).find('.ays-pb-blured-overlay').css( 'display', 'none' );
                $(document).find('.ays-pb-blured-overlay').prev('hr').css( 'display', 'none' ); 
            }
        });

        $(document).on('change', "#ays-pb-action_button_type", function(){
            var thisVal = $(this).val();
            var showPopupTriggersTooltip = {
                'pageLoaded':'On page load - Trigger displays the popup automatically on the page load. Define the time delay of the popup in Open Delay option.',
                'clickSelector':'On click - Trigger displays a popup on your site when the user clicks on a targeted CSS element(s). Define the CSS element in the CSS selector(s) option.',
                'both':'Both (On page load & On click) - Popup will be shown both on page load and click.',
            }

            // $(document).find('.ays-pb-triggers-tooltip').attr('title', showPopupTriggersTooltip[thisVal]);
            $(document).find('.ays-pb-triggers-tooltip').attr('data-original-title', showPopupTriggersTooltip[thisVal]);

            if( thisVal == 'clickSelector' || thisVal == 'both'){
                $(document).find('.ays-pb-open-click-hover').show(250);
                $(document).find('.ays-pb-open-click-hover').css( 'display', 'flex' );
                $(document).find('.ays-pb-open-click-hover').prev('hr').css( 'display', 'block' );
            }
            else{
                $(document).find('.ays-pb-open-click-hover').hide(250);
                $(document).find('.ays-pb-open-click-hover').prev('hr').css( 'display', 'none' );
            }
        });

        $(document).on('click', '.ays-pb-reset-styles', function(){
            var defaultValues = {
                'template'      : 'default',
                'displayTitle'  : false,
                'displayDesc'   : false,
                'width'         : '400',
                'percentPixel'  : 'px',
                'mobileWidth'   : '',
                'maxWidthMobile': '',
                'height'        : '500',
                'mobileHeight'  : '',
                'popupMinHeight': '',
                'fullScreen'    : false,
                'textColor'     : '#000',
                'fontFamily'    : 'inherit',
                'descPC'        : '13',
                'descMobile'    : '13',
                'textShadow'    : false,
                'textShColor'   : 'rgba(255,255,255,0)',
                'textShX'       : '2',
                'textShY'       : '2',
                'textShZ'       : '0',
                'openAnimSpeed' : '1',
                'closeAnimSpeed': '1',
                'closeAnim'     : 'fadeOut',
                'openAnim'      : 'fadeIn',
                'bgColor'       : '#fff',
                'bgImg'         : '',
                'bgImgSizing'   : 'cover',
                'bgGrad'        : false,
                'bgGradC1'      : '#000',
                'bgGradC2'      : '#fff',
                'bgGradDir'     : 'vertical',
                'headerBgColor' : '#fff',
                'overlayColor'  : '#000',
                'borderWidth'   : '1',
                'borderStyle'   : 'Solid',
                'closeBtnImg'   : '',
                'closeBtnColor' : '#000',
                'closeBtnColorHover': '#000',
                'closeBtnSize'  : '1',
                'boxShadow'     : false,
                'boxShadowColor': '#000',
                'boxShadowX'    : '0',
                'boxShadowY'    : '0',
                'boxShadowZ'    : '15',
                'bgImgStleOnMobile' : true,
                'bgImgPosition' : 'center-center',
            }       
            
            $(this).parents('form#ays_pb_form').find('label.ays-pb-template-checkbox-container input[value=default]').prop('checked',true);
            $(this).parents('form#ays_pb_form').find('input.ays_pb_title').prop('checked', defaultValues.displayTitle);

            $(this).parents('form#ays_pb_form').find('input.ays_pb_desc').prop('checked', defaultValues.displayDesc);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-width').val(defaultValues.width);
            $(this).parents('form#ays_pb_form').find('input#ays-pb-width').prop('readonly', false);

            $(this).parents('form#ays_pb_form').find('select#ays_popup_width_by_percentage_px').val(defaultValues.percentPixel);
            $(this).parents('form#ays_pb_form').find('select#ays_popup_width_by_percentage_px').parent('div.ays_pb_aysDropdown').find('div.text').text(defaultValues.percentPixel);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-mobile-width').val(defaultValues.mobileWidth);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-mobile-max-width').val(defaultValues.maxWidthMobile);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-height').val(defaultValues.height);
            $(this).parents('form#ays_pb_form').find('input#ays-pb-height').prop('readonly', false);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_mobile_height').val(defaultValues.mobileHeight);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_min_height').val(defaultValues.popupMinHeight);

            $(this).parents('form#ays_pb_form').find('input#open_pb_fullscreen').prop('checked', defaultValues.fullScreen);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-ays_pb_textcolor').wpColorPicker('color', defaultValues.textColor);

            $(this).parents('form#ays_pb_form').find('select#ays_pb_font_family').val(defaultValues.fontFamily);
            $(this).parents('form#ays_pb_form').find('select#ays_pb_font_family').parent('div.ays_pb_aysDropdown').find('div.text').text(defaultValues.fontFamily);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_font_size_for_pc').val(defaultValues.descPC);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_font_size_for_mobile').val(defaultValues.descMobile);

            $(this).parents('form#ays_pb_form').find('input#ays_enable_title_text_shadow').prop('checked', defaultValues.textShadow);

            $(this).parents('form#ays_pb_form').find('div.ays-pb-title-shadow').css('display', 'none');

            $(this).parents('form#ays_pb_form').find('input#ays_title_text_shadow_color').wpColorPicker('color', defaultValues.textShColor);

            $(this).parents('form#ays_pb_form').find('input#ays_ays_pb_title_text_shadow_x_offset').val(defaultValues.textShX);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_title_text_shadow_y_offset').val(defaultValues.textShY);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_title_text_shadow_z_offset').val(defaultValues.textShZ);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_animation_speed').val(defaultValues.openAnimSpeed);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_close_animation_speed').val(defaultValues.closeAnimSpeed);

            $(this).parents('form#ays_pb_form').find('select#ays-pb-animate_out').val(defaultValues.closeAnim);
            $(this).parents('form#ays_pb_form').find('select#ays-pb-animate_out').parent('div.ays_pb_aysDropdown').find('div.text').text(defaultValues.closeAnim);

            $(this).parents('form#ays_pb_form').find('select#ays-pb-animate_in').val(defaultValues.openAnim);
            $(this).parents('form#ays_pb_form').find('select#ays-pb-animate_in').parent('div.ays_pb_aysDropdown').find('div.text').text(defaultValues.openAnim);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-bgcolor').wpColorPicker('color', defaultValues.bgColor);
            
            $(this).parents('form#ays_pb_form').find('img#ays-pb-bg-img').attr('src', '');
            $(this).parents('form#ays_pb_form').find('input#ays-pb-bg-image').val('');
            $(this).parents('form#ays_pb_form').find('a#ays-pb-add-bg-image').text('Add Image');
            $(this).parents('form#ays_pb_form').find('span.ays-remove-bg-img').css('display', 'none');

            $(this).parents('form#ays_pb_form').find('.pb_position_block').find('.ays-pb-position-val-class').val(defaultValues.bgImgPosition);
            $(document).find('table#ays_pb_bg_image_position_table td').removeAttr('style');
            $(document).find('table#ays_pb_bg_image_position_table tr td[data-id=5]').css('background-color','#a2d6e7');

            $(this).parents('form#ays_pb_form').find('select#ays_pb_bg_image_sizing').val(defaultValues.bgImgSizing);
            $(this).parents('form#ays_pb_form').find('select#ays_pb_bg_image_sizing').parent('div.ays_pb_aysDropdown').find('div.text').text(defaultValues.bgImgSizing);

            $(this).parents('form#ays_pb_form').find('input#ays-enable-background-gradient').prop('checked', defaultValues.bgGrad);
            $(this).parents('form#ays_pb_form').find('div.ayspb-enable-background-gradient').css('display', 'none');

            $(this).parents('form#ays_pb_form').find('input#ays-background-gradient-color-1').wpColorPicker('color', defaultValues.bgGradC1);

            $(this).parents('form#ays_pb_form').find('input#ays-background-gradient-color-2').wpColorPicker('color', defaultValues.bgGradC2);

            $(this).parents('form#ays_pb_form').find('select#ays_pb_gradient_direction').val(defaultValues.bgGradDir);
            $(this).parents('form#ays_pb_form').find('select#ays_pb_gradient_direction').parent('div.ays_pb_aysDropdown').find('div.text').text(defaultValues.bgGradDir);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-header_bgcolor').wpColorPicker('color', defaultValues.headerBgColor);

            $(this).parents('form#ays_pb_form').find('input.ays_pb_overlay_color_change').wpColorPicker('color', defaultValues.overlayColor);

            $(this).parents('form#ays_pb_form').find('input#ays-pb-ays_pb_bordersize').val(defaultValues.borderWidth);

            $(this).parents('form#ays_pb_form').find('select#ays_pb_border_style').val(defaultValues.borderStyle);
            $(this).parents('form#ays_pb_form').find('select#ays_pb_border_style').parent('div.ays_pb_aysDropdown').find('div.text').text(defaultValues.borderStyle);
            
            $(this).parents('form#ays_pb_form').find('input#ays-pb-ays_pb_bordercolor').wpColorPicker('color', '#fff');

            $(this).parents('form#ays_pb_form').find('input#ays-pb-ays_pb_border_radius').val('1');

            $(this).parents('form#ays_pb_form').find('img#ays_close_btn_bg_img').attr('src', '');
            $(this).parents('form#ays_pb_form').find('input#close_btn_bg_img').val('');
            $(this).parents('form#ays_pb_form').find('a.ays_pb_add_close_btn_bg_image').text('Add Image');
            $(this).parents('form#ays_pb_form').find('div.ays_pb_close_btn_bg_img span.ays_remove_bg_img').css('display', 'none');

            $(this).parents('form#ays_pb_form').find('input#ays_pb_close_button_color').wpColorPicker('color', defaultValues.closeBtnColor);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_close_button_hover_color').wpColorPicker('color', defaultValues.closeBtnColorHover);

            $(this).parents('form#ays_pb_form').find('#ays_pb_close_button_size').val(defaultValues.closeBtnSize);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_enable_box_shadow').prop( 'checked', defaultValues.boxShadow);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_box_shadow_color').wpColorPicker('color', defaultValues.boxShadowColor);

            $(this).parents('form#ays_pb_form').find('div.ays-pb-box-shadow').css('display', 'none');

            $(this).parents('form#ays_pb_form').find('input#ays_pb_box_shadow_x_offset').val(defaultValues.boxShadowX);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_box_shadow_y_offset').val(defaultValues.boxShadowY);

            $(this).parents('form#ays_pb_form').find('input#ays_pb_box_shadow_z_offset').val(defaultValues.boxShadowZ);

            $(this).parents('form#ays_pb_form').find('#ays_pb_bg_image_direction_on_mobile').prop('checked', defaultValues.bgImgStleOnMobile);

            $(this).parents('form#ays_pb_form').find('div.ays_bg_image_box').css( {'background-size': defaultValues.bgImgSizing});
            $(this).parents('form#ays_pb_form').find('div.ays-pb-live-container').css( {'font-family': defaultValues.fontFamily});
        });
    });
    $(document).on('click', 'a.ays-pb-add-bg-image', function (e) {
        openMediaUploaderBg(e, $(this));
    });
    $(document).on('click', 'a.ays_pb_add_close_btn_bg_image', function (e) {
        openMediaUploaderCloseBtn(e, $(this));
    });

    $(document).on('change', '.ays_toggle_checkbox', function (e) {
        let state = $(this).prop('checked');
        let parent = $(this).parents('.ays_toggle_parent');

        if($(this).hasClass('ays_toggle_slide')){
            switch (state) {
                case true:
                    parent.find('.ays_toggle_target').slideDown(250);
                    break;
                case false:
                    parent.find('.ays_toggle_target').slideUp(250);
                    break;
            }
        }else{
            switch (state) {
                case true:
                    parent.find('.ays_toggle_target').show(250);
                    break;
                case false:
                    parent.find('.ays_toggle_target').hide(250);
                    break;
            }
        }
    });

    $(document).keydown(function(event) {
        var editButton = $(document).find("input#ays-button-top-apply , input#ays-cat-button-apply , input#ays-button-apply, input#ays_submit_settings");
        if (!(event.which == 83 && event.ctrlKey) && !(event.which == 19)){
            return true;  
        }
        editButton.trigger("click");
        event.preventDefault();
        return false;
    });

    

    function openMediaUploaderBg(e, element) {
        e.preventDefault();
        let aysUploader = wp.media({
            title: 'Upload',
            button: {
                text: 'Upload'
            },
            library: {
                type: 'image'
            },
            multiple: false
        }).on('select', function () {
            let attachment = aysUploader.state().get('selection').first().toJSON();
            element.text(pb.editImage);
            element.attr('data-add', true);
            $('.ays-pb-bg-image-container').parent().fadeIn();
            $('.ays-pb-bg-image-container').parents("#ays-popup-box-background-image").fadeIn();
            $('img#ays-pb-bg-img').attr('src', attachment.url);
            $('input#ays-pb-bg-image').val(attachment.url);
            $('.box-apm').css('background-image', `url('${attachment.url}')`);
            $('.ays_bg_image_box').css({
                'background-image' : `url('${attachment.url} ')`,
                'background-repeat' : 'no-repeat',
                'background-size' : 'cover',
            });
            ////
        }).open();
        return false;
    }
    function openMediaUploaderCloseBtn(e, element) {
        e.preventDefault();
        let aysUploader = wp.media({
            title: 'Upload',
            button: {
                text: 'Upload'
            },
            library: {
                type: 'image'
            },
            multiple: false
        }).on('select', function () {
            let attachment = aysUploader.state().get('selection').first().toJSON();
            
            element.text(pb.editImage);
            
            $('.ays_pb_close_btn_bg_img').parent().fadeIn();
            $('img#ays_close_btn_bg_img').attr('src', attachment.url);
            $('input#close_btn_bg_img').val(attachment.url);
            
            $('img.close_btn_img').attr('src', attachment.url);
            $(document).find('img.close_btn_img').css('display','block');

            $(document).find('label.close_btn_label > .close_btn_text').css('display','none');

            ////
        }).open();
        return false;
    }

    function openMediaUploaderVideo(e, element) {
        e.preventDefault();
        let aysUploader = wp.media({
            title: 'Upload',
            button: {
                text: 'Upload'
            },
            library: {
                type: 'video'
            },
            multiple: false
        }).on('select', function () {
            let attachment = aysUploader.state().get('selection').first().toJSON();
            element.text('Edit Video');
            $('.ays-pb-bg-video-container').parent().fadeIn();
            $('video#ays_pb_video_theme_video').attr('src', attachment.url);
            $('input#ays_pb_video_theme').val(attachment.url);
            $(document).find('video.video_theme').attr('src',attachment.url);
            ////
        }).open();
        return false;
    }

    function goToPro() {
        window.open(
            'https://ays-pro.com/wordpress/popup-box',
            '_blank'
        );
        return false;
    }

    function searchForPage(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }
        var searchText = data.text.toLowerCase();
        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (searchText.indexOf(params.term) > -1) {
          var modifiedData = $.extend({}, data, true);
          modifiedData.text += ' (matched)';

          // You can return modified objects from here
          // This includes matching the `children` how you want in nested data sets
          return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    // Delete confirmation
    $(document).on('click', '.ays_pb_confirm_del', function(e){            
        e.preventDefault();
        var message = $(this).data('message');
        var confirm = window.confirm('Are you sure you want to delete '+message+'?');
        if(confirm === true){
            window.location.replace($(this).attr('href'));
        }
    });

    // Submit buttons disableing with loader
    var subButtons = '.button#ays-button-top,.button#ays-button-top-apply,.button#ays-button,.button#ays-button-apply,.button#ays_submit_settings';
    $(document).on('click', subButtons ,function () {     
        var $this = $(this);
        submitOnce($this);
    });
    $(document).on("click" ,".button#ays-cat-button-apply", function(){
        var catTitle = $(document).find("#ays-title").val();
        if(catTitle != ''){
            var $this = $(this);
            subButtons += ',.button#ays-cat-button-apply';
            submitOnce($this);
        }
    });
    function submitOnce(subButton){
        var subLoader = subButton.siblings(".display_none");
        subLoader.removeClass("display_none");
        subLoader.css("padding-left" , "8px");
        subLoader.css("display" , "inline-flex");
        setTimeout(function() {
            $(subButtons).attr('disabled', true);
        }, 50);
        setTimeout(function() {
            $(subButtons).attr('disabled', false);
            subLoader.addClass("display_none");
        }, 5000);
    }

    $(document).on('click', '#ays-popups-next-button, #ays-popups-prev-button, .ays-pb-next-prev-button-class', function(e){
        e.preventDefault();
        var message = $(this).data('message');
        var confirm = window.confirm( message );
        if(confirm === true){
            window.location.replace($(this).attr('href'));
        }
    });

})( jQuery );
