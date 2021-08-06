<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class FlatPlainYmlTest extends TestCase
{
    public function testFlatPlainYml(): void
    {
        $flatYml1 = __DIR__ . "/fixtures/flatyml1.yml";
        $flatYml2 = __DIR__ . "/fixtures/flatyml2.yml";
        $result = __DIR__ . "/fixtures/plainflatresult";

        $compareYmlFilesString = gendiff($flatYml1, $flatYml2, 'plain');

        $this->assertStringEqualsFile($result, $compareYmlFilesString);
    }
}
