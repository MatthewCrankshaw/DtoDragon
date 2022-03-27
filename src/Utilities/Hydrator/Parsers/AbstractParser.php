<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use ReflectionProperty;

/**
 * Defines the base functionality of a parser
 * A parser is responsible for moving data within an array to an DTO and transforming the data if necessary,
 * The data might be as simple as a primitive type or as complex as an object.
 *
 * @package DtoDragon\Utilities\Hydrator\Parsers
 *
 * @author Matthew Crankshaw
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public abstract function registeredType(): string;

    /**
     * Parse the value from the data array to a DTO compatible value
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