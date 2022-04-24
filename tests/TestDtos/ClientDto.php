<?php

namespace DtoDragon\Test\TestDtos;

use DtoDragon\DataTransferObject;

class ClientDto extends DataTransferObject
{
    private readonly int $id;

    private readonly string $firstName;

    private readonly string $lastName;
}