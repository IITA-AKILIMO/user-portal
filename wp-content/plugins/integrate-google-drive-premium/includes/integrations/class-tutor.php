<?php

namespace IGD;
class Tutor {

	private static $instance = null;

	public function __construct() {
		add_filter( 'tutor_preferred_video_sources', array( $this, 'add_preferred_video_sources' ) );

		add_action( 'tutor_after_video_meta_box_item', array( $this, 'add_video_meta_box_item' ), 10, 2 );

		add_action( 'tutor_after_video_source_icon', array( $this, 'add_video_source_icon' ) );
	}

	public function add_preferred_video_sources( $sources ) {
		$sources['google_drive'] = [
			'title' => __( 'Google Drive', 'integrate-google-drive' ),
			'icon'  => 'tutor-icon-brand-google-drive',
		];

		return $sources;
	}

	public function add_video_meta_box_item( $tutor_video_input_state, $post ) {
		$video       = maybe_unserialize( get_post_meta( $post->ID, '_video', true ) );
		$videoSource = tutor_utils()->avalue_dot( 'source', $video );

		?>
		<div class="tutor-mt-16 video-metabox-source-item video_source_wrap_google_drive tutor-dashed-uploader"
		     style="<?php tutor_video_input_state( $videoSource, 'google_drive' ); ?>">

			<div class="video-metabox-source-google_drive-upload">
				<p class="video-upload-icon"><i class="tutor-icon-upload-icon-line"></i></p>
				<p><strong><?php esc_html_e( 'Select Your Video', 'integrate-google-drive' ); ?></strong></p>
				<p><?php esc_html_e( 'File Format: ', 'integrate-google-drive' ); ?> <span class="tutor-color-black">mp4, m4v, webm, ogv, flv, mov, avi, wmv, mkv, mpg, mpeg,3gp</span>
				</p>

				<div class="video_source_upload_wrap_google_drive">
					<button class="igd-tutor-button video_upload_btn tutor-btn tutor-btn-secondary tutor-btn-md">
						<?php esc_html_e( 'Browse Video', 'integrate-google-drive' ); ?>
					</button>
				</div>
			</div>

			<div class="google_drive-video-data">

				<div
					class="tutor-attachment-cards tutor-row tutor-attachment-size-below tutor-course-builder-attachments">
					<div class="tutor-col-lg-12 tutor-mb-16" data-attachment_id="">
						<div class="tutor-card">
							<div class="tutor-card-body">
								<div class="tutor-row tutor-align-center">
									<div class="tutor-col tutor-overflow-hidden">
										<div class="video-data-title tutor-fs-6 tutor-fw-medium tutor-color-black tutor-text-ellipsis tutor-mb-4"></div>
										<div class="tutor-fs-7 tutor-color-muted">
											<?php esc_html_e( 'Size', 'integrate-google-drive' ); ?>:
											<span class="video-data-size"></span>
										</div>
										<input type="hidden" name="" value="">
									</div>

									<div class="tutor-col-auto">
										<span class="tutor-delete-attachment tutor-iconic-btn tutor-iconic-btn-secondary" role="button">
											<span class="tutor-icon-times" aria-hidden="true"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


				<?php

				//phpcs:ignore
				echo '<div class="tutor-fs-6 tutor-fw-medium tutor-color-secondary tutor-mb-12" >' . __( 'Upload Video Poster', 'integrate-google-drive' ) . '</div>';

				// Load thumbnail segment.
				tutor_load_template_from_custom_path(
					tutor()->path . '/views/fragments/thumbnail-uploader.php',
					array(
						'media_id'   => tutor_utils()->avalue_dot( 'poster', $video ),
						'input_name' => 'video[poster]',
					),
					false
				);

				?>
			</div>

		</div>
		<?php
	}

	public function add_video_source_icon() { ?>
		<i class="tutor-icon-brand-google-drive" data-for="google_drive"></i>
		<?php
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

Tutor::instance();