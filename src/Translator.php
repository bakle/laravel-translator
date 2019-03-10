<?php

namespace Bakle\Translator;

use Bakle\Translator\TranslatableFile;
use Bakle\Translator\Clients\ClientTranslator;

class Translator
{

    const STATUS_ERROR = 'Error';
    const STATUS_SUCCESSFUL = 'Successful';

    /**
     * Relative file name from lang folder
     *
     * @var string
     */
    private $file;

    /**
     * Language of the file to be translated
     *
     * @var string
     */
    private $sourceLang;

    /**
     * Languages to translate the files
     *
     * @var array
     */
    private $targetLang;

    /**
     * Translator client
     *
     * @var ClientTranslator
     */
    private $client;

    private $status;

    private $message;

    public function __construct($file, $sourceLang, $targetLang)
    {
        $this->sourceLang = $sourceLang;
        $this->targetLang = $targetLang;
        $this->file = $file;
        $this->setUp();
    }

    /**
     * Start process of translation
     *
     * @return void
     */
    public function begin()
    {
        $translatable = new TranslatableFile($this->client);

        $this->client->setTargetLang($this->targetLang);
        $fileToTranslate = include $this->file;

        array_walk_recursive($fileToTranslate, function (&$text, $key) use ($translatable) {
            $textToTranslate = $translatable->lockSpecialWords($text);
            $textToTranslate = $translatable->lockSpecialWords($text);
            $this->client->translate($textToTranslate);
            $text = $translatable->unlockSpecialWords();
        });

        $translatable->createFile($fileToTranslate, $this->file, $this->targetLang);
    }

    /**
     * @return void
     */
    private function setUp(): void
    {
        $this->client = new ClientTranslator();
        $this->client->setSourceLang($this->sourceLang);
    }
}

