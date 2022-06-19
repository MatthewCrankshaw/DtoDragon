<?php

namespace DtoDragon\Services\Extractor;

use DtoDragon\DataTransferObject;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\Strategies\MatchNameStrategy;

class ExtractorFactory
{
    public function __invoke(DataTransferObject $dto): DtoExtractorInterface
    {
        $factory = new DtoReflectorFactory();
        $reflector = $factory($dto);
        $namingStrategy = new MatchNameStrategy();
        $propertyOmitter = new PropertyOmitter();
        return new DtoExtractor($reflector, $namingStrategy, $propertyOmitter);
    }
}
