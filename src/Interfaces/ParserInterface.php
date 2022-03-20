<?php

namespace DtoDragon\Interfaces;

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
     * @return string
     */
    public function getType(): string;

    /**
     * Parse the given string to an object
     *
     * @param string $value
     *
     * @return object
     */
    public function parse(string $value): object;
}
