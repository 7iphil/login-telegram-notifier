<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Send a Telegram message via bot API.
 */
function ltgntf_send_to_telegram( $message ) {
    $token   = sanitize_text_field( get_option( 'ltgntf_bot_token' ) );
    $chat_id = sanitize_text_field( get_option( 'ltgntf_chat_id' ) );

    if ( empty( $token ) || empty( $chat_id ) ) {
        return;
    }

    $url  = "https://api.telegram.org/bot{$token}/sendMessage";
    $args = [
        'body' => [
            'chat_id'    => $chat_id,
            'text'       => $message,
            'parse_mode' => 'Markdown',
        ],
        'timeout' => 10,
    ];

    wp_remote_post( $url, $args );
}
