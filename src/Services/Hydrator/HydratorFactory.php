<?php

namespace DtoDragon\Services\Hydrator;

use DtoDragon\Services\Strategies\MatchNameStrategy;

class HydratorFactory
{
    public function __invoke()
    {
        $namingStrategy = new MatchNameStrategy();
        return new DtoHydrator($namingStrategy);
    }
}
