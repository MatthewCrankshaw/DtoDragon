<?php

namespace DtoDragon\Test\TestDtos;

use DtoDragon\DataTransferObjectCollection;

class ServiceCollection extends DataTransferObjectCollection
{
    public static function dtoType(): string
    {
        return ServiceDto::class;
    }
}