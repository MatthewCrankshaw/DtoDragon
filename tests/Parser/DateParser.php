<?php

namespace DtoDragon\Test\Parser;

use DtoDragon\Interfaces\ParserInterface;
use DtoDragon\Test\Dtos\Date;
use ReflectionProperty;

class DateParser implements ParserInterface
{
    public function getTypes(): array
    {
        return [Date::class];
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