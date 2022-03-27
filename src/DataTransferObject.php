<?php

namespace DtoDragon;

use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Extractor\DtoExtractor;
use DtoDragon\Utilities\Hydrator\DtoHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\ArrayPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\CollectionPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\FloatPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\IntegerPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\StringPropertyHydrator;

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
        $this->registerBasicPropertyHydrators();
        $factory = new DtoReflectorFactory($this);
        $this->extractor = new DtoExtractor($factory);
        $this->hydrator = new DtoHydrator($factory);
        if (!empty($data)) {
            $this->hydrator->hydrate($data);
        }
    }

    /**
     * Register the property hydrators used to hydrate the DTO's
     *
     * @return void
     */
    private function registerBasicPropertyHydrators(): void
    {
        PropertyHydratorsSingleton::getInstance()->register(new IntegerPropertyHydrator());
        PropertyHydratorsSingleton::getInstance()->register(new StringPropertyHydrator());
        PropertyHydratorsSingleton::getInstance()->register(new ArrayPropertyHydrator());
        PropertyHydratorsSingleton::getInstance()->register(new FloatPropertyHydrator());
        PropertyHydratorsSingleton::getInstance()->register(new DtoPropertyHydrator());
        PropertyHydratorsSingleton::getInstance()->register(new CollectionPropertyHydrator());
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
