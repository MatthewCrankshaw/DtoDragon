<?php

namespace DtoDragon\interfaces;

/**
 * Defines the interface of an extractor
 * Extractors are responsible for extracting data from a data transfer object
 * and returning the data in an array format
 *
 * @package DtoDragon\interfaces
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
