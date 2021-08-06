<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class FlatPlainJsonTest extends TestCase
{
    public function testFlatPlainJson(): void
    {
        $flatjson1 = __DIR__ . "/fixtures/flatjson1.json";
        $flatjson2 = __DIR__ . "/fixtures/flatjson2.json";
        $result = __DIR__ . "/fixtures/plainflatresult";

        $compareJsonFilesString = gendiff($flatjson1, $flatjson2, 'plain');

        $this->assertStringEqualsFile($result, $compareJsonFilesString);
    }
}
