<?php

namespace Bakle\Translator\Commands;

use Bakle\Translator\Constants\FileExtensions;
use Bakle\Translator\Exceptions\BakleValidatorException;
use Bakle\Translator\Messages;
use Bakle\Translator\TranslatableFile;
use Bakle\Translator\Translator;
use Bakle\Translator\Validators\Validator;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TranslateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate {file? : Optional file to translate. If not set, it will take all files inside lang folder}
                             {--source-lang= : Original language of the file(s) to be translated} 
                             {--target-lang= : Language to translate, i.e: es, fr.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate lang files [.php, .json] to multiple languages.';

    private string $sourceLang;
    private string $targetLang;
    private ?string $fileToTranslate;

    public function handle(): int
    {
        try {
            $this->handleInputs();
            Validator::validateCredentials();
            Validator::validateTargetLanguage($this->targetLang);
            Validator::validateFile($this->fileToTranslate, $this->sourceLang);
        } catch (Exception $exception) {
            Log::error('Bakle-Translator', [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $translator = new Translator($this->sourceLang, $this->targetLang);

        $filesToTranslate = TranslatableFile::getTranslatableFiles($this->sourceLang, $this->fileToTranslate);

        if (!$filesToTranslate) {
            $this->error('Not found files to translate');

            return self::FAILURE;
        }

        $this->line("------ Translating files to '" . $this->targetLang . "' ------");

        foreach ($filesToTranslate as $file) {
            if (!FileExtensions::isAvailableExtension($file->getExtension())) {
                continue;
            }

            $translatedFileExists = Validator::fileExists($file->getFileName(), $this->sourceLang, $this->targetLang);

            if ($translatedFileExists) {
                if (!$this->confirm(Messages::forTranslatedFileExists($file->getFileName(), $this->targetLang))) {
                    continue;
                }
            }

            $this->comment(Messages::forTranslatingFile($file->getFileName(), $this->sourceLang, $this->targetLang));

            $translator->setFile($file);

            $translator->begin($this->output);

            $this->info(Messages::forTranslatedFile($file->getFileName(), $this->sourceLang, $this->targetLang));
        }

        $this->info('Translations completed!');

        return self::SUCCESS;
    }

    private function handleInputs(): void
    {
        $this->sourceLang = $this->option('source-lang') ?? app()->getLocale();

        if (!$this->option('target-lang')) {
            throw BakleValidatorException::forEmptyTargetLanguage();
        }
        $this->targetLang = $this->option('target-lang');
        $this->fileToTranslate = $this->argument('file');
    }
}
