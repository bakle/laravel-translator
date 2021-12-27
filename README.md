<a href="https://packagist.org/packages/bakle/translator">
    <img src="https://poser.pugx.org/bakle/translator/d/total.svg" alt="Total Downloads">
</a>

<a href="https://github.com/bakle/laravel-translator/actions">
    <img alt="Tests Passing" src="https://github.com/bakle/laravel-translator/actions/workflows/laravel-translator-pipeline/badge.svg" />
</a>

<a href="https://codecov.io/gh/bakle/laravel-translator">
      <img src="https://codecov.io/gh/bakle/laravel-translator/branch/master/graph/badge.svg" />
    </a>

[![Known Vulnerabilities](https://snyk.io/test/github/bakle/laravel-translator/badge.svg)](https://snyk.io/test/github/bakle/laravel-translator)

[![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=bakle&show_icons=true&theme=tokyonight)](https://github.com/bakle/laravel-translator)

# Laravel Translator

This is a package to translate any lang file inside your lang folder.

## Installation

`composer require bakle/translator`

## Configuration

This translator works with Google Translator API. First you have to create you Google Translator API
Key. https://cloud.google.com/translate

Create and set the `TRANSLATOR_API_KEY` environment key in your .env.

## How to Use It

***Note:*** *By default, the translator will set the source lang from your app locale.*

### Translate all your files to French ###

`php artisan translate --target-lang=fr`

### Translate a specific file ####

`php artisan translate en/validation.php --target-lang=fr`
