<?php

namespace DtoDragon\Utilities\Extractor;

/**
 * Defines the interface of a DTO extractor
 * Extractors are responsible for extracting data from a data transfer object
 * and returning the data in an array format
 *
 * @package DtoDragon\Interfaces
 *
 * @author Matthew Crankshaw
 */
interface DtoExtractorInterface
{
    /**
     * Extract data from the data transfer object and return it as an array
     *
     * @return array
     */
    public function extract(): array;
}
