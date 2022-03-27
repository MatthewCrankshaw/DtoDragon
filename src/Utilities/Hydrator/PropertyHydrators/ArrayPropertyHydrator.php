<?php

namespace DtoDragon\Utilities\Hydrator\PropertyHydrators;

/**
 * Property hydrator that converts a property from an array to a data transfer object
 * This property hydrator can be overridden to implement more complex conversion if necessary
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
class ArrayPropertyHydrator extends AbstractPropertyHydrator
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'array';
    }
}
