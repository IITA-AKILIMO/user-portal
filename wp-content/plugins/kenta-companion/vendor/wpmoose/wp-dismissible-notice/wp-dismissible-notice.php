<?php
/**
 * Plugin Name:       WP Dismissible Notice
 * Description:
 * Requires at least: 5.4
 * Requires PHP:      7.2
 * Version:           1.0.0
 * Author:            WP Moose
 * Author URI:        https://www.wpmoose.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-dismissible-notice
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Wpmoose\WpDismissibleNotice\Notices;

define( 'WP_MOOSE_NOTICE_PLUGIN_FILE', __FILE__ );
define( 'WP_MOOSE_NOTICE_PLUGIN_PATH', trailingslashit( plugin_dir_path( WP_MOOSE_NOTICE_PLUGIN_FILE ) ) );
define( 'WP_MOOSE_NOTICE_PLUGIN_URL', trailingslashit( plugins_url( '/', WP_MOOSE_NOTICE_PLUGIN_FILE ) ) );

require_once WP_MOOSE_NOTICE_PLUGIN_PATH . 'vendor/autoload.php';

$notices = Notices::instance( 'scope-1', WP_MOOSE_NOTICE_PLUGIN_URL );
$notices->add_notice( 'WP Moose dismissible test notice 1 in scope 1', 'wpmoose-test-notice-1', 'WP Moose' );
$notices->add_notice( 'WP Moose dismissible test notice 2 in scope 1', 'wpmoose-test-notice-2', 'WP Moose' );

$notices2 = Notices::instance( 'scope-2', WP_MOOSE_NOTICE_PLUGIN_URL );
$notices2->add_notice( 'WP Moose dismissible test notice 1 in scope 1', 'wpmoose-test-notice-1', 'WP Moose', 'error' );
$notices2->add_notice( 'WP Moose dismissible test notice 2 in scope 1', 'wpmoose-test-notice-2', 'WP Moose', 'error' );

add_action( 'admin_init', function () use ( $notices, $notices2 ) {
	$notices->reset_notice( 'wpmoose-test-notice-1' );
	$notices->reset_notice( 'wpmoose-test-notice-2' );

	$notices2->reset_notice( 'wpmoose-test-notice-1' );
	$notices2->reset_notice( 'wpmoose-test-notice-2' );
} );
