<?php

namespace DtoDragon\Utilities\Extractor\PropertyExtractors;

/**
 * Defines the interface of a property extractor
 * A property extractor is responsible for converting an object to an array
 *
 * @package DtoDragon\Interfaces
 *
 * @author Matthew Crankshaw
 */
interface PropertyExtractorInterface
{
    /**
     * Get the type of the object that can be extracted
     * When the extractor sees this type it will extract it to an array item
     * The array item might be a primitive or another array
     *
     * @return string
     */
    public function registeredType(): string;

    /**
     * Extract the given object to an array item
     *
     * @param object $object
     *
     * @return string
     */
    public function extract(object $object): string;
}
