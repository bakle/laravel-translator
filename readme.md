<a href="https://packagist.org/packages/bakle/translator"><img src="https://poser.pugx.org/bakle/translator/d/total.svg" alt="Total Downloads"></a>

# Laravel Translator
This is a package to translate any lang file inside your lang folder.

***Note:*** *This version works with .php and .json files only*.

## Installation

`composer require bakle/translator`

## Configuration

This translator works with Google Translator API. First you have to create you Google Translator API Key. https://cloud.google.com/translate

Create and set the `TRANSLATOR_API_KEY` environment key in your .env.


## How to Use It

***Note:*** *By default, the translator will set the source lang from your app locale.*

### Translate all your files to French ###

`php artisan translate --target-lang=fr`

### Translate all your files to multiple languages ###

`php artisan translate --target-lang=fr --target-lang=es --target-lang=pt`


### Translate a specific file ####

`php artisan translate en/validation.php --target-lang=fr`
