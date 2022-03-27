<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

/**
 * Parser that converts data from an array to a data transfer object compatible string
 * This parser can be overridden to implement more complex conversion if necessary
 *
 * @package DtoDragon\Utilities\Hydrator\Parsers
 *
 * @author Matthew Crankshaw
 */
class StringParser extends AbstractParser
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'string';
    }
}
