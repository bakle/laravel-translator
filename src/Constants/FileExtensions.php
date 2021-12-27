<?php

namespace Bakle\Translator\Constants;

class FileExtensions
{
    public const PHP = '.php';
    public const JSON = '.json';

    public static function getAvailableFileExtensions(): array
    {
        return [
            self::removeDotFromExtension(self::PHP),
            self::removeDotFromExtension(self::JSON),
        ];
    }

    public static function isAvailableExtension(string $extension): bool
    {
        return in_array($extension, self::getAvailableFileExtensions());
    }

    public static function isJson(string $extensionOrFile): bool
    {
        return $extensionOrFile === self::removeDotFromExtension(self::JSON) || str_ends_with($extensionOrFile, self::JSON);
    }

    private static function removeDotFromExtension(string $extension): string
    {
        return str_replace('.', '', $extension);
    }
}
