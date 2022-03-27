<?php

namespace DtoDragon\Utilities\Hydrator\PropertyHydrators;

use DtoDragon\DataTransferObject;
use ReflectionProperty;

/**
 * Property hydrator that converts array data to a data transfer object
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
class DtoPropertyHydrator implements PropertyHydratorInterface
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return DataTransferObject::class;
    }

    /**
     * Hydrate DataTransferObject property from an array of data
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return DataTransferObject
     */
    public function hydrate(ReflectionProperty $property, $value)
    {
        $dtoType = $property->getType()->getName();
        return new $dtoType($value);
    }
}
