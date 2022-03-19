<?php

namespace DtoDragon\utilities;

use DtoDragon\DataTransferObject;
use DtoDragon\interfaces\ReflectorInterface;

/**
 * Factory for creating DTO Reflectors for a particular DTO
 *
 * @package DtoDragon\utilities
 *
 * @author Matthew Crankshaw
 */
class DtoReflectorFactory
{
    /**
     * The data transfer object we would like the factory to create a reflector for
     *
     * @var DataTransferObject
     */
    public DataTransferObject $dto;

    /**
     * Construct the data transfer object reflector factory
     *
     * @param DataTransferObject $dto
     */
    public function __construct(DataTransferObject $dto)
    {
        $this->dto = $dto;
    }

    /**
     * Create the data transfer reflector for the DTO
     *
     * @return DtoReflector
     */
    public function create(): ReflectorInterface
    {
        return new DtoReflector($this->dto);
    }
}
