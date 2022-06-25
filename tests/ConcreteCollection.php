<?php

namespace DtoDragon\Test;

use DtoDragon\DataTransferObjectCollection;

class ConcreteCollection extends DataTransferObjectCollection
{
    public function dtoType(): string
    {
        return ConcreteDto::class;
    }
}