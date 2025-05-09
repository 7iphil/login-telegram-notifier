
=== Login Telegram Notifier ===
Contributors: philstudio
Tags: telegram, login alert, security, admin monitor, notification
Requires at least: 5.3
Tested up to: 6.8
Requires PHP: 7.2
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://yoomoney.ru/to/4100141266469

Sends Telegram alerts on WordPress admin login with IP, location, browser info. Secure, lightweight and Core-compliant.

== Description ==

Login Telegram Notifier keeps you informed every time someone logs into your WordPress admin area. It sends a detailed login alert to your Telegram bot, including:


* 🔗 URL
* 🌍 IP address
* 👤 Username
* 🧭 Geo location (via ip-api.com)
* ℹ️ Info about Browser and OS
* ⏰ Login timestamp


This is useful for monitoring suspicious logins, team access, staging environment entries or simply for peace of mind.

== Installation ==

= USING WORDPRESS PLUGIN INSTALLER =

1. Go to your WordPress Dashboard → Plugins → Add New.
2. Search for 'Login Telegram Notifier'.
3. Click 'Install' and then 'Activate'.
4. Done!

= MANUAL INSTALLATION =

1. Download the 'login-telegram-notifier' zip file.
2. Extract the content and copy it to the `/wp-content/plugins/` directory of your WordPress installation.
3. Go to Dashboard → Plugins → Installed Plugins.
4. Find 'Login Telegram Notifier' and click 'Activate'.
5. Go to Settings → Login Telegram Notifier to configure.

== Features ==
* 🔐 Sends login alerts via Telegram when anyone logs into WordPress
* 🌍 Includes IP address, location, user agent and timestamp
* ⚙️ Configurable Telegram bot token and chat ID
* 🚀 Uses WordPress Core standards (no curl, no file_get_contents)
* 🧼 Secure and GDPR-respecting (no logging of passwords or personal data)
* 🧠 Built for developers and sysadmins who want simple visibility

== Frequently Asked Questions ==

= How do I get a Telegram Bot Token and Chat ID? =

1. Search for @BotFather in Telegram and create a new bot to get your Bot Token.
2. Add your bot to a private/group chat and send a message.
3. Use tools like @userinfobot or web-based APIs to get the Chat ID (starts with `-` for groups).

= The plugin is active, but I don’t get notifications =

1. Check the "Enable Login Notifications" checkbox in Settings → Login Telegram Notifier.
2. Verify your bot token and chat ID are correct and active.
3. Make sure the bot is not blocked in your Telegram group or chat.
4. Try logging in with another browser or device to test it.

== Screenshots ==

1. Login Telegram Notifier settings page (Settings > Login Telegram Notifier)

== Changelog ==
= 1.0 =
* Initial release