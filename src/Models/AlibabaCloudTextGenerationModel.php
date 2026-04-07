<?php

declare(strict_types=1);

namespace Huzaifa\AiProviderForAlibabaCloud\Models;

use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Providers\Http\DTO\Request;
use WordPress\AiClient\Providers\Http\Enums\HttpMethodEnum;
use WordPress\AiClient\Providers\OpenAiCompatibleImplementation\AbstractOpenAiCompatibleTextGenerationModel;
use Huzaifa\AiProviderForAlibabaCloud\Provider\AlibabaCloudProvider;

/**
 * Class for text generation models used by AI Provider for Alibaba Cloud.
 *
 * @since 0.1.0
 *
 * @package Huzaifa\AiProviderForAlibabaCloud
 */
class AlibabaCloudTextGenerationModel extends AbstractOpenAiCompatibleTextGenerationModel
{
    /**
     * {@inheritDoc}
     *
     * Disables thinking mode for Alibaba Cloud models. Many Qwen 3+ models have
     * thinking enabled by default, which is incompatible with the `n` parameter
     * (candidate count) required by features like title generation.
     *
     * @since 0.1.0
     */
    protected function prepareGenerateTextParams(array $prompt): array
    {
        $params = parent::prepareGenerateTextParams($prompt);

        if (!isset($params['enable_thinking'])) {
            $params['enable_thinking'] = false;
        }

        return $params;
    }

    /**
     * {@inheritDoc}
     *
     * Alibaba Cloud may return `content` as an array of objects with `text` keys
     * instead of a plain string. This normalizes that format before parsing.
     *
     * @since 0.1.0
     */
    protected function parseResponseChoiceMessageParts(array $messageData, int $index): array
    {
        if (isset($messageData['content']) && is_array($messageData['content'])) {
            $texts = [];
            foreach ($messageData['content'] as $part) {
                if (is_array($part) && isset($part['text']) && is_string($part['text'])) {
                    $texts[] = $part['text'];
                }
            }
            $messageData['content'] = implode('', $texts);
        }

        return parent::parseResponseChoiceMessageParts($messageData, $index);
    }

    /**
     * {@inheritDoc}
     *
     * @since 0.1.0
     */
    protected function createRequest(
        HttpMethodEnum $method,
        string $path,
        array $headers = [],
        $data = null
    ): Request {
        return new Request(
            $method,
            AlibabaCloudProvider::url($path),
            $headers,
            $data,
            $this->getRequestOptions()
        );
    }
}
