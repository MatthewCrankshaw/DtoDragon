<?php

namespace DtoDragon\Exceptions;

use Exception;

/**
 * Exception class to represent an unexpected situation
 * where a property hydrator is requested but is not available for a given type
 *
 * @package DtoDragon\Exceptions
 *
 * @author Matthew Crankshaw
 */
class PropertyHydratorNotFoundException extends Exception
{
    /**
     * Construct the exception with a given message
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $message = 'Expected a property hydrator for type (' . $type
            . '). Define a new property hydrator and register it to the PropertyHydratorSingleton.';

        parent::__construct($message, 500);
    }
}
