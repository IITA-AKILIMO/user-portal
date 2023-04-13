(function( $ ) {
	'use strict';

	/**
	 * Vars
	 */
	window.ayg_is_ready = false;
	
	/**
	 * Init Automatic YouTube Gallery. Called when YouTube API is ready.
	 *
	 * @since 2.0.0
	 */
	function ayg_init() {
		if ( true == window.ayg_is_ready ) {
			return false;
		}

		window.ayg_is_ready = true;
		$( document ).trigger( 'ayg.ready' );
		
		// Classic Theme
		$( '.ayg-theme-classic' ).each(function() {
			init_classic_theme( $( this ) );
		});	
		
		// Single Video
		$( '.ayg-theme-single' ).each(function() {
			init_single_video( $( this ) );
		});

		// Livestream
		$( '.ayg-theme-livestream' ).each(function() {
			init_livestream( $( this ) );
		});

		// Pagination
		$( '.ayg-pagination' ).each(function() {
			init_pagination( $( this ) );
		});
	}

	/**
	 * Init Classic Theme.
	 *
	 * @since 2.0.0
	 */
	function init_classic_theme( $root ) {
		$root.addClass( 'ayg-theme-initialized' );

		var params        = $root.data( 'params' );
		var uid	          = params.uid;			
		var $current_item = $( '.ayg-item', '#ayg-' + uid ).eq(0);
		var $next_button  = $( '.ayg-pagination-next-btn', '#ayg-' + uid );
		var next_type     = $next_button.data( 'type' );	
		var player_id     = 'ayg-player-' + uid;

		// Player
		var player = ayg_init_player( player_id, {			
			custom: {
				params: params,
				image: $current_item.find( '.ayg-thumbnail-image' ).attr( 'src' )
			},
			events: {
				'onStateChange': function( e ) {
					if ( e.data == YT.PlayerState.ENDED ) {
						if ( 1 == params.autoadvance ) {
							player.stop();

							if ( $current_item.is( ':last-child' ) ) {
								if ( 'more' == next_type ) {
									if ( 1 == params.loop ) {
										$( '.ayg-item', '#ayg-' + uid ).eq(0).trigger( 'click' );
									}
								} else {
									// Load Next Page
									if ( $next_button.is( ':visible' ) ) {					
										$next_button.trigger( 'click' );

										var __interval = setInterval(
											function() {												
												if ( $( '.ayg-pagination.ayg-loading', '#ayg-' + uid ).length == 0 ) {
													clearInterval( __interval );
													$( '.ayg-item', '#ayg-' + uid ).eq(0).trigger( 'click' );
												}												
											}, 
											1000
										);									
									}									
								}
							} else {
								$current_item.next( '.ayg-item' ).trigger( 'click' );
							}
						} else {
							if ( 1 == params.loop ) {
								player.play();
							} else {
								player.stop();
							}
						}
					}				 
				}
			}
		});

		// Grid: On thumbnail clicked
		$( '#ayg-' + uid ).on( 'click', '.ayg-item:not(.ayg-active)', function() {
			$current_item = $( this );

			$( '.ayg-active', '#ayg-' + uid ).removeClass( 'ayg-active' );			
			$current_item.addClass( 'ayg-active' );

			// Change video
			player.change({
				id: $current_item.find( '.ayg-thumbnail' ).data( 'id' ),
				image: $current_item.find( '.ayg-thumbnail-image' ).attr( 'src' )
			});
			
			if ( 1 == params.player_title ) {
				var title = $current_item.find( '.ayg-thumbnail' ).data( 'title' );				
				$( '.ayg-player-title', '#ayg-' + uid ).html( title );
			}

			if ( 1 == params.player_description ) {
				var description = $current_item.find( '.ayg-thumbnail-description' ).html();
				$( '.ayg-player-description', '#ayg-' + uid ).html( description );
			}
			
			// Scroll to Top
			$( 'html, body' ).animate({
				scrollTop: $root.offset().top - ayg_public.top_offset
			}, 500, function() {
				// Change URL in Browser Address Bar
				var url = $current_item.find( '.ayg-thumbnail' ).data( 'url' );
				if ( '' != url ) {
					window.history.replaceState( null, null, url );
				}				
			});	
			
			// Load Next Page
			if ( 1 == params.autoadvance && 'more' == next_type ) {
				if ( $current_item.is( ':last-child' ) && $next_button.is( ':visible' ) ) {					
					$next_button.trigger( 'click' );
				}
			}
		});
	}

	/**
	 * Init Single Video.
	 *
	 * @since 2.0.0
	 */
	function init_single_video( $root ) {
		$root.addClass( 'ayg-theme-initialized' );
		
		var params    = $root.data( 'params' );
		var uid	      = params.uid;		
		var player_id = 'ayg-player-' + uid;	

		// Player
		var player = ayg_init_player( player_id, {			
			custom: {
				params: params,
				image: $( '#' + player_id ).data( 'image' )
			},
			events: {
				'onStateChange': function( e ) {
					if ( e.data == YT.PlayerState.ENDED ) {
						if ( 1 == params.loop ) {
							player.play();
						}
					}				 
				}
			}
		});		
	}

	/**
	 * Init Livestream.
	 *
	 * @since 2.0.0
	 */
	function init_livestream( $root ) {
		$root.addClass( 'ayg-theme-initialized' );
		
		var params    = $root.data( 'params' );
		var uid	      = params.uid;		
		var player_id = 'ayg-player-' + uid;	

		// Player
		var player = ayg_init_player( player_id, {			
			custom: {
				params: params,
				image: 'none'
			},
			events: {
				'onReady': function( e ) {
					var url = e.target.getVideoUrl();

					if ( url == 'https://www.youtube.com/watch?v=live_stream' ) {
						$( '.ayg-player-wrapper', '#ayg-' + uid ).fadeOut( 'fast', function() {
							$( '.ayg-fallback-message', '#ayg-' + uid ).fadeIn();
						});															
					} else {
						$( '#ayg-player-' + uid ).show();
					}
				},
				'onStateChange': function( e ) {
					if ( e.data == YT.PlayerState.ENDED ) {
						player.stop();
					}				 
				}
			}
		});		
	}

	/**
	 * Init Pagination.
	 *
	 * @since 2.0.0
	 */
	function init_pagination( $pagination ) {
		var params = $pagination.data( 'params' );
		params.action   = 'ayg_load_more_videos';
		params.security = ayg_public.ajax_nonce;

		var uid = params.uid;
		var $gallery = $( '.ayg-gallery', '#ayg-' + uid );

		// On button clicked
		$( '.ayg-btn', '#ayg-' + uid ).on( 'click', function() {
			$pagination.addClass( 'ayg-loading' );	
			
			var $this = $( this );
			var type  = $this.data( 'type' );
			params.pageToken = ( 'previous' == type ) ? params.prev_page_token : params.next_page_token;

			$.post( ayg_public.ajax_url, params, function( response ) {
				if ( response.success ) {
					var total_pages = parseInt( params.total_pages );

					if ( response.data.next_page_token ) {
						params.next_page_token = response.data.next_page_token;
					} else {
						params.next_page_token = '';
					}

					if ( response.data.prev_page_token ) {
						params.prev_page_token = response.data.prev_page_token;
					} else {
						params.prev_page_token = '';
					}

					switch ( type ) {
						case 'more':
							params.paged = Math.min( parseInt( params.paged ) + 1, total_pages );							

							if ( params.paged == total_pages ) {
								params.next_page_token = '';
								$this.hide();
							}

							$gallery.append( response.data.html );
							break;						
						case 'next':							
							params.paged = Math.min( parseInt( params.paged ) + 1, total_pages );	

							if ( params.paged == total_pages ) {
								params.next_page_token = '';
								$this.hide();
							}

							$( '.ayg-pagination-prev-btn', '#ayg-' + uid ).show();
							$( '.ayg-pagination-current-page-number', '#ayg-' + uid ).html( params.paged );		

							$gallery.html( response.data.html );
							break;
						case 'previous':
							params.paged = Math.max( parseInt( params.paged ) - 1, 1 );

							if ( 1 == params.paged ) {
								params.prev_page_token = '';
								$this.hide();
							}

							$( '.ayg-pagination-next-btn', '#ayg-' + uid ).show();
							$( '.ayg-pagination-current-page-number', '#ayg-' + uid ).html( params.paged );			

							$gallery.html( response.data.html );
							break;
					}

					$pagination.removeClass( 'ayg-loading' );
				} else {
					$pagination.removeClass( 'ayg-loading' ).hide();
				}
			});
		});
	}

	/**
	 * Init AYGPlayer.
	 *
	 * @since 2.0.0
	 */
	var ayg_init_player = function ( player_id, args ) {
		var player = null;	
		var $player_wrapper = $( '#' +  player_id ).closest( 'div' );		
		var video_id = $( '#' +  player_id ).data( 'id' );
		var params = args.custom.params;

		var init_player = function () {
			var iframe_src = 'https://www.youtube.com/embed/' + video_id + '?enablejsapi=1';
			
			if ( params.hasOwnProperty( 'is_live' ) ) {
				iframe_src = 'https://www.youtube.com/embed/live_stream?channel=' + video_id + '&enablejsapi=1';
			}

			iframe_src += '&playsinline=1';
			iframe_src += '&rel=0';

			if ( params.hasOwnProperty( 'autoplay' ) ) {
				iframe_src += ( '&autoplay=' + parseInt( params.autoplay ) );
			}
		
			if ( params.hasOwnProperty( 'controls' ) ) {
				iframe_src += ( '&controls=' + parseInt( params.controls ) );
			}
		
			if ( params.hasOwnProperty( 'modestbranding' ) ) {
				iframe_src += ( '&modestbranding=' + parseInt( params.modestbranding ) );
			}
		
			if ( params.hasOwnProperty( 'cc_load_policy' ) ) {
				iframe_src += ( '&cc_load_policy=' + parseInt( params.cc_load_policy ) );
			}
		
			if ( params.hasOwnProperty( 'iv_load_policy' ) ) {
				iframe_src += ( '&iv_load_policy=' + parseInt( params.iv_load_policy ) );
			}
		
			if ( params.hasOwnProperty( 'hl' ) ) {
				iframe_src += ( '&hl=' + params.hl );
			}
		
			if ( params.hasOwnProperty( 'cc_lang_pref' ) ) {
				iframe_src += ( '&cc_lang_pref=' + params.cc_lang_pref );
			}

			if ( $( '#' +  player_id ).prop( 'tagName' ).toLowerCase() == 'iframe' ) {
				$( '#' +  player_id ).attr( 'src', iframe_src );	
			} else {
				$( '#' +  player_id ).replaceWith( '<iframe id="' + player_id + '" class="ayg-player-iframe" width="100%" height="100%" src="' + iframe_src + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' );
			}					

			player = new YT.Player( player_id, { events: args.events } );
		}	

		if ( 1 == ayg_public.cookie_consent ) {
			var html = '<div class="ayg-privacy-wrapper" style="background-image: url(' + args.custom.image + ');">';
			html += '<div class="ayg-privacy-consent-block">';
			html += '<div class="ayg-privacy-consent-message">' + ayg_public.consent_message + '</div>';
			html += '<div class="ayg-privacy-consent-button">' + ayg_public.button_label + '</div>';
			html += '</div>';
			html += '</div>';

			$player_wrapper.append( html );

			$player_wrapper.find( '.ayg-privacy-consent-button' ).on( 'click', function() {
				$( this ).html( '...' );

				var data = {
					'action': 'ayg_set_cookie',
					'security': ayg_public.ajax_nonce
				};
	
				$.post( 
					ayg_public.ajax_url, 
					data, 
					function( response ) {
						if ( response.success ) {
							ayg_public.cookie_consent = 0;

							params.autoplay = 1;
							init_player();

							$player_wrapper.find( '.ayg-privacy-wrapper' ).remove();
						}
					}
				);
			});
		} else {
			init_player();
		}	
		
		return {
			play: function() {
				if ( player && player.playVideo ) {
					player.playVideo();
				}
			},
			change: function( obj ) {
				if ( player && player.loadVideoById ) {
					player.loadVideoById( obj.id );
				} else {
					video_id = obj.id;

					if ( 1 == ayg_public.cookie_consent ) {
						$player_wrapper.find( '.ayg-privacy-wrapper' ).css( 'background-image', "url(" + obj.image + ")" );
					}
				}
			},
			stop: function() {
				if ( player && player.stopVideo ) {
					player.stopVideo();
				}
			},
			destroy: function() {
				if ( player ) {
					if ( player.stopVideo ) {
						player.stopVideo();
					}

					if ( player.destroy ) {
						player.destroy();
					}
				} else {
					$( '#' +  player_id ).remove();
				}

				if ( 1 == ayg_public.cookie_consent ) {
					$player_wrapper.find( '.ayg-privacy-wrapper' ).remove();
				}
			}
		};
	}

	window.ayg_init_player = ayg_init_player;

	/**
	 * Called when the page has loaded.
	 *
	 * @since 1.0.0
	 */
	$(function() {
		// Init Automatic YouTube Gallery
		if ( 'undefined' === typeof window['YT'] ) {
			var tag = document.createElement( 'script' );
			tag.src = "https://www.youtube.com/iframe_api";
			var first_script_tag = document.getElementsByTagName( 'script' )[0];
			first_script_tag.parentNode.insertBefore( tag, first_script_tag );		
		}
		
		if ( 'undefined' == typeof window.onYouTubeIframeAPIReady ) {
			window.onYouTubeIframeAPIReady = function() {
				ayg_init();
			};
		} else if ( 'undefined' !== typeof window.YT ) {
			ayg_init();
		}
		
		var interval = setInterval(
			function() {
				if ( 'undefined' !== typeof window.YT && window.YT.loaded )	{
					clearInterval( interval );
					ayg_init();					
				}
			}, 
			10
		);

		// Locate gallery element on single video pages
		var gallery_id = ayg_public.gallery_id;
		if ( gallery_id != '' && $( '#ayg-' + gallery_id ).length ) {
			if ( history.scrollRestoration ) {
				history.scrollRestoration = 'manual';
			} else {
				window.onbeforeunload = function () {
					window.scrollTo( 0, 0 );
				}
			}
			
			$( 'html, body' ).animate({
				scrollTop: $( '#ayg-' + gallery_id ).offset().top - ayg_public.top_offset
			}, 500);	
		}

		// Toggle more/less content in the player description
		$( document ).on( 'click', '.ayg-player-description-toggle-btn', function( event ) {
			event.preventDefault();

			var $this = $( this);
			var $description = $this.closest( '.ayg-player-description' );
			var $dots = $description.find( '.ayg-player-description-dots' );
			var $more = $description.find( '.ayg-player-description-more' );

			if ( $dots.is( ':visible' ) ) {
				$this.html( ayg_public.i18n.show_less );
				$dots.hide();
				$more.fadeIn();									
			} else {					
				$more.fadeOut(function() {
					$this.html( ayg_public.i18n.show_more );
					$dots.show();					
				});								
			}	
		});

		// Gutenberg: On block init
		if ( 'undefined' !== typeof wp && 'undefined' !== typeof wp['hooks'] ) {
			var ayg_block_interval;
			var ayg_block_interval_retry_count;

			wp.hooks.addFilter( 'ayg_block_init', 'automatic-youtube-gallery/block', function( attributes ) {
				if ( 'livestream' == attributes.type ) {
					if ( ayg_block_interval_retry_count > 0 ) {
						clearInterval( ayg_block_interval );
					}

					ayg_block_interval_retry_count = 0;

					ayg_block_interval = setInterval(
						function() {
							ayg_block_interval_retry_count++;
							var $players = $( '.ayg-theme-livestream:not(.ayg-theme-initialized)' );

							if ( $players.length > 0 || ayg_block_interval_retry_count >= 10 ) {
								clearInterval( ayg_block_interval );
								ayg_block_interval_retry_count = 0;

								$players.each(function() {
									init_livestream( $( this ) );	
								});
							}
						}, 
						1000
					);
				}

				return attributes;
			});
		}
	});

})( jQuery );