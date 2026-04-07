=== AI Provider for Alibaba Cloud ===
Contributors: huzaifaalmesbah
Tags: ai, alibaba-cloud, dashscope, qwen, connector
Requires at least: 7.0
Tested up to: 7.0
Stable tag: 0.1.0
Requires PHP: 7.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Alibaba Cloud Model Studio (DashScope) provider for the WordPress AI Client.

== Description ==

This plugin provides Alibaba Cloud Model Studio (DashScope) integration for the WordPress AI Client. It enables WordPress sites to use Alibaba's powerful Qwen models for text generation and related AI capabilities.

**Features:**

* Text generation with Qwen models (qwen-turbo, qwen-plus, qwen-max, qwen-long, and more)
* Chat history support for conversational AI experiences
* Function calling (tool use) support for compatible models
* JSON output mode for structured responses
* Streaming response support
* Temperature and max tokens configuration
* Automatic provider registration
* Dynamic model discovery from DashScope API

**Available Models:**

Models are dynamically discovered from the DashScope API, including:

* **qwen-turbo** — Fast, cost-effective for most tasks
* **qwen-plus** — Balanced performance and speed
* **qwen-max** — Highest quality for complex tasks
* **qwen-long** — Optimized for long-context processing
* **qwen-vl-plus** — Multimodal vision-language model
* **qwen-coder-plus** — Specialized for code generation

For a complete list of available models, see the [Model Studio Models](https://www.alibabacloud.com/help/en/model-studio/models) page.

**Requirements:**

* PHP 7.4 or higher
* WordPress 7.0 or above
* Alibaba Cloud DashScope API key

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/ai-provider-for-alibaba-cloud/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure your Alibaba Cloud API key (see Configuration below)

== Configuration ==

**Via Environment Variable:**

Set the `DASHSCOPE_API_KEY` environment variable in your server configuration:

```bash
export DASHSCOPE_API_KEY=your-api-key-here
```

**Via WordPress Config:**

Add this line to your `wp-config.php` file:

```php
define( 'DASHSCOPE_API_KEY', 'your-api-key-here' );
```

**Via Settings Page:**

1. Go to Settings > AI Credentials
2. Enter your Alibaba Cloud DashScope API key
3. Save settings

== Usage ==

The provider automatically registers itself with the WordPress AI Client. Once configured, you can start generating text:

**Basic Text Generation:**

```php
$text = AI_Client::prompt( 'Explain quantum computing.' )
    ->using_provider( 'alibaba-cloud' )
    ->generate_text();
```

**Chat with History:**

```php
$chat = AI_Client::chat()
    ->using_provider( 'alibaba-cloud' )
    ->with_system_message( 'You are a helpful assistant.' )
    ->with_message( 'user', 'What is the capital of France?' )
    ->with_message( 'assistant', 'The capital of France is Paris.' )
    ->with_message( 'user', 'And what is its population?' )
    ->generate_text();
```

**Generate JSON Output:**

```php
$json = AI_Client::prompt( 'Extract contact info from this text...' )
    ->using_provider( 'alibaba-cloud' )
    ->with_json_output()
    ->generate_text();
```

**Function Calling (Tool Use):**

```php
$result = AI_Client::prompt( 'What is the weather in Tokyo?' )
    ->using_provider( 'alibaba-cloud' )
    ->with_function( $weather_function )
    ->generate_text();
```

**Specify a Model:**

```php
$text = AI_Client::prompt( 'Write a poem about AI.' )
    ->using_provider( 'alibaba-cloud' )
    ->with_model( 'qwen-max' )
    ->with_temperature( 0.8 )
    ->with_max_tokens( 500 )
    ->generate_text();
```

**Streaming Response:**

```php
AI_Client::prompt( 'Tell me a story.' )
    ->using_provider( 'alibaba-cloud' )
    ->stream_text( function( $chunk ) {
        echo $chunk;
        ob_flush();
        flush();
    } );
```

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

* **qwen-turbo** — Best for simple tasks, high volume, cost-sensitive applications
* **qwen-plus** — Best balance of performance and cost for most use cases
* **qwen-max** — Best for complex reasoning, creative writing, analysis
* **qwen-long** — Best for processing large documents and long-context tasks
* **qwen-coder-plus** — Best for code generation and programming tasks

= Is there a free tier? =

Alibaba Cloud offers free trial quota for new users. Check the pricing information in the Model Studio Console for current rates and free tier availability.

= What is the difference between DashScope and Qwen? =

**DashScope** is Alibaba Cloud's Model Studio platform — the service that hosts and provides access to AI models via API.

**Qwen** is the family of large language models developed by Alibaba's research team, available through the DashScope platform.

This plugin connects your WordPress site to the DashScope API to use Qwen models.

= Can I use multiple AI providers simultaneously? =

Yes! You can have multiple AI provider plugins active at the same time. Each provider registers itself separately, allowing you to choose the best model for each task:

```php
// Use Alibaba Cloud for one task
$text1 = AI_Client::prompt( '...' )->using_provider( 'alibaba-cloud' )->generate_text();

// Use a different provider for another task
$text2 = AI_Client::prompt( '...' )->using_provider( 'openai' )->generate_text();
```


== External Services ==

This plugin connects to the Alibaba Cloud Model Studio API to provide AI text generation capabilities.

Data is sent to the Model Studio API when your application code makes AI generation requests through the WordPress AI Client. The data sent includes your prompts, model configuration, and API key. No data is sent automatically — requests only occur when explicitly triggered by code using the WordPress AI Client.

* **API Console:** https://modelstudio.console.alibabacloud.com/ap-southeast-1/?tab=api#/api
* **Available Models:** https://www.alibabacloud.com/help/en/model-studio/models
* **Terms of Service:** https://www.alibabacloud.com/help/en/legal/latest/alibaba-cloud-international-website-product-terms-of-service-v-3-8-0?spm=a2c63.p38356.0.i2#d48a5c007bamp

== Changelog ==

= 0.1.0 =
* Initial pre-release
* Support for Qwen text generation models
* Chat history support
* Function calling support
* JSON output support
* Streaming response support
* Dynamic model discovery from DashScope API
* Admin settings page for API key configuration

== Upgrade Notice ==

= 0.1.0 =
Initial pre-release of the AI Provider for Alibaba Cloud plugin.
