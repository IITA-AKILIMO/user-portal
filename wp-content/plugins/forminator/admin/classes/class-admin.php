<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_Admin
 *
 * @since 1.0
 */
class Forminator_Admin {

	/**
	 * @var array
	 */
	public $pages = array();

	/**
	 * Forminator_Admin constructor.
	 */
	public function __construct() {
		$this->includes();

		// Init admin pages.
		add_action( 'admin_menu', array( $this, 'add_dashboard_page' ) );
		add_action( 'admin_notices', array( $this, 'show_stripe_updated_notice' ) );
		add_action( 'admin_notices', array( $this, 'show_rating_notice' ) );
		add_action( 'admin_notices', array( $this, 'show_pro_available_notice' ) );

		// Show Promote free plan notice only for Free version, for admins and if WPMU DEV Dashboard is not activated.
		if ( ! FORMINATOR_PRO && ! class_exists( 'WPMUDEV_Dashboard' ) && current_user_can( 'manage_options' )
				// The notice was already dismissed.
				&& ! self::was_notification_dismissed( 'forminator_promote_free_plan' )
				// Remind me later was clicked.
				&& ! self::maybe_remind_later()
			) {

			add_action( 'admin_notices', array( $this, 'promote_free_plan' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'promote_free_plan_scripts' ) );
		}

		add_action( 'admin_notices', array( $this, 'check_stripe_addon_version' ) );
		add_action( 'admin_notices', array( $this, 'show_cf7_importer_notice' ) );
		add_action( 'admin_notices', array( $this, 'show_addons_update_notice' ) );
		add_action( 'admin_init', array( $this, 'init_notices' ), 1 );

		// Add plugin action links.
		add_filter( 'plugin_action_links_' . FORMINATOR_PLUGIN_BASENAME, array( $this, 'add_plugin_action_links' ) );
		if ( forminator_is_networkwide() ) {
			add_filter(
				'network_admin_plugin_action_links_' . FORMINATOR_PLUGIN_BASENAME,
				array(
					$this,
					'add_plugin_action_links',
				)
			);
		}
		// Add links next to plugin details.
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 3 );

		// Init Admin AJAX class.
		new Forminator_Admin_AJAX();

