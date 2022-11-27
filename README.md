
# Laravel Slug Generator 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dudic/laravel-slug-generator.svg?style=flat-square)](https://packagist.org/packages/dudic/laravel-slug-generator)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Tests](https://github.com/LazarDudic/laravel-slug-generator/actions/workflows/test.yml/badge.svg)](https://github.com/LazarDudic/laravel-slug-generator/actions/workflows/test.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/dudic/laravel-slug-generator.svg?style=flat-square)](https://packagist.org/packages/dudic/laravel-slug-generator)



This package was created to generate slug on my personal projects, it is straightforward to use, you just need to install it, add trait to the model, and set the $slugConfiguration property in your model.

> **NOTE:** Tested for 9.* and 8.* version of Laravel. 

## Installation

You can install the package via composer:

```bash
composer require dudic/laravel-slug-generator
```

## Usage

```php
use Dudic\Sluggable\SlugGenerator;

class User extends Authenticatable
{
    use SlugGenerator; // add

    protected $slugConfiguration = [
        'create_from' => ['first_name', 'last_name'], // ['required', 'array']
        'slug_field' => 'slug', // ['required', 'string']
        'unique' => true, // ['optional', 'bool'] default true, if slug exist unique will add at end '-1' or any next number which will make unique slug
        'on_create' => true, // ['optional', 'bool'] default true
        'on_update' => true, // ['optional', 'bool'] default true
        'separator' => '-', // ['optional', 'string'] default "-"
        'max_length' => 250, // ['optional', 'int', 'min:1'] default 250, if not unique can exice exceed 250 
    ];
}

$user = User::create([
    'first_name' => 'John',
    'last_name' => 'Doe'
]);
echo $user->slug; // john-doe
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
