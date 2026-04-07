<?php

declare(strict_types=1);

namespace Huzaifa\AiProviderForAlibabaCloud\Settings;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registers and renders the Settings > Alibaba Cloud admin page.
 *
 * @since 0.1.0
 *
 * @package Huzaifa\AiProviderForAlibabaCloud
 */
class AdminPage
{
    public const OPTION_API_REGION = 'alibaba_cloud_api_region';
    public const OPTION_GROUP      = 'alibaba_cloud_settings';
    public const PAGE_SLUG         = 'alibaba-cloud-settings';

    /**
     * Available API regions and their base URLs.
     *
     * @since 0.1.0
     *
     * @var array<string, array{label: string, url: string}>
     */
    public const REGIONS = [
        'singapore' => [
            'label' => 'Singapore',
            'url'   => 'https://dashscope-intl.aliyuncs.com/compatible-mode/v1',
        ],
        'us-virginia' => [
            'label' => 'US (Virginia)',
            'url'   => 'https://dashscope-us.aliyuncs.com/compatible-mode/v1',
        ],
        'cn-beijing' => [
            'label' => 'China (Beijing)',
            'url'   => 'https://dashscope.aliyuncs.com/compatible-mode/v1',
        ],
        'cn-hongkong' => [
            'label' => 'China (Hong Kong)',
            'url'   => 'https://cn-hongkong.dashscope.aliyuncs.com/compatible-mode/v1',
        ],
    ];

    /**
     * Register hooks for the admin page.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function register(): void
    {
        add_action('admin_menu', [self::class, 'add_menu_page']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    /**
     * Add the submenu page under Settings.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function add_menu_page(): void
    {
        add_options_page(
            __('Alibaba Cloud', 'ai-provider-for-alibaba-cloud'),
            __('Alibaba Cloud', 'ai-provider-for-alibaba-cloud'),
            'manage_options',
            self::PAGE_SLUG,
            [self::class, 'render_page']
        );
    }

    /**
     * Register the settings and fields.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function register_settings(): void
    {
        register_setting(
            self::OPTION_GROUP,
            self::OPTION_API_REGION,
            [
                'type'              => 'string',
                'default'           => 'singapore',
                'sanitize_callback' => [self::class, 'sanitize_region'],
            ]
        );

        add_settings_section(
            'alibaba_cloud_api_section',
            __('API Settings', 'ai-provider-for-alibaba-cloud'),
            [self::class, 'render_section_description'],
            self::PAGE_SLUG
        );

        add_settings_field(
            self::OPTION_API_REGION,
            __('API Region', 'ai-provider-for-alibaba-cloud'),
            [self::class, 'render_api_region_field'],
            self::PAGE_SLUG,
            'alibaba_cloud_api_section'
        );
    }

    /**
     * Sanitize the region value.
     *
     * @since 0.1.0
     *
     * @param string $value The submitted region value.
     * @return string The sanitized region value.
     */
    public static function sanitize_region(string $value): string
    {
        if (isset(self::REGIONS[$value])) {
            return $value;
        }

        return 'singapore';
    }

    /**
     * Returns the base URL for the selected region.
     *
     * @since 0.1.0
     *
     * @return string The base URL for the API.
     */
    public static function getBaseUrl(): string
    {
        $region = get_option(self::OPTION_API_REGION, 'singapore');

        if (isset(self::REGIONS[$region])) {
            return self::REGIONS[$region]['url'];
        }

        return self::REGIONS['singapore']['url'];
    }

    /**
     * Detects the correct API region for a given API key by testing each endpoint.
     *
     * Tries the /models endpoint on each region. The first region that returns
     * a successful response is saved as the active region.
     *
     * @since 0.1.0
     *
     * @param string $api_key The API key to test.
     * @return string|null The detected region key, or null if no region matched.
     */
    public static function detectRegion(string $api_key): ?string
    {
        foreach (self::REGIONS as $regionKey => $region) {
            $response = wp_remote_get(
                $region['url'] . '/models',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $api_key,
                    ],
                    'timeout' => 10,
                ]
            );

            if (is_wp_error($response)) {
                continue;
            }

            $code = wp_remote_retrieve_response_code($response);
            if ($code >= 200 && $code < 300) {
                return $regionKey;
            }
        }

        return null;
    }

    /**
     * Auto-detects and saves the correct region when the API key is updated.
     *
     * Hooked into update_option and add_option for the connector API key setting.
     *
     * @since 0.1.0
     *
     * @param mixed $old_value The old option value (unused for add_option hook).
     * @param mixed $value     The new option value.
     * @return void
     */
    public static function onApiKeyUpdate($old_value, $value): void
    {
        if (!is_string($value) || '' === $value) {
            return;
        }

        // Skip if the value hasn't actually changed.
        if ($value === $old_value) {
            return;
        }

        $region = self::detectRegion($value);

        if ($region !== null) {
            update_option(self::OPTION_API_REGION, $region);
        }
    }

    /**
     * Handles auto-detection when the API key option is first created.
     *
     * @since 0.1.0
     *
     * @param string $option The option name (unused).
     * @param mixed  $value  The new option value.
     * @return void
     */
    public static function onApiKeyAdd($option, $value): void
    {
        self::onApiKeyUpdate('', $value);
    }

    /**
     * Render the section description.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function render_section_description(): void
    {
        echo '<p>' . esc_html__(
            'The API region is auto-detected when you enter your API key in Settings > AI Credentials. You can also change it manually below.',
            'ai-provider-for-alibaba-cloud'
        ) . '</p>';
    }

    /**
     * Render the API region dropdown field.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function render_api_region_field(): void
    {
        $current = get_option(self::OPTION_API_REGION, 'singapore');
        ?>
        <select name="<?php echo esc_attr(self::OPTION_API_REGION); ?>" id="alibaba_cloud_api_region_select">
            <?php foreach (self::REGIONS as $key => $region) : ?>
                <option value="<?php echo esc_attr($key); ?>" <?php selected($current, $key); ?>>
                    <?php echo esc_html($region['label']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">
            <?php esc_html_e(
                'This is auto-detected from your API key. You can override it manually if needed.',
                'ai-provider-for-alibaba-cloud'
            ); ?>
        </p>
        <?php
    }

    /**
     * Render the settings page.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function render_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        echo '<div class="wrap">';
        echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>';

        settings_errors(self::OPTION_API_REGION);

        echo '<form action="options.php" method="post">';
        settings_fields(self::OPTION_GROUP);
        do_settings_sections(self::PAGE_SLUG);
        submit_button();
        echo '</form>';
        echo '</div>';
    }
}
