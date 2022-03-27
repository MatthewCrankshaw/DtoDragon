<?php

namespace DtoDragon\Test\Parser;

use DtoDragon\Test\Dtos\Date;
use DtoDragon\Utilities\Hydrator\Parsers\ParserInterface;
use ReflectionProperty;

class DateParser implements ParserInterface
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
    public function parse(ReflectionProperty $property, $value): object
    {
        $dateParts = explode('-', $value);
        return new Date($dateParts[0], $dateParts[1], $dateParts[2]);
    }
}