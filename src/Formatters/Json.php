<?php

namespace Differ\Formatters\Json;

/**
 * @param array<array<string, mixed>> $diff
 */
function format(array $diff): string
{
    return json_encode($diff) ?: '';
}
