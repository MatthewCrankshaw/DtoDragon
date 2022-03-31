<?php

namespace DtoDragon\Test\PropertyExtractor;

use DtoDragon\Test\Dtos\Date;
use DtoDragon\Utilities\Extractor\PropertyExtractors\PropertyExtractorInterface;

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
    public function extract(object $object): string
    {
        return $object->day . '-' . $object->month . '-' . $object->year;
    }
}