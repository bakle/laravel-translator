<?php

namespace Bakle\Translator\Commands;

use Bakle\Translator\TranslatableFile;
use Bakle\Translator\Translator;
use Bakle\Translator\Validators\Validator;
use Illuminate\Console\Command;

class TranslateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate {file? : Optional file to translate. If not set, it will take all files inside lang folder}
                             {--source-lang= : Original language of the file(s) to be translated} 
                             {--target-lang=* : Array of language to translate, i.e: es, fr.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate lang files [.php, .json] to multiple languages.';

    public function handle(): int
    {
        Validator::validateCredentials();

        $file = $this->argument('file');
        $sourceLang = $this->option('source-lang') ?? app()->getLocale();
        $targetLang = $this->option('target-lang');

        Validator::validateTargetLanguages($targetLang);

        Validator::validateFile($file, $sourceLang);

        $this->comment('Starting translating process...');

        $translatableFiles = TranslatableFile::getTranslatableFiles($sourceLang, $file);

        if (count($translatableFiles) > 0) {

            foreach ($targetLang as $lang) {

                $this->line("------ Translating files to '" . $lang . "' ------");
                foreach ($translatableFiles as $file) {

                    // just allow some extensions
                    if (!in_array($file->getExtension(), ['php', 'json'])) continue;

                    $translatedFileExists = TranslatableFile::translatedFileExists($lang . DIRECTORY_SEPARATOR . $file->getFileName());

                    if ($translatedFileExists) {
                        if (!$this->confirm('The file ' . $lang . '/' . $file->getFileName() . ' already exists. Do you want to overwrite it?')) {
                            continue;
                        }
                    }

                    $this->comment('Translating ' . $sourceLang . '/' . $file->getFileName() . ' to ' . $lang . '/' . $file->getFileName());

                    $translator = new Translator($file, $sourceLang, $lang);
                    $translator->begin($this->output);
                    $this->info('');
                    $this->info('Translated ' . $sourceLang . '/' . $file->getFileName() . ' to ' . $lang . '/' . $file->getFileName());

                }

                $this->line("------ Finished Translating files to '" . $lang . "' ------");
            }

            $this->info('Translations completed!');
        }else{
            $this->info('Not found files to translate');
        }


        return self::SUCCESS;
    }
}
