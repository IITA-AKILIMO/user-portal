<?php

$logs = [

	'v.1.1.94' => [
		'date' => '19 April, 2023',

		'new'         => [
			'Added Tutor LMS integration.',
			'Added Divi builder integration.',
			'Added Private Files support for embed module.',
			'Added file size field show/hide option for the file browser module.',
			'Added download support for search box module.',
			'Added Embed iFrame height and width customization options.',
		],
		'fix'         => [
			'Fixed scrolling to the search box issue.',
			'Fixed multiple ACF filed issue.',
			'Fixed embed documents popout issue.',
			'Fixed WooCommerce product edit page issue.',
			'Fixed Contact Form 7 email notification file list issue.'
		],
		'enhancement' => [
			'Improved plugin performance.',
		],
	],

	'v.1.1.93' => [
		'date' => '04 April, 2023',

		'new'         => [
			'Added access denied message for the shortcode module when user is not allowed to access the module',
			'Added shortcode usage locations in the shortcode builder list',
			'Added download enable/ disable option for the Gallery module',
			'Added Statistics export option',
			'Added WooCommerce and Dokan Upload box in the product, cart, checkout, order-received and my-account page',
			'Added download all option for Gallery',
			'Added Facebook and Disqus comment integration for the Gallery module.',
		],
		'fix'         => [
			'Fixed file rename not working',
			'Fixed file browser not working in mobile devices issue',
			'Fixed ACF thumbnail_link expire issue',
			'Fixed classic editor text editor issue',
			'Fixed Forms file uploader issue',
		],
		'enhancement' => [
			'Improve WooCommerce and Dokan Uploads',
		],
	],

	'v.1.1.91' => [
		'date' => '12 March, 2023',

		'new'         => [
			'Added New Slider Carousel Module',
		],
		'fix'         => [
			'Fixed Elementor Integration Fatal Error',
		],
		'enhancement' => [
			'Updated Multiple File Selection UI',
		],
	],

	'v.1.1.90' => [
		'date' => '12 March, 2023',

		'new'         => [
			'Added support for shortcut files.',
			'Added video files support to the gallery module.',
			'Add download, upload, delete, search, preview restrictions by specific users and roles.',
			'Added Manage Sharing Permissions settings.',
			'Added Google Workspace domain support.',
			'Added Maximum Number Files to Upload settings.',
			'Added Upload File Name Rename settings.',
			'Added RTL CSS supports.',
		],
		'fix'         => [
			'Fixed private folders issue.',
			'Fixed Gallery preview not full-size image issue.',
			'Fixed Media Player not playing issue.',
			'Fixed WooCommerce upload issue.',
			'Fixed File Uploader HTTP Error issue.',
		],
		'enhancement' => [
			'Unlocked the Gallery module for free.',
			'Improved the gallery module.',
			'Improved auto sync.',
			'Improve Search Functionality.',
		],
	],

	'v.1.1.87' => [
		'date' => '12 February 2023',

		'new' => [
			'Added WooCommerce File Uploads',
			'Added Dokan plugin integration',
			'Added Advanced Custom Fields (ACF) plugin integration.',
			'Add file redirect only/ read only method instead of download after purchase in WooCommerce.',
			'Added .mkv video file support for the media player.',
			'Unlock Contact Form 7 file upload integration in the free version.',
		],
		'fix' => [
			'Fixed folder download issue.',
			'Fixed email notification issue on file upload/download/delete.',
			'Fixed minor issue with file upload.',
		],
	],
	'v.1.1.85' => [
		'date' => '17 January 2023',

		'fix'         => [
			'Fixed preview permission issue.',
			'PHP Fatal error.',
			'Fixed uploader not showing error message.',
			'Fixed WPForms Google Drive file uploader.',
		],
		'enhancement' => [
			'Updated preview functionality.',
			'Added compatibility for Elementor - v3.5.0.',
		],
	],
	'v.1.1.84' => [
		'date' => '10 January 2023',
		'new'  => [
			'Added statistics summary email report in daily, weekly, and monthly frequency.',
			'Added export/ import option for Settings, Shortcode Modules, User Private Files, and Statistics Logs.',
			'Added shortcode builder bulk selection action to delete multiple modules at once.',
		],
		'fix'  => [
			'Fixed Block Editor Module Builder Issue.',
			'Fixed Classic Editor Media Player Module Builder.',
		],
	],
	'v1.1.83'  => [
		'date' => '08 January 2023',
		'new'  => [
			'Added Download button in the media player to download the audio/video file.',
			'Added audio visualizer in the media player.',
			'Added Multiple download option for documents files.',
			'Added the option to allow users access plugin admin pages by selecting specific user roles and users.',
		],
		'fix'  => [
			'Fixed The Divi Builder compatibility issue.',
			'Fixed documents files download internal server error.',
			'Fixed multiple account issue.',
		]
	],
	'v1.1.81'  => [
		'date' => '16 December 2022',
		'fix'  => [
			'Fixed folder download internal server error issue',
			'Fixed hyperlink not working in embed documents',
		]
	],

	'v1.1.80' => [
		'date'        => '7 December, 2022',
		'new'         => [
			'Added template folder supports for while creating user private folders',
			'Added option to create and rename folders for each Google Drive form upload entry (GravityForms, WPForms, FluentForms, NinjaForms, FormidableForms, ContactForm7)',
			'Added pause/resume upload option for file upload.',
			'Added File sharing channels show/hide option in settings',
			'Added new Elementor widgets File Browser, File Uploader, Photo Gallery, Media Player, File Search, Embed Documents, Insert Download Links, Insert View Links',
			'Added new Gutenberg blocks File Browser, File Uploader, Photo Gallery, Media Player, File Search, Embed Documents, Insert Download Links, Insert View Links',
			'Added direct link option to share your files and folders with a link in your website.',
			'Added option to create Google Docs, Sheets, Slides from the file browser.',
			'Added single file selection option for the file browser module.',
			'Added single file selection option for user private folders.',
		],
		'fix'         => [
			'Fixed Classic Editor integration issue',
			'Fixed Gravity Forms Uploads not working with Google Drive',
			'Fixed Own Google App redirect URI issue',
			'Fixed multiple files zip download issue',
		],
		'enhancement' => [
			'Updated Google oAuth authentication app from WPMilitary to SoftLab',
			'Improved private folders creation process',
			'Improved Classic Editor integrations',
			'Updated Freemius SDK to the latest version.',
			'Improved multiple file selection for the file browser module.',
		],
		'remove'      => [
			'Removed Module Builder Elementor widget.',
			'Removed Module Builder Gutenberg block.',
		],
	],

	'v1.1.73' => [
		'date'        => '15 October, 2022',
		'new'         => [
			'Added supports for shared drives',
			'Added minimum file size upload option',
			'Added file selection for the Media Player & Gallery module',
			'Added Export, Import and Reset settings feature',
			'Added Gallery row height option in the Gallery module.',
			'Added NinjaForms, FluentForms and Formidable Forms Google Drive upload integration',
			'Added file sharing option in the frontend file browser.',
		],
		'fix'         => [
			'Fixed spreadsheet and slide files preview not showing issue.',
			'Fixed file browser accounts list dropdown.',
			'Fixed private folder non-allowed files showing in the list.',
			'Fixed manual Google App authentication.',
			'Fixed show files/ folders settings for the file browser module.',
		],
		'enhancement' => [
			'Improved overall Performance & User Interface',
			'Updated the file uploader UI style.',
		],
		'remove'      => [
			'Removed file browser custom background color appearance settings option.',
			'Removed Simple uploader style from the file uploader module advanced settings.',
		]
	],

	'v1.1.72' => [
		'date'        => '15 August, 2022',
		'new'         => [
			'Added file sharing.',
			'Added unlimited file size upload support.',
		],
		'fix'         => [
			'Fixed PHP error.'
		],
		'enhancement' => [
			'Improved file uploader module performance.',
		],
	],


];


