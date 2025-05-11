<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register plugin settings.
 */
function ltgntf_register_settings() {
    register_setting( 'ltgntf_settings_group', 'ltgntf_bot_token', [
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    register_setting( 'ltgntf_settings_group', 'ltgntf_chat_id', [
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    register_setting( 'ltgntf_settings_group', 'ltgntf_enabled', [
        'sanitize_callback' => 'ltgntf_sanitize_checkbox',
    ] );
}
add_action( 'admin_init', 'ltgntf_register_settings' );

/**
 * Add settings menu.
 */
function ltgntf_add_settings_menu() {
    
    add_submenu_page(
        'tools.php',
        esc_html( __( 'Login Telegram Notifier', 'login-telegram-notifier' ) ),
        esc_html( __( 'Login Telegram Notifier', 'login-telegram-notifier' ) ),
        'manage_options',
        'login-telegram-notifier',
        'ltgntf_render_settings_page'
    );

}

add_action( 'admin_menu', 'ltgntf_add_settings_menu' );

/**
 * Sanitize checkbox.
 */
function ltgntf_sanitize_checkbox( $value ) {
    return $value === '1' ? '1' : '';
}

/**
 * Render settings page.
 */
function ltgntf_render_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Login Telegram Notifier Settings', 'login-telegram-notifier' ); ?></h1>
        <?php settings_errors(); ?>
        <form method="post" action="options.php" autocomplete="off">
            <?php
            settings_fields( 'ltgntf_settings_group' );
            do_settings_sections( 'ltgntf_settings_group' );
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="ltgntf_bot_token"><?php esc_html_e( 'Telegram Bot Token', 'login-telegram-notifier' ); ?></label>
                    </th>
                    <td>
                        <input type="password" id="ltgntf_bot_token" name="ltgntf_bot_token" value="<?php echo esc_attr( get_option( 'ltgntf_bot_token' ) ); ?>" placeholder="<?php echo esc_html( __( 'for example', 'login-telegram-notifier' ) ); ?>: 0123456789:TOKEN_CHARS" class="regular-text" autocomplete="new-password">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="ltgntf_chat_id"><?php esc_html_e( 'Telegram Chat ID', 'login-telegram-notifier' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="ltgntf_chat_id" name="ltgntf_chat_id" value="<?php echo esc_attr( get_option( 'ltgntf_chat_id' ) ); ?>" placeholder="<?php echo esc_html( __( 'for example', 'login-telegram-notifier' ) ); ?>: -9876543210" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php esc_html_e( 'Enable Login Notifications', 'login-telegram-notifier' ); ?>
                    </th>
                    <td>
                        <input type="checkbox" id="ltgntf_enabled" name="ltgntf_enabled" value="1" <?php checked( get_option( 'ltgntf_enabled' ), 1 ); ?> />
                        <label for="ltgntf_enabled"><?php esc_html_e( 'Send alerts when someone logs into the admin panel', 'login-telegram-notifier' ); ?></label>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <div style="padding: 20px; border-left: 4px solid #2271b1; background-color: #f0f8ff;">
            <h2 style="margin-top: 0;">🤖 <?php echo esc_html( __( 'How do I get my Telegram chat ID and bot token?', 'login-telegram-notifier' ) ); ?></h2>

            <p>
                <?php echo esc_html( __( 'Use', 'login-telegram-notifier' ) ); ?> 
                <a href="https://t.me/BotFather" target="_blank">@BotFather</a> 
                <?php echo esc_html( __( 'to create a bot and get your token.', 'login-telegram-notifier' ) ); ?>
            </p>

            <p>
                <?php echo esc_html( __( 'After creating the bot, start a conversation with it so it can recognize your chat.', 'login-telegram-notifier' ) ); ?>
            </p>

            <p>
                <?php echo esc_html( __( 'Then open the following URL (replacing', 'login-telegram-notifier' ) ); ?> 
                <code>&lt;your_token&gt;</code> 
                <?php echo esc_html( __( 'with your actual bot token):', 'login-telegram-notifier' ) ); ?><br>
                <code>https://api.telegram.org/bot&lt;your_token&gt;/getUpdates</code>
            </p>

            <p>
                <?php echo esc_html( __( 'You will see a JSON response containing your', 'login-telegram-notifier' ) ); ?> 
                <code>chat.id</code> — <?php echo esc_html( __( 'that is your Chat ID.', 'login-telegram-notifier' ) ); ?>
            </p>

            <hr style="margin: 20px 0;">

            <h3>👥 <?php echo esc_html( __( 'Using your bot in a group', 'login-telegram-notifier' ) ); ?></h3>
            <p>
                <?php echo esc_html( __( 'You can also create a Telegram group and add your bot to it.', 'login-telegram-notifier' ) ); ?>
            </p>
            <p>
                <?php echo esc_html( __( 'After sending a message to the group, call', 'login-telegram-notifier' ) ); ?> 
                <code>/getUpdates</code> 
                <?php echo esc_html( __( 'again to retrieve the group chat ID.', 'login-telegram-notifier' ) ); ?>
            </p>
            <p>
                <?php echo esc_html( __( 'This allows your bot to send error notifications directly to a team chat.', 'login-telegram-notifier' ) ); ?>
            </p>
        </div>
        <div style="padding: 20px; border-left: 4px solid #dba617; background-color: #fffbe5;">
            <h2 style="margin-top: 0;">⚠️ <?php echo esc_html( __( 'Telegram API Limit Notice', 'login-telegram-notifier' ) ); ?></h2>
            <p><strong><?php echo esc_html( __( 'Telegram Bot API — Rate Limit Explanation', 'login-telegram-notifier' ) ); ?></strong></p>
            <p><?php echo esc_html( __( 'Telegram applies several rate limits to bots to prevent spam and overuse. Below is a summary of the most relevant constraints:', 'login-telegram-notifier' ) ); ?></p>

            <table class="widefat striped" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th style="width: 250px;"><?php echo esc_html( __( 'Limit', 'login-telegram-notifier' ) ); ?></th>
                        <th><?php echo esc_html( __( 'Details / Notes', 'login-telegram-notifier' ) ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong><?php echo esc_html( __( '30 messages per second globally', 'login-telegram-notifier' ) ); ?></strong></td>
                        <td><?php echo esc_html( __( 'Applies only when messages are sent to different users or chats. Sending to the same chat is subject to stricter limits.', 'login-telegram-notifier' ) ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo esc_html( __( '1 message per second per chat', 'login-telegram-notifier' ) ); ?></strong></td>
                        <td><?php echo esc_html( __( 'Applies to all chats (private or group). Sending more than one message per second to the same chat ID will cause messages to be dropped or delayed.', 'login-telegram-notifier' ) ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo esc_html( __( '20 messages per minute to a group chat (if the bot is not an admin)', 'login-telegram-notifier' ) ); ?></strong></td>
                        <td><?php echo esc_html( __( 'If your bot is not an administrator in the target group, it can send no more than 20 messages per minute to that chat. Excess messages will be silently ignored.', 'login-telegram-notifier' ) ); ?></td>
                    </tr>
                </tbody>
            </table>
            <p style="margin-top: 20px;"><strong>💡 <?php echo esc_html( __( 'Tip:', 'login-telegram-notifier' ) ); ?></strong> 
                <?php echo esc_html( __( 'To ensure consistent delivery, consider batching multiple updates into one message, or adding delays between sends. Making the bot an admin in the group is highly recommended if sending frequently.', 'login-telegram-notifier' ) ); ?>
            </p>
        </div>
    </div>
    <?php
}