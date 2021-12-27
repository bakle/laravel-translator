<?php

namespace Bakle\Translator;

use Bakle\Translator\Constants\FileExtensions;
use Bakle\Translator\Contracts\ClientTranslator;
use Symfony\Component\Finder\SplFileInfo;

class Translator
{
    private SplFileInfo $file;

    private string $sourceLang;

    private string $targetLang;

    private ClientTranslator $client;

    private TranslatableFile $translatable;

    public function __construct(string $sourceLang, string $targetLang)
    {
        $this->sourceLang = $sourceLang;
        $this->targetLang = $targetLang;
        $this->client = new (config('bakle-translator.translator'));
        $this->client->setSourceLang($this->sourceLang);
        $this->translatable = new TranslatableFile($this->client);
    }

    public function setFile(SplFileInfo $file)
    {
        $this->file = $file;
    }

    public function begin($consoleOutput): void
    {
        $this->client->setTargetLang($this->targetLang);

        $fileContentToTranslate = $this->getFileContentToTranslate();

        $progressBar = $consoleOutput->createProgressBar(count($fileContentToTranslate, COUNT_RECURSIVE));
        $progressBar->start();

        $translatedContent = $this->translate($fileContentToTranslate, $progressBar);

        $this->translatable->createFile($translatedContent, $this->file, $this->targetLang);
        $progressBar->finish();
    }

    private function getFileContentToTranslate(): array
    {
        return FileExtensions::isJson($this->file->getExtension())
            ? json_decode($this->file->getContents(), true)
            : include $this->file;
    }

    private function translate(array $fileContent, $progressBar): array
    {
        array_walk_recursive($fileContent, function (&$text, $key) use ($progressBar) {
            $textToTranslate = $this->translatable->lockSpecialWords($text);
            $this->client->translate($textToTranslate);
            $text = $this->translatable->unlockSpecialWords();
            $progressBar->advance();
        });

        return $fileContent;
    }
}