?>

<div id="what-new" class="getting-started-content content-what-new">
	<div class="content-heading">
		<h2>What's new in the latest changes</h2>
		<p>Check out the latest change logs.</p>
	</div>

	<?php
	$i = 0;
	foreach ( $logs as $v => $log ) { ?>
		<div class="log <?php echo esc_attr($i == 0 ? 'active' : ''); ?>">
			<div class="log-header">
				<span class="log-version"><?php echo esc_html($v); ?></span>
				<span class="log-date">(<?php echo esc_html($log['date']); ?>)</span>

				<i class="<?php echo esc_attr($i == 0 ? 'dashicons-arrow-up-alt2' : 'dashicons-arrow-down-alt2'); ?> dashicons "></i>
			</div>

			<div class="log-body">
				<?php

				if ( ! empty( $log['new'] ) ) {
					printf('<div class="log-section new"><h3>%s</h3>', __('New Features', 'integrate-google-drive'));
					foreach ( $log['new'] as $item ) {
						echo '<div class="log-item log-item-new"><i class="dashicons dashicons-plus-alt2"></i> <span>' . $item . '</span></div>';
					}
					echo '</div>';
				}


				if ( ! empty( $log['fix'] ) ) {
					printf('<div class="log-section fix"><h3>%s</h3>', __('Fixes', 'integrate-google-drive'));
					foreach ( $log['fix'] as $item ) {
						echo '<div class="log-item log-item-fix"><i class="dashicons dashicons-saved"></i> <span>' . $item . '</span></div>';
					}
					echo '</div>';
				}

				if ( ! empty( $log['enhancement'] ) ) {
					printf('<div class="log-section enhancement"><h3>%s</h3>', __('Enhancements', 'integrate-google-drive'));
					foreach ( $log['enhancement'] as $item ) {
						echo '<div class="log-item log-item-enhancement"><i class="dashicons dashicons-star-filled"></i> <span>' . $item . '</span></div>';
					}
					echo '</div>';
				}

				if ( ! empty( $log['remove'] ) ) {
					printf( '<div class="log-section remove"><h3>%s</h3>', __('Removes', 'integrate-google-drive'));
					foreach ( $log['remove'] as $item ) {
						echo '<div class="log-item log-item-remove"><i class="dashicons dashicons-trash"></i> <span>' . $item . '</span></div>';
					}
					echo '</div>';
				}


				?>
			</div>

		</div>
		<?php
		$i ++;
	} ?>


</div>


<script>
    jQuery(document).ready(function ($) {
        $('.log-header').on('click', function () {
            $(this).next('.log-body').slideToggle();
            $(this).find('i').toggleClass('dashicons-arrow-down-alt2 dashicons-arrow-up-alt2');
            $(this).parent().toggleClass('active');
        });
    });
</script>