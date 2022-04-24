<?php

namespace DtoDragon\Services\Extractor\PropertyExtractors;

use DtoDragon\DataTransferObject;
use ReflectionProperty;

/**
 * Extractor for the dto property type
 * Subclasses of dto's will be extracted from a parent dto to an array using this extractor
 *
 * @author Matthew Crankshaw
 */
class DtoPropertyExtractor extends AbstractPropertyExtractor
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return DataTransferObject::class;
    }

    /**
     * Extract the values from a given dto property to an array
     *
     * @param DataTransferObject $dto
     * @param ReflectionProperty $property
     *
     * @return mixed|null
     */
    public function extract(DataTransferObject $dto, ReflectionProperty $property)
    {
        $value = $property->getValue($dto);
        if (is_null($value)) {
            return null;
        }

        return $value->toArray();
    }
}
