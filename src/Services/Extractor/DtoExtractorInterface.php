<?php

namespace DtoDragon\Services\Extractor;

use DtoDragon\DataTransferObject;

/**
 * Defines the interface of a DTO extractor
 * Extractors are responsible for extracting data from a data transfer object
 * and returning the data in an array format
 *
 * @author Matthew Crankshaw
 */
interface DtoExtractorInterface
{
    /**
     * Extract data from the data transfer object and return it as an array
     *
     * @param DataTransferObject $dto
     *
     * @return array
     */
    public function extract(DataTransferObject $dto): array;
}
