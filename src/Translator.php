<?php

namespace Bakle\Translator;

use Bakle\Translator\Clients\GoogleTranslator;
use Symfony\Component\Finder\SplFileInfo;

class Translator
{
    private SplFileInfo $file;

    private string $sourceLang;

    private string $targetLang;

    private GoogleTranslator $client;

    public function __construct(SplFileInfo $file, string $sourceLang, string $targetLang)
    {
        $this->sourceLang = $sourceLang;
        $this->targetLang = $targetLang;
        $this->file = $file;
        $this->setUp();
    }

    public function begin($consoleOutput): void
    {
        $translatable = new TranslatableFile($this->client);

        $this->client->setTargetLang($this->targetLang);
        
        if($this->file->getExtension()==='json')
        {
            $fileToTranslate = json_decode($this->file->getContents(),true);
        }else {
            $fileToTranslate = include $this->file;
        }

        $progressBar = $consoleOutput->createProgressBar(count($fileToTranslate, COUNT_RECURSIVE));
        $progressBar->start();

        array_walk_recursive($fileToTranslate, function (&$text, $key) use ($translatable, $progressBar) {
            $textToTranslate = $translatable->lockSpecialWords($text);
            $this->client->translate($textToTranslate);
            $text = $translatable->unlockSpecialWords();
            $progressBar->advance();
        });

        $translatable->createFile($fileToTranslate, $this->file, $this->targetLang);
        $progressBar->finish();
    }

    private function setUp(): void
    {
        $this->client = new (config('bakle-translator.translator'));
        $this->client->setSourceLang($this->sourceLang);
    }
}
