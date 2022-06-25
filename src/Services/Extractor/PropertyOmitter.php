<?php

namespace DtoDragon\Services\Extractor;

class PropertyOmitter implements PropertyOmitterInterface
{
    /**
     * @var string[]
     */
    protected array $properties;

    public function __construct()
    {
        $this->properties = [];
    }

    public function add(string $property): void
    {
        $this->properties[] = $property;
    }

    /**
     * @return string[]
     */
    public function omitted(): array
    {
        return $this->properties;
    }
}
