# PHP Coding Standard

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tightenco/tighten-coding-standard.svg?style=flat-square)](https://packagist.org/packages/tightenco/tighten-coding-standard)
[![Run tests](https://github.com/tighten/tighten-coding-standard/workflows/Run%20tests/badge.svg?branch=main)](https://github.com/tighten/tighten-coding-standard/actions?query=workflow%3A%22Run+tests%22)


This repository contains Tighten Coding Standard configurations for both [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and [Easy Coding Standard](https://github.com/symplify/easy-coding-standard) which combines [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and [PHP Coding Standards Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) into one configuration.

## Installation

You can install the package via composer:

```bash
composer require tightenco/tighten-coding-standard
```

## PHP CodeSniffer

### Installation

Run `./vendor/bin/phpcs -i` to make sure you see "Tighten" in that list.

### Usage

Add the standard to your local `.phpcs.xml.dist`:

```xml
<?xml version="1.0"?>
<ruleset>
   <file>app</file>
   <file>config</file>
   <file>database</file>
   <file>public</file>
   <file>resources</file>
   <file>routes</file>
   <file>tests</file>

   <rule ref="Tighten"/>
</ruleset>
```

### Sniffs

A list of sniffs included in this standard can be generated using:

```bash
./vendor/bin/phpcs --standard=Tighten -e
```

Documentation for a specific sniff can be generated using:

```bash
./vendor/bin/phpcs --generator=text --sniffs=Generic.Arrays.DisallowLongArraySyntax
```

## Easy Coding Standard

 [Easy Coding Standard](https://github.com/symplify/easy-coding-standard) combines [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and [PHP Coding Standards Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) into one configuration.

### Installation

Create a file named `tcs.php` in the root directory of your project with the following:

```php
<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/vendor/tightenco/tighten-coding-standard/config/tighten.php');
};
```

Or you can choose the Laravel specific standard:

```php
<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/vendor/tightenco/tighten-coding-standard/config/laravel.php');
};
```

### Configuration

After importing the Tighten or Laravel standard you can customize the rules to suit your project's needs.

If you need to make changes to any options you can alter or override the defaults. First you include the defaults found in the `options.php` configuration file, modify as needed, then set `parameters` and `services`.

```php
<?php

use PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/vendor/tightenco/tighten-coding-standard/config/tighten.php');

    // Include the defaults
    $defaultOptions = include __DIR__ . '/vendor/tightenco/tighten-coding-standard/config/options.php';

    $services = $containerConfigurator->services();
    $parameters = $containerConfigurator->parameters();

    // Add an additional path
    $parameters->set(
        Option::PATHS,
        array_merge(
            $defaultOptions[Option::PATHS],
            [__DIR__ . '/src']
        )
    );

    // Add additional skip options
    $parameters->set(
        Option::SKIP,
        [
            // Disable converting double quotes to single quotes
            SingleQuoteFixer::class,
            // Disable camel caps rule in custom folder
            CamelCapsMethodNameSniff::class => ['*/custom/*'],
        ]
    );

    // Add additional fixer or sniff
    $services->set(OctalNotationFixer::class);
};
```

### Running Easy Coding Standard

```bash
# Check
vendor/bin/ecs check --config tcs.php

# Fix
vendor/bin/ecs check --fix --config tcs.php
```

Optionally you can add these aliases to your `composer.json` file under the `scripts` section.

```json
    "scripts": {
        ...
        "check": [
            "vendor/bin/ecs check --config tcs.php"
        ],
        "fix": [
            "vendor/bin/ecs check --fix --config tcs.php"
        ],
    }
```

```bash
# Check
composer check

# Fix
composer fix
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tighten.co instead of using the issue tracker.

## Credits

- [Sara Bine](https://github.com/sbine)
- [Matt Stauffer](https://github.com/mattstauffer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
