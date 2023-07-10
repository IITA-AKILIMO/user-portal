<?php

$integrations = [
	'classic-editor' => [
		'title'       => __( 'Classic Editor', 'integrate-google-drive' ),
		'description' => __( 'Add Google Drive module, embed documents and insert file view links and download links using the Google Drive button on the classic editor.', 'integrate-google-drive' ),
	],

	'gutenberg-editor' => [
		'title'       => __( 'Gutenberg Editor', 'integrate-google-drive' ),
		'description' => __( 'Add Google Drive modules, embed documents and insert file view links and download links using the Google Drive Gutenberg editor blocks', 'integrate-google-drive' ),
	],

	'elementor' => [
		'title'       => __( 'Elementor', 'integrate-google-drive' ),
		'description' => __( 'Add Google Drive modules, embed documents and insert file view links and download links using the Google Drive Elementor widgets.', 'integrate-google-drive' ),
	],


	'divi' => [
		'title'       => __( 'Divi', 'integrate-google-drive' ),
		'description' => __( 'Add Google Drive modules, embed documents and insert file view links and download links using the Google Drive Divi Page Builder modules.', 'integrate-google-drive' ),
	],

	'acf' => [
		'title'       => __( 'Advanced Custom Fields', 'integrate-google-drive' ),
		'description' => __( 'Allows you to select Google Drive files and folders using ACF field and display in theme template file.', 'integrate-google-drive' ),
	],

	'woocommerce'     => [
		'title'       => __( 'WooCommerce', 'integrate-google-drive' ),
		'description' => __( 'You can serve your downloadable product\'s files directly from Google Drive, and also you can let your customers upload files to your Google Drive account when they purchase your products.', 'integrate-google-drive' ),
	],
	'dokan'           => [
		'title'       => __( 'Dokan', 'integrate-google-drive' ),
		'description' => __( 'Allows vendors to serve their Google Drive files as downloadable files and let customer upload files to Google Drive on checkout.', 'integrate-google-drive' ),
	],
	'edd'             => [
		'title'       => __( 'Easy Digital Downloads', 'integrate-google-drive' ),
		'description' => __( 'Allows you to serve your Easy Digital Downloads files directly from Google Drive.', 'integrate-google-drive' ),
	],
	'tutor'             => [
		'title'       => __( 'Tutor LMS', 'integrate-google-drive' ),
		'description' => __( 'Allows you to serve your course videos and attachment files directly from Google Drive.', 'integrate-google-drive' ),
	],
	'cf7'             => [
		'title'       => __( 'Contact Form 7', 'integrate-google-drive' ),
		'description' => __( 'Allows you to upload your files directly to Google Drive from your Contact Form 7 upload field.', 'integrate-google-drive' ),
	],
	'wpforms'         => [
		'title'       => __( 'WPForms', 'integrate-google-drive' ),
		'description' => __( 'Allows you to upload your files directly to Google Drive from your WPForms upload field.', 'integrate-google-drive' ),
	],
	'gravityforms'    => [
		'title'       => __( 'Gravity Forms', 'integrate-google-drive' ),
		'description' => __( 'Allows you to upload your files directly to Google Drive from your Gravity Forms upload field.', 'integrate-google-drive' ),
	],
	'fluentforms'     => [
		'title'       => __( 'Fluent Forms', 'integrate-google-drive' ),
		'description' => __( 'Allows you to upload your files directly to Google Drive from your Fluent Forms upload field.', 'integrate-google-drive' ),
	],
	'formidableforms' => [
		'title'       => __( 'Formidable Forms', 'integrate-google-drive' ),
		'description' => __( 'Allows you to upload your files directly to Google Drive from your Formidable Forms upload field.', 'integrate-google-drive' ),
	],
	'ninjaforms'      => [
		'title'       => __( 'Ninja Forms', 'integrate-google-drive' ),
		'description' => __( 'Allows you to upload your files directly to Google Drive from your Ninja Forms upload field.', 'integrate-google-drive' ),
	]
];

?>

