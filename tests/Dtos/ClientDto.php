<?php

namespace DtoDragon\Test\Dtos;

use DtoDragon\DataTransferObject;

class ClientDto extends DataTransferObject
{
    private int $id;

    private string $firstName;

    private string $lastName;
}