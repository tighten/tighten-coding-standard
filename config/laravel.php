<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(__DIR__ . '/tighten.php');

    $defaultOptions = include __DIR__ . '/options.php';

    $ecsConfig->paths($defaultOptions['paths']);

    // Add additional skip options
    $ecsConfig->skip(array_merge(
        $defaultOptions['skip'],
        [
            // Laravel preferences: allow unused imports
            NoUnusedImportsFixer::class,
        ]
    ));

    // Laravel preferences: no spaces when concatenating
    $ecsConfig->rule(ConcatSpaceFixer::class);

    // Laravel preferences: no empty braces
    $ecsConfig->ruleWithConfiguration(NewWithBracesFixer::class, [
        'anonymous_class' => false,
        'named_class' => false,
    ]);
};
