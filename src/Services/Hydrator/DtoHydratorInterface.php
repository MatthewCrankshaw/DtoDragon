<?php

namespace DtoDragon\Services\Hydrator;

use DtoDragon\DataTransferObject;

/**
 * Defines the interface of a DTO hydrator
 * Hydrators are responsible for hydrating a data transfer object from an array of data
 *
 * @author Matthew Crankshaw
 */
interface DtoHydratorInterface
{
    /**
     * Hydrate the DTO object with data from the array
     *
     * @param DataTransferObject $dto
     * @param array $data
     *
     * @return DataTransferObject
     */
    public function hydrate(DataTransferObject $dto, array $data): DataTransferObject;
}
