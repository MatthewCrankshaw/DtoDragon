<?php

namespace DtoDragon\Services;

use DtoDragon\DataTransferObject;

/**
 * Factory for creating DTO Reflectors for a particular DTO
 *
 * @author Matthew Crankshaw
 */
class DtoReflectorFactory
{
    /**
     * Create the data transfer reflector for the DTO
     *
     * @param DataTransferObject $dto
     *
     * @return DtoReflector
     */
    public function __invoke(DataTransferObject $dto): ReflectorInterface
    {
        return new DtoReflector($dto);
    }
}
