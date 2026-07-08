=== Automatic YouTube Gallery ===
Plugin URI: https://plugins360.com/automatic-youtube-gallery/
Contributors: plugins360, wpvideogallery, freemius
Donate link: https://plugins360.com
Tags: youtube gallery, youtube playlist, youtube channel, youtube embed, youtube live
Requires at least: 6.3
Tested up to: 7.0
Requires PHP: 5.6.20
Stable tag: 2.7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Build dynamic video galleries by simply adding a YouTube USERNAME, CHANNEL, PLAYLIST, SEARCH KEYWORDS, or a custom list of video URLs.

== Description ==

Create responsive, modern & dynamic video galleries by simply adding a YouTube USERNAME, CHANNEL, PLAYLIST, SEARCH KEYWORDS, or a custom list of video URLs.

* [View Demo](https://demo.plugins360.com/automatic-youtube-gallery/)
* [Documentation](https://plugins360.com/automatic-youtube-gallery/documentation/)
* [Contact & Support](https://plugins360.com/support/)
* [Home Page](https://plugins360.com/automatic-youtube-gallery/)

<blockquote>
The only dynamic YouTube gallery plugin with <a href="https://plugins360.com/automatic-youtube-gallery/deeplinking/">deeplinking</a> capabilities.
</blockquote>

https://www.youtube.com/watch?v=a90OGk42fJ4&rel=0

### STANDARD FEATURES

* Create unlimited & searchable galleries.
* Automate your galleries using various YouTube sources like,
 * USERNAME
 * CHANNEL
 * PLAYLIST
 * SEARCH KEYWORDS
 * Custom YouTube URLs list
* Auto Embed Live Stream from a YouTube Channel.
* GDPR consent before the playback.
* Gutenberg Block support.
* Shortcode Builder for the old classic editor and other third-party page builders.
* Sidebar Widget (Compatible with Elementor Page Builder).
* Built-in caching for quick page loads.
* Most importantly, a Clear & Beautiful Admin Interface.
* [+] Hooks for Developers.

### PREMIUM FEATURES

* [SEO](https://plugins360.com/automatic-youtube-gallery/deeplinking/): Deeplinking, Open Graph Tags, and Schema.org Markup (via JSON-LD).
* [Popup Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-popup/)
* [Inline Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-inline/)
* [Slider Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-slider/)
* [Playlist Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-playlister/)

### TRANSLATION READY

Do you speak another language? Want to contribute in a meaningful way to Automatic YouTube Gallery? There's no better way than to help us translate the plugin. This plugin is translation ready and you can [translate](https://plugins360.com/automatic-youtube-gallery/translate-to-your-language/) to your language easily. Once finished, please reach out to us [here](https://plugins360.com/support/) to get your language file included in the core.

### SUPPORT AND DOCUMENTATION
	
We do have [documentation](https://plugins360.com/automatic-youtube-gallery/documentation/) on the plugin.
	
Still, Having Issues? We are just an email away. Please write to us describing your issue using the "Contact" form available under our plugin's menu. You should receive a reply within 24 hours (except Sunday).
	
Also, we answer all support requests [on the WordPress.org support forum](https://wordpress.org/support/plugin/automatic-youtube-gallery/).

== Installation ==

1. Download the plugin.
2. From the WordPress Admin Panel, click on Plugins => Add New.
3. Click on Upload, so you can directly upload your plugin zip file.
4. Use the browse button to select the plugin zip file that was downloaded, and then click on Install Now.
5. Once installed, click "Activate".
6. Then, go to the plugin dashboard, and configure your "YouTube API Key" as per the instructions given on the page. Save the changes.
7. That's it. Now, you can start building your galleries straight away from the plugin dashboard. 

For more detailed instructions visit plugin [documentation](https://plugins360.com/automatic-youtube-gallery/documentation/).

== Frequently Asked Questions ==

= 1. How to get a YouTube Data API Key? =

Please follow [get Youtube API](https://plugins360.com/automatic-youtube-gallery/how-to-get-youtube-api-key/) instructions.

= 2. Help! My video gallery doesn't look right! =

First of all, don't worry! I promise you that we can get it looking right. This can be caused by a multitude of things, so try the following (in the order of appearance):

* Check your browser's javascript console to see if there are any errors that may be causing this issue.
* Make sure that your WordPress theme is not including multiple versions of jQuery and is using the latest version.
* Try disabling other plugins that are used for photo galleries, minifying scripts, widgets, or otherwise altering your site's appearance, one by one, and really determine if you need it.

If nothing works, please describe your issue and submit a ticket on our plugin support forum, you should receive a reply within 24 hours (except Sunday).

= 3. Does the plugin support third-party page builders like "Elementor", "WPBakery", "Divi", etc.? =

Yes, the plugin is fully compatible with popular page builders like Elementor, WPBakery, Divi, and more.

* For **Elementor**, the plugin provides a dedicated WordPress widget. You can find it under the "WordPress" tab in the Elementor editor. Simply drag and drop the widget into your design to embed your video gallery seamlessly.
* Alternatively, for **Elementor** and other page builders, you can use the plugin's **Shortcode Builder** to generate a shortcode. Once created, you can add the shortcode to any section or module of your favorite page builder.

This flexibility ensures you can integrate your video gallery effortlessly, regardless of your preferred page builder.

= 4. Is the plugin compatible with WordPress Multisite? =

Yes, it is. However, do not "network-activate" the plugin. Activate it only on the subsites on which you need the gallery. This can be done under "Plugins => Add New" as the Administrator user.

== Screenshots ==

1. Step 1: Install the Plugin
2. Step 2: Configure the YouTube API Key
3. Step 3: Build the Gallery
4. Classic Theme
5. Popup Theme
6. Slider Theme
7. Playlist Theme
8. Plugin Settings
9. Gutenberg Block
10. Widget

== Changelog ==

= 2.7.2 =

* New: Added "Slider Autoplay" and "Autoplay Speed" settings for the Slider + Popup theme.
* New: Introduced `ayg_theme_classic_params`, `ayg_theme_inline_params`, `ayg_theme_playlist_params`, `ayg_theme_slider_params`, `ayg_theme_slider_inline_params`, and `ayg_theme_slider_popup_params` filter hooks for customizing player parameters per theme.
* New: Introduced `ayg_theme_slider_slick_options` filter hook for customizing Slick carousel options across all slider themes.
* New: Introduced `ayg_search_form_params` filter hook for customizing search form parameters. The previous `ayg_search_form_args` hook is deprecated but retained for backward compatibility.
* New: Introduced `ayg_autoflush_rewrite_rules_in_admin` filter hook to optionally enable rewrite rule checks in admin contexts (runs on public pages only by default).
* Tweak: Updated Freemius SDK to version 2.13.1.
* Tweak: Improved performance of video storage by replacing per-video database queries with a single bulk INSERT per API response, reducing database load on cache-miss pagination requests.
* Tweak: Disabled autoloading for the `ayg_transient_keys`, `ayg_channel_ids`, and `ayg_playlist_ids` options to prevent lookup caches from being loaded on every page request site-wide.
* Tweak: Switched rewrite rule flush from hard (`.htaccess` rewrite) to soft (database only), avoiding unnecessary file I/O on the front end.
* Fix: WordPress 7.0 compatibility issues.

= 2.7.1 =

* New: Added options to force-load the plugin's CSS (recommended) and JavaScript (advanced) across all front-end pages. This helps resolve layout or functionality issues caused by themes, page builders, or optimization plugins.
* New: Added a "Shorts / Vertical (9:16)" option to the "Image Height (Ratio)" setting.
* New: Added a "Shorts / Vertical (9:16)" option to the "Player Height (Ratio)" setting.
* Tweak: Improved popup player behavior — the player now always fits within the viewport. Previously, it could extend beyond the visible area.
* Tweak: Enhanced slider dots behavior by limiting the maximum number of dots to 5 and automatically enabling dots during navigation when using the slider template.
* Tweak: Introduced a new wrapper function, ayg_get_option(), for the WordPress get_option() function to prevent issues when plugin settings are missing.
* Fix: Resolved an issue where deeplinking did not work correctly on the site home/front page.
* Fix: Registered custom query variables to prevent conflicts with SEO and optimization plugins that may strip unrecognized query vars.
* Fix: Various minor bug fixes and performance enhancements.

= 2.6.5 =

* Tweak: Updated Freemius SDK to version 2.13.0.
* Fix: WordPress 6.9 compatibility issues.

= 2.6.4 =

* New: Added support for displaying single videos in a popup.
* Tweak: Enhanced Schema.org (JSON-LD) structured data support for all single video layouts.
* Tweak: Updated Freemius SDK to version 2.12.2.
* Fix: Resolved issue where the fullscreen button stopped working during continuous play in fullscreen mode.
* Fix: Improved compatibility with the Divi page builder.
* Fix: Various minor bug fixes and performance enhancements.

= 2.6.1 =

* Security Fix: Addressed multiple security issues to enhance overall plugin security.
* Tweak: Updated the Freemius SDK to version 2.12.1.
* Fix: Fixed compatibility issues with the Oxygen page builder.
* Fix: Various minor bug fixes and performance improvements.

= 2.6.0 =

* New: Added support for disabling automatic page scroll to the video player by setting the "Page Scroll Top Offset" to -1, giving users more control over layout behavior.
* Fix: Resolved various minor bugs and applied performance improvements for a smoother experience.

= 2.5.9 =

* New: Introduced a search form to filter videos within the gallery for easier navigation.
* New: Added a dedicated settings page to manage all button labels used by the plugin in one place.
* Tweak: "Development Mode" is now disabled by default, as some users were unknowingly using it on production websites, leading to YouTube quota exceeded errors.
* Tweak: Added an option to disable caching on a per-gallery basis for greater flexibility.
* Fix: Addressed several minor bugs and implemented performance enhancements.

= 2.5.6 =

* Update: Upgraded to the latest version of the Freemius SDK for enhanced compatibility.
* Fix: Fixed multiple minor bugs to ensure a smoother and more reliable user experience.

= 2.5.5 =

* Tweak: Updated the "Freemius SDK" to version 2.10.1.
* Fix: Compatibility issues with the Elementor page builder.

= 2.5.2 =

* New: Introduced a "Custom Video Player" as an alternative to the default native YouTube embed. Users can configure this via the "Player Type" option.
* New: Added "Lazy Loading" for images and videos, enhancing page load times and overall performance.
* New: Introduced a new "Page Scroll Top Offset" option, enabling users to define a custom top offset (in pixels) when the page scrolls to the video player after clicking on a thumbnail.
* Tweak: Completely rewrote the plugin's JavaScript files using the latest "Custom Elements" technology, ensuring better integration and improved performance.
* Tweak: Updated the "Freemius SDK" to version 2.9.0.
* Fix: Resolved various minor bugs to enhance stability and functionality.

= 2.4.3 =

* New: Introduced a new "Player Width" option.
* Tweak: Updated Freemius SDK (2.7.4).
* Fix: Poster image display issue when using the single video shortcode.
* Fix: [+] a few minor bug fixes.

= 2.3.9 =

* Tweak: Updated Freemius SDK (2.7.0).
* Fix: Livestream API caching issue.
* Fix: Conflict issue with the Google Site Kit plugin.
* Fix: [+] a few minor bug fixes.

= 2.3.8 =

* Tweak: Optimized JavaScript loading.
* Tweak: Updated Freemius SDK (2.6.2).
* Fix: GDPR compatibility issues.
* Fix: YouTube Livestream feature stopped working due to a recent update from the YouTube API.
* Fix: [+] a few minor bug fixes.

= 2.3.6 =

* Tweak: Updated Freemius SDK (2.6.1).
* Fix: WordPress 6.4 compatibility issues.
* Fix: [+] a few minor bug fixes.

= 2.3.5 =

* Fix: Security fix: Broken Access Control. Thanks to Rafshanzani Suhada from [Patchstack](https://patchstack.com/).
* Fix: [+] a few minor bug fixes.

= 2.3.3 =

* Tweak: Updated Freemius SDK (2.5.10).
* Fix: Security fix.
* Fix: [+] a few minor bug fixes.

= 2.3.2 =

* New: WPML Compatibility.
* New: POLYLANG Compatibility.
* New: Support for the "Muted" option in the player.
* New: "Privacy Enhanced Mode" for the player.
* New: Support for YouTube "Origin" parameter that adds extra security for the player.
* New: Options to change the "Load More", "Previous", and the "Next" pagination button labels.
* Tweak: Updated to the Gutenberg API Version 2.
* Tweak: Updated Freemius SDK (2.5.7).
* Tweak: All the CSS & JS files added by the plugin are minified for better performance.
* Fix: [+] a few minor bug fixes.

= 2.2.0 =

* Tweak: Updated Freemius SDK (2.5.2).
* Fix: Performance issues that occurred after upgrading to our 2.1.0 version.

= 2.1.0 =

* New: Sidebar Widget.
* New: A filter hook "ayg_pagination_args" for developers to override the pagination args.
* Tweak: Player initialization has been changed from "Iframe" to "Javascript" for better performance.
* Tweak: Updated Freemius SDK (2.4.5).
* Fix: [+] few minor bug fixes.

= 2.0.0 =

* New: GDPR consent before the playback.
* Tweak: The plugin front-end has been completely rewritten.
* Fix: [+] few minor bug fixes.

= 1.6.5 =

* Security Fix.

= 1.6.4 =

* New: Auto Embed Live Stream from a YouTube Channel.
* Fix: [+] few minor bug fixes.

= 1.6.3 =

* Fix: Videos with the "Unlisted" status on the YouTube website are not showing.
* Fix: The "Single Video" source type is broken when the default theme is "Popup" in the plugin's global settings page.

= 1.6.2 =

* Fix: WordPress 5.8 compatibility issues.

= 1.6.1 =

* Tweak: Player & Gallery script files rewritten completely for more performance and flexibility.
* Tweak: Disabled related videos at the end of the video.
* Tweak: Excluded private videos from the gallery.
* Tweak: Automatic advancing to the next video when the video is the last on the page. The "Pagination Type" should be "Load More".
* Tweak: Updated Freemius SDK (2.4.2).
* Fix: [+] few minor bug fixes.

= 1.6.0 =

* Tweak: Updated Freemius SDK (2.4.1).
* Fix: WordPress 5.6 compatibility issues.

= 1.5.0 =

* New: A filter hook "ayg_script_args" for developers to override the gallery JS args.
* Fix: WordPress 5.5 compatibility issues.
* Fix: YouTube API key 403 forbidden error.
* Fix: SMUSH plugin conflict issues.
* Fix: [+] few minor bug fixes.

= 1.4.0 =

* Tweak: Make URLs as clickable links in the video description.
* Tweak: Updated Freemius SDK (2.4.0).
* Fix: [+] few minor bug fixes.

= 1.3.0 =

* New: Updated plugin dashboard with a shortcode builder.
* Fix: Conflict with fitvids.js plugin.

= 1.2.0 =

* Tweak: Updated Freemius SDK (2.3.0).
* Fix: Security fix.

= 1.1.0 =

* Fix: Security fix.

= 1.0.0 =

* Initial release.

== Upgrade Notice ==

= 2.7.2 =

WordPress 7 Compatibility Release. [See changelog](https://wordpress.org/plugins/automatic-youtube-gallery/#developers)