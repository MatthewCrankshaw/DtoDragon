<?php

namespace DtoDragon\utilities\extractor;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\interfaces\DtoExtractorInterface;
use DtoDragon\singletons\CastersSingleton;
use DtoDragon\Test\Caster\DateCaster;
use DtoDragon\utilities\DtoReflector;
use DtoDragon\utilities\DtoReflectorFactory;
use ReflectionProperty;

class DtoExtractor implements DtoExtractorInterface
{
    private DtoReflector $reflector;

    public function __construct(DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create();
        CastersSingleton::getInstance()->register(new DateCaster());
    }

    /**
     * @inheritDoc
     */
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
        $casters = CastersSingleton::getInstance();
        $propertyName = $property->getName();
        $value = $this->reflector->getPropertyValue($property);
        if ($this->isNestedDto($value)) {
            $value = $value->toArray();
        } elseif ($casters->hasCaster($value)) {
            $caster = $casters->getCaster($value);
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
