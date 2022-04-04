<?php

namespace DtoDragon;

use DtoDragon\ServiceProviders\DtoServiceProvider;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Extractor\DtoExtractor;
use DtoDragon\Utilities\Hydrator\DtoHydrator;

/**
 * The base implementation of a data transfer object
 * All data transfer objects will extend this class
 * Contains an extractor for extracting data to an array
 * and a hydrator for hydrating the DTO with data from an array
 *
 * @package DtoDragon
 *
 * @author Matthew Crankshaw
 */
class DataTransferObject
{
    /**
     * The extractor responsible for extracting data to an array
     * @var DtoExtractor
     */
    private DtoExtractor $extractor;

    /**
     * The hydrator responsible for filling data transfer objects with data
     * @var DtoHydrator
     */
    private DtoHydrator $hydrator;

    /**
     * Construct a new data transfer object
     * If a data array is provided hydrate the DTO
     * Otherwise remain leave values unset
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        DtoServiceProvider::boot();
        $factory = new DtoReflectorFactory($this);
        $this->extractor = new DtoExtractor($factory);
        $this->hydrator = new DtoHydrator($factory);
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
