<?php

declare(strict_types=1);

namespace Huzaifa\AiProviderForAlibabaCloud\Provider;

use WordPress\AiClient\AiClient;
use WordPress\AiClient\Common\Exception\RuntimeException;
use WordPress\AiClient\Providers\ApiBasedImplementation\AbstractApiProvider;
use WordPress\AiClient\Providers\ApiBasedImplementation\ListModelsApiBasedProviderAvailability;
use WordPress\AiClient\Providers\Contracts\ModelMetadataDirectoryInterface;
use WordPress\AiClient\Providers\Contracts\ProviderAvailabilityInterface;
use WordPress\AiClient\Providers\DTO\ProviderMetadata;
use WordPress\AiClient\Providers\Enums\ProviderTypeEnum;
use WordPress\AiClient\Providers\Http\Enums\RequestAuthenticationMethod;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelMetadata;
use Huzaifa\AiProviderForAlibabaCloud\Metadata\AlibabaCloudModelMetadataDirectory;
use Huzaifa\AiProviderForAlibabaCloud\Models\AlibabaCloudTextGenerationModel;
use Huzaifa\AiProviderForAlibabaCloud\Settings\AdminPage;

/**
 * Class for AI Provider for Alibaba Cloud.
 *
 * @since 0.1.0
 *
 * @package Huzaifa\AiProviderForAlibabaCloud
 */
class AlibabaCloudProvider extends AbstractApiProvider
{
    /**
     * {@inheritDoc}
     *
     * @since 0.1.0
     */
    protected static function baseUrl(): string
    {
        return AdminPage::getBaseUrl();
    }

    /**
     * {@inheritDoc}
     *
     * @since 0.1.0
     */
    protected static function createModel(
        ModelMetadata $modelMetadata,
        ProviderMetadata $providerMetadata
    ): ModelInterface {
        $capabilities = $modelMetadata->getSupportedCapabilities();
        foreach ($capabilities as $capability) {
            if ($capability->isTextGeneration()) {
                return new AlibabaCloudTextGenerationModel($modelMetadata, $providerMetadata);
            }
        }

        // phpcs:disable WordPress.Security.EscapeOutput.ExceptionNotEscaped
        throw new RuntimeException(
            'Unsupported model capabilities: ' . implode(', ', $capabilities)
        );
        // phpcs:enable WordPress.Security.EscapeOutput.ExceptionNotEscaped
    }

    /**
     * {@inheritDoc}
     *
     * @since 0.1.0
     */
    protected static function createProviderMetadata(): ProviderMetadata
    {
        $providerMetadataArgs = [
            'alibaba-cloud',
            'Alibaba Cloud',
            ProviderTypeEnum::cloud(),
            'https://modelstudio.console.alibabacloud.com/',
        ];

        // Authentication method support was added in 0.4.0.
        if (class_exists(RequestAuthenticationMethod::class)) {
            $providerMetadataArgs[] = RequestAuthenticationMethod::apiKey();
        }

        // Provider description support was added in 1.2.0.
        if (defined(AiClient::class . '::VERSION') && version_compare(AiClient::VERSION, '1.2.0', '>=')) {
            if (function_exists('__')) {
                $providerMetadataArgs[] = __('Text generation with Alibaba Cloud Qwen models.', 'ai-provider-for-alibaba-cloud');
            } else {
                $providerMetadataArgs[] = 'Text generation with Alibaba Cloud Qwen models.';
            }

            // Provider logo support was added in 1.3.0.
            if (version_compare(AiClient::VERSION, '1.3.0', '>=')) {
                $providerMetadataArgs[] = dirname(__DIR__, 2) . '/assets/logo.svg';
            }
        }

        return new ProviderMetadata(...$providerMetadataArgs);
    }

    /**
     * {@inheritDoc}
     *
     * @since 0.1.0
     */
    protected static function createProviderAvailability(): ProviderAvailabilityInterface
    {
        // Check valid API access by attempting to list models.
        return new ListModelsApiBasedProviderAvailability(
            static::modelMetadataDirectory()
        );
    }

    /**
     * {@inheritDoc}
     *
     * @since 0.1.0
     */
    protected static function createModelMetadataDirectory(): ModelMetadataDirectoryInterface
    {
        return new AlibabaCloudModelMetadataDirectory();
    }
}
