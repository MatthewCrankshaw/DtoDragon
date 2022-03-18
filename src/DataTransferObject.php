<?php

namespace DtoDragon;

use DtoDragon\utilities\DtoReflectorFactory;
use DtoDragon\utilities\extractor\DtoExtractor;
use DtoDragon\utilities\hydrator\DtoHydrator;

/**
 * Class DataTransferObject
 *
 * @package DtoDragon
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
