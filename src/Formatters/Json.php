<?php

namespace Differ\Formatters\Json;

/**
 * @param array<array<string, mixed>> $diff
 * @return string
 */
function format(array $diff)
{
    $json = json_encode($diff);
    if (is_bool($json)) {
        return '';
    }
    return $json;
}
