<?php

namespace Differ\Formatters\Stylish;

function stringify($value, $depth)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }

    if (is_int($value)) {
        return (string) $value;
    }

    if (is_string($value)) {
        return $value;
    }

    $closingIndent = str_repeat(" ", $depth * 4);
    $strings = array_map(function ($key) use ($value, $depth) {
        $indent = str_repeat(" ", ($depth + 1) * 4);
        $stringedVal = stringify($value->$key, $depth + 1);
        return "{$indent}{$key}: {$stringedVal}";
    }, array_keys(get_object_vars($value)));

    $result = implode("\n", $strings);
    return "{\n{$result}\n{$closingIndent}}";
}

function build(array $data, $depth = 1)
{
    $indent = str_repeat(" ", $depth * 4);
    $indentInner = str_repeat(" ", $depth * 4 - 2);
    $result = array_map(function ($item) use ($indent, $indentInner, $depth) {
        ['key' => $key, 'type' => $type] = $item;
        $value = $item['value'] ?? null;

        if ($type === "added") {
            $val = stringify($value, $depth);
            return "{$indentInner}+ {$key}: {$val}";
        }
        if ($type === "deleted") {
            $val = stringify($value, $depth);
            return "{$indentInner}- {$key}: {$val}";
        }
        if ($type === "nested") {
            $val = build($item['children'], $depth + 1);
            return "{$indent}{$key}: {\n{$val}\n{$indent}}";
        }
        if ($type === "changed") {
            $oldVal = stringify($item['oldValue'], $depth);
            $val = stringify($value, $depth);
            $strOut = "{$indentInner}- {$key}: {$oldVal}";
            $strOff = "{$indentInner}+ {$key}: {$val}";
            return "{$strOut}\n{$strOff}";
        }
        if ($type === "unchanged") {
            return "{$indent}{$key}: {$value}";
        }
        throw new \Exception("Unknown type: {$type}");
    }, $data);

    return implode("\n", $result);
}

function format(array $diff)
{
    $result = build($diff);
    return "{\n{$result}\n}";
}
