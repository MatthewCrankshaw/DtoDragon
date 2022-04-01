<?php

namespace DtoDragon\Utilities\Extractor\PropertyExtractors;

use DtoDragon\DataTransferObject;
use ReflectionProperty;

/**
 * Defines the base functionality of a property extractor
 * A property extractor is responsible for extracting data from a DTO property
 * to an array property and transforming the data,
 * The data might be as simple as a primitive type or as complex as an object.
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
abstract class AbstractPropertyExtractor implements PropertyExtractorInterface
{
    /**
     * @inheritDoc
     */
    abstract public function registeredType(): string;

    /**
     * Extract the DTO property value to associated data array value
     *
     * @param DataTransferObject $dto
     * @param ReflectionProperty $property
     *
     * @return mixed
     */
    public function extract(DataTransferObject $dto, ReflectionProperty $property)
    {
        return $property->getValue($dto);
    }
}
