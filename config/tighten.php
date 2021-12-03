<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;

use PHP_CodeSniffer\Standards\PSR1\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Files\SideEffectsSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ClassFileNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    ////////////////////////////////////////////////////////////////////////////////
    // PSR-1
    ////////////////////////////////////////////////////////////////////////////////

    // 2.1. PHP Tags
    $services->set(FullOpeningTagFixer::class);

    // 2.2. Character Encoding
    $services->set(EncodingFixer::class);

    // 2.3. Side Effects
    $services->set(SideEffectsSniff::class);

    // 3. Namespace and Class Names
    $services->set(ValidClassNameSniff::class);
    $services->set(ClassDeclarationSniff::class);

    // 4.1. Constants
    $services->set(UpperCaseConstantNameSniff::class);

    // 4.3. Methods
    $services->set(CamelCapsMethodNameSniff::class);

    ////////////////////////////////////////////////////////////////////////////////
    // PSR-12
    ////////////////////////////////////////////////////////////////////////////////

    $containerConfigurator->import(SetList::PSR_12);

    ////////////////////////////////////////////////////////////////////////////////
    // Config
    ////////////////////////////////////////////////////////////////////////////////

    $parameters = $containerConfigurator->parameters();

    $parameters->set(
        Option::PATHS,
        [
            './app',
            './config',
            './database',
            './public',
            './resources',
            './routes',
            './tests',
        ]
    );

    // Ignore normal Laravel files and folders
    $parameters->set(
        Option::SKIP,
        [
            '/*/cache/*',
            '*/*.blade.php',
            '*/autoload.php',
            '*/storage/*',
            '*/docs/*',
            '*/vendor/*',
            '*/migrations/*',
        ]
    );

    ////////////////////////////////////////////////////////////////////////////////
    // Tighten preferences
    ////////////////////////////////////////////////////////////////////////////////

    $parameters->set(
        Option::SKIP,
        [
            // Disable missing namespace rule for tests and database files
            ClassDeclarationSniff::class => ['*/database/*', '*/tests/*'],
            // Disable "Visibility must be declared on method" rule for test files
            VisibilityRequiredFixer::class => ['*/tests/*'],
            // Disable camel caps rule for tests
            CamelCapsMethodNameSniff::class => ['*/tests/*'],
            // Disable Class name should match the file name for migrations
            ClassFileNameSniff::class => ['*/migrations/*'],
        ]
    );

    // Force [] short array syntax
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [['syntax' => 'short']]);

    // Convert double quotes to single quotes for simple strings
    $services->set(SingleQuoteFixer::class);

    // Class name should match the file name
    $services->set(ClassFileNameSniff::class);

    // Expect one space after NOT (!) operator
    $services->set(NotOperatorWithSuccessorSpaceFixer::class);
};