		/**
		 * Triggered when Admin is loaded
		 */
		do_action( 'forminator_admin_loaded' );
	}

	/**
	 * Setup WPMUDEV Dashboard notifications.
	 *
	 * @return void
	 */
	public function init_notices() {
		if ( FORMINATOR_PRO ) {
			return;
		}

		$install_date = get_site_option( 'forminator_free_install_date', false );
		if ( ! $install_date ) {
			$install_date = time();
		}

		// Notice module file.
		include_once forminator_plugin_dir() . 'library/lib/free-notices/module.php';

		// Register plugin for notice.
		do_action(
			'wpmudev_register_notices',
			'forminator',
			array(
				'basename'     => plugin_basename( FORMINATOR_PLUGIN_BASENAME ),
				'title'        => 'Forminator',
				'wp_slug'      => 'forminator',
				'installed_on' => $install_date,
				'screens'      => array(
					'toplevel_page_forminator',
					'forminator_page_forminator-cform',
					'forminator_page_forminator-poll',
					'forminator_page_forminator-quiz',
					'forminator_page_forminator-entries',
					'forminator_page_forminator-integrations',
					'forminator_page_forminator-settings',
				),
			)
		);
	}

	/**
	 * Include required files
	 *
	 * @since 1.0
	 */
	private function includes() {
		// Admin pages.
		include_once forminator_plugin_dir() . 'admin/pages/dashboard-page.php';
		include_once forminator_plugin_dir() . 'admin/pages/entries-page.php';
		include_once forminator_plugin_dir() . 'admin/pages/integrations-page.php';
		include_once forminator_plugin_dir() . 'admin/pages/settings-page.php';
		include_once forminator_plugin_dir() . 'admin/pages/upgrade-page.php';
		include_once forminator_plugin_dir() . 'admin/pages/addons-page.php';
		include_once forminator_plugin_dir() . 'admin/pages/reports-page.php';

		// Admin AJAX.
		include_once forminator_plugin_dir() . 'admin/classes/class-admin-ajax.php';

		// Admin Data.
		include_once forminator_plugin_dir() . 'admin/classes/class-admin-data.php';

		// Admin l10n.
		include_once forminator_plugin_dir() . 'admin/classes/class-admin-l10n.php';

		if ( forminator_is_import_plugin_enabled( 'cf7' ) ) {
			// CF7 Import.
			include_once forminator_plugin_dir() . 'admin/classes/thirdparty-importers/class-importer-cf7.php';
		}

		if ( forminator_is_import_plugin_enabled( 'ninjaforms' ) ) {
			// Ninjaforms Import.
			include_once forminator_plugin_dir() . 'admin/classes/thirdparty-importers/class-importer-ninja.php';
		}

		if ( forminator_is_import_plugin_enabled( 'gravityforms' ) ) {
			// Gravityforms CF7 Import.
			include_once forminator_plugin_dir() . 'admin/classes/thirdparty-importers/class-importer-gravity.php';
		}

		// Admin Addons page.
		include_once forminator_plugin_dir() . 'admin/classes/class-addons-page.php';

        // Admin report page
        include_once forminator_plugin_dir() . 'admin/classes/class-reports-page.php';

	}

	/**
	 * Initialize Dashboard page
	 *
	 * @since 1.0
	 */
	public function add_dashboard_page() {
		$title = __( 'Forminator', 'forminator' );
		if ( FORMINATOR_PRO ) {
			$title = __( 'Forminator Pro', 'forminator' );
		}

		$this->pages['forminator']           = new Forminator_Dashboard_Page( 'forminator', 'dashboard', $title, $title, false, false );
		$this->pages['forminator-dashboard'] = new Forminator_Dashboard_Page( 'forminator', 'dashboard', __( 'Forminator Dashboard', 'forminator' ), __( 'Dashboard', 'forminator' ), 'forminator' );
	}

	/**
	 * Add Integrations page
	 *
	 * @since 1.1
	 */
	public function add_integrations_page() {
		add_action( 'admin_menu', array( $this, 'init_integrations_page' ) );
	}

	/**
	 * Initialize Integrations page
	 *
	 * @since 1.1
	 */
	public function init_integrations_page() {
		$this->pages['forminator-integrations'] = new Forminator_Integrations_Page(
			'forminator-integrations',
			'integrations',
			__( 'Integrations', 'forminator' ),
			__( 'Integrations', 'forminator' ),
			'forminator'
		);

		// TODO: remove this after converted to JS.
		$addons = Forminator_Addon_Loader::get_instance()->get_addons()->to_array();
		foreach ( $addons as $slug => $addon_array ) {
			$addon_class = forminator_get_addon( $slug );

			if ( $addon_class && is_callable( array( $addon_class, 'admin_hook_html_version' ) ) ) {
				call_user_func( array( $addon_class, 'admin_hook_html_version' ) );
			}
		}

	}

	/**
	 * Add Settings page
	 *
	 * @since 1.0
	 */
	public function add_settings_page() {
		add_action( 'admin_menu', array( $this, 'init_settings_page' ) );
	}

	/**
	 * Initialize Settings page
	 *
	 * @since 1.0
	 */
	public function init_settings_page() {
		$this->pages['forminator-settings'] = new Forminator_Settings_Page( 'forminator-settings', 'settings', __( 'Global Settings', 'forminator' ), __( 'Settings', 'forminator' ), 'forminator' );
	}

	/**
	 * Add Entries page
	 *
	 * @since 1.0.5
	 */
	public function add_entries_page() {
		add_action( 'admin_menu', array( $this, 'init_entries_page' ) );
	}

	/**
	 * Initialize Entries page
	 *
	 * @since 1.0.5
	 */
	public function init_entries_page() {
		$this->pages['forminator-entries'] = new Forminator_Entries_Page(
			'forminator-entries',
			'common/entries',
			__( 'Forminator Submissions', 'forminator' ),
			__( 'Submissions', 'forminator' ),
			'forminator'
		);
	}

	/**
	 * Add Forminator Pro page
	 *
	 * @since 1.0
	 */
	public function add_upgrade_page() {
		add_action( 'admin_menu', array( $this, 'init_upgrade_page' ) );
	}

	/**
	 * Initialize Settings page
	 *
	 * @since 1.0
	 */
	public function init_upgrade_page() {
		$this->pages['forminator-upgrade'] = new Forminator_Upgrade_Page( 'forminator-upgrade', 'upgrade', __( 'Upgrade to Forminator Pro', 'forminator' ), __( 'Forminator Pro', 'forminator' ), 'forminator' );
	}

	/**
	 * Add Add-ons page
	 *
	 * @since 1.15
	 */
	public function add_addons_page() {
		add_action( 'admin_menu', array( $this, 'init_addons_page' ) );
	}

	/**
	 * Initialize Add-ons page
	 *
	 * @since 1.15
	 */
	public function init_addons_page() {
		$this->pages['forminator-addons'] = new Forminator_Addons_Page(
			'forminator-addons',
			'addons',
			__( 'Forminator Add-ons', 'forminator' ),
			__( 'Add-ons', 'forminator' ),
			'forminator'
		);
	}

	/**
	 * Add Reports page
	 *
	 * @since 1.18.0
	 */
	public function add_reports_page() {
		add_action( 'admin_menu', array( $this, 'init_reports_page' ) );
	}

	/**
	 * Initialize Reports page
	 *
	 * @since 1.18.0
	 */
	public function init_reports_page() {
		$this->pages['forminator-reports'] = new Forminator_Reports_Page( 'forminator-reports', 'common/reports', __( 'Reports', 'forminator' ), __( 'Reports', 'forminator' ), 'forminator' );
	}

	/**
	 * Check if we have any old Stripe form
	 *
	 * @return bool
	 * @since 1.9
	 */
	public function has_old_stripe_forms() {
		$forms = Forminator_Form_Model::model()->get_models_by_field_and_version( 'stripe-1', '1.9-alpha.1' );

		if ( count( $forms ) > 0 ) {
			return true;
		}

		return false;
	}


	/**
	 * Displays an admin notice when the user is an active member and doesn't have Forminator Pro installed
	 * Shown in forminator pages. Per user notification.
	 */
	public function show_pro_available_notice() {
		if ( ( isset( $_GET['page'] ) && 'forminator' !== substr( $_GET['page'], 0, 10 ) ) || FORMINATOR_PRO ) {
			return;
		}
		// The notice was already dismissed.
		if ( self::was_notification_dismissed( 'forminator_pro_is_available' ) ) {
			return;
		}

		// Show the notice only to users who can do something about this and who are members.
		if ( ! self::user_can_update_plugins() || ! forminator_can_install_pro() ) {
			return;
		}

		$url  = add_query_arg(
            array( 'page' => 'wpmudev-plugins' ),
            network_admin_url( 'admin.php' )
        ) . '#pid=2097296';
		$link = '<a type="button" href="' . esc_url( $url ) . '" target="_self" class="button button-primary">' . esc_html__( 'Upgrade' ) . '</a>';

		$username = forminator_get_current_username();
		$name     = ! empty( $username ) ? $username : __( 'Hey', 'forminator' );

		$message = '<p>';
		/* translators: user's name */
		$message .= sprintf( esc_html__( '%s, it appears you have an active WPMU DEV membership but haven\'t upgraded Forminator to the pro version. You won\'t lose any settings upgrading, go for it!', 'forminator' ), $name );
		$message .= '</p>';
		$message .= '<p>' . $link . '</p>';

		echo '<div class="forminator-grouped-notice notice notice-info is-dismissible"'
		     . ' data-notice-slug="forminator_pro_is_available"'
		     . ' data-nonce="' . esc_attr( wp_create_nonce( 'forminator_dismiss_notice' ) ) . '">';
		echo wp_kses_post( $message );
		echo '</div>';
	}

	/**
	 * Enqueue scripts for Promote Free Plan notice
	 */
	public function promote_free_plan_scripts() {
		// Show the notice only on WP Dashboard page.
		$screen = get_current_screen();
		if ( 'dashboard' !== $screen->id ) {
			return;
		}

		$dashboard_object = $this->pages['forminator-dashboard'];
		$dashboard_object->enqueue_scripts( '' );
	}

	/**
	 * Displays Promote Free Plan notice
	 */
	public function promote_free_plan() {
		// Show the notice only on WP Dashboard page.
		$screen = get_current_screen();
		if ( 'dashboard' !== $screen->id ) {
			return;
		}

		$button_1 = '<a href="https://wpmudev.com/register/?free_hub&utm_source=forminator&utm_medium=plugin&utm_campaign=forminator_wp_admin_free_plan_1" target="_blank" class="button button-primary">'
				. esc_html__( 'Claim your free gift' )
				. '</a>';
		$button_2 = '<button class="button" id="forminator-promote-popup-open">' . esc_html__( 'Find out more' ) . '</button>';
		$remind   = '<a style="margin-left:20px;text-decoration: none;" href="#" id="forminator-promote-remind-later" data-nonce="' . esc_attr( wp_create_nonce( 'forminator_promote_remind_later' ) ) . '">' . esc_html__( 'Remind me later', 'forminator' ) . '</a>';

		$message  = '<p><strong>';
		$message .= esc_html__( 'Managing multiple WP sites for clients? Here’s a free gift to make it easier', 'forminator' );
		$message .= '</strong></p>';
		$message .= '<p>';
		$message .= esc_html__( 'In addition to Forminator, WPMU DEV has everything you need for fast and convenient site management.', 'forminator' );
		$message .= '</p>';
		$message .= '<p>';
		$message .= esc_html__( 'Trusted by over 50K web developers. Completely free to try.', 'forminator' );
		$message .= '</p>';
		$message .= '<p>' . $button_1 . '&nbsp;&nbsp;&nbsp;&nbsp;' . $button_2 . $remind . '</p>';

		echo '<div class="forminator-grouped-notice notice notice-info is-dismissible"'
			. ' data-notice-slug="forminator_promote_free_plan"'
			. ' data-nonce="' . esc_attr( wp_create_nonce( 'forminator_dismiss_notice' ) ) . '">';
		echo wp_kses_post( $message );
		echo '</div>';
		$dashboard_object = $this->pages['forminator-dashboard'];
		echo '<div class="' . esc_attr( $dashboard_object->get_sui_body_class() ) . '">';
		echo '<div class="sui-wrap wpmudev-forminator-forminator">';
		$dashboard_object->template( 'dashboard/promote-free-plan' );
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Displays an admin notice when Forminator version is 1.16.0 or higher and Stripe Addon version is less than 1.0.4
	 * Shown in forminator pages. Per user notification.
	 */
	public function check_stripe_addon_version() {
		// Show the notice only if Stripe Addon is active and its version is less than 1.0.4.
		if ( ! defined( 'FORMINATOR_STRIPE_ADDON' ) || ! class_exists( 'Forminator_Stripe_Addon' )
		     || version_compare( FORMINATOR_STRIPE_ADDON, '1.0.4', '>=' ) ) {
			return;
		}

		// Show the notice only for administrators.
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		$message = '<p>';
		/* translators: Forminator vesrion */
		$message .= sprintf( esc_html__( 'We\'ve noticed you have updated to Forminator Pro version %s. Please ensure you also update your Forminator Stripe Subscriptions Add-on to version 1.0.4 or higher to ensure compatibility with the new submissions processes.', 'forminator' ), FORMINATOR_VERSION );
		$message .= '</p>';

		echo '<div class="forminator-grouped-notice notice notice-error"'
		     . ' data-notice-slug="forminator_pro_is_available"'
		     . '>';
		echo wp_kses_post( $message );
		echo '</div>';
	}

	/**
	 * Check if the given notification was dismissed.
	 *
	 * @param string $notification_name Notification slug.
	 *
	 * @return bool
	 */
	public static function was_notification_dismissed( $notification_name ) {
		$dismissed = get_user_meta( get_current_user_id(), 'frmt_dismissed_messages', true );

		return ( is_array( $dismissed ) && in_array( $notification_name, $dismissed, true ) );
	}

	/**
	 * Return true if Remind me later was clicked
	 *
	 * @return bool
	 */
	private static function maybe_remind_later() {
		$option = get_transient( 'forminator_free_plan_remind_later_' . get_current_user_id() );

		return ! ! $option;
	}

	/**
	 * Check if the current user is able to update plugins
	 *
	 * @return bool
	 */
	public static function user_can_update_plugins() {
		$cap = is_multisite() ? 'manage_network_plugins' : 'update_plugins';

		return current_user_can( $cap );
	}

	/**
	 * Show CF7 importer notice
	 *
	 * @since 1.11
	 */
	public function show_cf7_importer_notice() {
		$notice_dismissed = get_option( 'forminator_cf7_notice_dismissed', false );

		if ( $notice_dismissed ) {
			return;
		}

		if ( ! forminator_is_import_plugin_enabled( 'cf7' ) ) {
			return;
		}

		?>
        <div class="forminator-notice-cf7 forminator-notice notice notice-info"
             data-prop="forminator_cf7_notice_dismissed"
             data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminator_dismiss_notification' ) ); ?>">
            <p style="color: #1A2432; font-size: 14px; font-weight: bold;"><?php echo esc_html__( 'Forminator - Import your Contact Form 7 forms automatically', 'forminator' ); ?></p>

            <p style="color: #72777C; line-height: 22px;"><?php echo esc_html__( 'We noticed that Contact Form 7 is active on your website. You can use our built-in Contact Form 7 importer to import your existing forms and the relevant plugin settings from Contact Form 7 to Forminator. The importer supports the most widely used add-ons as well.', 'forminator' ); ?></p>

            <p>
                <a href="<?php echo esc_url( menu_page_url( 'forminator-settings', false ) . '&section=import' ); ?>"
                   class="button button-primary"><?php esc_html_e( 'Import Contact Form 7 Forms', 'forminator' ); ?></a>
                <a href="#" class="dismiss-notice"
                   style="margin-left: 10px; text-decoration: none; color: #555; font-weight: 500;"><?php esc_html_e( 'Dismiss', 'forminator' ); ?></a>
            </p>

        </div>

        <script type="text/javascript">
            jQuery('.forminator-notice-cf7 .button-primary').on('click', function (e) {
                e.preventDefault();

                var $self = jQuery(this);
                var $notice = jQuery(e.currentTarget).closest('.forminator-notice');
                var ajaxUrl = '<?php echo esc_url( forminator_ajax_url() ); ?>';

                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'forminator_dismiss_notification',
                        prop: $notice.data('prop'),
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    location.href = $self.attr('href');
                });
            });

            jQuery('.forminator-notice-cf7 .dismiss-notice').on('click', function (e) {
                e.preventDefault();

                var $notice = jQuery(e.currentTarget).closest('.forminator-notice');
                var ajaxUrl = '<?php echo esc_url( forminator_ajax_url() ); ?>';

                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'forminator_dismiss_notification',
                        prop: $notice.data('prop'),
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    $notice.hide();
                });
            });
        </script>
		<?php
	}

	/**
	 * Show Stripe admin notice
	 *
	 * @since 1.9
	 */
	public function show_stripe_updated_notice() {
		$notice_dismissed = get_option( 'forminator_stripe_notice_dismissed', false );

		if ( $notice_dismissed ) {
			return;
		}

		if ( ! $this->has_old_stripe_forms() ) {
			return;
		}
		?>

		<div class="forminator-notice notice notice-warning" data-prop="forminator_stripe_notice_dismissed"
             data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminator_dismiss_notification' ) ); ?>">

            <p style="color: #72777C; line-height: 22px;"><?php echo wp_kses_post( sprintf( __( 'To make Forminator\'s Stripe field <a href="%s" target="_blank">SCA Compliant</a>, we have replaced the Stripe Checkout modal with Stripe Elements which adds an inline field to collect your customer\'s credit or debit card details. Your existing forms with Stripe field are automatically updated, but we recommend checking them to ensure everything works fine.', 'forminator' ), 'https://stripe.com/gb/guides/strong-customer-authentication' ) ); ?></p>

            <p>
                <a href="<?php echo esc_url( menu_page_url( 'forminator', false ) . '&show_stripe_dialog=true' ); ?>"
                   class="button button-primary"><?php esc_html_e( 'Learn more', 'forminator' ); ?></a>
                <a href="#" class="dismiss-notice"
                   style="margin-left: 10px; text-decoration: none; color: #555; font-weight: 500;"><?php esc_html_e( 'Dismiss', 'forminator' ); ?></a>
            </p>

        </div>

        <script type="text/javascript">
            jQuery('.forminator-notice .dismiss-notice').on('click', function (e) {
                e.preventDefault();

                var $notice = jQuery(e.currentTarget).closest('.forminator-notice');
                var ajaxUrl = '<?php echo esc_url( forminator_ajax_url() ); ?>';

                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'forminator_dismiss_notification',
                        prop: $notice.data('prop'),
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    $notice.hide();
                });
            });
        </script>
		<?php
	}

	/**
	 * Show rating admin notice
	 *
	 * @since 1.10
	 */
	public function show_rating_notice() {

		if ( FORMINATOR_PRO ) {
			return;
		}

		$notice_success   = get_option( 'forminator_rating_success', false );
		$notice_dismissed = get_option( 'forminator_rating_dismissed', false );

		if ( $notice_dismissed || $notice_success ) {
			return;
		}
		$published_modules     = forminator_total_forms( 'publish' );
		$publish_later         = get_option( 'forminator_publish_rating_later', false );
		$publish_later_dismiss = get_option( 'forminator_publish_rating_later_dismiss', false );

		if ( ( ( 5 < $published_modules && 10 >= $published_modules ) && ! $publish_later ) || ( 10 < $published_modules && ! $publish_later_dismiss ) ) {

			$milestone = ( 10 >= $published_modules ) ? 5 : 10;
			?>

            <div id="forminator-free-publish-notice"
				 class="forminator-rating-notice notice notice-info fui-wordpress-notice"
                 data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminator_dismiss_notification' ) ); ?>">

                <p style="color: #72777C; line-height: 22px;"><?php printf( esc_html__( 'Awesome! You\'ve published more than %d modules with Forminator. Hope you are enjoying it so far. We have spent countless hours developing this free plugin for you, and we would really appreciate it if you could drop us a rating on wp.org to help us spread the word and boost our motivation.', 'forminator' ), (int) $milestone ); ?></p>

                <p>
                    <a type="button" href="#" target="_blank" class="button button-primary button-large"
                       data-prop="forminator_rating_success"><?php esc_html_e( 'Rate Forminator', 'forminator' ); ?></a>

                    <button type="button" class="button button-large" style="margin-left: 11px;"
                            data-prop="<?php echo 10 > $published_modules ? 'forminator_publish_rating_later' : 'forminator_publish_rating_later_dismiss'; ?>"><?php esc_html_e( 'Maybe later', 'forminator' ); ?></button>

                    <a href="#" class="dismiss"
                       style="margin-left: 11px; color: #555; line-height: 16px; font-weight: 500; text-decoration: none;"
                       data-prop="forminator_rating_dismissed"><?php esc_html_e( 'No Thanks', 'forminator' ); ?></a>
                </p>

            </div>

			<?php
		} else {

			$install_date       = get_site_option( 'forminator_free_install_date', false );
			$days_later_dismiss = get_option( 'forminator_days_rating_later_dismiss', false );

			if ( $install_date && current_time( 'timestamp' ) > strtotime( '+7 days', $install_date ) && ! $publish_later && ! $publish_later_dismiss && ! $days_later_dismiss ) {
				?>

                <div id="forminator-free-usage-notice"
					 class="forminator-rating-notice notice notice-info fui-wordpress-notice"
                     data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminator_dismiss_notification' ) ); ?>">

                    <p style="color: #72777C; line-height: 22px;"><?php esc_html_e( 'Excellent! You\'ve been using Forminator for a while now. Hope you are enjoying it so far. We have spent countless hours developing this free plugin for you, and we would really appreciate it if you could drop us a rating on wp.org to help us spread the word and boost our motivation.', 'forminator' ); ?></p>

                    <p>
                        <a type="button" href="#" target="_blank" class="button button-primary button-large"
                           data-prop="forminator_rating_success"><?php esc_html_e( 'Rate Forminator', 'forminator' ); ?></a>

                        <a href="#" class="dismiss"
                           style="margin-left: 11px; color: #555; line-height: 16px; font-weight: 500; text-decoration: none;"
                           data-prop="forminator_days_rating_later_dismiss"><?php esc_html_e( 'Maybe later', 'forminator' ); ?></a>
                    </p>

                </div>

				<?php
			}
		}

		?>

        <script type="text/javascript">
            jQuery('.forminator-rating-notice a, .forminator-rating-notice button').on('click', function (e) {
                e.preventDefault();

                var $notice = jQuery(e.currentTarget).closest('.forminator-rating-notice'),
                    prop = jQuery(this).data('prop'),
                    ajaxUrl = '<?php echo esc_url( forminator_ajax_url() ); ?>';

                if ('forminator_rating_success' === prop) {
                    window.open('https://wordpress.org/support/plugin/forminator/reviews/#new-post', '_blank');
                }

                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'forminator_dismiss_notification',
                        prop: prop,
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    $notice.hide();
                });
            });
        </script>

		<?php
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param array $links Plugin Action links.
	 *
	 * @return mixed
	 * @since 1.13
	 */
	public function add_plugin_action_links( $links ) {
		// Settings link.
		if ( forminator_get_admin_cap() ) {
			$action_links['dashboard'] = '<a href="' . admin_url( 'admin.php?page=forminator-settings' ) . '" aria-label="' . esc_attr( __( 'Go to Forminator Settings', 'forminator' ) ) . '">' . esc_html__( 'Settings', 'forminator' ) . '</a>';
		}
		// Documentation link.
		$action_links['docs'] = '<a href="' . forminator_get_link( 'docs', 'forminator_pluginlist_docs' ) . '" aria-label="' . esc_attr( __( 'Docs', 'forminator' ) ) . '" target="_blank">' . esc_html__( 'Docs', 'forminator' ) . '</a>';

		// Check if the current logged-in member has access Forminator Pro.
		$can_install_pro = forminator_can_install_pro();

		// Upgrade or Renew links.
		if ( ! FORMINATOR_PRO ) {
			if ( $can_install_pro ) {
				$action_links['upgrade'] = '<a href="' . forminator_get_link( 'plugin', 'forminator_pluginlist_upgrade' ) . '" aria-label="' . esc_attr( __( 'Upgrade to Forminator Pro', 'forminator' ) ) . '" style="color: #8D00B1;" target="_blank">' . esc_html__( 'Upgrade', 'forminator' ) . '</a>';
			} else {
				$action_links['renew'] = '<a href="' . forminator_get_link( 'plugin', 'forminator_pluginlist_renew' ) . '" aria-label="' . esc_attr( __( 'Upgrade 30% OFF Sale', 'forminator' ) ) . '" style="color: #8D00B1;" target="_blank">' . esc_html__( 'Upgrade 30% OFF Sale', 'forminator' ) . '</a>';
			}
		} elseif ( ! class_exists( 'WPMUDEV_Dashboard' ) ) {
			$action_links['renew'] = '<a href="' . forminator_get_link( 'plugin', 'forminator_pluginlist_renew' ) . '" aria-label="' . esc_attr( __( 'Renew Membership', 'forminator' ) ) . '" style="color: #8D00B1;" target="_blank">' . esc_html__( 'Renew Membership', 'forminator' ) . '</a>';
		}

		return array_merge( $action_links, $links );
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @param mixed $links Plugin Row Meta.
	 * @param mixed $file Plugin Base file.
	 * @param array $plugin_data Plugin data.
	 *
	 * @return array
	 * @since 1.13
	 */
	public function plugin_row_meta( $links, $file, $plugin_data ) {
		if ( FORMINATOR_PLUGIN_BASENAME === $file ) {
			// Show network meta links only when activated network wide.
			if ( is_network_admin() && ! forminator_is_networkwide() ) {
				return $links;
			}

			// Change AuthorURI link.
			if ( isset( $links[1] ) ) {
				$author_uri = FORMINATOR_PRO ? 'https://wpmudev.com/' : 'https://profiles.wordpress.org/wpmudev/';
				$author_uri = sprintf(
					'<a href="%s" target="_blank">%s</a>',
					$author_uri,
					__( 'WPMU DEV' )
				);
				$links[1]   = sprintf( __( 'By %s' ), $author_uri );
			}

			if ( ! FORMINATOR_PRO ) {
				// Change AuthorURI link.
				if ( isset( $links[2] ) && false === strpos( $links[2], 'target="_blank"' ) ) {
					if ( ! isset( $plugin_data['slug'] ) && $plugin_data['Name'] ) {
						$links[2] = sprintf(
							'<a href="%s" class="thickbox open-plugin-details-modal" aria-label="%s" data-title="%s">%s</a>',
							esc_url(
								network_admin_url(
									'plugin-install.php?tab=plugin-information&plugin=forminator' .
									'&TB_iframe=true&width=600&height=550'
								)
							),
							/* translators: %s: Plugin name. */
							esc_attr( sprintf( __( 'More information about %s' ), $plugin_data['Name'] ) ),
							esc_attr( $plugin_data['Name'] ),
							__( 'View details' )
						);
					} else {
						$links[2] = str_replace( 'href=', 'target="_blank" href=', $links[2] );
					}
				}
				$row_meta['rate']    = '<a href="' . esc_url( forminator_get_link( 'rate' ) ) . '" aria-label="' . esc_attr__( 'Rate Forminator', 'forminator' ) . '" target="_blank">' . esc_html__( 'Rate Forminator', 'forminator' ) . '</a>';
				$row_meta['support'] = '<a href="' . esc_url( forminator_get_link( 'support' ) ) . '" aria-label="' . esc_attr__( 'Support', 'forminator' ) . '" target="_blank">' . esc_html__( 'Support', 'forminator' ) . '</a>';
			} else {
				// Change 'Visit plugins' link to 'View details'.
				if ( isset( $links[2] ) && false !== strpos( $links[2], 'project/forminator' ) ) {
					$links[2] = sprintf(
						'<a href="%s" target="_blank">%s</a>',
						esc_url( forminator_get_link( 'pro_link', '', 'project/forminator-pro/' ) ),
						__( 'View details' )
					);
				}
				$row_meta['support'] = '<a href="' . esc_url( forminator_get_link( 'support' ) ) . '" aria-label="' . esc_attr__( 'Premium Support', 'forminator' ) . '" target="_blank">' . esc_html__( 'Premium Support', 'forminator' ) . '</a>';
			}
			$row_meta['roadmap'] = '<a href="' . esc_url( forminator_get_link( 'roadmap' ) ) . '" aria-label="' . esc_attr__( 'Roadmap', 'forminator' ) . '" target="_blank">' . esc_html__( 'Roadmap', 'forminator' ) . '</a>';

			return array_merge( $links, $row_meta );
		}

		return $links;
	}

	/**
	 * Show addons update notice
	 */
	public function show_addons_update_notice() {
		if ( ! FORMINATOR_PRO ) {
			return;
		}

		$version = '';
		$addons  = $this->pages['forminator-addons']->get_addons_by_action();
		if ( empty( $addons['update'] ) ) {
			return;
		}
		foreach ( $addons['update'] as $update ) {
			$version .= $update->version_latest . '_';
		}

		$notice_dismissed = get_option( 'forminator_addons_update_' . $version . 'dismiss', false );
		if ( $notice_dismissed ) {
			return;
		}

		$notice_later = get_option( 'forminator_addons_update_' . $version . 'later', false );
		if ( $notice_later && current_time( 'timestamp' ) < strtotime( '+7 days', $notice_later ) ) {
			return;
		}
		?>

        <div id="forminator-addons-update-notice"
			 class="forminator-update-notice notice notice-info fui-wordpress-notice is-dismissible"
             data-nonce="<?php echo esc_attr( wp_create_nonce( 'forminator_dismiss_notification' ) ); ?>">
            <p style="color: #72777C; line-height: 22px;">
                <strong>
					<?php echo esc_html__( 'New update available for one or more Add-ons.', 'forminator' ); ?>
                </strong>
            </p>
            <p style="color: #72777C; line-height: 22px;">
				<?php esc_html_e( 'A new update is available for one or more of your Forminator Add-ons. Click on the button below to check and update the required Add-on.', 'forminator' ); ?>
            </p>
            <p><a type="button"
                  href="<?php echo esc_url( menu_page_url( 'forminator-addons', false ) ); ?>"
                  target="_blank" class="button button-primary button-large"
                ><?php esc_html_e( 'View and Update', 'forminator' ); ?></a>
				<?php if ( ! $notice_later ) { ?>
                    <a href="#" class="forminator-notice-dismiss"
                       data-prop="forminator_addons_update_<?php echo esc_attr( $version ); ?>later"
                       style="margin-left: 11px; color: #555; line-height: 16px; font-weight: 500; text-decoration: none;"
                       data-prop-value="<?php echo esc_attr( current_time( 'timestamp' ) ); ?>"><?php esc_html_e( 'Remind me later', 'forminator' ); ?></a>
				<?php } ?>
            </p>
            <button type="button" class="notice-dismiss forminator-notice-dismiss"
                    data-prop="forminator_addons_update_<?php echo esc_attr( $version ); ?>dismiss">
                <span class="screen-reader-text"></span>
            </button>
        </div>
        <script type="text/javascript">
            jQuery('.forminator-update-notice .forminator-notice-dismiss').on('click', function (e) {
                e.preventDefault();

                var $notice = jQuery(e.currentTarget).closest('.forminator-update-notice'),
                    prop = jQuery(this).data('prop'),
                    value = jQuery(this).data('prop-value'),
                    ajaxUrl = '<?php echo esc_url( forminator_ajax_url() ); ?>';
                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'forminator_dismiss_notification',
                        prop: prop,
                        value: 'undefined' !== typeof value ? value : '',
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    $notice.hide();
                });
            });
        </script>
		<?php
	}
}
