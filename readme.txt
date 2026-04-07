=== AI Provider for Alibaba Cloud ===
Contributors: huzaifaalmesbah
Tags: ai, alibaba-cloud, dashscope, qwen, connector
Requires at least: 7.0
Tested up to: 7.0
Stable tag: 0.1.0
Requires PHP: 7.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

AI Provider for Alibaba Cloud Model Studio (DashScope) for the WordPress AI Client.

== Description ==

This plugin provides Alibaba Cloud Model Studio (DashScope) integration for the WP AI Client SDK. It enables WordPress sites to use Alibaba's massive suite of Qwen models for text generation and related AI capabilities.

**Features:**

* Text generation with Qwen models (qwen-turbo, qwen-plus, qwen-max, and more)
* Chat history support
* Function calling support
* JSON output support
* Automatic provider registration

Available models are dynamically discovered from the DashScope API.

**Requirements:**

* PHP 7.4 or higher
* WP AI Client plugin must be installed and activated
* Alibaba Cloud DashScope API key

== Installation ==

1. Ensure the WP AI Client plugin is installed and activated
2. Upload the plugin files to `/wp-content/plugins/ai-provider-for-alibaba-cloud/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Settings > AI Credentials and enter your Alibaba Cloud API key

== Usage ==

The provider automatically registers itself. Once your API key is configured, you can start generating text:

= Basic Text Generation =

`$text = AI_Client::prompt( 'Explain quantum computing.' )->using_provider( 'alibaba-cloud' )->generate_text();`

== Frequently Asked Questions ==

= How do I get an Alibaba Cloud API key? =

Visit the Alibaba Cloud Model Studio (DashScope) console to generate an API key.

= Which models are available? =

Available models include the entire Qwen line (qwen-turbo, qwen-plus, qwen-max, etc.). Models are dynamically fetched from the DashScope API.

== Changelog ==

= 0.1.0 =
* Initial release
* Support for Qwen text generation models
* Chat history support
* Function calling support
* JSON output support
