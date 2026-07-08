(function( $ ) {
    'use strict';

    const AYGPlayerTemplate = document.createElement( 'template' );

    AYGPlayerTemplate.innerHTML = `
        <style>
            :host {                             
                display: block;  
                width: 100%;      
                contain: content;
            }

            :host([hidden]) {
                display: none;
            }

            :host([ratio="auto"]) {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
            }

            #root {
                display: block;
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                cursor: pointer;
                line-height: 1.5;
                font-size: 16px;
            }

            :host([ratio="auto"]) #root {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
            }

            :host:not([ratio="auto"]) #root {      
                position: relative;
                padding-bottom: 56.25%;
                width: 100%;
                height: 0;
            }
        
            iframe {
                position: absolute;
                inset: 0;
                z-index: 1;
                border: 0;
                width: 100%;
                height: 100%;                   
            }        

            #play-button {
                display: block;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate3d(-50%, -50%, 0); 
                transition: all 0.2s cubic-bezier(0, 0, 0.2, 1); 
                z-index: 1;
                border: 0;        
                background: center/72px 48px no-repeat url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 72 48'%3E%3Cpath fill='%23f00' fill-opacity='.9' d='M66.5 7.7c-.8-2.9-2.5-5.4-5.4-6.2C55.8.1 34 0 34 0S12.2.1 6.9 1.6c-3 .7-4.6 3.2-5.4 6.1a89.6 89.6 0 000 32.5c.8 3 2.5 5.5 5.4 6.3C12.2 47.9 34 48 34 48s21.8-.1 27.1-1.6c3-.7 4.6-3.2 5.4-6.1C68 35 68 24 68 24s0-11-1.5-16.3z'/%3E%3Cpath fill='%23fff' d='M45 24L27 14v20'/%3E%3C/svg%3E");
                cursor: pointer;
                width: 72px;
                height: 48px;
                filter: grayscale(1);   
            }       
            
            #root:hover > #play-button,
            #play-button:focus {
                filter: none;
            }

            /* Cookie consent */
            #cookieconsent-modal {  
                box-sizing: border-box;
                display: none;
                position: absolute; 
                top: 50%;
                left: 50%;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 0.75em;  
                transform: translate3d(-50%, -50%, 0);
                z-index: 1;
                border-radius: 3px; 
                background: rgba(0, 0, 0, 0.7);
                padding: 1em;
                width: 90%;
                max-width: 640px;            
                color: #fff;
            }
            
            #cookieconsent-button {
                display: block;
                margin: 0;
                border: 0;
                border-radius: 3px;  
                background: #e70808;
                cursor: pointer; 
                padding: 0.5em 1em;   
                color: #fff; 
            }

            #cookieconsent-button:hover,
            #cookieconsent-button:focus {
                background: #fff;
                color: #333;
            }

            #root.cookieconsent {
                cursor: unset;
            }

            #root.cookieconsent > #play-button {
                display: none;
            }

            #root.cookieconsent > #cookieconsent-modal {
                display: flex;            
            }

            @media only screen and (max-width: 480px) {
                #cookieconsent-modal {
                    width: 100%;
                    height: 100%;
                    font-size: 90%;
                }
            }

            @media only screen and (max-width: 320px) {
                #cookieconsent-modal {
                    gap: 0.5em;
                }

                #cookieconsent-button {
                    border-radius: 2px;  
                    padding: 0.35em 0.75em;   
                }
            }

            /* Post-click styles */
            #root.initialized {
                cursor: unset;
            }

            #root.initialized > #play-button,
            #root.initialized > #cookieconsent-modal {            
                display: none;
            }

            /* Plyr styles */
            #root .plyr {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
            }            

            #root .plyr__control--overlaid {
                --plyr-control-spacing: 15px;
            }

            #root .plyr__control--overlaid svg {
                --plyr-control-icon-size: 27px;
            }

            #root .plyr--youtube-no-logo iframe {
                top: -50%;
                height: 200%;
            }

            #root .plyr--initialized.plyr--no-controls .plyr__control--overlaid {
                display: none;
            }

            #root .plyr--initialized iframe {
                pointer-events: none;
            }
        </style>
        <div id="root" part="root">
            <button type="button" id="play-button" aria-label="Play Video"></button>
            <div id="cookieconsent-modal">
                <div id="cookieconsent-message">Please accept YouTube cookies to play this video. By accepting you will be accessing content from YouTube, a service provided by an external third party.</div>
                <button type="button" id="cookieconsent-button">I Agree</button>
            </div>
            <div id="player" class="plyr__video-embed"></div>
        </div>
    `;

    /**
	 * Load css files.
	 */
	const stylePromises = {};

	window.AYGLoadStyle = ( file ) => {
		if ( ! file || ! file.id ) {
			return Promise.resolve();
		}
		
		if ( stylePromises[ file.id ] ) {
			return stylePromises[ file.id ];
		}

		if ( document.getElementById( file.id ) ) {
			return Promise.resolve();
		}

		stylePromises[ file.id ] = new Promise(( resolve, reject ) => {
			const link = document.createElement( 'link' );

			link.id      = file.id;
			link.rel     = 'stylesheet';
			link.href    = file.href;
			link.onload  = resolve;
			link.onerror = reject;

			document.head.appendChild( link );
		});

		return stylePromises[ file.id ];
	};

	/**
	 * Load script files.
	 */
	const scriptPromises = {};

	window.AYGLoadScript = ( file ) => {
		if ( ! file || ! file.id ) {
			return Promise.resolve();
		}
		
		if ( scriptPromises[ file.id ] ) {
			return scriptPromises[ file.id ];
		}

		if ( document.getElementById( file.id ) ) {
			return Promise.resolve();
		}

		scriptPromises[ file.id ] = new Promise(( resolve, reject ) => {
			const script = document.createElement( 'script' );

			script.id      = file.id;
			script.src     = file.src;
			script.defer   = true;
			script.onload  = resolve;
            script.onerror = reject;

			document.body.appendChild( script );
		});

		return scriptPromises[ file.id ];
	};

    /**
     * Get player HTML.
     */
    window.getAYGPlayerHtml = ( video, params ) => {
        let siteurl = 'https://www.youtube.com';
        if ( ayg_config.privacy_enhanced_mode == 1 ) {
            siteurl = 'https://www.youtube-nocookie.com';
        }

        video.src = siteurl + '/embed/' + video.id + '?enablejsapi=1&playsinline=1&rel=0';

        if ( ayg_config.hasOwnProperty( 'origin' ) && ayg_config.origin.length > 0 ) {
            video.src += '&origin=' + ayg_config.origin;
        }

        let autoplay = params.hasOwnProperty( 'autoplay' ) ? parseInt( params.autoplay ) : 0;
        if ( autoplay == 1 ) {
            video.src += '&autoplay=1';
        }

        let muted = params.hasOwnProperty( 'muted' ) ? parseInt( params.muted ) : 0;
        if ( muted == 1 ) {
            video.src += '&mute=1';
        }

        let controls = params.hasOwnProperty( 'controls' ) ? parseInt( params.controls ) : 1;
        if ( controls == 0 ) {
            video.src += '&controls=0';
        }

        let modestbranding = params.hasOwnProperty( 'modestbranding' ) ? parseInt( params.modestbranding ) : 0;
        if ( modestbranding == 1 ) {
            video.src += '&modestbranding=1';
        }

        let cc_load_policy = params.hasOwnProperty( 'cc_load_policy' ) ? parseInt( params.cc_load_policy ) : 0;
        if ( cc_load_policy == 1 ) {
            video.src += '&cc_load_policy=1';
        }

        let iv_load_policy = params.hasOwnProperty( 'iv_load_policy' ) ? parseInt( params.iv_load_policy ) : 0;
        if ( iv_load_policy == 0 ) {
            video.src += '&iv_load_policy=3';
        }

        if ( params.hasOwnProperty( 'hl' ) && params.hl.length > 0 ) {
            video.src += '&hl=' + params.hl;
        }

        if ( params.hasOwnProperty( 'cc_lang_pref' ) && params.cc_lang_pref.length > 0 ) {
            video.src += '&cc_lang_pref=' + params.cc_lang_pref;
        }

        // Build player html
        let html = '<ayg-player class="mfp-prevent-close"';		
        html += ' title="' + video.title + '"';
        html += ' src="' + video.src + '"';		
        html += ' poster="' + video.poster + '"';
        html += ' ratio="' + video.ratio + '"';
        html += '>';
        html += '</ayg-player>';

        return html;
    }

    /**
     * Player Element.
     */
    class AYGPlayerElement extends HTMLElement {

        /**
         * Element created.
         */
        constructor() {
            super();        
            
            // Attach Shadow DOM to the component
            const shadowDom = this.attachShadow({ mode: 'open' });
            this.shadowRoot.appendChild( AYGPlayerTemplate.content.cloneNode( true ) );        

            // Set references to the DOM elements from the component's template
            this.rootEl = shadowDom.querySelector( '#root' );
            this.playButtonEl = shadowDom.querySelector( '#play-button' );
            this.cookieConsentMessageEl = shadowDom.querySelector( '#cookieconsent-message' );
            this.cookieConsentButtonEl = shadowDom.querySelector( '#cookieconsent-button' );
            this.playerEl = shadowDom.querySelector( '#player' );
            this.iframeEl = null;
            
            // Set references to the private properties used by the component
            this._isRendered = false;
            this._isCookieConsentAdded = false;
            this._isPosterImageAdded = false;
            this._isPlayerAdded = false;             
            this._forcePlayerElement = navigator.vendor.includes( 'Apple' ) || navigator.userAgent.includes( 'Mobi' ); 
            this._intersectionObserver = null;
            this._isInViewport = false;
            this._hasPlayerControls = true;
            this._hasAutoplayRequested = false;
            this._hasMuted = false;
            this._hasYTApiEnabled = false;
            this._hideYouTubeLogo = false;
            this._playerApi = null;
            this._playerType = ayg_config.player_type;
            this._playerColor = ayg_config.player_color;
            this._pendingPlay = false;
            this._hasCookieConsent = parseInt( ayg_config.cookieconsent ) == 1 ? true : false;
            this._cookieConsentMessage = ayg_config.cookieconsent_message || '';
            this._cookieConsentButtonLabel = ayg_config.cookieconsent_button_label || '';
            this._ajaxUrl = ayg_config.ajax_url;
            this._ajaxNonce = ayg_config.ajax_nonce;
        }

        /**
         * Browser calls this method when the element is added to the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        connectedCallback() { 
            if ( ! this.src ) return false;       

            const url   = new URL( this.src );
            const query = new URLSearchParams( url.search ); 

            this._hasPlayerControls = ! ( query.has( 'controls' ) && ( query.get( 'controls' ) == 0 || query.get( 'controls' ) == false ) );    
            this._hasAutoplayRequested = query.has( 'autoplay' ) && ( query.get( 'autoplay' ) == 1 || query.get( 'autoplay' ) == true );    
            this._hasMuted = query.has( 'mute' ) && ( query.get( 'mute' ) == 1 || query.get( 'mute' ) == true );
            this._hasYTApiEnabled = query.has( 'enablejsapi' ) && ( query.get( 'enablejsapi' ) == 1 || query.get( 'enablejsapi' ) == true );  
            this._hideYouTubeLogo = query.has( 'modestbranding' ) && ( query.get( 'modestbranding' ) == 1 || query.get( 'modestbranding' ) == true );    
            
            if ( this._playerType == 'custom' ) {
                this._forcePlayerElement = true;
            } 

            if ( ! this.lazyLoad ) {
                this._forcePlayerElement = true;
            }
            
            if ( ! this.poster ) {
                this._forcePlayerElement = true;
            }

            if ( this._hasAutoplayRequested ) {
                this._forcePlayerElement = true;
            }        
        
            this._render();

            this.addEventListener( 'pointerover', () => this._warmConnections(), { once: true } );
            this.addEventListener( 'focusin', () => this._warmConnections(), { once: true } );
            
            this.addEventListener( 'click', () => this._addPlayer( true ) );
            this.cookieConsentButtonEl.addEventListener( 'click', () => this._onCookieConsent() );        
        }

        /**
         * Browser calls this method when the element is removed from the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        disconnectedCallback() {
            this.removeEventListener( 'pointerover', () => this._warmConnections(), { once: true } );
            this.removeEventListener( 'focusin', () => this._warmConnections(), { once: true } );
        
            this.removeEventListener( 'click', () => this._addPlayer( true ) ); 
            this.cookieConsentButtonEl.removeEventListener( 'click', () => this._onCookieConsent() );       
        }

        /**
         * Array of attribute names to monitor for changes.
         */
        static get observedAttributes() {
            return [ 'ratio' ];
        }   
        
        /**
         * Called when one of the observed attributes listed above is modified.
         */
        attributeChangedCallback( name, oldValue, newValue ) {
            if ( oldValue == newValue ) return false;

            switch ( name ) {
                case 'ratio':      
                    if ( newValue == 'auto' ) {
                        this.rootEl.style.paddingBottom = 0;
                    } else {
                        this.rootEl.style.paddingBottom = `${parseFloat(newValue)}%`;
                    }
                    break;
            }
        }

        /**
         * Define getters and setters for attributes.
         */

        get title() {
            return this.getAttribute( 'title' ) || '';
        }

        set title( value ) {
            this.setAttribute( 'title', value );
        } 

        get src() {
            const value = this.getAttribute( 'src' ) || '';
            return AYGPlayerElement.isValidUrl( value ) ? value : '';
        }

        set src( value ) {
            if ( AYGPlayerElement.isValidUrl( value ) ) {
                this.setAttribute( 'src', value );
            }
        } 

        get poster() {
            const value = this.getAttribute( 'poster' ) || '';
            return AYGPlayerElement.isValidUrl( value ) ? value : '';
        }

        set poster( value ) {
            if ( AYGPlayerElement.isValidUrl( value ) ) {
                this.setAttribute( 'poster', value );
            }
        }

        get lazyLoad() {
            return this.hasAttribute( 'lazyload' );
        }

        /**
         * Define private methods.
         */

        _render() {    
            if ( this._isRendered ) return false;          
            
            if ( this.lazyLoad && ! this._isInViewport ) {
                this._initIntersectionObserver();
                return false;
            }
            
            if ( this._hasCookieConsent ) {      
                this._addCookieConsent();           
                return false;
            }  

            this._isRendered = true; 

            if ( this._forcePlayerElement ) {
                this._addPlayer();
            } else {                    
                this._addPosterImage();    
            }
        }

        _addCookieConsent() {
            if ( this._isCookieConsentAdded ) return false; 
            this._isCookieConsentAdded = true;

            this._addPosterImage();   
            
            if ( this._cookieConsentMessage ) {
                this.cookieConsentMessageEl.innerHTML = this._cookieConsentMessage;
            }

            if ( this._cookieConsentButtonLabel ) {
                this.cookieConsentButtonEl.innerHTML = this._cookieConsentButtonLabel;
            }

            this._addClass( 'cookieconsent' );       
        }

        _onCookieConsent() {   
            this._isRendered = true;
                
            const elements = document.querySelectorAll( 'ayg-player' );
            for ( let i = 0; i < elements.length; i++ ) {
                elements[ i ].removeCookieConsent();
            }

            this._addPlayer( true );
            this._setCookie();
        }

        _addPosterImage() {
            if ( this._isPosterImageAdded ) return false; 
            this._isPosterImageAdded = true;

            if ( this.poster ) {
                this.rootEl.style.backgroundImage = `url("${this.poster}")`;
            }        
        }

        _addPlayer( forceAutoplay = false ) {
            if ( this._isPlayerAdded || this._hasCookieConsent ) return false;  
            this._isPlayerAdded = true;        

            this._addClass( 'initialized' );

            this.iframeEl = this._createIframeEmbed( forceAutoplay );
            this.playerEl.append( this.iframeEl );

            if ( this._playerType == 'custom' ) {
                this.playerEl.style = '--plyr-color-main: ' + this._playerColor;               

                const plyrPromise =	this._loadStyle( ayg_config.plugin_url + 'vendor/plyr/plyr.css?ver=3.7.8' )
                    .then( () => {
                        return window.Plyr ? Promise.resolve() : window.AYGLoadScript({
                            id: 'automatic-youtube-gallery-plyr-js',
                            src: ayg_config.plugin_url + 'vendor/plyr/plyr.polyfilled.js?ver=3.7.8'
                        });
                    });

                plyrPromise.then( () => {
                    this._initPlyrApi( forceAutoplay );
                }).catch( error => {
                    console.error( 'Failed to initialize Plyr:', error );
                });                           
            } else {
                // Set focus for a11y
                this.iframeEl.focus();        
                
                this._initYTApi( forceAutoplay );
            }
        }

        _createIframeEmbed( forceAutoplay ) {
            const iframeEl = document.createElement( 'iframe' );
            
            iframeEl.id = 'player';
            iframeEl.width = 560;
            iframeEl.height = 315;       
            iframeEl.title = this.title;        
            iframeEl.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
            iframeEl.referrerPolicy = 'strict-origin-when-cross-origin';
            iframeEl.allowFullscreen = true;

            if ( forceAutoplay ) {
                const url = new URL( this.src );

                let searchParams = url.searchParams;
                searchParams.set( 'autoplay', 1 );

                url.search = searchParams.toString();

                iframeEl.src = url.toString();
            } else {
                iframeEl.src = this.src;
            }
            
            iframeEl.dataset.poster = this.poster;

            return iframeEl;
        }

        _initPlyrApi( forceAutoplay ) {
            // Load Plyr library
            let options = {
                iconUrl: ayg_config.plugin_url + 'vendor/plyr/plyr.svg',
                resetOnEnd: true,
                fullscreen: {
                    enabled: true,
                    iosNative: true
                }
            };

            if ( forceAutoplay ) {
                options.autoplay = true;
            }

            if ( this._hasMuted ) {
                options.muted = true;
            }

            let controls = [ 'play-large' ];
            
            if ( this._hasPlayerControls ) {
                controls = [ 'play-large', 'play', 'current-time', 'progress', 'duration', 'mute', 'volume', 'fullscreen' ];

                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test( navigator.userAgent );
                if ( isMobile ) {
                    controls = [ 'play-large', 'play', 'progress', 'current-time', 'mute', 'fullscreen' ];
                }
            }      

            options.controls = controls;

            this._plyr = new Plyr( this.playerEl, options );

            this._plyr.on( 'ready', ( event ) => {
                this._playerApi = event.detail.plyr.embed;
                this._plyr.autoplay = true;

                // Hide YouTube logo if needed
                if ( this._hideYouTubeLogo ) {
                    event.target.className += ' plyr--youtube-no-logo';
                }
            });

            let classNamesUpdated = false;
            this._plyr.on( 'playing', ( event ) => {
                if ( ! classNamesUpdated ) {
                    classNamesUpdated = true;

                    event.target.className += ' plyr--initialized';
                    if ( ! this._hasPlayerControls ) {
                        event.target.className += ' plyr--no-controls';
                    }
                }

                // Pause other players
                const elements = document.querySelectorAll( 'ayg-player' );
                for ( let i = 0; i < elements.length; i++ ) {
                    if ( elements[ i ] != this ) {
                        elements[ i ].pause();
                    }
                }
            });

            this._plyr.on( 'ended', ( event ) => {
                event.target.className += ' plyr--stopped';
            });
        }

        _initYTApi( forceAutoplay ) {
            if ( ! this._hasYTApiEnabled ) return false;

            this._loadYTApi().then(() => {
                this._playerApi = new YT.Player( this.iframeEl, {
                    events: {
                        'onReady': ( event ) => {   
                            if ( forceAutoplay && this._pendingPlay ) {
                                event.target.playVideo();
                                this._pendingPlay = false;
                            }
                        },
                        'onStateChange': ( event ) => {
                            if ( 0 == event.data ) { // ended
                                // Force exit from fullscreen if still active
                                if ( document.fullscreenElement ) {
                                    document.exitFullscreen().catch(() => {});

                                    // Delay before replacing iframe
                                    setTimeout( () => {
                                        this._dispatchEvent( 'ended' );
                                    }, 500 );
                                } else {
                                    this._dispatchEvent( 'ended' );
                                }
                            }
                    
                            if ( 1 == event.data ) { // playing
                                const elements = document.querySelectorAll( 'ayg-player' );
                                for ( let i = 0; i < elements.length; i++ ) {
                                    if ( elements[ i ] != this ) {
                                        elements[ i ].pause();
                                    }
                                } 
                            } 
                        }
                    }
                });
            });
        }

        _loadYTApi() {
            return new Promise(( resolve ) => { 
                if ( typeof window.YT === 'undefined' && typeof AYGPlayerElement.isApiLoaded === 'undefined' ) {
                    AYGPlayerElement.isApiLoaded = true;

                    const tag = document.createElement( 'script' );
                    tag.src = 'https://www.youtube.com/iframe_api';
                    
                    const firstScriptTag = document.getElementsByTagName( 'script' )[0];
                    firstScriptTag.parentNode.insertBefore( tag, firstScriptTag );	
                }		

                if ( typeof window.YT !== 'undefined' && window.YT.loaded )	{
                    resolve();	
                } else {		
                    let intervalHandler = setInterval(
                        function() {
                            if ( typeof window.YT !== 'undefined' && window.YT.loaded )	{
                                clearInterval( intervalHandler );
                                resolve();	
                            }
                        }, 
                        10 
                    );
                }
            });
        }

        _initIntersectionObserver() {
            if ( this._intersectionObserver ) return false;

            const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0,
            };

            this._intersectionObserver = new IntersectionObserver(( entries, observer ) => {
                entries.forEach(entry => {
                    if ( entry.isIntersecting ) {
                        this._isInViewport = true;
                        this._render();

                        if ( this._isRendered ) observer.unobserve( this );
                    } else {
                        this._isInViewport = false;
                    }
                });
            }, options);

            this._intersectionObserver.observe( this );
        }   

        _warmConnections() {
            if ( AYGPlayerElement.isPreconnected ) return false;

            if ( this.src.indexOf( 'www.youtube-nocookie.com' ) > -1 ) {
                AYGPlayerElement.addPrefetch( 'preconnect', 'https://www.youtube-nocookie.com' );
            } else {
                AYGPlayerElement.addPrefetch( 'preconnect', 'https://www.youtube.com' );
            }

            AYGPlayerElement.addPrefetch( 'preconnect', 'https://www.google.com' );
            AYGPlayerElement.addPrefetch( 'preconnect', 'https://googleads.g.doubleclick.net' );
            AYGPlayerElement.addPrefetch( 'preconnect', 'https://static.doubleclick.net' );

            AYGPlayerElement.isPreconnected = true;
        }   

        _hasClass( className ) {
            return this.rootEl.classList.contains( className );
        }
        
        _addClass( className ) {
            this.rootEl.classList.add( className );
        }

        _removeClass( className ) {
            this.rootEl.classList.remove( className );
        }

        _dispatchEvent( eventName ) {
            const event = new CustomEvent( eventName, {
                detail: {},
                bubbles: true,
                cancelable: true
            });

            this.dispatchEvent( event );
        }

        /**
         * Define private async methods.
         */
        
        async _loadStyle( url ) {
			if ( ! AYGPlayerElement.plyrCssText ) {
				const res = await fetch( url );
				if ( ! res.ok ) throw new Error( res.status );
				
				AYGPlayerElement.plyrCssText = await res.text();
			}

			if ( 'adoptedStyleSheets' in Document.prototype && 'replaceSync' in CSSStyleSheet.prototype ) {
				const sheet = new CSSStyleSheet();
				sheet.replaceSync( AYGPlayerElement.plyrCssText );
				this.shadowRoot.adoptedStyleSheets = [ sheet ];
			} else {
				const style = document.createElement( 'style' );
				style.textContent = AYGPlayerElement.plyrCssText;
				this.shadowRoot.appendChild( style );
			}
		}

        async _setCookie() {
            try {
                let formData = new FormData();
                formData.append( 'action', 'ayg_set_cookie' );
                formData.append( 'security', this._ajaxNonce );

                fetch( this._ajaxUrl, { method: 'POST', body: formData } );
            } catch ( error ) {
                /** console.log( error ); */
            }
        }    

        /**
         * Define static methods.
         */

        static isValidUrl( url ) {
            if ( url == '' ) return false;

            try {
                new URL( url );
                return true;
            } catch ( error ) {
                return false;
            }
        }   

        static addPrefetch( kind, url ) {
            const linkElem = document.createElement( 'link' );
            linkElem.rel = kind;
            linkElem.href = url;

            document.head.append( linkElem );
        }

        /**
         * Define API methods.
         */

        removeCookieConsent() {
            this._hasCookieConsent = false;
            this._removeClass( 'cookieconsent' );          
            this._render();
        }
        
        play( video = null ) {
            // Handle gesture-initiated autoplay or manual play
            if ( video && typeof video === 'object' ) {
                this.change( video );
                return;
            }

            // Fallback: try to play the current video
            if ( this._playerApi && this._playerApi.playVideo ) {
                this._playerApi.playVideo();
            } else {
                this._pendingPlay = true;
            }
        } 

        pause() {
            if ( this._playerApi && this._playerApi.pauseVideo ) {
                this._playerApi.pauseVideo();
            }
        } 

        change( video ) {
            let autoplay = true;
            if ( video.hasOwnProperty( 'autoplay' ) ) {
                autoplay = video.autoplay;
            }

            if ( this._playerApi ) {
                // Update poster image       
                if ( video.hasOwnProperty( 'poster' ) ) {  
                    if ( this._plyr ) {
                        this._plyr.poster = ''; 

                        setTimeout( () => {
                            this._plyr.poster = video.poster;
                        }, 100 );
                    }
                }

                // Update video ID
                if ( video.hasOwnProperty( 'id' ) ) {
                    if ( autoplay ) {
                        if ( this._playerApi.loadVideoById ) {
                            this._playerApi.loadVideoById( video.id );
                        }
                    } else {
                        if ( this._playerApi.cueVideoById ) {
                            this._playerApi.cueVideoById( video.id );
                        }
                    }
                }
            } else {
                // Update video URL
                if ( video.hasOwnProperty( 'id' ) ) {
                    const url = new URL( this.src );

                    url.pathname = `/embed/${video.id}`;

                    let searchParams = url.searchParams;
                    searchParams.set( 'autoplay', ( autoplay ? 1 : 0 ) );

                    url.search = searchParams.toString();

                    this.src = url.toString();

                    if ( this._isPlayerAdded ) { 
                        this.iframeEl.setAttribute( 'src', this.src );
                    }
                }

                // Update poster image
                if ( video.hasOwnProperty( 'poster' ) ) {
                    this.poster = video.poster;

                    if ( this._isPosterImageAdded ) {  
                        if ( this._isPlayerAdded ) {
                            this.rootEl.style.backgroundImage = 'none';
                        } else {
                            this.rootEl.style.backgroundImage = `url("${video.poster}")`;
                        }                    
                    }
                }

                // Play video
                if ( ! this._isPlayerAdded && ! this._hasCookieConsent ) {
                    this._addPlayer( true );
                }
            }

            // Update title
            if ( video.hasOwnProperty( 'title' ) ) {
                this.title = video.title;
            }
        }

        stop() {
            if ( this._playerApi && this._playerApi.stopVideo ) {
                this._playerApi.stopVideo();
            }
        }

    }

    AYGPlayerElement.plyrCssText = null;

    /**
     * Description Element.
     */
    class AYGDescriptionElement extends HTMLElement {

        /**
         * Element created.
         */
        constructor() {
            super();

            // Set references to the private properties used by the component
            this._isRendered = false;
            this._showMoreButtonLabel = ayg_config.i18n.show_more;
            this._showLessButtonLabel = ayg_config.i18n.show_less;
        }

        /**
         * Browser calls this method when the element is added to the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        connectedCallback() {
            if ( this._isRendered ) return false; 
            this._isRendered = true;

            $( this ).on( 'click', '.ayg-player-description-toggle-btn', ( event ) => this._toggle( event ) );
        }

        /**
         * Browser calls this method when the element is removed from the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        disconnectedCallback() {
            if ( ! this._isRendered ) return false; 

            $( this ).off( 'click', '.ayg-player-description-toggle-btn', ( event ) => this._toggle( event ) );
        }

        /**
         * Define private methods.
         */

        _toggle( event ) {
            event.preventDefault();

            const $dotsEl = $( this ).find( '.ayg-player-description-dots' );
            const $moreEl = $( this ).find( '.ayg-player-description-more' );

            if ( $dotsEl.is( ':visible' ) ) {
                event.currentTarget.innerHTML = this._showLessButtonLabel;
                $dotsEl.hide();
                $moreEl.fadeIn();									
            } else {					
                $moreEl.fadeOut(() => {
                    event.currentTarget.innerHTML = this._showMoreButtonLabel;
                    $dotsEl.show();				
                });								
            }
        }

    }

    /**
     * Search Form Element.
     */
    class AYGSearchFormElement extends HTMLElement {

        /**
         * Element created.
         */
        constructor() {
            super();

            // Set references to the DOM elements used by the component
            this.$el = null;
            this.$root = null;
            this.$searchForm = null;
            this.$searchInput = null;
            this.$searchBtn = null;
            this.$resetBtn = null;
            this.$player = null;
            this.$videos = null; 
            this.$pagination = null; 

            // Set references to the private properties used by the component
            this._isRendered = false;
            this._formData = {};
            this._ajaxUrl = ayg_config.ajax_url;
            this._ajaxNonce = ayg_config.ajax_nonce; 
            this._searchTerm = '';
            this._isLoading = false;      
        }

        /**
         * Browser calls this method when the element is added to the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        connectedCallback() {
            if ( this._isRendered ) return false; 
            this._isRendered = true;

            this.$el = $( this );
            this.$root = this.$el.closest( '.ayg' );

            this.$searchForm = this.$el.find( 'form' );
            this.$searchInput = this.$el.find( '.ayg-search-input' );
            this.$searchBtn = this.$el.find( '.ayg-search-btn' ); 
            this.$resetBtn = this.$el.find( '.ayg-reset-btn' );    
            this.$player = this.$root.find( '.ayg-theme > .ayg-player' );        
            this.$videos = this.$root.find( '.ayg-videos' );
            this.$pagination = this.$root.find( '.ayg-pagination' );            

            this._formData = this.$el.data( 'params' );
            this._formData.action = 'ayg_load_videos';
            this._formData.security = this._ajaxNonce;
            this._formData.searchTerm = '';
            
            this.$searchForm.on( 'submit', ( event ) => this._search( event ) );
            this.$searchInput.on( 'blur', ( event ) => this._search( event ) );
            this.$searchBtn.on( 'click', ( event ) => this._search( event ) );
            this.$resetBtn.on( 'click', ( event ) => this._reset( event ) );
        }

        /**
         * Browser calls this method when the element is removed from the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        disconnectedCallback() {
            if ( ! this._isRendered ) return false;

            this.$searchForm.off( 'submit', ( event ) => this._search( event ) );
            this.$searchInput.off( 'blur', ( event ) => this._search( event ) );
            this.$searchBtn.off( 'click', ( event ) => this._search( event ) );
            this.$resetBtn.off( 'click', ( event ) => this._reset( event ) );
        }

        /**
         * Define getters and setters for attributes.
         */

        set loading( value ) {
            if ( this._isLoading == value ) {
                return false;
            }
            
            this._isLoading = value;

            this.$searchBtn.hide();
            this.$resetBtn.hide();

            if ( value ) {
                this.$el.find( '.ayg-status-message' ).remove();
                
                this.$searchBtn.show();
                this.$searchBtn.find( 'svg' ).hide();
                this.$searchBtn.append( '<span class="ayg-loading"></span>' );
            } else {
                if ( this._searchTerm.length > 0 ) {
                    this.$resetBtn.show();
                } else {                    
                    this.$searchBtn.show();
                }

                this.$searchBtn.find( '.ayg-loading' ).remove();
                this.$searchBtn.find( 'svg' ).show();
            }
        }
        
        set message( response ) {
            this.$el.find( '.ayg-status-message' ).remove();

            if ( response.data.message ) {
                if ( response.success ) {
                    let icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">' + 
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />' + 
                    '</svg>';

                    this.$el.append( '<div class="ayg-status-message">' + icon + response.data.message + '</div>' );
                } else {
                    let icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">' + 
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />' + 
                    '</svg>';

                    this.$el.append( '<div class="ayg-status-message ayg-error">' + icon + response.data.message + '</div>' );
                }
            }
        }

        /**
         * Define private methods.
         */

        _search( event ) {
            if ( event ) {
                event.preventDefault();
            }

            this._searchTerm = this.$searchInput.val();
            if ( this._searchTerm == this._formData.searchTerm ) {
                return false;
            }

            this.loading = true;

            this._formData.searchTerm = this._searchTerm;             
            this._formData.pageToken  = ( this._searchTerm.length > 0 ) ? 1 : '';            

            this._fetch( this._formData, ( response ) => {
                if ( response.success ) {
                    this.$videos.html( response.data.html );                   

                    this._updatePlayer( response );
                    this._updatePagination( response );

                    this.$el.trigger( 'videos.updated' );
                }

                if ( this._searchTerm.length > 0 ) {
                    this.message = response;   
                }
                
                this.loading = false;
            });
        }

        _reset( event ) {
            this.$searchInput.val( '' );
            this._search( event );
        }
        
        _updatePlayer( response ) {
            if ( this.$player.length == 0 ) {
                return false;
            }
            
            const $selectedVideo = this.$videos.find( '.ayg-video' ).eq(0);

            const videoId = $selectedVideo.find( '.ayg-thumbnail' ).data( 'id' );                        
            const title = $selectedVideo.find( '.ayg-thumbnail' ).data( 'title' );	
            const description = $selectedVideo.find( '.ayg-thumbnail-description' ).html();
            const poster = $selectedVideo.find( '.ayg-thumbnail-image' ).attr( 'src' );
            const player = this.$player.find( 'ayg-player' ).get(0);
            const params = this.$root.find( '.ayg-theme' ).data( 'params' );

            player.change({
                id: videoId,
                title: title,
                poster: poster,
                autoplay: false
            });

            if ( params.player_title == 1 ) {            			
                this.$player.find( '.ayg-player-title' ).html( title );
            }

            if ( params.player_description == 1 ) {            
                this.$player.find( '.ayg-player-description' ).html( description );
            }
        }

        _updatePagination( response ) {
            if ( this.$pagination.length == 0 ) {
                return false;
            }
            
            const totalPages = parseInt( response.data.total_pages || 1 );

            const $previousButton = this.$pagination.find( '.ayg-pagination-prev-btn' );
            if ( $previousButton.length > 0 ) {
                $previousButton.hide();
            }

            const $nextButton = this.$pagination.find( '.ayg-pagination-next-btn' );
            if ( $nextButton.length > 0 ) {
                if ( totalPages == 1 ) {
                    $nextButton.hide();
                } else {
                    $nextButton.show();
                }
            }

            const $currentPage = this.$pagination.find( '.ayg-pagination-current-page-number' );
            if ( $currentPage.length > 0 ) {
                $currentPage.html( 1 );
            }

            const $totalPages = this.$pagination.find( '.ayg-pagination-total-pages' );
            if ( $totalPages.length > 0 ) {
                $totalPages.html( totalPages );
            }
            
            // Update Form Data
            const paginationEl = this.$pagination.get( 0 );

            let formData = paginationEl.formData;
            formData.searchTerm = this._searchTerm;
            formData.total_pages = totalPages;
            formData.next_page_token = response.data.next_page_token;

            paginationEl.update( formData );
        }

        _fetch( data, callback ) {       
            $.post( this._ajaxUrl, data, callback, 'json' ); 						
        }

    }

    /**
     * Pagination Element.
     */
    class AYGPaginationElement extends HTMLElement {

        /**
         * Element created.
         */
        constructor() {
            super();

            // Set references to the DOM elements used by the component
            this.$el = null;
            this.$videos = null;
            this.$nextButton = null;
            this.$previousButton = null;

            // Set references to the private properties used by the component
            this._isRendered = false; 
            this._formData = {};
            this._ajaxUrl = ayg_config.ajax_url;
            this._ajaxNonce = ayg_config.ajax_nonce;
            this._totalPages = 1;
            this._paged = 1;
            this._pageTokens = [''];        
        }

        /**
         * Browser calls this method when the element is added to the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        connectedCallback() {
            if ( this._isRendered ) return false; 
            this._isRendered = true;

            this.$el = $( this );
            this.$videos = this.$el.closest( '.ayg' ).find( '.ayg-videos' );

            this._formData = this.$el.data( 'params' );
            this._formData.action = 'ayg_load_videos';
            this._formData.security = this._ajaxNonce;
            
            this._totalPages = parseInt( this._formData.total_pages );       

            this.$el.on( 'click', '.ayg-pagination-next-btn', ( event ) => this._next( event ) );
            this.$el.on( 'click', '.ayg-pagination-prev-btn', ( event ) => this._previous( event ) );
        }

        /**
         * Browser calls this method when the element is removed from the document.
         * (can be called many times if an element is repeatedly added/removed)
         */
        disconnectedCallback() {
            if ( ! this._isRendered ) return false; 
            
            this.$el.off( 'click', '.ayg-pagination-next-btn', ( event ) => this._next( event ) );
            this.$el.off( 'click', '.ayg-pagination-prev-btn', ( event ) => this._previous( event ) );
        }

        /**
         * Define getters and setters for attributes.
         */

        get formData() {
            return this._formData;
        }

        /**
         * Define private methods.
         */

        _next( event ) {
            this.$el.addClass( 'ayg-loading' );	

            this.$nextButton = $( event.currentTarget ); 			
            const type = this.$nextButton.data( 'type' );

            this._formData.pageToken = this._formData.next_page_token;
            this._pageTokens[ this._paged ] = this._formData.pageToken;

            this._fetch( this._formData, ( response ) => {
                if ( response.success ) {
                    this._paged = Math.min( this._paged + 1, this._totalPages );

                    this._formData.next_page_token = '';
                    if ( this._paged < this._totalPages && response.data.next_page_token ) {
                        this._formData.next_page_token = response.data.next_page_token;
                    }

                    switch ( type ) {
                        case 'more':
                            this.$videos.append( response.data.html );
                            break;						
                        case 'next':
                            this.$el.find( '.ayg-pagination-prev-btn' ).show();
                            this.$el.find( '.ayg-pagination-current-page-number' ).html( this._paged );		

                            this.$videos.html( response.data.html );
                            break;
                    }

                    if ( this._formData.next_page_token == '' ) {
                        this.$nextButton.hide();
                    }

                    this.$el.trigger( 'videos.updated' );
                }

                this.$el.removeClass( 'ayg-loading' );
            });
        }

        _previous( event ) {
            this.$el.addClass( 'ayg-loading' );	

            this.$previousButton = $( event.currentTarget );        
                    
            this._paged = Math.max( this._paged - 1, 1 );
            this._formData.pageToken = this._pageTokens[ this._paged - 1 ];

            this._fetch( this._formData, ( response ) => {
                if ( response.success ) {
                    this._formData.next_page_token = '';
                    if ( response.data.next_page_token ) {
                        this._formData.next_page_token = response.data.next_page_token;
                    }

                    this.$videos.html( response.data.html );

                    this.$el.find( '.ayg-pagination-next-btn' ).show();
                    this.$el.find( '.ayg-pagination-current-page-number' ).html( this._paged );			

                    if ( this._paged == 1 ) {
                        this.$previousButton.hide();
                    }

                    this.$el.trigger( 'videos.updated' );
                }

                this.$el.removeClass( 'ayg-loading' );
            });
        }

        _fetch( data, callback ) {       
            $.post( this._ajaxUrl, data, callback, 'json' ); 						
        }

        /**
         * Define public methods.
         */

        update( value ) {       
            this._formData = value;

            this._totalPages = parseInt( this._formData.total_pages ); 
            this._paged = 1;
            this._pageTokens = [''];					
        }

    }

	/**
	 * Called when the page has loaded.
	 *
	 * @since 1.0.0
	 */
	$(function() {
        // Register custom elements
        if ( ! customElements.get( 'ayg-player' ) ) {
            customElements.define( 'ayg-player', AYGPlayerElement );
        }

        if ( ! customElements.get( 'ayg-description' ) ) {
            customElements.define( 'ayg-description', AYGDescriptionElement );
        }

        if ( ! customElements.get( 'ayg-search-form' ) ) {
            customElements.define( 'ayg-search-form', AYGSearchFormElement );
        }

        if ( ! customElements.get( 'ayg-pagination' ) ) {
            customElements.define( 'ayg-pagination', AYGPaginationElement );
        }

		// Locate gallery element on single video pages       
		const currentGalleryId = ayg_config.current_gallery_id;
        const pageTopOffset    = parseInt( ayg_config.top_offset );        

		if ( pageTopOffset >= 0 && currentGalleryId ) {
            const $gallery = $( '#ayg-' + currentGalleryId );

            if ( $gallery.length > 0 ) {
                if ( history.scrollRestoration ) {
                    history.scrollRestoration = 'manual';
                } else {
                    window.onbeforeunload = function() {
                        window.scrollTo( 0, 0 );
                    }
                }
                
                $( 'html, body' ).animate({
                    scrollTop: $gallery.offset().top - pageTopOffset
                }, 500);	
            }
		}

        // Init assets
        const plugin_url     = ayg_config.plugin_url;
		const plugin_version = ayg_config.plugin_version;

		const assets = [
			{ 
				selector: 'ayg-theme-classic', 
				script: {
					id: 'automatic-youtube-gallery-theme-classic-js',
					src: plugin_url + 'public/assets/js/theme-classic.min.js?ver=' + plugin_version
				}
			},
            { 
				selector: 'ayg-theme-inline', 
				script: {
					id: 'automatic-youtube-gallery-theme-inline-js',
					src: plugin_url + 'premium/public/assets/js/theme-inline.min.js?ver=' + plugin_version
				}
			},
            { 
				selector: 'ayg-theme-playlist', 
				script: {
					id: 'automatic-youtube-gallery-theme-playlist-js',
					src: plugin_url + 'premium/public/assets/js/theme-playlist.min.js?ver=' + plugin_version
				}
			},
			{ 
				selector: 'ayg-theme-popup, .ayg-theme-single-popup', 
				script: {
					id: 'automatic-youtube-gallery-theme-popup-js',
					src: plugin_url + 'premium/public/assets/js/theme-popup.min.js?ver=' + plugin_version
				}
			},
			{ 
				selector: 'ayg-theme-slider, ayg-theme-slider-popup, ayg-theme-slider-inline', 
				script: {
					id: 'automatic-youtube-gallery-theme-slider-js',
					src: plugin_url + 'premium/public/assets/js/theme-slider.min.js?ver=' + plugin_version
				}
			}
		];

		// Scan DOM and load required assets
		const loadAssets = ( root = document ) => {
			if ( ! root || ( root.nodeType !== 1 && root !== document ) ) {
				return;
			}

			for ( const asset of assets ) {
				if ( root.matches?.( asset.selector ) || root.querySelector( asset.selector ) ) {
					if ( asset.style ) window.AYGLoadStyle( asset.style );
					if ( asset.script ) window.AYGLoadScript( asset.script );
				}
			}
		};

		// Initial scan (page load)
		loadAssets( document );

		// Observe dynamically added elements (Elementor, DIVI, AJAX)
		const observer = new MutationObserver(( mutations ) => {
			for ( const mutation of mutations ) {
				for ( const node of mutation.addedNodes ) {
					loadAssets( node );
				}
			}
		});

		observer.observe( document.body, {
			childList: true,
			subtree: true
		});
	});

})( jQuery );