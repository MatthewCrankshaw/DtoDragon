<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use DtoDragon\DataTransferObject;
use DtoDragon\Interfaces\ParserInterface;
use ReflectionProperty;

class DtoParser implements ParserInterface
{
    public function getTypes(): array
    {
        return [DataTransferObject::class];
    }

    public function parse(ReflectionProperty $property, $value)
    {
        $dtoType = $property->getType()->getName();
        return new $dtoType($value);
    }
}