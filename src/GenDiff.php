<?php

namespace Differ\Differ;

use SplFileInfo;

use function Differ\Parsers\parser;
use function Differ\Formatter\format;

function readFile(string $path): string
{
    if (!file_exists($path)) {
        throw new \Exception("Can't find file in {$path}");
    }
    $fileContent = file_get_contents($path, true);
    if (is_bool($fileContent)) {
        return '';
    }
    return $fileContent;
}

function getExt(string $filePath): string
{
    return (new SplFileInfo($filePath))->getExtension();
}

/**
 * @param string|integer|boolean|object $value
 * @return object|string
 */
function toString($value)
{
    if (is_object($value)) {
        return $value;
    }
    return trim(var_export($value, true), "'");
}

/**
 * @param array<array> $arrays
 * @return array<string>
 */
function mergeArraysKeys(array ...$arrays): array
{
    $result = array_map(function ($array): array {
        return array_keys($array);
    }, $arrays);
    return array_values(
        array_unique(
            array_merge(...$result)
        )
    );
}

/**
 * @param array<array<string, mixed>> $array
 * @return string
 */
function formating(array $array): string
{
    $mergeKeyValue = array_map(
        function ($key, $value) {
            $keyStr = toString($key);
            $valueStr = toString($value);
            return "  {$keyStr}: {$valueStr}";
        },
        array_keys($array),
        $array
    );
    $implodeAr = implode("\n", $mergeKeyValue);
    return "{\n{$implodeAr}\n}\n";
}

/**
 * @return array<array<string, mixed>>
 */
function genDiffAST(object $firstFile, object $secondFile): array
{
    $firstFileAr = get_object_vars($firstFile);
    $secondFileAr = get_object_vars($secondFile);
    $keys = mergeArraysKeys($firstFileAr, $secondFileAr);
    sort($keys);
    return array_map(function ($key) use ($firstFileAr, $secondFileAr) {
        if (!array_key_exists($key, $secondFileAr)) {
            return [
                "key" => $key,
                "type" => "deleted",
                "value" => $firstFileAr[$key]
            ];
        }
        if (!array_key_exists($key, $firstFileAr)) {
            return [
                "key" => $key,
                "type" => "added",
                "value" => $secondFileAr[$key]
            ];
        }
        if (is_object($secondFileAr[$key]) && is_object($firstFileAr[$key])) {
            return [
                "key" => $key,
                "type" => "nested",
                "children" => genDiffAST($firstFileAr[$key], $secondFileAr[$key])
            ];
        }
        if ($secondFileAr[$key] !== $firstFileAr[$key]) {
            return [
                "key" => $key,
                "type" => "changed",
                "value" => $secondFileAr[$key],
                "oldValue" => $firstFileAr[$key]
            ];
        }

        return [
            "key" => $key,
            "type" => 'unchanged',
            "value" => $secondFileAr[$key]
        ];
    }, $keys);
}

function gendiff(string $firstFile, string $secondFile, string $format = 'stylish'): string
{
    $firstFileContent = parser(readFile($firstFile), getExt($firstFile));
    $secondFileContent = parser(readFile($secondFile), getExt($secondFile));
    $diffAST = genDiffAST($firstFileContent, $secondFileContent);
    return format($diffAST, $format);
}
