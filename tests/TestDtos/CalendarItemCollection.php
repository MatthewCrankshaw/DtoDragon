<?php

namespace DtoDragon\Test\TestDtos;

use DtoDragon\DataTransferObjectCollection;

class CalendarItemCollection extends DataTransferObjectCollection
{
    public static function dtoType(): string
    {
        return CalendarItemDto::class;
    }
}