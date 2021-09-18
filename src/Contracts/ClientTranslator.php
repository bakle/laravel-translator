<?php

namespace Bakle\Translator\Contracts;

abstract class ClientTranslator
{
    protected string $endpoint;

    protected string $apiKey;

    protected string $sourceLang;

    protected string $targetLang;

    public function __construct()
    {
        $this->apiKey = config('bakle-translator.api_key');
        $this->endpoint = config('bakle-translator.client_endpoint');
    }

    abstract public function translate(string $text): void;

    abstract public function getTranslatedText(): string;

    public function setSourceLang(string $sourceLang): void
    {
        $this->sourceLang = $sourceLang;
    }

    public function getSourceLang(): string
    {
        return $this->sourceLang;
    }

    public function setTargetLang(string $targetLang): void
    {
        $this->targetLang = $targetLang;
    }

    public function getTargetLang(): string
    {
        return $this->targetLang;
    }
}
