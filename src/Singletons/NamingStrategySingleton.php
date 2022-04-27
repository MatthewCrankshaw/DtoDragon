<?php

namespace DtoDragon\Singletons;

use DtoDragon\Services\Strategies\NamingStrategyInterface;

/**
 * Defines the singleton that manages the naming strategies
 * Naming strategies are used to match property names when hydrating and extracting data from DTO's
 * 
 * @author Matthew Crankshaw
 */
class NamingStrategySingleton extends Singleton
{
    /**
     * The registered naming stratergy 
     *
     * @var NamingStrategyInterface
     */
    private NamingStrategyInterface $strategy;

    /**
     * Register a naming strategy
     *
     * @param NamingStrategyInterface $strategy
     * 
     * @return void
     */
    public function register(NamingStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * Retrieve the current naming strategy
     *
     * @return NamingStrategyInterface
     */
    public function get(): NamingStrategyInterface
    {
        return $this->strategy;
    }
}
