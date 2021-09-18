<?php

namespace Bakle\Translator\Validators;

use Bakle\Translator\Constants\Languages;
use Bakle\Translator\Exceptions\BakleValidatorException;
use Bakle\Translator\TranslatableFile;

class Validator
{
    /**
     * @throws BakleValidatorException
     */
    public static function validateCredentials(): void
    {
        if (!config('bakle-translator.api_key')) {
            throw BakleValidatorException::forInvalidCredentials();
        }
    }

    /**
     * @throws BakleValidatorException
     */
    public static function validateTargetLanguages(array $targetLang): void
    {
        if (count($targetLang) === 0) {
            throw BakleValidatorException::forEmptyTargetLanguage();
        }

        $availableLanguages = Languages::getConstantsValues();

        foreach ($targetLang as $language) {
            if (!in_array($language, $availableLanguages)) {
                throw BakleValidatorException::forInvalidTargetLanguage($language);
            }
        }
    }

    /**
     * @throws BakleValidatorException
     */
    public static function validateFile(?string $file, string $sourceLang): void
    {
        if ($file && !TranslatableFile::translatedFileExists($sourceLang . DIRECTORY_SEPARATOR . $file)) {
            throw BakleValidatorException::forInvalidFile($file);
        }
    }
}
