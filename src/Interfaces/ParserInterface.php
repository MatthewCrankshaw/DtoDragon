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
     * Get the types of the data that can be parsed by this parser
     * When the hydrator sees one this type it will parse it using the parse method
     *
     * @return string[]
     */
    public function registerTypes(): array;

    /**
     * Parse the given value to the data transfer object's property
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function parse(ReflectionProperty $property, $value);
}
