<?php

namespace DtoDragon\Test\Dtos;

use DtoDragon\DataTransferObject;

class MultiTypeDto extends DataTransferObject
{
    private int $id;

    public string $testString;
}