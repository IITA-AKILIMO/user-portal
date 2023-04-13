<?php

namespace IGD;


class ACF extends \acf_field {

	private static $instance = null;

	public function __construct() {

		$this->name = 'integrate_google_drive_field';

		$this->label = __( 'Google Drive Files', 'integrate-google-drive' );

		$this->category = __( 'Integrate Google Drive', 'integrate-google-drive' );

		parent::__construct();
	}

	public function render_field( $field ) { ?>
        <div class="igd-acf-field">
			<?php
			acf_hidden_input(
				[
					'name'      => $field['name'],
					'value'     => empty( $field['value'] ) ? '' : json_encode( $field['value'] ),
					'data-name' => 'id',
				]
			);

			$files = $field['value'];

			?>
            <table class="igd-items-table wp-list-table widefat striped">
                <thead>
                <th style="width: 18px;"></th>
                <th><?php esc_html_e( 'Name', 'integrate-google-drive' ); ?></th>
                <th><?php esc_html_e( 'File ID', 'integrate-google-drive' ); ?></th>
                <th style="width: 220px;"><?php esc_html_e( 'Actions', 'integrate-google-drive' ); ?></th>
                </thead>

                <tbody>
				<?php
				if ( ! empty( $files ) ) {
					foreach ( $files as $file ) { ?>
                        <tr>
                            <td><img class="file-icon" src="<?php echo esc_url( $file['icon_link'] ); ?>"/></td>
                            <td class="file-name" style="max-width: 220px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;display: block;"><?php echo esc_html( $file['name'] ); ?></td>
                            <td class="file-id"><?php echo esc_html( $file['id'] ); ?></td>
                            <td class="file-actions">
                                <a href="<?php echo esc_url( $file['view_link'] ); ?>" target="_blank"
                                   class="button file-view"><?php esc_html_e( 'View', 'integrate-google-drive' ); ?></a>
                                <a href="<?php echo esc_url( $file['download_link'] ); ?>" class="button file-download"><?php esc_html_e( 'Download', 'integrate-google-drive' ); ?></a>
                                <a href="#" class="button button-link-delete file-remove"
                                   data-id="<?php echo esc_attr( $file['id'] ) ?>"><?php esc_html_e( 'Remove', 'integrate-google-drive' ); ?></a>
                            </td>
                        </tr>
					<?php }
				} else {
					printf( '<tr class="empty-row"><td></td><td colspan="3">%s</td></tr>', __( 'No Files Added', 'integrate-google-drive' ) );
				}
				?>
                </tbody>
            </table>

            <button type="button" class="button button-secondary igd-acf-button">
                <img src="<?php echo IGD_ASSETS; ?>/images/drive.png" width="20"/>
                <span><?php echo __( 'Add File', 'integrate-google-drive' ) ?></span>
            </button>
        </div>
		<?php
	}

	public function load_value( $value, $post_id, $field ) {
		if ( empty( $value ) ) {
			return [];
		}

		return json_decode( $value, true );
	}

	public function update_value( $value, $post_id, $field ) {

		if ( ! is_array( $value ) ) {
			$entries = json_decode( wp_unslash( $value ), true );
		} else {
			$entries = $value;
		}


		if ( empty( $entries ) ) {
			return [];
		}

		return json_encode( $entries );
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

ACF::instance();