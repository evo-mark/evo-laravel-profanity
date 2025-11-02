<p align="center">
    <a href="https://evomark.co.uk" target="_blank" alt="Link to evoMark's website">
        <picture>
          <source media="(prefers-color-scheme: dark)" srcset="https://evomark.co.uk/wp-content/uploads/static/evomark-logo--dark.svg">
          <source media="(prefers-color-scheme: light)" srcset="https://evomark.co.uk/wp-content/uploads/static/evomark-logo--light.svg">
          <img alt="evoMark company logo" src="https://evomark.co.uk/wp-content/uploads/static/evomark-logo--light.svg" width="500">
        </picture>
    </a>
</p>
<p align="center">
    <a href="https://packagist.org/packages/evo-mark/evo-laravel-profanity"><img src="https://img.shields.io/packagist/v/evo-mark/evo-laravel-profanity?logo=packagist&logoColor=white" alt="Build status" /></a>
    <a href="https://packagist.org/packages/evo-mark/evo-laravel-profanity"><img src="https://img.shields.io/packagist/dt/evo-mark/evo-laravel-profanity" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/evo-mark/evo-laravel-profanity"><img src="https://img.shields.io/packagist/l/evo-mark/evo-laravel-profanity" alt="Licence"></a>
</p>

# Evo Laravel Profanity

This package provides a `profanity` validation rule that draws on the words made available in the Pest Profanity package.

## Installation

You can install the package via composer:

```bash
composer require evo-mark/evo-laravel-profanity
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="evo-laravel-profanity-config"
```

## Usage

The validator uses your current locale for determining which profanity words to check against. Alternatively, you can set this manually in your config file. See the [Pest repository](https://github.com/pestphp/pest-plugin-profanity/tree/HEAD/src/Config/profanities) for available locales.

To use the validator, simply include the `profanity` rule in your ruleset.

You can include/exclude additional words by publishing the config and adding them there, e.g.

```php
return [
    'includingWords' => [
        'en' => ['soccer']
    ],
    'excludingWords' => [
        'en' => []
    ]
];
```

On failure, the validator will return the message in your `lang/{locale}/validation` file under the `profanity` property.

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'email' => ['required', 'string', 'email'],
        'first_name' => ['required', 'string', 'profanity'],
    ]);
}
```

## Support Open-Source Software

We're providing this package free-of-charge. However, all development and maintenance costs time, energy and money. So please help fund this project if you can.

<p align="center" style="display:flex;align-items:center;gap:1rem;justify-content:center">
<a href="https://github.com/sponsors/craigrileyuk" target="_blank"><img src="https://img.shields.io/badge/sponsor-GitHub%20Sponsors-fafbfc?style=for-the-badge&logo=github" /></a>
<a href="https://www.buymeacoffee.com/craigrileyuk" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;" /></a>
</p>

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Licence

The MIT Licence (MIT). Please see [Licence File](LICENCE.md) for more information.
