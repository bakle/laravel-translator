<?php

namespace Bakle\Translator;

use Illuminate\Support\ServiceProvider;
use Bakle\Translator\Commands\TranslateCommand;

class TranslatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/bakleTranslator.php';

        $this->publishes([
            $configPath => config_path('bakleTranslator.php')
        ]);
        
        $this->mergeConfigFrom($configPath, 'bakleTranslator');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TranslateCommand::class,                
            ]);
        }
    }
}
