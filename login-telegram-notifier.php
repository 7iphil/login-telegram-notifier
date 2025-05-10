<?php
/**
 * Plugin Name:         Login Telegram Notifier
 * Plugin URI:          https://iphil.top/portfolio/login-telegram-notifier/
 * Description:         Sends admin login notifications to Telegram with IP, location and browser info.
 * Version:             1.0
 * Author:              philstudio
 * Author URI:          https://iphil.top
 * Requires at least:   5.3
 * Tested up to:        6.8
 * License:             GPLv2 or later
 * Uninstall:           true
 * Text Domain:         login-telegram-notifier
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_filter('plugin_row_meta', 'ltgntf_plugin_row_meta', 10, 2);
 
function ltgntf_plugin_row_meta($links, $file) {

    if ($file === plugin_basename(__FILE__)) {

        $links[] = '<a href="' . esc_url(admin_url('tools.php?page=login-telegram-notifier')) . '">Settings</a>';

    }

    return $links;

}

// Define constants
define( 'LTGNTF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LTGNTF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load required files
require_once LTGNTF_PLUGIN_PATH . 'includes/geo.php';
require_once LTGNTF_PLUGIN_PATH . 'includes/notifier.php';
require_once LTGNTF_PLUGIN_PATH . 'admin/settings-page.php';

// Hook into login
add_action( 'wp_login', 'ltgntf_handle_login', 10, 2 );

/**
 * Handle user login and send Telegram notification.
 */
function ltgntf_handle_login( $user_login, $user ) {
	if ( ! get_option( 'ltgntf_enabled' ) ) {
		return;
	}

	$ip  = ltgntf_get_user_ip();
	$geo = ltgntf_get_geolocation( $ip );

	// Validate and sanitize $_SERVER['REQUEST_URI']
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$url         = site_url() . $request_uri;

	$message  = "🔐 *WP Login Alert*\n";
	$message .= "🔗 *URL*: `" . esc_url_raw( $url ) . "`\n";
	$message .= "🌍 *IP*: `" . esc_html( $ip ) . "`\n";
	$message .= "👤 *User*: `" . esc_html( $user_login ) . "`\n";

	if ( $geo && is_array( $geo ) && $geo['status'] === 'success' ) {
		$location = sanitize_text_field( $geo['city'] . ', ' . $geo['country'] );
		$message .= "🧭 *Location*: `" . esc_html( $location ) . "`\n";
	}

	// Handle user agent
	$ua_raw = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
	$ua_info = $ua_raw ? parse_user_agent_custom( substr( $ua_raw, 0, 300 ) ) : null;

	$browser_string = is_array( $ua_info )
		? $ua_info['browser'] . ' ' . $ua_info['version'] . ' on ' . $ua_info['platform']
		: 'Browser and OS not detected';

	$message .= "ℹ️ *Info*: `" . esc_html( $browser_string ) . "`\n";
	$message .= "🕒 *Time*: `" . current_time( 'mysql' ) . "`";

	ltgntf_send_to_telegram( $message );
}

function parse_user_agent_custom($ua) {
	$platform = 'Unknown';
	$browser  = 'Unknown';
	$version  = '';

	// Detect platform
	if (preg_match('/iPhone|iPad|iPod/i', $ua)) {
		$platform = 'iOS';
	} elseif (preg_match('/Android/i', $ua)) {
		$platform = 'Android';
	} elseif (preg_match('/Windows NT 10.0/i', $ua)) {
		$platform = 'Windows 10';
	} elseif (preg_match('/Windows NT 11.0/i', $ua)) {
		$platform = 'Windows 11';
	} elseif (preg_match('/Windows NT 6.3/i', $ua)) {
		$platform = 'Windows 8.1';
	} elseif (preg_match('/Windows NT 6.2/i', $ua)) {
		$platform = 'Windows 8';
	} elseif (preg_match('/Windows NT 6.1/i', $ua)) {
		$platform = 'Windows 7';
	} elseif (preg_match('/Macintosh|Mac OS X/i', $ua)) {
		$platform = 'macOS';
	} elseif (preg_match('/Linux/i', $ua)) {
		$platform = 'Linux';
	}

	// Detect browser (mobile first)
	if (preg_match('/FxiOS\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Firefox (iOS)';
		$version = $matches[1];
	} elseif (preg_match('/EdgiOS\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Edge (iOS)';
		$version = $matches[1];
	} elseif (preg_match('/CriOS\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Chrome (iOS)';
		$version = $matches[1];
	} elseif (preg_match('/OPiOS\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Opera (iOS)';
		$version = $matches[1];
	} elseif (preg_match('/Version\/([0-9.]+).*Safari/i', $ua, $matches)) {
		$browser = 'Safari';
		$version = $matches[1];

	// Desktop browsers
	} elseif (preg_match('/Firefox\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Firefox';
		$version = $matches[1];
	} elseif (preg_match('/Edg\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Edge';
		$version = $matches[1];
	} elseif (preg_match('/OPR\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Opera';
		$version = $matches[1];
	} elseif (preg_match('/Chrome\/([0-9.]+)/i', $ua, $matches)) {
		$browser = 'Chrome';
		$version = $matches[1];
	}

	return [
		'platform' => $platform,
		'browser'  => $browser,
		'version'  => $version,
	];
}

