<?php

namespace DtoDragon\Test\dtos;

use DtoDragon\DataTransferObject;

class MultiTypeDto extends DataTransferObject
{
    private int $id;

    public string $testString;
}