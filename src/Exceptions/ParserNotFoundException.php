<?php

namespace DtoDragon\Exceptions;

use Exception;

/**
 * Exception class to represent an unexpected situation
 * where a parser is requested but is not available for a given type
 *
 * @package DtoDragon\Exceptions
 *
 * @author Matthew Crankshaw
 */
class ParserNotFoundException extends Exception
{
    /**
     * Construct the exception with a given message
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $message = 'Expected a parser for type (' . $type
            . '). Define a new parser and register it to the ParsersSingleton.';

        parent::__construct($message, 500);
    }
}
