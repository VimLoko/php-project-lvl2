<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class NestedYmlTest extends TestCase
{
    public function testNestedYml(): void
    {
        $nestedYml1 = __DIR__ . "/fixtures/nestedyml1.yml";
        $nestedYml2 = __DIR__ . "/fixtures/nestedyml2.yml";
        $result = __DIR__ . "/fixtures/nestedresult";

        $compareYmlFilesString = gendiff($nestedYml1, $nestedYml2);

        $this->assertStringEqualsFile($result, $compareYmlFilesString);
    }
}
