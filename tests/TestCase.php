<?php

namespace Tighten\CodingStandard\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    const TEMP_FOLDER = __DIR__ . '/temp';

    protected function setUp(): void
    {
        parent::setUp();

        if (!file_exists(self::TEMP_FOLDER)) {
            mkdir(self::TEMP_FOLDER);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        array_map('unlink', array_filter((array) glob(self::TEMP_FOLDER . '/*')));
        rmdir(self::TEMP_FOLDER);
    }
}
