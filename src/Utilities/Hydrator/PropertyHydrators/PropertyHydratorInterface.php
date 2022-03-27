<?php

namespace DtoDragon\Utilities\Hydrator\PropertyHydrators;

use ReflectionProperty;

/**
 * Defines the interface of a property hydrator
 * A property hydrator is responsible for moving data within an array to a DTO and transforming the data as necessary,
 * The data might be as simple as a primitive type or as complex as an object.
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
interface PropertyHydratorInterface
{
    /**
     * Register the type that this class is able to hydrate
     * When hydrating a DTO property with a given piece of data in the array,
     * this type shows whether the property hydrator supports converting that particular data type
     *
     * @return string
     */
    public function registeredType(): string;

    /**
     * Hydrate the given property based on the type of the property provided
     * The value provided may be a mixed type but the value returned should be the one registered
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function hydrate(ReflectionProperty $property, $value);
}
