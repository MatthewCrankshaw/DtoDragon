<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use ReflectionProperty;

/**
 * Defines the interface of a parser
 * A parser is responsible for moving data within an array to a DTO and transforming the data as necessary,
 * The data might be as simple as a primitive type or as complex as an object.
 *
 * @package DtoDragon\Interfaces
 *
 * @author Matthew Crankshaw
 */
interface ParserInterface
{
    /**
     * Register the type that this class is able to parse
     * When hydrating a DTO property with a given piece of data in the array,
     * this type shows whether the parser supports parsing that particular data type
     *
     * @return string
     */
    public function registeredType(): string;

    /**
     * Parse the given value based on the type of the property
     * The value provided may be a mixed type but the value returned should be one registered
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function parse(ReflectionProperty $property, $value);
}
