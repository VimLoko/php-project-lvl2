<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class NestedJsonTest extends TestCase
{
    public function testNestedJson(): void
    {
        $nestedJson1 = __DIR__ . "/fixtures/nestedjson1.json";
        $nestedJson2 = __DIR__ . "/fixtures/nestedjson2.json";
        $result = __DIR__ . "/fixtures/nestedresult";

        $compareJsonFilesString = gendiff($nestedJson1, $nestedJson2);

        $this->assertStringEqualsFile($result, $compareJsonFilesString);
    }
}
