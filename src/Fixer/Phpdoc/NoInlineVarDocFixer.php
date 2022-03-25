<?php

namespace Tighten\CodingStandard\Fixer\Phpdoc;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Tokens;

final class NoInlineVarDocFixer extends AbstractFixer
{
    public function getName(): string
    {
        return 'Tighten/no_inline_var';
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'No inline `@var` PHPDoc.',
            [new CodeSample("public function test() {\n\t/**@var MyClass \$a */\n\t\$a = test();\n}")]
        );
    }

    /**
     * Must run before NoExtraBlankLinesFixer, NoTrailingWhitespaceFixer, NoWhitespaceInBlankLineFixer.
     */
    public function getPriority(): int
    {
        return 3;
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAnyTokenKindsFound([T_COMMENT, T_DOC_COMMENT]);
    }

    protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
    {
        foreach ($tokens as $index => $token) {
            if (! $token->isComment()) {
                continue;
            }

            if (Preg::match('#^/\*\*\h*@var\h+(\S+)\h*(\$\S+)?\h*([^\n]*)\*/$#', $token->getContent())) {
                try {
                    $prevFunction = $tokens->getPrevTokenOfKind($index, [[T_FUNCTION]]);
                    $functionStart = $tokens->getNextTokenOfKind($prevFunction, ['{']);
                    $functionEnd = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $functionStart);

                    if ($index >= $functionStart && $index <= $functionEnd) {
                        $tokens->clearRange($tokens->getPrevNonWhitespace($index)+1, $index);
                    }
                } catch (\Throwable $th) {
                }
            }
        }
    }
}
