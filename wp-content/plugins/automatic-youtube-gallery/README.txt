=== Automatic YouTube Gallery ===
Plugin URI: https://plugins360.com/automatic-youtube-gallery/
Contributors: plugins360, wpvideogallery, freemius
Donate link: https://plugins360.com
Tags: youtube gallery, youtube playlist, youtube channel, youtube embed, youtube live
Requires at least: 4.9.5
Tested up to: 6.1
Requires PHP: 5.6.20
Stable tag: 2.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Build dynamic video galleries by simply adding a YouTube USERNAME, CHANNEL, PLAYLIST, SEARCH TERM, or a custom list of video URLs.

== Description ==

Create responsive, modern & dynamic video galleries by simply adding a YouTube USERNAME, CHANNEL, PLAYLIST, SEARCH TERM, or a custom list of video URLs.

* [View Demo](https://demo.plugins360.com/automatic-youtube-gallery/)
* [Documentation](https://plugins360.com/automatic-youtube-gallery/documentation/)
* [Contact & Support](https://plugins360.com/support/)
* [Home Page](https://plugins360.com/automatic-youtube-gallery/)

<blockquote>
The only dynamic YouTube gallery plugin with <a href="https://plugins360.com/automatic-youtube-gallery/deeplinking/">deeplinking</a> capabilities.
</blockquote>

https://www.youtube.com/watch?v=a90OGk42fJ4&rel=0

### STANDARD FEATURES

* Create unlimited galleries.
* Automate your galleries using various YouTube sources like,
 * USERNAME
 * CHANNEL
 * PLAYLIST
 * SEARCH TERM
 * Custom YouTube URLs list
* Auto Embed Live Stream from a YouTube Channel.
* GDPR consent before the playback.
* Gutenberg Block support.
* Shortcode Builder for the old classic editor and other third-party page builders.
* Sidebar Widget
* Built-in caching for quick page loads.
* Most importantly, a Clear & Beautiful Admin Interface.
* [+] Hooks for Developers.

### PREMIUM FEATURES

* [SEO](https://plugins360.com/automatic-youtube-gallery/deeplinking/): Deeplinking, Open Graph Tags, and Schema.org Markup (via JSON-LD).
* [Popup Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-popup/)
* [Slider Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-slider/)
* [Playlist Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-playlister/)
* [Inline Theme](https://demo.plugins360.com/automatic-youtube-gallery/theme-inline/)

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

Yes. Simply, generate your shortcode using the plugin's "Shortcode Builder" and add it to your favourite page builder.

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

= 2.2.0 =

Introduces several bug fixes. [See changelog](https://wordpress.org/plugins/automatic-youtube-gallery/#developers)