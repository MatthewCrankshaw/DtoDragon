<?php

namespace DtoDragon\Test\dtos;

use DtoDragon\DataTransferObjectCollection;

class ServiceCollection extends DataTransferObjectCollection
{
    public static function dtoType(): string
    {
        return ServiceDto::class;
    }
}