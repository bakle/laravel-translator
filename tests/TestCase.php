<?php

namespace Bakle\Translator\Test;

use Bakle\Translator\TranslatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [TranslatorServiceProvider::class];
    }
}
