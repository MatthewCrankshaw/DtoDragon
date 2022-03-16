<?php

namespace DtoDragon\utilities\extractor;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\interfaces\ExtractorInterface;
use DtoDragon\utilities\DtoReflector;
use DtoDragon\utilities\DtoReflectorFactory;
use ReflectionProperty;

class Extractor implements ExtractorInterface
{
    private DtoReflector $reflector;

    public function __construct(DataTransferObject $dto, DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create($dto);
    }

    public function extract(): array
    {
        $array = [];
        foreach ($this->reflector->getProperties() as $property) {
            $this->extractProperty($property, $array);
        }
        return $array;
    }

    private function extractProperty(ReflectionProperty $property, array &$array): void
    {
        $propertyName = $property->getName();
        $value = $this->reflector->getProperty($property);
        if ($this->isNestedObject($value)) {
            $value = $value->toArray();
        }
        $array[$propertyName] = $value;
    }

    private function isNestedObject($value): bool
    {
        return is_a($value, DataTransferObject::class)
            || is_a($value, DataTransferObjectCollection::class);
    }
}