<?php

namespace Bakle\Translator;

use Bakle\Translator\Constants\FileExtensions;

class Messages
{
    public static function forTranslatedFileExists(string $fileName, string $targetLang): string
    {
        $fileName = $targetLang . DIRECTORY_SEPARATOR . $fileName;

        if (FileExtensions::isJson($fileName)) {
            $fileName = $targetLang . FileExtensions::JSON;
        }

        return 'The file ' . $fileName . ' already exists. Do you want to overwrite it?';
    }

    public static function forTranslatingFile(string $fileName, string $sourceLang, string $targetLang): string
    {
        $sourceFile = $sourceLang . DIRECTORY_SEPARATOR . $fileName;
        $destinationFile = $targetLang . DIRECTORY_SEPARATOR . $fileName;

        if (FileExtensions::isJson($fileName)) {
            $sourceFile = $fileName;
            $destinationFile = $targetLang . FileExtensions::JSON;
        }

        return 'Translating ' . $sourceFile . ' to ' . $destinationFile;
    }

    public static function forTranslatedFile(string $fileName, string $sourceLang, string $targetLang): string
    {
        $sourceFile = $sourceLang . DIRECTORY_SEPARATOR . $fileName;
        $destinationFile = $targetLang . DIRECTORY_SEPARATOR . $fileName;

        if (FileExtensions::isJson($fileName)) {
            $sourceFile = $fileName;
            $destinationFile = $targetLang . FileExtensions::JSON;
        }

        return "\nTranslated " . $sourceFile . ' to ' . $destinationFile;
    }
}
