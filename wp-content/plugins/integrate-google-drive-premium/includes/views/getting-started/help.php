<?php

$faqs = [
	[
		'question' => __( 'Is there any upload file size limit for the File Uploader module?', 'integrate-google-drive' ),
		'answer'   => __( 'No, using the File Uploader module you can upload unlimited size of files to your Google Drive.', 'integrate-google-drive' ),
	],[
		'question' => __( 'Is the files uploaded directly to Google Drive?', 'integrate-google-drive' ),
		'answer'   => __( 'Yes, the files directly uploaded to the Google Drive and doesn\'t affect your server storage or performance.', 'integrate-google-drive' ),
	],
	[
		'question' => __( 'Can the users share the files using the file links or through email?', 'integrate-google-drive' ),
		'answer'   => __( 'Yes, Users can share the files links via Direct File link, Email, Facebook, Twitter, and Whatsapp, and also can get embed code to share the file on a web page.', 'integrate-google-drive' ),
	],
	[
		'question' => __( 'Can I link a Google Drive folder to a user on my site when they have been registered?', 'integrate-google-drive' ),
		'answer'   => __( 'Yes, you can link a Google Drive folder to a user on your site when they have been registered. You can also link the private folders to the users manually.', 'integrate-google-drive' ),
	],
	[
		'question' => __( 'Can I use multiple Google Drive accounts?', 'integrate-google-drive' ),
		'answer'   => __( 'Yes, you can link to multiple Google Drive accounts to Integrate Google Drive plugin.', 'integrate-google-drive' ),
	],
	[
		'question' => __( 'Are there any usage limits?', 'integrate-google-drive' ),
		'answer'   => __( 'There are no bandwidth or file size issues for your web host. If you want to stream any media files (Audio, Video), the files will be streamed directly from Google Drive.
<br><br>
But, when any zip file will be downloaded, these will be downloaded through your site and can generate some traffic.', 'integrate-google-drive' ),
	],
	[
		'question' => __( 'Documents preview not working?', 'integrate-google-drive' ),
		'answer'   => __( 'In order to preview documents, the files should have the sharing permission "Anyone with link can view". The plugin will automatically change the sharing permission.
<br><br>
However, in some case the plugin isn\'t able to manage the sharing permissions even with those setting enabled. In that case, please try to set the sharing permissions manually via the native Google Drive interface.', 'integrate-google-drive' ),
	],
	[
		'question' => __( 'Why search module search results are slow?', 'integrate-google-drive' ),
		'answer'   => __( 'The search module search results may take some time to show the search results. The time depends on the number of files that are selected for the search module. If your selected folders for the search module have a lot of children files then the search module search results may take some time to show the search results.', 'integrate-google-drive' ),
	],
];

?>


<div id="help" class="igd-help getting-started-content">

    <div class="content-heading">
        <h2><?php esc_html_e( 'Frequently Asked Questions', 'integrate-google-drive' ); ?></h2>
    </div>

    <section class="section-faq">
		<?php foreach ( $faqs as $faq ) : ?>
            <div class="faq-item">
                <div class="faq-header">
                    <i class="dashicons dashicons-arrow-down-alt2"></i>
                    <h3><?php echo $faq['question']; ?></h3>
                </div>

                <div class="faq-body">
                    <p><?php echo $faq['answer']; ?></p>
                </div>
            </div>
		<?php endforeach; ?>
    </section>

    <div class="content-heading">
        <h2><?php esc_html_e( 'Need Help?', 'integrate-google-drive' ); ?></h2>
        <p><?php esc_html_e( 'Read our knowledge base documentation or you can contact us directly.', 'integrate-google-drive' ); ?></p>
    </div>

    <div class="section-wrap">
        <section class="section-documentation section-half">
            <div class="col-image">
                <img src="<?php echo IGD_ASSETS . '/images/getting-started/documentation.png' ?>"
                     alt="<?php esc_attr_e( 'Documentation', 'integrate-google-drive' ); ?>">
            </div>
            <div class="col-description">
                <h2><?php _e( 'Documentation', 'integrate-google-drive' ) ?></h2>
                <p>
					<?php esc_html_e( 'Check out our detailed online documentation and video tutorials to find out more about what you can
                    do.', 'integrate-google-drive' ); ?>
                </p>
                <a class="igd-btn btn-primary" href="https://softlabbd.com/integrate-google-drive"
                   target="_blank"><?php esc_html_e( 'Documentation', 'integrate-google-drive' ); ?></a>
            </div>
        </section>

        <section class="section-contact section-half">
            <div class="col-image">
                <img src="<?php echo IGD_ASSETS . '/images/getting-started/contact.png' ?>"
                     alt="<?php esc_attr_e( 'Contact', 'integrate-google-drive' ); ?>">
            </div>
            <div class="col-description">
                <h2><?php esc_html_e( 'Contact us', 'integrate-google-drive' ); ?></h2>
                <p><?php esc_html_e( 'We have dedicated support team to provide you fast, friendly & top-notch customer support.', 'integrate-google-drive' ); ?></p>
                <a class="igd-btn btn-primary" href="https://softlabbd.com/contact" target="_blank">
					<?php esc_html_e( 'Contact us', 'integrate-google-drive' ); ?>
                </a>
            </div>
        </section>
    </div>

    <div class="facebook-cta">
        <div class="cta-content">
            <h2><?php esc_html_e( 'Join our Facebook Group', 'integrate-google-drive' ); ?></h2>
            <p>
                <?php esc_html_e( 'Discuss, and share your problems & solutions for Integrate Google Drive WordPress plugin. Let\'s make a
                better community, share ideas, solve problems and finally build good relations.', 'integrate-google-drive' ); ?>
            </p>
        </div>

        <div class="cta-btn">
            <a href="https://www.facebook.com/groups/integrate.google.drive.wp" class="igd-btn btn-primary"
               target="_blank"
            ><?php esc_html_e( 'Join Now', 'integrate-google-drive' ); ?></a>
        </div>

    </div>

</div>

<script>
    jQuery(document).ready(function ($) {
        $('.igd-help .faq-item .faq-header').on('click', function () {
            $(this).parent().toggleClass('active');
        });
    });
</script>