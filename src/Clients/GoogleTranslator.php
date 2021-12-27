<?php

namespace Bakle\Translator\Clients;

use Bakle\Translator\Contracts\ClientTranslator;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class GoogleTranslator extends ClientTranslator
{
    private string $format = 'text';

    public function translate(string $text): void
    {
        $client = new Client();

        try {
            $this->response = $client->request('POST', $this->endpoint, [
                'form_params' => $this->buildParams($text),
            ]);
        } catch (\Exception $e) {
            Log::error('Translator Error: ', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
            throw new \Exception('There was a problem translating the text.');
        }
    }

    /**
     * Get the translated text.
     *
     * @return string
     */
    public function getTranslatedText(): string
    {
        $translated = json_decode($this->response->getBody()->getContents());

        if (!empty($translated)) {
            return Arr::first($translated->data->translations)->translatedText;
        }
    }

    private function buildParams(string $text): array
    {
        return [
            'key' => $this->apiKey,
            'format' => $this->format,
            'source' => $this->getSourceLang(),
            'target' => $this->getTargetLang(),
            'q' => $text,
        ];
    }
}
