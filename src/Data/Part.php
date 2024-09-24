<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * A datatype containing media that is part of a multi-part Content message.
 */
final class Part implements Arrayable
{
    /**
     * @param  string|null  $text  Inline text.
     * @param  Blob|null  $inlineData  Inline media bytes.
     */
    public function __construct(
        public readonly ?string $text = null,
        public readonly ?Blob $inlineData = null,
        public readonly ?array $functionCall = null,
        public readonly ?array $functionResponse = null,
        public readonly ?array $fileData = null
    ) {
    }

    /**
     * @param  array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, functionCall: ?array }  $attributes
     */
    public static function from(array $attributes): self
    {
        $functionCall = $attributes['functionCall'] ?? null;
        if ($functionCall !== null && is_array($functionCall['args']) && count($functionCall['args']) === 0){
            $functionCall['args'] = null;
        }

        return new self(
            text: $attributes['text'] ?? null,
            inlineData: isset($attributes['inlineData']) ? Blob::from($attributes['inlineData']) : null,
            functionCall: $functionCall,
            functionResponse: isset($attributes['functionResponse']) ? $attributes['functionResponse'] : null,
            fileData: isset($attributes['fileData']) ? $attributes['fileData'] : null
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->text !== null) {
            $data['text'] = $this->text;
        }

        if ($this->inlineData !== null) {
            $data['inlineData'] = $this->inlineData;
        }

        if ($this->functionCall !== null) {
            $data['functionCall'] = $this->functionCall;
        }

        if ($this->functionResponse !== null) {
            $data['functionResponse'] = $this->functionResponse;
        }

        if ($this->fileData !== null) {
            $data['file_data'] = $this->fileData;
        }

        return $data;
    }
}
