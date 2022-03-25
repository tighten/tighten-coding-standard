<?php

use Tighten\CodingStandard\Fixer\Phpdoc\NoInlineVarDocFixer;

return (new PhpCsFixer\Config())
    ->registerCustomFixers([new NoInlineVarDocFixer()])
    ->setRules(['Tighten/no_inline_var' => true])
    ->setUsingCache(false);
