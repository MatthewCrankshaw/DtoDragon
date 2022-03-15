<?php

namespace DtoDragon\Test\dtos;

use DtoDragon\DataTransferObjectCollection;

class CalendarItemCollection extends DataTransferObjectCollection
{
    public static function dtoType(): string
    {
        return CalendarItemDto::class;
    }
}