<?php

namespace DtoDragon\Services;

use ReflectionProperty;

/**
 * Defines the interface of a reflector
 * A DtoReflector is responsible for reporting and interacting the properties of the dto
 *
 * @author Matthew Crankshaw
 */
interface ReflectorInterface
{
    /**
     * Get the properties of a class as an of ReflectionProperties
     *
     * @return ReflectionProperty[]
     */
    public function getProperties(): array;

    /**
     * Gets the value of a reflected class regardless of accessibility
     *
     * @param ReflectionProperty $property
     *
     * @return mixed
     */
    public function getPropertyValue(ReflectionProperty $property);

    /**
     * Sets the value of a reflected class regardless of accessibility
     *
     * @param ReflectionProperty $property - the property we would like to set
     * @param mixed $value - the value we would like to set the property to
     */
    public function setPropertyValue(ReflectionProperty $property, $value): void;
}
