<?php

namespace DtoDragon\interfaces;

use DtoDragon\DataTransferObject;

/**
 * Defines the interface of a DTO hydrator
 * Hydrators are responsible for hydrating a data transfer object from an array of data
 *
 * @package DtoDragon\interfaces
 *
 * @author Matthew Crankshaw
 */
interface DtoHydratorInterface
{
    /**
     * Hydrate the DTO object with data from the array
     *
     * @param array $data
     *
     * @return DataTransferObject
     */
    public function hydrate(array $data): DataTransferObject;
}
