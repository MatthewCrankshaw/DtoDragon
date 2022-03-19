<?php

namespace DtoDragon\Test\Parser;

use DtoDragon\Interfaces\ParserInterface;
use DtoDragon\Test\Dtos\Date;

class DateParser implements ParserInterface
{
    public function getType(): string
    {
        return Date::class;
    }

    public function parse(string $value): object
    {
        $dateParts = explode('-', $value);
        return new Date($dateParts[0], $dateParts[1], $dateParts[2]);
    }
}