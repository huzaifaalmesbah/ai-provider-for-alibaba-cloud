<?php
/**
 * Plugin Name: AI Provider for Alibaba Cloud
 * Plugin URI: https://wordpress.org/plugins/ai-provider-for-alibaba-cloud/
 * Description: AI Provider for Alibaba Cloud Model Studio (DashScope) for the WordPress AI Client.
 * Requires at least: 7.0
 * Requires PHP: 7.4
 * Version: 0.1.0
 * Author: Huzaifa Al Mesbah
 * Author URI: https://profiles.wordpress.org/huzaifaalmesbah/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ai-provider-for-alibaba-cloud
 *
 * @package Huzaifa\AiProviderForAlibabaCloud
 */

declare(strict_types=1);

namespace Huzaifa\AiProviderForAlibabaCloud;

use WordPress\AiClient\AiClient;
use Huzaifa\AiProviderForAlibabaCloud\Provider\AlibabaCloudProvider;
use Huzaifa\AiProviderForAlibabaCloud\Settings\AdminPage;

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/src/autoload.php';

/**
 * Registers the Alibaba Cloud provider with the AI Client.
 *
 * @since 0.1.0
 *
 * @return void
 */
function register_provider(): void
{
    if (!class_exists(AiClient::class)) {
        return;
    }

    $registry = AiClient::defaultRegistry();

    if ($registry->hasProvider(AlibabaCloudProvider::class)) {
        return;
    }

    $registry->registerProvider(AlibabaCloudProvider::class);
}

add_action('init', __NAMESPACE__ . '\\register_provider', 5);

/**
 * Registers the admin settings page.
 *
 * @since 0.1.0
 *
 * @return void
 */
function register_admin_page(): void
{
    AdminPage::register();
}

add_action('init', __NAMESPACE__ . '\\register_admin_page');

// Auto-detect region when the API key is saved from the Connectors page.
add_action('update_option_connectors_ai_alibaba_cloud_api_key', [AdminPage::class, 'onApiKeyUpdate'], 10, 2);
add_action('add_option_connectors_ai_alibaba_cloud_api_key', [AdminPage::class, 'onApiKeyAdd'], 10, 2);
