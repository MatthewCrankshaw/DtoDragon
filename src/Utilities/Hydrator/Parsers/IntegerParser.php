<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

/**
 * Parser that converts integer data from an array to a data transfer object compatible integer
 * This parser can be overridden to implement more complex conversion if necessary
 *
 * @package DtoDragon\Utilities\Hydrator\Parsers
 *
 * @author Matthew Crankshaw
 */
class IntegerParser extends AbstractParser
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'int';
    }
}
