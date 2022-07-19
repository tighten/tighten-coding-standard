<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Files\SideEffectsSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ClassFileNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->parallel();

    ////////////////////////////////////////////////////////////////////////////////
    // PSR-1
    ////////////////////////////////////////////////////////////////////////////////

    // 2.1. PHP Tags
    $ecsConfig->rule(FullOpeningTagFixer::class);

    // 2.2. Character Encoding
    $ecsConfig->rule(EncodingFixer::class);

    // 2.3. Side Effects
    $ecsConfig->rule(SideEffectsSniff::class);

    // 3. Namespace and Class Names
    $ecsConfig->rule(ValidClassNameSniff::class);
    $ecsConfig->rule(ClassDeclarationSniff::class);

    // 4.1. Constants
    $ecsConfig->rule(UpperCaseConstantNameSniff::class);

    // 4.3. Methods
    $ecsConfig->rule(CamelCapsMethodNameSniff::class);

    ////////////////////////////////////////////////////////////////////////////////
    // PSR-12
    ////////////////////////////////////////////////////////////////////////////////

    $ecsConfig->sets([SetList::PSR_12]);

    ////////////////////////////////////////////////////////////////////////////////
    // Tighten preferences
    ////////////////////////////////////////////////////////////////////////////////

    $defaultOptions = include __DIR__ . '/options.php';

    $ecsConfig->paths($defaultOptions['paths']);
    $ecsConfig->skip($defaultOptions['skip']);

    // Force [] short array syntax
    $ecsConfig->rule(ArraySyntaxFixer::class, ['syntax' => 'short']);

    // Convert double quotes to single quotes for simple strings
    $ecsConfig->rule(SingleQuoteFixer::class);

    // Class name should match the file name
    $ecsConfig->rule(ClassFileNameSniff::class);

    // Expect one space after NOT (!) operator
    $ecsConfig->rule(NotOperatorWithSuccessorSpaceFixer::class);

    // Alphabetical imports
    $ecsConfig->rule(OrderedImportsFixer::class);

    // Order class elements
    $ecsConfig->ruleWithConfiguration(
        OrderedClassElementsFixer::class,
        [
            'order' => [
                'use_trait',
                'property_public_static',
                'property_protected_static',
                'property_private_static',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'method_public_static',
                'method_protected_static',
                'method_private_static',
                'method_public',
                'method_protected',
                'method_private',
                'magic',
            ],
        ]
    );

    // No compact() and no 'dumps'
    // Use config() over env()
    $ecsConfig->ruleWithConfiguration(
        ForbiddenFunctionsSniff::class,
        [
            'forbiddenFunctions' => [
                'compact' => null,
                'dd' => null,
                'dump' => null,
                'ray' => null,
                'var_dump' => null,
                'env' => 'config',
            ],
        ]
    );

    // No unused imports
    $ecsConfig->rule(NoUnusedImportsFixer::class);

    // Trailing comma in multiline arrays
    $ecsConfig->rule(TrailingCommaInMultilineFixer::class);

    // No string interpolation without braces
    $ecsConfig->rule(ExplicitStringVariableFixer::class);
    $ecsConfig->rule(SimpleToComplexStringVariableFixer::class);
};
