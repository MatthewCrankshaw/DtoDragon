<?php

namespace DtoDragon;

use DtoDragon\Singletons\DtoServiceProviderSingleton;

/**
 * The base implementation of a data transfer object
 * All data transfer objects will extend this class
 * Contains an extractor for extracting data to an array
 * and a hydrator for hydrating the DTO with data from an array
 *
 * @author Matthew Crankshaw
 */
class DataTransferObject
{
    /**
     * Construct a new data transfer object
     * If a data array is provided hydrate the DTO
     * Otherwise remain leave values unset
     */
    public function __construct()
    {
        DtoServiceProviderSingleton::getInstance()->boot();
    }
}
