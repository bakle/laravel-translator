<?php

namespace Bakle\Translator\Validators;

use Bakle\Translator\Constants\FileExtensions;
use Bakle\Translator\Constants\Languages;
use Bakle\Translator\Exceptions\BakleValidatorException;
use Illuminate\Support\Facades\File;

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
    public static function validateTargetLanguage(string $targetLang): void
    {
        if (!in_array($targetLang, Languages::getConstantsValues())) {
            throw BakleValidatorException::forInvalidTargetLanguage($targetLang);
        }
    }

    /**
     * @throws BakleValidatorException
     */
    public static function validateFile(?string $file, string $sourceLang): void
    {
        if ($file && !self::fileExists($file, $sourceLang)) {
            throw BakleValidatorException::forInvalidFile($file);
        }
    }

    public static function fileExists(string $file, string $lang, string $targetLang = null): bool
    {
        if (FileExtensions::isJson($file)) {
            return File::exists(
                resource_path('lang/') . ($targetLang
                    ? $targetLang . FileExtensions::JSON : $file)
            );
        }

        $path = $targetLang ? resource_path("lang/{$targetLang}") : resource_path("lang/{$lang}");

        return File::exists($path . DIRECTORY_SEPARATOR . $file);
    }
}
