<?php

namespace DtoDragon\Interfaces;

use ReflectionProperty;

/**
 * Defines the interface of a parser
 * A parser is responsible for converting a string to an object
 *
 * @package DtoDragon\Interfaces
 *
 * @author Matthew Crankshaw
 */
interface ParserInterface
{
    /**
     * Get the type of the object that can be parsed
     * When the hydrator sees this type it will parse it to an object using the parse method
     *
     * @return string[]
     */
    public function getTypes(): array;

    /**
     * Parse the given value to the data transfer object's property
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function parse(ReflectionProperty $property, $value);
}
