<?php

namespace Bakle\Translator\Exceptions;

class BakleValidatorException extends \Exception
{
    public static function forInvalidCredentials(): self
    {
        return new self('Invalid credentials! Please provide a valid credentials for your provider.');
    }

    public static function forInvalidTargetLanguage(string $invalidLanguage): self
    {
        return new self(sprintf('The language "%s" is invalid.', $invalidLanguage));
    }

    public static function forEmptyTargetLanguage(): self
    {
        return new self('No target language found. Please provide a valid one.');
    }

    public static function forInvalidFile(string $invalidFile): self
    {
        return new self(sprintf('The file "%s" doesn\'t exist.', $invalidFile));
    }
}
