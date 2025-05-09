<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get the user's IP address.
 */
function ltgntf_get_user_ip() {
	if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$raw_ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		$ip_list = explode( ',', $raw_ip );
		return trim( $ip_list[0] );
	}

	if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
		return sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	}

	return '0.0.0.0';
}

/**
 * Get geolocation info from ip-api.com
 */
function ltgntf_get_geolocation( $ip ) {
    
    $response = wp_remote_get( "http://ip-api.com/json/" . esc_html( $ip ) );

    if ( is_wp_error( $response ) ) {
    
        return false;

    }

    $body = wp_remote_retrieve_body( $response ); 

    $data = json_decode( $body, true );

    return is_array( $data ) ? $data : false;

}
