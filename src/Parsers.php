<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parser(string $data, string $format): object
{
    switch ($format) {
        case "json":
            return json_decode($data, false, 512, JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR);
        case "yml":
        case "yaml":
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new Exception("Wrong file extension: {$format}");
    }
}
