<?php

namespace Bakle\Translator\Clients;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class ClientTranslator
{
    /**
     * Endpoint to Google Translator API.
     *
     * @var string
     */
    private $endpoint;

    /**
     * Google Translator API Key.
     *
     * @var string
     */
    private $apiKey;

    /**
     * Language of the original text.
     *
     * @var string
     */
    private $sourceLang;

    /**
     * Language of the translated text.
     *
     * @var string
     */
    private $targetLang;

    /**
     * Format of Google Translator response.
     *
     * @var string
     */
    private $format = 'text';

    private $response;

    public function __construct()
    {
        $this->apiKey = config('bakleTranslator.api_key');
        $this->endpoint = config('bakleTranslator.client_endpoint');
    }

    /**
     * Set the source lang.
     *
     * @param string $sourceLang
     * @return void
     */
    public function setSourceLang($sourceLang): void
    {
        $this->sourceLang = $sourceLang;
    }

    /**
     * Get the source lang.
     *
     * @return string
     */
    public function getSourceLang(): string
    {
        return $this->sourceLang;
    }

    /**
     * Set the target lang.
     *
     * @param string $targetLang
     * @return void
     */
    public function setTargetLang($targetLang): void
    {
        $this->targetLang = $targetLang;
    }

    /**
     * Get the target lang.
     *
     * @return string
     */
    public function getTargetLang(): string
    {
        return $this->targetLang;
    }

    /**
     * Translate text.
     *
     * @param string $text
     * @return void
     */
    public function translate($text): void
    {
        $client = new Client();

        try {
            $this->response = $client->request('POST', $this->endpoint, [
                'form_params' => $this->buildParams($text),
            ]);
        } catch (\Exception $e) {
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

        if (!empty($translated) && !is_null($translated)) {
            return Arr::first($translated->data->translations)->translatedText;
        }
    }

    /**
     * Build params in array.
     *
     * @param string $text
     * @return array
     */
    private function buildParams($text): array
    {
        return $params = [
            'key' => $this->apiKey,
            'format' => $this->format,
            'source' => $this->getSourceLang(),
            'target' => $this->getTargetLang(),
            'q' => $text,
        ];
    }
}
