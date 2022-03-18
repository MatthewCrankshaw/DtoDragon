<?php

namespace DtoDragon\utilities;

use DtoDragon\DataTransferObject;
use DtoDragon\interfaces\ReflectorInterface;

class DtoReflectorFactory
{
    public DataTransferObject $dto;

    public function __construct(DataTransferObject $dto)
    {
        $this->dto = $dto;
    }

    /**
     * @return DtoReflector
     */
    public function create(): ReflectorInterface
    {
        return new DtoReflector($this->dto);
    }
}