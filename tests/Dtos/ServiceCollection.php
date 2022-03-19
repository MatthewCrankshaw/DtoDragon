<?php

namespace DtoDragon\Test\Dtos;

use DtoDragon\DataTransferObjectCollection;

class ServiceCollection extends DataTransferObjectCollection
{
    public static function dtoType(): string
    {
        return ServiceDto::class;
    }
}