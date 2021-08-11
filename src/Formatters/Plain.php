<?php

namespace Differ\Formatters\Plain;

function stringify($value)
{
    if ($value === 0) {
        return $value;
    }
    $type = gettype($value);
    switch ($type) {
        case 'array':
        case 'object':
            return "[complex value]";
        case 'NULL':
            return 'null';
        case 'boolean':
            return $value ? 'true' : 'false';
        default:
            return "'$value'";
    }
}

function build(array $data, $ancestry = '')
{
    $filtered = array_filter($data, function ($node) {
        return $node['type'] != 'unchanged';
    });

    $mapping = array_map(function ($node) use ($ancestry) {
        $newAncestry = $ancestry . $node['key'];
        $type = $node['type'];

        switch ($type) {
            case 'added':
                $value = stringify($node['value']);
                $formatView = "Property '%s' was added with value: %s";
                return sprintf($formatView, $newAncestry, $value);

            case 'deleted':
                return "Property '{$newAncestry}' was removed";

            case 'changed':
                $newVal = stringify($node['value']);
                $oldval = stringify($node['oldValue']);
                $formatView = "Property '%s' was updated. From %s to %s";
                return sprintf($formatView, $newAncestry, $oldval, $newVal);

            case 'nested':
                $newAncestry .= '.';
                $result = build($node['children'], $newAncestry);
                return implode("\n", $result);
            default:
                throw new \Exception("Unknown type {$type}");
        }
    }, $filtered);
    return $mapping;
}

function format(array $diff)
{
    return implode("\n", (build($diff)));
}