<div id="introduction" class="getting-started-content content-introduction active">

    <section class="section-introduction section-full">
        <div class="col-description">
            <h2><?php esc_html_e( 'Quick Overview', 'integrate-google-drive' ); ?></h2>
            <p>
				<?php
				esc_html_e( 'Integrate Google Drive is the best and easy to use Google Drive cloud solution plugin for
                WordPress to integrate your Google Drive documents and media directly into your WordPress
                Website.', 'integrate-google-drive' );
				?>
            </p>
            <p>
				<?php
				esc_html_e( 'Share your Google Drive cloud files into your site very fast and easily. You can browse, manage,
                embed, display, upload, download, search, play, share your Google Drive files directly into your
                website without any hassle and coding.', 'integrate-google-drive' );
				?>
            </p>
        </div>

        <div class="col-image">

            <iframe src="https://www.youtube.com/embed/3RqCA7J9HB4?rel=0"
                    title="Integrate Google Drive - Video Overview" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>

    </section>

    <div class="content-heading">
        <h2><?php esc_html_e( 'Never miss a valuable features', 'integrate-google-drive' ); ?></h2>
        <p><?php esc_html_e( 'Let\'s explore the awesome features of the plugin', 'integrate-google-drive' ); ?></p>
    </div>

    <div class="section-wrap">
        <section class="section-file-browser section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'File Browser', 'integrate-google-drive' ); ?></h2>

                <p>
					<?php
					esc_html_e( 'You can manage your cloud files from your website using the full-featured file browser of the
                    plugin. Manage preview, download, upload, rename, move, delete, permissions per user using
                    the file browser. Users can also browse your cloud files using the File Browser.', 'integrate-google-drive' );
					?>
                </p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/file-browser.png'); ?>"
                     alt="<?php esc_attr_e( 'File Browser', 'integrate-google-drive' ); ?>">
            </div>
        </section>


        <section class="section-file-uploader section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'File Uploader', 'integrate-google-drive' ); ?></h2>

                <p>
					<?php
					esc_attr_e( 'You and also your users can upload files directly to your Google Drive account from your
                    site. You can upload unlimited size of files.', 'integrate-google-drive' );
					?>
                </p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/file-uploader.png'); ?>"
                     alt="<?php esc_attr_e( 'File Uploader', 'integrate-google-drive' ); ?>">
            </div>
        </section>
    </div>

    <section class="section-media-player section-full">
        <div class="col-description">
            <h2><?php esc_html_e( 'Media Player', 'integrate-google-drive' ); ?></h2>
            <p>
				<?php esc_html_e( 'You can play your Google Drive audio & video files with a playlist into your website. Audio and
                video can be played in a single player.', 'integrate-google-drive' ); ?>
            </p>
        </div>

        <div class="col-image">
            <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/media-player.png'); ?>"/>
        </div>
    </section>

    <div class="section-wrap">

        <section class="section-photo-gallery section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'Gallery', 'integrate-google-drive' ); ?></h2>
                <p>
					<?php esc_html_e( 'You can add a grid lightbox popup gallery of photos and videos in your page/ post using the gallery
                    module of the plugin. The gallery will be generated based on the folders, photos and images that you select.', 'integrate-google-drive' ); ?>
                </p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/photo-gallery.png'); ?>"/>
            </div>
        </section>

        <section class="section-slider-carousel section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'Slider Carousel', 'integrate-google-drive' ); ?></h2>
                <p>
					<?php esc_html_e( 'With the Slider Carousel module, you can create a beautiful and interactive slider carousel to showcase your Google Drive images, videos, and documents. Simply use the shortcode to embed the slider anywhere on your site.', 'integrate-google-drive' ); ?>
                </p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/slider-carousel.png'); ?>"/>
            </div>
        </section>

    </div>

    <div class="section-wrap">
        <section class="section-file-search section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'File Search', 'integrate-google-drive' ); ?></h2>
                <p><?php esc_html_e( 'You can search any of your cloud files from your site and also let the users to search the
                    cloud files to view and download.', 'integrate-google-drive' ); ?></p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/file-search.png'); ?>"/>
            </div>
        </section>

        <section class="section-embed section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'Embed Documents', 'integrate-google-drive' ); ?></h2>
                <p>
					<?php
					esc_html_e( 'You can easily embed any Google Drive Cloud files in any post/ page of your WordPress website
                directly using this plugin.', 'integrate-google-drive' );
					?>
                </p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/embed.png'); ?>"/>
            </div>

        </section>
    </div>

    <div class="section-wrap">
        <section class="section-file-importer section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'File Importer', 'integrate-google-drive' ); ?></h2>
                <p>
					<?php esc_html_e( 'Import any Google Drive document and media files to your media library by one click and use
                    them on any post/ page.', 'integrate-google-drive' ); ?>
                </p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/file-importer.png'); ?>"/>
            </div>
        </section>

        <section class="section-links section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'File View & Download Links', 'integrate-google-drive' ); ?></h2>
                <p><?php esc_html_e( 'You can insert direct links to your post/ page to download/ view your Google Drive cloud
                    files.', 'integrate-google-drive' ); ?></p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/links.png'); ?>"/>
            </div>
        </section>
    </div>

    <div class="section-wrap">
        <section class="section-private-folders section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'Private Folders', 'integrate-google-drive' ); ?></h2>
                <p>
					<?php esc_html_e( 'Using Private Folders you can easily and securely share your Google Drive documents with your
                    users/clients. This allows your users/ clients to view, download and manage their documents
                    in their own private folders.', 'integrate-google-drive' ); ?>
                </p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/private-folders.png'); ?>"/>
            </div>
        </section>

        <section class="section-multiple-accounts section-half">
            <div class="col-description">
                <h2><?php esc_html_e( 'Multiple Google Accounts', 'integrate-google-drive' ); ?></h2>
                <p><?php esc_html_e( 'You can link multiple Google accounts and can use files from the multiple accounts.', 'integrate-google-drive' ); ?></p>
            </div>

            <div class="col-image">
                <img src="<?php echo esc_url(IGD_ASSETS . '/images/getting-started/multiple-accounts.png'); ?>"/>
            </div>
        </section>
    </div>

    <div class="content-heading">
        <h2><?php esc_html_e( 'Powerful Integrations with Popular Plugins', 'integrate-google-drive' ); ?></h2>
        <p><?php esc_html_e( 'Using this plugin, you can integrate your Google Drive with available popular plugins.', 'integrate-google-drive' ); ?> </p>
    </div>


    <section class="integrations">
		<?php foreach ( $integrations as $key => $integration ) { ?>
            <div class="integration">
                <div class="integration-logo">
                    <img src="<?php echo esc_url(IGD_ASSETS . '/images/settings/' . $key . '.png'); ?>"
                         alt="<?php echo esc_attr($integration['title']); ?>">
                </div>
                <h3 class="integration-title"><?php echo esc_html($integration['title']); ?></h3>
                <p><?php echo esc_html($integration['description']); ?></p>
            </div>
		<?php } ?>
    </section>


</div>