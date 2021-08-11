<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\format as stylishFormat;
use function Differ\Formatters\Plain\format as plainFormat;
use function Differ\Formatters\Json\format as jsonFormat;

/**
 * @param array<array<string, mixed>> $data
 */
function format(array $data, string $format): string
{
    switch ($format) {
        case "stylish":
            return stylishFormat($data);
        case "plain":
            return plainFormat($data);
        case "json":
            return jsonFormat($data);
        default:
            throw new \Exception("Wrong file extension: {$format}");
    }
}
