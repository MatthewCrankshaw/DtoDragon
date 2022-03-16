<?php

namespace DtoDragon\utilities;

use DtoDragon\DataTransferObject;
use DtoDragon\interfaces\DtoReflectorInterface;

class DtoReflectorFactory
{
    /**
     * @return DtoReflector
     */
    public function create(DataTransferObject $dto): DtoReflectorInterface
    {
        return new DtoReflector($dto);
    }
}