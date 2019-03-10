<?php

namespace Bakle\Translator\Commands;

use Illuminate\Console\Command;
use Bakle\Translator\Translator;
use Bakle\Translator\TranslatableFile;

class TranslateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate {file? : Optional file to translate. If not set, it will take all files inside lang folder}
                             {--source-lang= : Original language of the file(s) to be translated} 
                             {--target-lang=* : Array of language to translate, i.e: "es", "fr". If not set, it will take all languages set inside app.locales}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate lang files to multiple languages.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $file = $this->argument('file');
        $sourceLang = $this->option('source-lang') ?? app()->getLocale();
        $targetLang = $this->option('target-lang');

        if (count($targetLang) == 0) {
            $this->error('No target language found. Please provide at least one.');
            return false;
        }

        if (!config('bakleTranslator.api_key')) {
            $this->error('No api key provided!');
            return false;
        }

        $this->comment('Starting translating process...');
        $translatableFiles = TranslatableFile::getTranslatableFiles($file);
        
        if (count($translatableFiles) > 0) {
            foreach ($targetLang as $lang) {                
                
                $this->line("------ Translating files to '" . $lang . "' ------");
                foreach ($translatableFiles as $file) {
                    $translatedFileExists = TranslatableFile::translatedFileExists($lang . '/' . $file->getFileName());
                    
                    if ($translatedFileExists) {
                        if (!$this->confirm('The file ' . $lang . '/' . $file->getFileName() . ' already exists. Do you want to overwrite it?')) {
                            continue;
                        }
                    }
                    
                    //try {
                        $this->comment('Translating ' . $sourceLang . '/' . $file->getFileName() . ' to ' . $lang . '/' . $file->getFileName());
                        $translator = new Translator($file, $sourceLang, $lang);
                        $translator->begin();
                        $this->info('Translated ' . $sourceLang . '/' . $file->getFileName() . ' to ' . $lang . '/' . $file->getFileName());
                    /*} catch (\Exception $e) {
                        $this->error($e->getMessage());
                        return false;
                    }*/
                }

                $this->line("------ Finished Translating files to '" . $lang . "' ------");
                $this->line('');
            }

            $this->info('Translations completed!');
        } else {
            $this->error('There are no files to translate.');
            return false;
        }
    }
}
