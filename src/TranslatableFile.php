<?php

namespace Bakle\Translator;

use Bakle\Translator\Contracts\ClientTranslator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class TranslatableFile
{
    private string $regExpr = "/(:\b.+?)\b|(&\b.+?)\b|(\<.+?\>)/i";

    private string $lockerSymbols = '**';

    private array $matches = [];

    private ClientTranslator $clientTranslator;

    public function __construct($clientTranslator)
    {
        $this->clientTranslator = $clientTranslator;
    }

    public static function getTranslatableFiles($lang, $file = null): array
    {
        $relativePath = resource_path("lang/{$lang}/");

        if ($file) {
            return [new SplFileInfo($relativePath . $file, $relativePath, '')];
        }

        return File::allFiles($relativePath);
    }

    public static function translatedFileExists($file): bool
    {
        if ($file) {
            return File::exists((resource_path('lang/') . $file));
        }

        return false;
    }

    public function lockSpecialWords(&$text): string
    {
        preg_match_all($this->regExpr, $text, $this->matches);

        return preg_replace($this->regExpr, $this->lockerSymbols, $text);
    }

    /**
     * Replace $lockerSybmols with original special words.
     *
     * @return string
     */
    public function unlockSpecialWords(): string
    {
        return vsprintf(str_replace($this->lockerSymbols, '%s', $this->clientTranslator->getTranslatedText()), Arr::first($this->matches));
    }

    /**
     * Create translated file.
     *
     * @return void
     */
    public function createFile($fileToTranslate, SplFileInfo $file, $targetLang): void
    {
        if($file->getExtension()==='json')
        {
            $dataToFile = json_encode($fileToTranslate);
        }else{
            $dataToFile = "<?php\n\n\treturn " . $this->formatData($fileToTranslate, "\t") . ";";
        }

        $newFolderPath = resource_path('lang/') . $targetLang;

        if (!File::exists($newFolderPath)) {
            File::makeDirectory($newFolderPath);
        }

        File::put($newFolderPath . '/' . $file->getFilename(), $dataToFile);
    }

    private function formatData($data, $indentation = ''): string
    {
        switch (gettype($data)) {
            case 'string':
                return '"' . addcslashes($data, "\\\$\"\r\n\t\v\f") . '"';
            case 'array':
                $indexed = array_keys($data) === range(0, count($data) - 1);
                $r = [];

                foreach ($data as $key => $value) {
                    $r[] = "{$indentation}    "
                        . ($indexed ? '' : $this->formatData($key) . ' => ')
                        . $this->formatData($value, "{$indentation}    ");
                }

                return "[\n" . implode(",\n", $r) . "\n" . $indentation . ']';
            case 'boolean':
                return $data ? 'TRUE' : 'FALSE';
            default:
                return var_export($data, true);
        }
    }
}
