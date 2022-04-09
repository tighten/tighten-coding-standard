<?php

use PHP_CodeSniffer\Standards\PSR1\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ClassFileNameSniff;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;

return [
    Option::PATHS => [
        './app',
        './config',
        './database',
        './public',
        './resources',
        './routes',
        './tests',
    ],
    Option::SKIP => [
        '/*/cache/*',
        '*/*.blade.php',
        '*/autoload.php',
        '*/storage/*',
        '*/docs/*',
        '*/vendor/*',
        // Disable missing namespace rule for tests and database files
        ClassDeclarationSniff::class => ['*/database/*', '*/tests/*'],
        // Disable "Visibility must be declared on method" rule for test files
        VisibilityRequiredFixer::class => ['*/tests/*'],
        // Disable camel caps rule for tests
        CamelCapsMethodNameSniff::class => ['*/tests/*'],
        // Disable Class name should match the file name for migrations
        ClassFileNameSniff::class => ['*/migrations/*'],
        // Disable "Forbidden functions" rule for config files
        'The use of function env() is forbidden; use config() instead' => ['/config/*'],
    ],
];
