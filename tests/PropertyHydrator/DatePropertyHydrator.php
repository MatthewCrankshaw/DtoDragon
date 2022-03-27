<?php

namespace DtoDragon\Test\PropertyHydrator;

use DtoDragon\Test\Dtos\Date;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\PropertyHydratorInterface;
use ReflectionProperty;

class DatePropertyHydrator implements PropertyHydratorInterface
{
    public function registeredType(): string
    {
        return Date::class;
    }

    /**
     *
     *
     * @param string $value
     *
     * @return object
     */
    public function hydrate(ReflectionProperty $property, $value): object
    {
        $dateParts = explode('-', $value);
        return new Date($dateParts[0], $dateParts[1], $dateParts[2]);
    }
}