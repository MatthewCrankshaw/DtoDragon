<?php

namespace DtoDragon\Test\PropertyExtractor;

use DtoDragon\DataTransferObject;
use DtoDragon\Test\TestDtos\Date;
use DtoDragon\Utilities\Extractor\PropertyExtractors\PropertyExtractorInterface;
use ReflectionProperty;

class DatePropertyExtractor implements PropertyExtractorInterface
{
    public function registeredType(): string
    {
        return Date::class;
    }

    /**
     * @param Date $object
     *
     * @return string
     */
    public function extract(DataTransferObject $dto, ReflectionProperty $property): ?string
    {
        $value = $property->getValue($dto);

        if (is_null($value)) {
            return null;
        }

        return $value->day . '-' . $value->month . '-' . $value->year;
    }
}