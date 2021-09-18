<?php

namespace Bakle\Translator;

use Bakle\Translator\Commands\TranslateCommand;
use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/bakle-translator.php';

        $this->publishes([
            $configPath => config_path('bakle-translator.php'),
        ]);

        $this->mergeConfigFrom($configPath, 'bakle-translator');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TranslateCommand::class,
            ]);
        }
    }
}
