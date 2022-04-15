<?php

namespace DtoDragon;

use DtoDragon\Singletons\DtoServiceProviderSingleton;
use DtoDragon\Singletons\NamingStrategySingleton;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Extractor\DtoExtractor;
use DtoDragon\Utilities\Extractor\DtoExtractorInterface;
use DtoDragon\Utilities\Hydrator\DtoHydrator;
use DtoDragon\Utilities\Hydrator\DtoHydratorInterface;
use DtoDragon\Utilities\Strategies\MatchNameStrategy;

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
     * @var DtoExtractorInterface
     */
    private DtoExtractorInterface $extractor;

    /**
     * The hydrator responsible for filling data transfer objects with data
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
        NamingStrategySingleton::getInstance()->register(new MatchNameStrategy());
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
