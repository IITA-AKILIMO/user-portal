<?php
/**
 * JS reference : assets/js/admin/layout.js
 */

/** @var $this Forminator_CForm_View_Page */
$count             = $this->filtered_total_entries();
$is_filter_enabled = $this->is_filter_box_enabled();

$live_payment_count = $this->has_live_payments( $this->form_id );
if ( $this->has_payments() && $count <= 100 ) {
	$notice_args = array(
		'submissions'     => $live_payment_count,
		'min_submissions' => 0,
		'notice'          => sprintf( esc_html__( "%1\$sCongratulations!%2\$s You have started collecting live payments on this form - that's awesome. We have spent countless hours developing this free plugin for you, and we would really appreciate it if you could drop us a rating on wp.org to help us spread the word and boost our motivation.", 'forminator' ), '<strong>', '</strong>' ),
	);
} else {
	$notice_args = array(
		'submissions' => $count,
	);
}

if ( $this->error_message() ) : ?>

		<div
			role="alert"
			class="sui-notice sui-notice-red sui-active"
			style="display: block; text-align: left;"
			aria-live="assertive"
		>

			<div class="sui-notice-content">

				<div class="sui-notice-message">

					<span class="sui-notice-icon sui-icon-info" aria-hidden="true"></span>

					<p><?php echo esc_html( $this->error_message() ); ?></p>

				</div>

			</div>

		</div>

	<?php
endif;

