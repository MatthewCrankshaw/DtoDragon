<?php

namespace DtoDragon\Test\Dtos;

use DtoDragon\DataTransferObjectCollection;

class CalendarItemCollection extends DataTransferObjectCollection
{
    public static function dtoType(): string
    {
        return CalendarItemDto::class;
    }
}