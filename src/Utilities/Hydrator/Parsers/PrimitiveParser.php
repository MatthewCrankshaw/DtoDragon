<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use ReflectionProperty;

/**
 * Parser that converts primitive data from an array to a data transfer object compatible primitive
 * This parser can be overridden to implement more complex conversion if necessary
 *
 * @package DtoDragon\Utilities\Hydrator\Parsers
 *
 * @author Matthew Crankshaw
 */
class PrimitiveParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function registerTypes(): array
    {
        return ['int', 'string', 'float', 'double', 'array'];
    }

    /**
     * Parse the primitive value from the data array to a DTO compatible value
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return mixed
     */
    public function parse(ReflectionProperty $property, $value)
    {
        return $value;
    }
}
