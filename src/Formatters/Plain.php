<?php

namespace Differ\Formatters\Plain;

/**
 * @param string|integer $value
 * @return string|integer
 */
function stringify($value)
{
    $type = gettype($value);
    switch ($type) {
        case 'array':
        case 'object':
            return "[complex value]";
        case 'NULL':
            return 'null';
        case 'boolean':
            return $value === true ? 'true' : 'false';
        default:
            return $value === 0 ? $value : "'$value'";
    }
}

/**
 * @param array<array<string, mixed>> $data
 * @return array<string>
 */
function build(array $data, string $ancestry = ''): array
{
    $filtered = array_filter($data, function (array $node): bool {
        return $node['type'] != 'unchanged';
    });

    $mapping = array_map(function (array $node) use ($ancestry): string {
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
                $newAncestry = $newAncestry . '.';
                $result = build($node['children'], $newAncestry);
                return implode("\n", $result);
            default:
                throw new \Exception("Unknown type {$type}");
        }
    }, $filtered);
    return $mapping;
}

/**
 * @param array<array<string, mixed>> $diff
 * @return string
 */
function format(array $diff): string
{
    return implode("\n", (build($diff)));
}
