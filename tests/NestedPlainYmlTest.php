<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class NestedPlainYmlTest extends TestCase
{
    public function testNestedPlainYml(): void
    {
        $nestedYml1 = __DIR__ . "/fixtures/nestedyml1.yml";
        $nestedYml2 = __DIR__ . "/fixtures/nestedyml2.yml";
        $result = __DIR__ . "/fixtures/plainresult";

        $compareJsonFilesString = gendiff($nestedYml1, $nestedYml2, 'plain');

        $this->assertStringEqualsFile($result, $compareJsonFilesString);
    }
}
