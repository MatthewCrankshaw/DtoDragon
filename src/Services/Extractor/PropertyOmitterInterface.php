<?php

namespace DtoDragon\Services\Extractor;

interface PropertyOmitterInterface
{
    public function add(string $property): void;

    public function omitted(): array;
}
