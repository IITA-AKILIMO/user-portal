<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_Reports
 *
 * Handle data exports
 *
 * @since 1.0
 */
class Forminator_Reports {

	/**
	 * Plugin instance
	 *
	 * @since  1.20.0
	 * @access private
	 * @var null
	 */
	private static $instance = null;

	/**
	 * report instance
	 *
	 * @var null
	 */
	public $report_instance = null;

	/**
	 * Return the plugin instance
	 *
	 * @return Forminator_Reports|null
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Main constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		add_action( 'wp_footer', array( &$this, 'schedule_reports' ) );
		add_action( 'forminator_process_report', array( &$this, 'process_report' ) );
	}

	/**
	 * Set up the schedule
	 *
	 * @since 1.0
	 */
	public function schedule_reports() {
		if ( ! wp_next_scheduled( 'forminator_process_report' ) ) {
			wp_schedule_event( time(), 'every_minute', 'forminator_process_report' );
		}
	}

	/**
	 * process report.
	 *
	 * @since 1.20.0
	 */
	public function process_report() {
		$report_model = Forminator_Form_Reports_Model::get_instance();
		$report_data  = $report_model->fetch_all_report();

		if ( empty( $report_data ) ) {
			return;
		}

		foreach ( $report_data as $report ) {
			$report_value = Forminator_Core::sanitize_array( maybe_unserialize( $report->report_value ) );
			if ( 'active' !== $report->status || empty( $report_value ) ) {
				continue;
			}

			$report_schedule = $report_value['schedule'];
			$last_sent       = strtotime( $report->date_updated );
			$current_time    = current_time( 'timestamp' );
			// check the next sent.
			$next_sent = null;
			$frequency = ! empty( $report_schedule['frequency'] ) ? $report_schedule['frequency'] : 'daily';
			switch ( $frequency ) {
				case 'daily':
					$next_sent = strtotime( '+24 hours', $last_sent );
					$next_sent = date_i18n( 'Y-m-d', $next_sent ) . ' ' . $report_schedule['time'];
					break;
				case 'weekly':
					$day       = isset( $report_schedule['weekDay'] ) ? $report_schedule['weekDay'] : 'monday';
					$next_sent = strtotime( 'next ' . $day, $last_sent );
					$next_sent = date_i18n( 'Y-m-d', $next_sent ) . ' ' . $report_schedule['weekTime'];
					break;
				case 'monthly':
					$next_sent = $this->get_monthly_report_date( $last_sent, $report_schedule );
					break;
				default:
					break;
			}

			if ( $current_time > strtotime( trim( $next_sent ) ) ) {
				$this->send_email_report( $report_value );
				$report_model->report_update_date( $report->report_id );
			}
		}
	}

	/**
	 * Get monthly report
	 *
	 * @param $last_sent
	 * @param $settings
	 *
	 * @return false|string
	 */
	private function get_monthly_report_date( $last_sent, $settings ) {
		$month_date = isset( $settings['monthDay'] ) ? $settings['monthDay'] : 1;
		$hour       = isset( $settings['monthTime'] ) ? date_i18n( 'H:i', strtotime( $settings['monthTime'] ) ) : '00:00';
		$next_sent  = strtotime( date_i18n( "Y-m-{$month_date} {$hour}", $last_sent ) );

		if ( $last_sent >= $next_sent ) {
			// If not - next month.
			$next_sent = strtotime( '+1 month', $next_sent );
		}

		return date_i18n( 'Y-m-d H:i:s', $next_sent );
	}

	/**
	 * Send out an email report.
	 *
	 * @param $options
	 *
	 * @since 1.20.0
	 *
	 * @return bool|mixed|void
	 */
	protected function send_email_report( $options ) {
		if ( empty( $options['recipients'] ) || empty( $options['settings'] ) ) {
			return;
		}
		$mail_sent   = false;
		$report_data = $this->forminator_email_report_data( $options['settings'] );
		if ( empty( $report_data ) ) {
			return;
		}
		foreach ( $options['recipients'] as $recipient ) {
			$params = array(
				'label'     => ! empty( $options['settings']['label'] ) ? $options['settings']['label'] : '',
				'module'    => ! empty( $options['settings']['module'] ) ? $options['settings']['module'] : 'forms',
				'site_url'  => site_url(),
				'site_name' => get_bloginfo( 'name' ),
				'settings'  => $options['settings'],
				'recipient' => $recipient,
				'schedule'  => forminator_get_schedule_time( $options['schedule'] ),
				'reports'   => $report_data,
			);

			$email_content = self::report_email_html( $params );

			// Change nl to br.
			$email_content = stripslashes( $email_content );

			$no_reply_email = 'noreply@' . wp_parse_url( get_site_url(), PHP_URL_HOST );
			$headers        = array(
				'From: Forminator <' . $no_reply_email . '>',
				'Content-Type: text/html; charset=UTF-8',
			);

			$mail_sent = wp_mail( $recipient['email'], $this->get_subject(), $email_content, $headers );
		}

		return $mail_sent;
	}

	/**
	 * Set report email subject.
	 *
	 * @return string
	 * @since 1.20.0
	 */
	public function get_subject() {
		return sprintf( /* translators: %s: Url for site */
			__( 'Here\'s your latest report for %s', 'forminator' ),
			site_url()
		);
	}

	/**
	 * Email HTML
	 *
	 * @param $params
	 *
	 * @return mixed|string
	 */
	public function report_email_html( $params ) {
		return forminator_template( 'common/reports/email-report', $params );
	}

	/**
	 * email report data
	 *
	 * @param $settings
	 *
	 * @return array
	 */
	public function forminator_email_report_data( $settings ) {
		$email_report = array();
		$module       = isset( $settings['module'] ) ? $settings['module'] : 'forms';
		$module_type  = isset( $settings[ $module . '_type' ] ) ? $settings[ $module . '_type' ] : 'all';
		if ( 'selected' === $module_type ) {
			$module_ids = isset( $settings[ 'selected_' . $module ] ) ? $settings[ 'selected_' . $module ] : array();
		} else {
			$method     = 'get_' . $module;
			$modules    = Forminator_API::$method( null, 1, 999, 'publish' );
			$module_ids = array_map(
                function ( $ar ) {
                    return $ar->id;
                },
                $modules
            );
		}
		if ( ! empty( $module_ids ) ) {
			foreach ( $module_ids as $m => $module_id ) {
				$views      = Forminator_Form_Views_Model::get_instance()->count_views( $module_id );
				$submission = Forminator_Form_Entry_Model::count_report_entries( $module_id );
				$conversion = 0 < $views
					? number_format( ( $submission * 100 ) / $views, 1 )
					: 0;

				$email_report[ $m ] = array(
					'title'      => forminator_get_form_name( $module_id ),
					'views'      => $views,
					'submission' => $submission,
					'conversion' => ! empty( $conversion ) ? $conversion . '%' : '',
					'payments'   => null,
				);
				if ( Forminator_Form_Entry_Model::has_live_payment( $module_id ) ) {
					$payment_data = Forminator_Form_Entry_Model::payment_amount( $module_id );
					$sum_value    = null;
					if ( ! empty( $payment_data ) ) {
						$payment_value = array_map(
                            function ( $payment ) {
                                return maybe_unserialize( $payment->meta_value );
                            },
                            $payment_data
                        );

						$sum_value = ! empty( $payment_value ) ? array_sum( array_column( $payment_value, 'amount' ) ) : 0;

					}
					$email_report[ $m ]['payments'] = 0 !== $sum_value ? '$' . $sum_value : 0;
				}
			}
		}

		return $email_report;
	}
}
