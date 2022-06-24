<?php

namespace DtoDragon\Services\Extractor;

use DtoDragon\Services\Strategies\MatchNameStrategy;

class ExtractorFactory
{
    public function __invoke(): DtoExtractorInterface
    {
        $namingStrategy = new MatchNameStrategy();
        $propertyOmitter = new PropertyOmitter();
        return new DtoExtractor($namingStrategy, $propertyOmitter);
    }
}
