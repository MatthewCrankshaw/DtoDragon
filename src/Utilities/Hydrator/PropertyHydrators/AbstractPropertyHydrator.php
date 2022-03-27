<?php

namespace DtoDragon\Utilities\Hydrator\PropertyHydrators;

use ReflectionProperty;

/**
 * Defines the base functionality of a property hydrator
 * A property hydrator is responsible for hydrating data from an array to an DTO property and transforming the data,
 * The data might be as simple as a primitive type or as complex as an object.
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
abstract class AbstractPropertyHydrator implements PropertyHydratorInterface
{
    /**
     * @inheritDoc
     */
    abstract public function registeredType(): string;

    /**
     * Hydrate the DTO property value with the associated data array value
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return mixed
     */
    public function hydrate(ReflectionProperty $property, $value)
    {
        return $value;
    }
}
