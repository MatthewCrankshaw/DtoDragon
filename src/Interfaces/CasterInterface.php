<?php

namespace DtoDragon\Interfaces;

/**
 * Defines the interface of a caster
 * A caster is responsible for converting an object to a string
 *
 * @package DtoDragon\Interfaces
 *
 * @author Matthew Crankshaw
 */
interface CasterInterface
{
    /**
     * Get the type of the object that can be casted
     * When the extractor sees this type it will cast it to an string using the cast method
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Cast the given object to a string
     *
     * @param object $object
     *
     * @return string
     */
    public function cast(object $object): string;
}
