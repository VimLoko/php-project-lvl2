<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class NestedPlainJsonTest extends TestCase
{
    public function testNestedPlainJson(): void
    {
        $nestedJson1 = __DIR__ . "/fixtures/nestedjson1.json";
        $nestedJson2 = __DIR__ . "/fixtures/nestedjson2.json";
        $result = __DIR__ . "/fixtures/plainresult";

        $compareJsonFilesString = gendiff($nestedJson1, $nestedJson2, 'plain');

        $this->assertStringEqualsFile($result, $compareJsonFilesString);
    }
}
