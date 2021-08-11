<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class JsonTest extends TestCase
{
    public function testFlatJson(): void
    {
        $flatjson1 = __DIR__ . "/fixtures/flatjson1.json";
        $flatjson2 = __DIR__ . "/fixtures/flatjson2.json";
        $result = __DIR__ . "/fixtures/jsonresult";

        $compareJsonFilesString = gendiff($flatjson1, $flatjson2, 'json');

        $this->assertStringEqualsFile($result, $compareJsonFilesString);
    }
}
