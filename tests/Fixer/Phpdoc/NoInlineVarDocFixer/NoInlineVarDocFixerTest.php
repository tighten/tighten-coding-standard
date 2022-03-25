<?php

namespace Tighten\CodingStandard\Tests\Fixer\Php;

use Tighten\CodingStandard\Tests\TestCase;

class NoInlineVarDocFixerTest extends TestCase
{
    /**
     * @dataProvider provideFixCases
     */
    public function test_fix($input, $expected): void
    {
        $config = __DIR__ . '/.php-cs-fixer.php';
        $file = self::TEMP_FOLDER . '/' . md5($input) . '.php';
        file_put_contents($file, $input);

        exec("php ./vendor/bin/php-cs-fixer fix {$file} --config={$config}", $output);

        $this->assertSame($expected, file_get_contents($file));
    }

    public function provideFixCases(): array
    {
        return [
            [
<<<'EOT'
<?php

/**
 * Undocumented class
 */
class NoInlineVarDocFixer
{
    /** @var MyClass $notInline */
    public function test1()
    {
        /** @var MyClass $inline */
        $a = test();
    }

    // Keep this comment
    public function test2()
    {
        $a = test(); /** @var MyClass $inline */
    }
}

EOT,
<<<'EOT'
<?php

/**
 * Undocumented class
 */
class NoInlineVarDocFixer
{
    /** @var MyClass $notInline */
    public function test1()
    {
        $a = test();
    }

    // Keep this comment
    public function test2()
    {
        $a = test();
    }
}

EOT,
            ],
            [
<<<'EOT'
<?php

/** @var MyClass $notInline */
function test()
{
    /** @var MyClass $inline */
    $a = test();
}

EOT,
<<<'EOT'
<?php

/** @var MyClass $notInline */
function test()
{
    $a = test();
}

EOT,
            ],
        ];
    }
}
