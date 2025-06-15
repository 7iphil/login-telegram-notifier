=== Login Telegram Notifier ===
Contributors: philstudio  
Tags: telegram, login, alert, security, monitor
Requires at least: 5.3  
Tested up to: 6.8  
Requires PHP: 7.2  
Stable tag: 1.1.1 
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  
Donate link: https://yoomoney.ru/to/4100141266469  

This plugin sends real-time Telegram alerts when someone logs into the WordPress admin panel. Includes IP, location, user agent and more.

== Description ==

Login Telegram Notifier sends you instant login notifications via Telegram every time someone signs into your WordPress admin area.

The alert includes:

* 🔗 Login URL
* 🌍 IP address
* 🧭 Geo location (via ip-api.com)
* 👤 Username
* ℹ️ Browser and OS information
* ⏰ Login timestamp

This plugin helps site owners monitor unauthorized access, multi-user logins or staging/admin activity.

== Installation ==

= Using the WordPress Plugin Installer =

1. Go to WordPress Dashboard → Plugins → Add New.
2. Search for "Login Telegram Notifier".
3. Click "Install" then "Activate".
4. Go to Settings → Login Telegram Notifier and enter your Telegram Bot Token and Chat ID.

= Manual Installation =

1. Download the plugin zip file.
2. Unzip and upload to `/wp-content/plugins/login-telegram-notifier`.
3. Activate via Dashboard → Plugins.
4. Configure in Tools → Login Telegram Notifier.

= СREATE A TELEGRAM BOT =

1. Open Telegram and search for the user **@BotFather**.
2. Type `/start` and follow instructions to create a new bot.
3. Choose a name and a username for your bot.
4. After creation, **BotFather** will send you a token (example: 123456789:ABCdefGHIjkLmnoPQRstuVWxyZ).
5. Find and copy your chat ID here: https://api.telegram.org/bot<your_token>/getUpdates.
6. Paste **bot token** and **chat ID** into plugin settings: **Tools > Login Telegram Notifier**.

== Features ==

* 🔔 Telegram notifications on every login
* 🌍 IP, geo location, browser and OS info
* 🔐 Works with Telegram bots securely
* 🧼 GDPR-friendly — no sensitive data stored
* 💡 Simple setup, no coding required

== Frequently Asked Questions ==

= How do I get my Telegram Bot Token? =

Use [@BotFather](https://t.me/BotFather) in Telegram to create a bot and get your token.

= How do I find my Chat ID? =

Send a message to the bot, then use the [getUpdates API](https://api.telegram.org/bot<your-token>/getUpdates) to retrieve your chat ID.

= I'm not receiving alerts. Why? =

1. Check that notifications are enabled in plugin settings.
2. Make sure your bot is not blocked in the group or chat.
3. Ensure your token and chat ID are valid.
4. Try logging in from another browser to test.

== External services ==

This plugin connects to the following external services:

=== Telegram Bot API ===  
Used to send login alert messages to your Telegram bot/chat.  
🔗 [Telegram API Docs](https://core.telegram.org/bots/api)  
📜 [Telegram Privacy Policy](https://telegram.org/privacy)

Data sent: Chat ID, bot token (from your settings), and message with IP/location/user agent info.  
Data is only sent when someone logs in and notifications are enabled.
All data is not stored locally exclude Chat ID, bot token from your settings.

=== IP-API.com ===  
Used to retrieve geolocation data (city, country) from the IP address.  
🔗 [https://ip-api.com](http://ip-api.com)  
📜 [Privacy Policy](https://ip-api.com/docs/legal)

Data sent: visitor’s IP address.  
Data is used to enhance notification detail and is not stored locally.

== Screenshots ==

1. Search for @BotFather in Telegram | Create new bot in @BotFather | Find and copy your chat ID here: https://api.telegram.org/bot<your_token>/getUpdates
2. Paste bot token and chat ID into plugin settings: Tools > Login Telegram Notifier.

== Changelog ==

= 1.0 =
* Initial release

= 1.1 =
* [Fixed] Fix readme.txt file
* [Added] Added External services Info

== Upgrade Notice ==

= 1.1.1 =
* [Added] Added screenshot and step-by-step guide on how to create a Telegram bot, obtain a token, and find your chat ID.
