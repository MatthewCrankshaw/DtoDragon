<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use DtoDragon\DataTransferObject;
use DtoDragon\Interfaces\ParserInterface;
use ReflectionProperty;

/**
 * Parser that converts array data to a data transfer object
 *
 * @package DtoDragon\Utilities\Hydrator\Parsers
 *
 * @author Matthew Crankshaw
 */
class DtoParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function registerTypes(): array
    {
        return [DataTransferObject::class];
    }

    /**
     * Parse an array of data to a DataTransferObject
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return DataTransferObject
     */
    public function parse(ReflectionProperty $property, $value)
    {
        $dtoType = $property->getType()->getName();
        return new $dtoType($value);
    }
}
