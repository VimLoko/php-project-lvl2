<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\gendiff;

class FlatJsonTest extends TestCase
{
    public function testFlatJson()
    {
        $flatjson1 = __DIR__ . "/../fixtures/flatjson1.json";
        $flatjson2 = __DIR__ . "/../fixtures/flatjson2.json";
        $result = file_get_contents(__DIR__ . "/../fixtures/flatjsonresult");

        $compareJsonFilesString = gendiff($flatjson1, $flatjson2);
        print_r($compareJsonFilesString);
        $this->assertEquals($compareJsonFilesString, $result);
//        $this->assertStringEqualsFile($compareJsonFilesString, __DIR__ . "/../fixtures/flatjsonresult");
    }
}
