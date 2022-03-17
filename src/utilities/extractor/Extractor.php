<?php

namespace DtoDragon\utilities\extractor;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\interfaces\ExtractorInterface;
use DtoDragon\singletons\CastersSingleton;
use DtoDragon\Test\Caster\DateCaster;
use DtoDragon\utilities\DtoReflector;
use DtoDragon\utilities\DtoReflectorFactory;
use ReflectionProperty;

class Extractor implements ExtractorInterface
{
    private DtoReflector $reflector;

    private CastersSingleton $casters;

    public function __construct(DataTransferObject $dto, DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create($dto);
        $this->casters = CastersSingleton::getInstance();
        $this->casters->register(new DateCaster());
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
        if ($this->isNestedDto($value)) {
            $value = $value->toArray();
        } elseif ($this->casters->hasCaster($value)) {
            $caster = $this->casters->getCaster($value);
            $value = $caster->cast($value);
        }
        $array[$propertyName] = $value;
    }

    private function isNestedDto($value): bool
    {
        return is_a($value, DataTransferObject::class)
            || is_a($value, DataTransferObjectCollection::class);
    }
}