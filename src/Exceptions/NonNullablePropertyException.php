<?php

namespace DtoDragon\Exceptions;

use Exception;

/**
 * Exception class to represent an unexpected situation
 * where a dto property is trying to be filled with a null value when the property is not nullable
 *
 * @package DtoDragon\Exceptions
 *
 * @author Matthew Crankshaw
 */
class NonNullablePropertyException extends Exception
{
    /**
     * Construct the exception with a given message
     *
     * @param string $propertyName
     */
    public function __construct(string $propertyName)
    {
        parent::__construct(
            'Trying to fill property (' . $propertyName . ') with a null value when it is not nullable.',
            500
        );
    }
}
