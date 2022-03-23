<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use DtoDragon\Interfaces\ParserInterface;
use ReflectionProperty;

class PrimitiveParser implements ParserInterface
{
    public function getTypes(): array
    {
        return ['int', 'string', 'float', 'double', 'array'];
    }

    public function parse(ReflectionProperty $property, $value)
    {
        return $value;
    }
}