<?php

namespace DtoDragon\Singletons;

use DtoDragon\Utilities\Extractor\PropertyExtractors\ArrayPropertyExtractor;
use DtoDragon\Utilities\Extractor\PropertyExtractors\CollectionPropertyExtractor;
use DtoDragon\Utilities\Extractor\PropertyExtractors\DtoPropertyExtractor;
use DtoDragon\Utilities\Extractor\PropertyExtractors\FloatPropertyExtractor;
use DtoDragon\Utilities\Extractor\PropertyExtractors\IntegerPropertyExtractor;
use DtoDragon\Utilities\Extractor\PropertyExtractors\StringPropertyExtractor;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\ArrayPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\CollectionPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\FloatPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\IntegerPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\StringPropertyHydrator;
use Symfony\Contracts\Service\ServiceProviderInterface;

/**
 * Service provider for the data transfer object
 * Boots the relevant services that are used by the DtoDragon system for transforming
 * and manipulating the relevant data
 *
 * @package DtoDragon\ServiceProviders
 *
 * @author Matthew Crankshaw
 */
class DtoServiceProviderSingleton extends Singleton
{
    /**
     * Stores whether the service provider has booted successfully
     *
     * @var bool
     */
    public bool $booted = false;

    /**
     * Boot the data transfer object's services
     *
     * @return void
     */
    public function boot(): void
    {
        if (!$this->booted) {
            $this->registerBasicPropertyHydrators();
            $this->registerBasicPropertyExtractors();
        }
        $this->booted = true;
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
     * Register the property extractors used to extract the data from the DTOs
     *
     * @return void
     */
    private function registerBasicPropertyExtractors(): void
    {
        PropertyExtractorsSingleton::getInstance()->register(new IntegerPropertyExtractor());
        PropertyExtractorsSingleton::getInstance()->register(new StringPropertyExtractor());
        PropertyExtractorsSingleton::getInstance()->register(new ArrayPropertyExtractor());
        PropertyExtractorsSingleton::getInstance()->register(new FloatPropertyExtractor());
        PropertyExtractorsSingleton::getInstance()->register(new DtoPropertyExtractor());
        PropertyExtractorsSingleton::getInstance()->register(new CollectionPropertyExtractor());
    }
}