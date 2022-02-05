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

This list can be generated using:

```bash
./vendor/bin/phpcs --standard=Tighten -e
```

Documentation for a specific sniff can be generated using:

```bash
./vendor/bin/phpcs --generator=text --sniffs=Generic.Arrays.DisallowLongArraySyntax
```

#### Generic (17 sniffs)

- Generic.Arrays.DisallowLongArraySyntax
- Generic.ControlStructures.InlineControlStructure
- Generic.Files.ByteOrderMark
- Generic.Files.LineEndings
- Generic.Files.LineLength
- Generic.Formatting.DisallowMultipleStatements
- Generic.Formatting.SpaceAfterNot
- Generic.Functions.FunctionCallArgumentSpacing
- Generic.NamingConventions.UpperCaseConstantName
- Generic.PHP.DisallowAlternativePHPTags
- Generic.PHP.DisallowShortOpenTag
- Generic.PHP.LowerCaseConstant
- Generic.PHP.LowerCaseKeyword
- Generic.PHP.LowerCaseType
- Generic.WhiteSpace.DisallowTabIndent
- Generic.WhiteSpace.IncrementDecrementSpacing
- Generic.WhiteSpace.ScopeIndent

#### PEAR (1 sniff)

- PEAR.Functions.ValidDefaultValue

#### PSR1 (3 sniffs)

- PSR1.Classes.ClassDeclaration
- PSR1.Files.SideEffects
- PSR1.Methods.CamelCapsMethodName

#### PSR12 (16 sniffs)

- PSR12.Classes.AnonClassDeclaration
- PSR12.Classes.ClassInstantiation
- PSR12.Classes.ClosingBrace
- PSR12.ControlStructures.BooleanOperatorPlacement
- PSR12.ControlStructures.ControlStructureSpacing
- PSR12.Files.DeclareStatement
- PSR12.Files.FileHeader
- PSR12.Files.ImportStatement
- PSR12.Files.OpenTag
- PSR12.Functions.NullableTypeDeclaration
- PSR12.Functions.ReturnTypeDeclaration
- PSR12.Keywords.ShortFormTypeKeywords
- PSR12.Namespaces.CompoundNamespaceDepth
- PSR12.Operators.OperatorSpacing
- PSR12.Properties.ConstantVisibility
- PSR12.Traits.UseDeclaration

#### PSR2 (9 sniffs)

- PSR2.Classes.ClassDeclaration
- PSR2.Classes.PropertyDeclaration
- PSR2.ControlStructures.ElseIfDeclaration
- PSR2.ControlStructures.SwitchDeclaration
- PSR2.Files.ClosingTag
- PSR2.Files.EndFileNewline
- PSR2.Methods.FunctionCallSignature
- PSR2.Methods.FunctionClosingBrace
- PSR2.Methods.MethodDeclaration

#### Squiz (18 sniffs)

- Squiz.Classes.ClassFileName
- Squiz.Classes.ValidClassName
- Squiz.ControlStructures.ControlSignature
- Squiz.ControlStructures.ForEachLoopDeclaration
- Squiz.ControlStructures.ForLoopDeclaration
- Squiz.ControlStructures.LowercaseDeclaration
- Squiz.Functions.FunctionDeclaration
- Squiz.Functions.FunctionDeclarationArgumentSpacing
- Squiz.Functions.LowercaseFunctionKeywords
- Squiz.Functions.MultiLineFunctionDeclaration
- Squiz.Scope.MethodScope
- Squiz.Strings.ConcatenationSpacing
- Squiz.Strings.DoubleQuoteUsage
- Squiz.WhiteSpace.CastSpacing
- Squiz.WhiteSpace.ControlStructureSpacing
- Squiz.WhiteSpace.ScopeClosingBrace
- Squiz.WhiteSpace.ScopeKeywordSpacing
- Squiz.WhiteSpace.SuperfluousWhitespace

## Easy Coding Standard

### Installation

Create a file named `ecs.php` in the root directory of your project.

```php
<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/vendor/tightenco/tighten-coding-standard/config/tighten.php');
};
```

After importing the Tighten standard you can customize the rules to suit your project's needs.  As an example, you can change the paths to `/src` using the following:

```php
$parameters = $containerConfigurator->parameters();
$parameters->set(Option::PATHS, [__DIR__ . '/src']);
```

### Running Easy Coding Standard

```bash
# Check
vendor/bin/ecs check

# Fix
vendor/bin/ecs check --fix
```

Optionally you can add aliases to your `composer.json` file under the `scripts` section.

```json
    "scripts": {
        "check": [
            "vendor/bin/ecs check",
        ],
        "fix": [
            "vendor/bin/ecs check --fix"
        ],
    }
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
