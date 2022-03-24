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
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message, 500);
    }
}
