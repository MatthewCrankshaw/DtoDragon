<?php

namespace DtoDragon\Exceptions;

use Exception;

/**
 * Exception class to represent an unexpected situation
 * where the hydrating array for the DTO, is missing one of the DTO's properties
 *
 * @package DtoDragon\Exceptions
 *
 * @author Matthew Crankshaw
 */
class PropertyDataNotProvidedException extends Exception
{
    public function __construct(string $propertyName, string $dtoType, array $dataArray)
    {
        $message = 'Expected property ('
            . $propertyName . ') to exist in the DTO being hydrated ('
            . $dtoType . ') ['
            . json_encode($dataArray) . ']';

        parent::__construct($message, 500);
    }
}
