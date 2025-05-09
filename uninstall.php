<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Remove plugin options
delete_option( 'ltgntf_enabled' );
delete_option( 'ltgntf_bot_token' );
delete_option( 'ltgntf_chat_id' );
