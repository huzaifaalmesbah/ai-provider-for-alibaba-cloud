=== AI Provider for Alibaba Cloud ===
Contributors: huzaifaalmesbah
Tags: ai, alibaba-cloud, dashscope, qwen, connector
Requires at least: 7.0
Tested up to: 7.0
Stable tag: 0.1.0
Requires PHP: 7.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Independent WordPress AI Client provider for Alibaba Cloud Model Studio (DashScope).

== Description ==

This plugin provides a third-party Alibaba Cloud Model Studio (DashScope) integration for the WordPress AI Client. It enables WordPress sites to use Alibaba's powerful Qwen models for text generation and related AI capabilities.
It is not affiliated with, endorsed by, or sponsored by Alibaba Cloud.

**Features:**

* Text generation with Qwen models
* Chat history support for conversational AI experiences
* Function calling (tool use) support for compatible models
* JSON output mode for structured responses
* Streaming response support
* Automatic provider registration

Available models are dynamically discovered from the DashScope API, including qwen-turbo, qwen-plus, qwen-max, qwen-long, qwen-vl-plus, and qwen-coder-plus.

**Requirements:**

* PHP 7.4 or higher
* WordPress 7.0 or above
* Alibaba Cloud DashScope API key

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/ai-provider-for-alibaba-cloud/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure your Alibaba Cloud API key via the `DASHSCOPE_API_KEY` environment variable or constant, or through the AI Credentials settings page

== Screenshots ==

1. API key configuration page for the connector.
2. Connector page after successful configuration.
3. Alibaba Cloud settings with region selection option.
4. Using AI plugin with this connector to create post title.

== Frequently Asked Questions ==

= How do I get an Alibaba Cloud DashScope API key? =

1. Visit the [Alibaba Cloud Model Studio Console](https://modelstudio.console.alibabacloud.com/ap-southeast-1/?tab=api#/api)
2. Create an account or log in with your Alibaba Cloud account
3. Navigate to API-KEY Management
4. Create a new API key
5. Copy and securely store your API key

= Does this plugin work without the WordPress AI Client? =

No, this plugin requires the WordPress AI Client (built into WordPress 7.0+) to be available. It provides the Alibaba Cloud-specific implementation that the WordPress AI Client uses.

= Which Qwen model should I use? =

Available models include qwen-turbo, qwen-plus, qwen-max, qwen-long, qwen-vl-plus, and qwen-coder-plus. For a complete list of available models, see the [Model Studio Models](https://www.alibabacloud.com/help/en/model-studio/models) page.

= Is there a free tier? =

Alibaba Cloud offers free trial quota for new users. Check the pricing information in the Model Studio Console for current rates and free tier availability.

= What is the difference between DashScope and Qwen? =

**DashScope** is Alibaba Cloud's Model Studio platform — the service that hosts and provides access to AI models via API.

**Qwen** is the family of large language models developed by Alibaba's research team, available through the DashScope platform.

This plugin connects your WordPress site to the DashScope API to use Qwen models.

= Where can I report bugs or request features? =

This plugin is open source and hosted on [GitHub](https://github.com/huzaifaalmesbah/ai-provider-for-alibaba-cloud).

* **Report a bug:** [GitHub Issues](https://github.com/huzaifaalmesbah/ai-provider-for-alibaba-cloud/issues)
* **Request a feature:** [GitHub Issues](https://github.com/huzaifaalmesbah/ai-provider-for-alibaba-cloud/issues)
* **Contribute:** [Pull Requests](https://github.com/huzaifaalmesbah/ai-provider-for-alibaba-cloud/pulls)

== Changelog ==

= 0.1.0 =
* Initial release
* Support for Qwen text generation models
* Chat history support
* Function calling support
* JSON output support
* Streaming response support
* Dynamic model discovery from DashScope API
* Admin settings page for API key configuration

== External Services ==

This plugin connects to the Alibaba Cloud Model Studio API to provide AI text generation capabilities.

Data is sent to the Model Studio API when your application code makes AI generation requests through the WordPress AI Client. The data sent includes your prompts, model configuration, and API key. No data is sent automatically — requests only occur when explicitly triggered by code using the WordPress AI Client.

* **API Console:** [Alibaba Cloud Model Studio Console](https://modelstudio.console.alibabacloud.com/ap-southeast-1/?tab=api#/api)
* **Available Models:** [Model Studio Models](https://www.alibabacloud.com/help/en/model-studio/models)
* **Terms of Service:** [Alibaba Cloud Terms of Service](https://www.alibabacloud.com/help/en/legal/latest/alibaba-cloud-international-website-product-terms-of-service-v-3-8-0?spm=a2c63.p38356.0.i2#d48a5c007bamp)

== Upgrade Notice ==

= 0.1.0 =
Initial release of the AI Provider for Alibaba Cloud plugin.
