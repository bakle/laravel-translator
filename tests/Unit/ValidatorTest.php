<?php

namespace Bakle\Translator\Test\Unit;

use Bakle\Translator\Exceptions\BakleValidatorException;
use Bakle\Translator\Test\TestCase;
use Bakle\Translator\Validators\Validator;

class ValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function itThrowsExceptionIfThereAreNoCredentials()
    {
        $this->expectException(BakleValidatorException::class);
        $this->expectExceptionMessage('Invalid credentials! Please provide a valid credentials for your provider.');
        Validator::validateCredentials();
    }

    /**
     * @test
     */
    public function itThrowsExceptionIfTargetLangIsInvalid()
    {
        $this->expectException(BakleValidatorException::class);
        $this->expectExceptionMessage('The language "test" is invalid.');
        Validator::validateTargetLanguage('test');
    }

    /**
     * @test
     */
    public function itThrowsExceptionIfFileDoesNotExist()
    {
        $this->expectException(BakleValidatorException::class);
        $this->expectExceptionMessage('The file "test" doesn\'t exist.');
        Validator::validateFile('test', 'es');
    }

    /**
     * @test
     */
    public function checkIfJsonFileExists()
    {
        $response = Validator::fileExists('test.json', 'es');
        $this->assertFalse($response);

        $this->setBasePath();
        $response = Validator::fileExists('en.json', 'en');
        $this->assertTrue($response);
    }

    /**
     * @test
     */
    public function checkIfPhpFileExists()
    {
        $response = Validator::fileExists('test.php', 'es');
        $this->assertFalse($response);

        $this->setBasePath();
        $response = Validator::fileExists('test.php', 'en');
        $this->assertTrue($response);

        $response = Validator::fileExists('test.php', 'en', 'en');
        $this->assertTrue($response);
    }

    private function setBasePath()
    {
        $this->app->setBasePath(dirname(__DIR__) . '/Dummy');
    }
}
