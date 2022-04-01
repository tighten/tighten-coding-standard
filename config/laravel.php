<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/tighten.php');

    $defaultParameters = include __DIR__ . '/parameters.php';

    $services = $containerConfigurator->services();
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, $defaultParameters[Option::PATHS]);

    $parameters->set(
        Option::SKIP,
        array_merge(
            $defaultParameters[Option::SKIP],
            [
                // Laravel preferences: allow unused imports
                NoUnusedImportsFixer::class,
            ]
        )
    );

    // Laravel preferences: no spaces when concatenating
    $services->set(ConcatSpaceFixer::class);

    // Laravel preferences: no empty braces
    $services->set(NewWithBracesFixer::class)
        ->call(
            'configure',
            [
                [
                    'anonymous_class' => \false,
                    'named_class' => \false,
                ],
            ],
        );
};
