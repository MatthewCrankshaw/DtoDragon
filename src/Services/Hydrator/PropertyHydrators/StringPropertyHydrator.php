<?php

namespace DtoDragon\Services\Hydrator\PropertyHydrators;

/**
 * Property hydrator that converts data from an array to a data transfer object compatible string property
 * This property hydrator can be overridden to implement more complex conversion if necessary
 *
 * @author Matthew Crankshaw
 */
class StringPropertyHydrator extends AbstractPropertyHydrator
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'string';
    }
}
