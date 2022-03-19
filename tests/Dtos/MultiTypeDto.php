<?php

namespace DtoDragon\Test\Dtos;

use DtoDragon\DataTransferObject;

class MultiTypeDto extends DataTransferObject
{
    private int $id;

    private string $testString;

    private Date $date;
}