<?php

namespace Differ\Differ;

use SplFileInfo;

use function Differ\Parsers\parser;

function readFile(string $path): string
{
    if (!file_exists($path)) {
        throw new \Exception("Can't find file in {$path}");
    }
    return file_get_contents($path, true);
}

function getExt(string $filePath): string
{
    return (new SplFileInfo($filePath))->getExtension();
}

function toString($value): string
{
    return trim(var_export($value, true), "'");
}

function mergeArraysKeys(array ...$arrays): array
{
    $result = [];
    foreach ($arrays as $array) {
        $result = [...$result, ...array_keys($array)];
    }
    return array_values(
        array_unique($result)
    );
}

function formating(array $array): string
{
    $mergeKeyValue = array_map(
        function ($key, $value) {
            $key = toString($key);
            $value = toString($value);
            return "  {$key}: {$value}";
        },
        array_keys($array),
        $array
    );
    $implodeAr = implode("\n", $mergeKeyValue);
    return "{\n{$implodeAr}\n}\n";
}

function gendiff(string $firstFile, string $secondFile): string
{
    $firstFileContent = parser(readFile($firstFile), getExt($firstFile));
    $secondFileContent = parser(readFile($secondFile), getExt($secondFile));
    $keys = mergeArraysKeys($firstFileContent, $secondFileContent);
    sort($keys);
    $result = [];
    foreach ($keys as $key) {
        $existKeyInFirstAr = array_key_exists($key, $firstFileContent);
        $existKeyInSecondAr = array_key_exists($key, $secondFileContent);
        $valueFirstAr = $firstFileContent[$key] ?? null;
        $valueSecondAr = $secondFileContent[$key] ?? null;
        if ($existKeyInFirstAr && $existKeyInSecondAr) {
            if ($valueFirstAr === $valueSecondAr) {
                $result["  {$key}"] = $valueFirstAr;
            } else {
                $result["- {$key}"] = $valueFirstAr;
                $result["+ {$key}"] = $valueSecondAr;
            }
        }
        if ($existKeyInFirstAr && !$existKeyInSecondAr) {
            $result["- {$key}"] = $valueFirstAr;
        }
        if (!$existKeyInFirstAr && $existKeyInSecondAr) {
            $result["+ {$key}"] = $valueSecondAr;
        }
    }
    return formating($result);
}
