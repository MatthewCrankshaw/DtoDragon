<?php

namespace DtoDragon\Singletons;

use DtoDragon\Services\Strategies\NamingStrategyInterface;

class NamingStrategySingleton extends Singleton
{
    private NamingStrategyInterface $strategy;

    public function register(NamingStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function get(): NamingStrategyInterface
    {
        return $this->strategy;
    }
}
