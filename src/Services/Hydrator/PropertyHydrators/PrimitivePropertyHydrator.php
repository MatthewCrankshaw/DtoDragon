<?php

namespace DtoDragon\Services\Hydrator\PropertyHydrators;

/**
 * Property hydrator that converts data from an array to a data transfer object compatible primitive property
 *
 * @author Matthew Crankshaw
 */
class PrimitivePropertyHydrator extends AbstractPropertyHydrator
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'primitive';
    }
}
