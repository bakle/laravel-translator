<?php

namespace Bakle\Translator\Test\Unit;

use Bakle\Translator\Messages;
use Bakle\Translator\Test\TestCase;

class MessageTest extends TestCase
{
    /**
     * @test
     */
    public function forTranslatedJsonFileExists()
    {
        $message = Messages::forTranslatedFileExists('en.json', 'en');
        $this->assertEquals('The file en.json already exists. Do you want to overwrite it?', $message);
    }

    /**
     * @test
     */
    public function forTranslatedPhpFileExists()
    {
        $message = Messages::forTranslatedFileExists('test.php', 'en');
        $this->assertEquals('The file en/test.php already exists. Do you want to overwrite it?', $message);
    }

    /**
     * @test
     */
    public function forTranslatingJsonFile()
    {
        $message = Messages::forTranslatingFile('en.json', 'en', 'es');
        $this->assertEquals('Translating en.json to es.json', $message);
    }

    /**
     * @test
     */
    public function forTranslatingPhpFile()
    {
        $message = Messages::forTranslatingFile('test.php', 'en', 'es');
        $this->assertEquals('Translating en/test.php to es/test.php', $message);
    }

    /**
     * @test
     */
    public function forTranslatedJsonFile()
    {
        $message = Messages::forTranslatedFile('en.json', 'en', 'es');
        $this->assertEquals("\nTranslated en.json to es.json", $message);
    }

    /**
     * @test
     */
    public function forTranslatedPhpFile()
    {
        $message = Messages::forTranslatedFile('test.php', 'en', 'es');
        $this->assertEquals("\nTranslated en/test.php to es/test.php", $message);
    }
}
