<?php

namespace DtoDragon\Exceptions;

use Exception;

/**
 * Exception class to represent an unexpected situation
 * where a property extractor is requested but is not available for a given type
 *
 * @package DtoDragon\Exceptions
 *
 * @author Matthew Crankshaw
 */
class PropertyExtractorNotFoundException extends Exception
{
    /**
     * Construct the exception with a given message
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $message = 'Expected a property extractor for type (' . $type
            . '). Define a new property extractor and register it to the PropertyExtractorSingleton.';

        parent::__construct($message, 500);
    }
}