if ( $this->total_entries() > 0 ) :

	$is_registration = ! empty( $this->model->settings['form-type'] )
			&& 'registration' === $this->model->settings['form-type'];
	?>

	<form method="GET" class="forminator-entries-actions">

		<input type="hidden" name="page" value="<?php echo esc_attr( $this->get_admin_page() ); ?>">
		<input type="hidden" name="form_type" value="<?php echo esc_attr( $this->get_form_type() ); ?>">
		<input type="hidden" name="form_id" value="<?php echo esc_attr( $this->get_form_id() ); ?>">

		<div class="fui-pagination-entries sui-pagination-wrap">
			<?php $this->paginate(); ?>
		</div>

		<div class="sui-box fui-box-entries">

			<fieldset class="forminator-entries-nonce">
				<?php wp_nonce_field( 'forminatorFormEntries', 'forminatorEntryNonce' ); ?>
			</fieldset>

			<div class="sui-box-body fui-box-actions">

				<?php $this->template( 'common/entries/prompt', $notice_args ); ?>

				<?php
				$this->template(
					'common/entries/filter',
					array(
						'fields'          => $this->model->get_real_fields(),
						'is_registration' => $is_registration,
					)
				);
				?>

			</div>

			<?php if ( true === $is_filter_enabled ) : ?>

				<?php $this->template( 'common/entries/active_filters_row' ); ?>

			<?php endif; ?>

			<table class="sui-table sui-table-flushed sui-accordion fui-table-entries">

				<?php $this->entries_header(); ?>

				<tbody>

				<?php
				$url_entry_id = filter_input( INPUT_GET, 'entry_id', FILTER_VALIDATE_INT );
				$url_entry_id = $url_entry_id ? $url_entry_id : 0;
				foreach ( $this->entries_iterator() as $entries ) {

					$entry_id    = $entries['id'];
					$db_entry_id = isset( $entries['entry_id'] ) ? $entries['entry_id'] : '';
					$draft_id    = isset( $entries['draft_id'] ) ? $entries['draft_id'] : '';

					$summary       = $entries['summary'];
					$summary_items = $summary['items'];

					$detail       = $entries['detail'];
					$detail_items = $detail['items'];

					$accordion_classes = '';
					// Open entry tab by received submission link.
					if ( $url_entry_id === (int) $db_entry_id ) {
						$accordion_classes .= ' sui-accordion-item--open';
					}
					if ( ! empty( $draft_id ) ) {
						$accordion_classes .= ' sui-default draft-entry';
					}

					$pending_approval = ! empty( $entries['activation_key'] );
					if ( $pending_approval ) {
						$accordion_classes .= ' sui-warning';
					}
					?>

					<tr class="sui-accordion-item <?php echo esc_attr( $accordion_classes ); ?>" data-entry-id="<?php echo esc_attr( $db_entry_id ); ?>">

						<?php foreach ( $summary_items as $key => $summary_item ) { ?>

							<?php
							if ( ! $summary['num_fields_left'] && ( count( $summary_items ) - 1 ) === $key ) :

								echo '<td>';

								echo esc_html( $summary_item['value'] );

								echo '<span class="sui-accordion-open-indicator">';

								echo '<i class="sui-icon-chevron-down"></i>';

								echo '</span>';

								echo '</td>';

							elseif ( 1 === $summary_item['colspan'] ) :

								echo '<td class="sui-accordion-item-title">';

								echo '<label class="sui-checkbox">';

								echo '<input type="checkbox" name="entry[]" value="' . esc_attr( $db_entry_id ) . '" id="wpf-cform-module-' . esc_attr( $db_entry_id ) . '" />';

								echo '<span aria-hidden="true"></span>';

								echo '<span class="sui-screen-reader-text">' . sprintf(/* translators: ... */
									esc_html__( 'Select entry number %s', 'forminator' ),
									esc_html( $db_entry_id )
								) . '</span>';

								echo '</label>';

								echo esc_html( $db_entry_id );

								if ( ! empty( $draft_id ) ) {
									echo '<span class="sui-tag draft-tag">' . esc_html__( 'Draft', 'forminator' ) . '</span>';
								}

								if ( $pending_approval ) {
									echo '&nbsp;&nbsp;<span class="sui-tooltip" data-tooltip="'
											. esc_html__( 'Pending Approval', 'forminator' ) . '" type="button">'
											. '<span class="sui-icon-warning-alert sui-warning" aria-hidden="true"></span>'
											. '<span class="sui-screen-reader-text">' . esc_html__( 'Pending Approval', 'forminator' ) . '</span>'
										. '</span>';
								}

								echo '</td>';

							else :

								echo '<td>';

								echo '<div class="forminator-submissions-column-ellipsis">' . esc_html( $summary_item['value'] ) . '</div>';

								echo '<span class="sui-accordion-open-indicator fui-mobile-only" aria-hidden="true">';
								echo '<i class="sui-icon-chevron-down"></i>';
								echo '</span>';

								echo '</td>';

							endif;
							?>

						<?php } ?>

						<?php
						if ( $summary['num_fields_left'] ) {

							echo '<td>';
							echo '' . sprintf(/* translators: ... */
								esc_html__( '+ %s other fields', 'forminator' ),
								esc_html( $summary['num_fields_left'] )
							) . '';
							echo '<span class="sui-accordion-open-indicator">';
							echo '<i class="sui-icon-chevron-down"></i>';
							echo '</span>';
							echo '</td>';

						}
						?>

					</tr>

					<tr class="sui-accordion-item-content">

						<td colspan="<?php echo esc_attr( $detail['colspan'] ); ?>">

							<div class="sui-box fui-entry-content">

								<div class="sui-box-body">

									<h2 class="fui-entry-title"><?php echo '#' . esc_attr( $db_entry_id ); ?></h2>

									<?php if ( ! empty( $draft_id ) ) { ?>
										<div class="sui-box-settings-slim-row sui-sm draft-id">
											<div class="sui-box-settings-col-1">
												<span class="sui-settings-label"><?php esc_html_e( 'Draft ID', 'forminator' ); ?></span>
											</div>
											<div class="sui-box-settings-col-2">
												<span class="sui-settings-label"><strong><?php echo esc_html( $draft_id ); ?></strong></span>
											</div>
										</div>
									<?php } ?>

									<?php foreach ( $detail_items as $detail_item ) { ?>
										<?php include_once forminator_plugin_dir() . 'admin/views/custom-form/entries/content-details.php'; ?>
										<?php forminator_submissions_content_details( $detail_item ); ?>
									<?php } ?>

								</div>

								<div class="sui-box-footer">

									<button
											type="button"
											class="sui-button sui-button-ghost sui-button-red wpmudev-open-modal"
										<?php
										if ( isset( $entries['activation_key'] ) ) {
											$button_title      = esc_html( 'Delete Submission & User', 'forminator' );
											$is_activation_key = true;
											?>
											data-activation-key="<?php echo esc_attr( $entries['activation_key'] ); ?>"
											data-modal="delete-unconfirmed-user-module"
											data-entry-id="<?php echo esc_attr( $db_entry_id ); ?>"
											data-form-id="<?php echo esc_attr( $this->model->id ); ?>"
											<?php
										} else {
											$button_title      = esc_html( 'Delete', 'forminator' );
											$is_activation_key = false;
											?>
											data-modal="delete-module"
											data-form-id="<?php echo esc_attr( $db_entry_id ); ?>"
										<?php } ?>
											data-modal-title="<?php esc_attr_e( 'Delete Submission', 'forminator' ); ?>"
											data-modal-content="<?php esc_attr_e( 'Are you sure you wish to permanently delete this submission?', 'forminator' ); ?>"
											data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminatorFormEntries' ) ); ?>"
									>
										<i class="sui-icon-trash" aria-hidden="true"></i> <?php echo wp_kses_post( $button_title ); ?>
									</button>

									<?php if ( isset( $entries['activation_method'] ) && 'manual' === $entries['activation_method'] && $is_activation_key ) { ?>

										<div class="sui-actions-right">
											<button
													type="button"
													class="sui-button wpmudev-open-modal"
													data-modal="approve-user-module"
													data-modal-title="<?php esc_attr_e( 'Approve User', 'forminator' ); ?>"
													data-modal-content="<?php esc_attr_e( 'Are you sure you want to approve and activate this user?', 'forminator' ); ?>"
													data-form-id="<?php echo esc_attr( $db_entry_id ); ?>"
													data-activation-key="<?php echo esc_attr( $entries['activation_key'] ); ?>"
													data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminatorFormEntries' ) ); ?>"
											>
												<?php esc_html_e( 'Approve User', 'forminator' ); ?>
											</button>
										</div>

									<?php } ?>

									<div class="sui-actions-right">

										<?php if ( empty( $entries['draft_id'] ) ) { ?>
											<button
												role="button"
												class="sui-button sui-button-ghost forminator-resend-notification-email"
												data-entry-id="<?php echo esc_attr( $db_entry_id ); ?>"
												data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminatorResendNotificationEmail' ) ); ?>"
											>
												<span class="sui-icon-send" aria-hidden="true"></span>
												<?php esc_html_e( 'Resend Notification Email', 'forminator' ); ?>
											</button>
										<?php } ?>

										<?php if ( ( isset( $entries['activation_method'] ) && 'email' === $entries['activation_method'] ) && isset( $entries['activation_key'] ) ) { ?>

											<button
												role="button"
												class="sui-button sui-button-ghost resend-activation-btn"
												data-activation-key="<?php echo esc_attr( $entries['activation_key'] ); ?>"
												data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminatorResendActivation' ) ); ?>"
											>
												<span class="sui-icon-undo" aria-hidden="true"></span>
												<?php esc_html_e( 'Resend activation link', 'forminator' ); ?>
											</button>

										<?php } ?>

									</div>

								</div>

							</div>

						</td>

					</tr>

				<?php } ?>

				</tbody>

			</table>

			<div class="sui-box-body fui-box-actions">

				<div class="sui-box-search">

					<?php $this->bulk_actions( 'bottom', $is_registration ); ?>

				</div>

			</div>

		</div>

	</form>

<?php else : ?>

	<?php include_once forminator_plugin_dir() . 'admin/views/common/entries/content-none.php'; ?>
	<?php
endif;
