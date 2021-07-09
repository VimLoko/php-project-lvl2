<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\format as stylishFormat;

function format(array $data, string $format): string
{
    switch ($format) {
        case "stylish":
            return stylishFormat($data);
//        case "yml":
//        case "yaml":
//            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new Exception("Wrong file extension: {$format}");
    }
}
