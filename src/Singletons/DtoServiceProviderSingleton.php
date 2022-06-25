<?php

namespace DtoDragon\Singletons;

use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Services\Extractor\PropertyExtractors\CollectionPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\DtoPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\PrimitivePropertyExtractor;
use DtoDragon\Services\Hydrator\HydratorFactory;
use DtoDragon\Services\Hydrator\PropertyHydrators\CollectionPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\PrimitivePropertyHydrator;

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
    protected bool $booted = false;

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
    protected function registerBasicPropertyHydrators(): void
    {
        $factory = new HydratorFactory();
        PropertyHydratorsSingleton::getInstance()->register(new PrimitivePropertyHydrator());
        PropertyHydratorsSingleton::getInstance()->register(new DtoPropertyHydrator($factory()));
        PropertyHydratorsSingleton::getInstance()->register(new CollectionPropertyHydrator($factory()));
    }

    /**
     * Register the property extractors used to extract the data from the DTOs
     *
     * @return void
     */
    protected function registerBasicPropertyExtractors(): void
    {
        $factory = new ExtractorFactory();
        PropertyExtractorsSingleton::getInstance()->register(new PrimitivePropertyExtractor());
        PropertyExtractorsSingleton::getInstance()->register(new DtoPropertyExtractor($factory()));
        PropertyExtractorsSingleton::getInstance()->register(new CollectionPropertyExtractor($factory()));
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
