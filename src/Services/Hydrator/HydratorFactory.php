<?php

namespace DtoDragon\Services\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\Strategies\MatchNameStrategy;

class HydratorFactory
{
    public function __invoke(DataTransferObject $dto)
    {
        $factory = new DtoReflectorFactory();
        $reflector = $factory($dto);
        $namingStrategy = new MatchNameStrategy();
        return new DtoHydrator($reflector, $namingStrategy);
    }
}