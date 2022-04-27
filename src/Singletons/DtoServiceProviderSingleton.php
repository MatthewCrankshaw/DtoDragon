<?php

namespace DtoDragon\Singletons;

use DtoDragon\Services\Extractor\PropertyExtractors\ArrayPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\CollectionPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\DtoPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\FloatPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\IntegerPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\StringPropertyExtractor;
use DtoDragon\Services\Hydrator\PropertyHydrators\ArrayPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\CollectionPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\FloatPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\IntegerPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\StringPropertyHydrator;

/**
 * Service provider for the data transfer object
 * Boots the relevant services that are used by the DtoDragon system for transforming
 * and manipulating the relevant data
 *
 * @author Matthew Crankshaw
 */
class DtoServiceProviderSingleton extends Singleton
{
    /**
     * Identifies whether a the service provider is booted
     *
     * @var boolean
     */
    private bool $booted;

    /**
     * Clear the service provider by clearing all loaded services
     *
     * @return void
     */
    public function clear(): void
    {
        PropertyHydratorsSingleton::getInstance()->clear();
        PropertyExtractorsSingleton::getInstance()->clear();
        $this->booted = false;
    }

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

    /**
     * Sets whether or not the service provider has booted
     *
     * @param boolean $booted
     *
     * @return void
     */
    public function setBooted(bool $booted): void
    {
        $this->booted = $booted;
    }
}
