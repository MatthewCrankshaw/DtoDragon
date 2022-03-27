<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

/**
 * Parser that converts data from an array to a data transfer object compatible float
 * This parser can be overridden to implement more complex conversion if necessary
 *
 * @package DtoDragon\Utilities\Hydrator\Parsers
 *
 * @author Matthew Crankshaw
 */
class FloatParser extends AbstractParser
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'float';
    }
}
