<?php

namespace Bakle\Translator;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class TranslatableFile
{

    private $regExpr = "/(:\b.+?)\b|(&\b.+?)\b|(\<.+?\>)/i";

    private $lockerSymbols = "**";

    private $matches = [];

    private $clientTranslator;

    public function __construct(&$clientTranslator)
    {
        $this->clientTranslator = $clientTranslator;
    }

    /**
     * Get all lang files
     *
     * @return array
     */
    public static function getTranslatableFiles($file): array
    {
        if ($file) {
            return [new SplFileInfo((resource_path('lang/') . $file), resource_path('lang'), '')];            
        }

        return File::allFiles(resource_path('lang'));       
        
    }

    /**
     * Get all lang files
     *
     * @return array
     */
    public static function translatedFileExists($file)
    {
        if ($file) {
            return File::exists((resource_path('lang/') . $file));
        }

        return false;
        
    }

    /**
     * Replace special words with $lockerSymbols
     *
     * @param string $text
     * @return string
     */
    public function lockSpecialWords(&$text): string
    {
        preg_match_all($this->regExpr, $text, $this->matches);        
        return ((preg_replace($this->regExpr, $this->lockerSymbols, $text)));
    }

    /**
     * Replace $lockerSybmols with original special words
     *
     * @return string
     */
    public function unlockSpecialWords(): string
    {
        return vsprintf(str_replace($this->lockerSymbols, '%s', $this->clientTranslator->getTranslatedText()), Arr::first($this->matches));
    }

    /**
     * Create translated file
     *
     * @return string
     */
    public function createFile($fileToTranslate, $file, $targetLang): void
    {
        $dataToFile = "<?php\n\n\treturn " . $this->formatData($fileToTranslate, "\t") . ";";
        $newFolderPath = resource_path('lang/') . $targetLang . '/' . $file->getFilename();
        $newFolderPath = resource_path('lang/') . $targetLang;
        if (!File::exists($newFolderPath)) {
            File::makeDirectory($newFolderPath);
        }
    
        File::put($newFolderPath . '/' . $file->getFilename(), $dataToFile);
    }

    private function formatData($data, $indentation="") {
        switch (gettype($data)) {
            case "string":
                return '"' . addcslashes($data, "\\\$\"\r\n\t\v\f") . '"';
            case "array":
                $indexed = array_keys($data) === range(0, count($data) - 1);
                $r = [];
                foreach ($data as $key => $value) {
                    $r[] = "$indentation    "
                         . ($indexed ? "" : $this->formatData($key) . " => ")
                         . $this->formatData($value, "$indentation    ");
                }
                return "[\n" . implode(",\n", $r) . "\n" . $indentation . "]";
            case "boolean":
                return $data ? "TRUE" : "FALSE";
            default:
                return var_export($data, TRUE);
        }
    }
}
