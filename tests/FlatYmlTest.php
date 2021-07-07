<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class FlatYmlTest extends TestCase
{
    public function testFlatYml(): void
    {
        $flatyml1 = __DIR__ . "/fixtures/flatyml1.yml";
        $flatyml2 = __DIR__ . "/fixtures/flatyml2.yml";
        $result = __DIR__ . "/fixtures/flatjsonresult";

        $compareJsonFilesString = gendiff($flatyml1, $flatyml2);

        $this->assertStringEqualsFile($result, $compareJsonFilesString);
    }
}
