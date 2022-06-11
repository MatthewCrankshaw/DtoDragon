<?php

namespace DtoDragon;

use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Services\Hydrator\HydratorFactory;
use DtoDragon\Singletons\DtoServiceProviderSingleton;
use DtoDragon\Services\Extractor\DtoExtractorInterface;
use DtoDragon\Services\Hydrator\DtoHydratorInterface;

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
     * The extractor responsible for extracting data to an array
     *
     * @var DtoExtractorInterface
     */
    private DtoExtractorInterface $extractor;

    /**
     * The hydrator responsible for filling data transfer objects with data
     *
     * @var DtoHydratorInterface
     */
    private DtoHydratorInterface $hydrator;

    /**
     * Construct a new data transfer object
     * If a data array is provided hydrate the DTO
     * Otherwise remain leave values unset
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        DtoServiceProviderSingleton::getInstance()->boot();
        $extractorFactory = new ExtractorFactory();
        $hydratorFactory = new HydratorFactory();
        $this->extractor = $extractorFactory($this);
        $this->hydrator = $hydratorFactory($this);
        if (!empty($data)) {
            $this->hydrator->hydrate($data);
        }
    }

    /**
     * Convert the data transfer object to an array of strings
     *
     * @return string[]
     */
    public function toArray(): array
    {
        return $this->extractor->extract();
    }
}
