<?php

namespace DtoDragon\utilities\extractor;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\interfaces\DtoExtractorInterface;
use DtoDragon\interfaces\ReflectorInterface;
use DtoDragon\singletons\CastersSingleton;
use DtoDragon\utilities\DtoReflector;
use DtoDragon\utilities\DtoReflectorFactory;
use ReflectionProperty;

/**
 * An extractor class for extracting data from a dto and presenting it as an array
 * The extractor will also use casters to cast values to strings if the appropriate caster is available
 *
 * @package DtoDragon\utilities\extractor
 *
 * @author Matthew Crankshaw
 */
class DtoExtractor implements DtoExtractorInterface
{
    /**
     * An object to reflect the data transfer object
     *
     * @var DtoReflector
     */
    private ReflectorInterface $reflector;

    public function __construct(DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create();
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

    /**
     * Extract a single property to the array
     * If the property is a nested object it will recursively extract that object to an array
     *
     * @param ReflectionProperty $property
     * @param array $array
     *
     * @return void
     */
    private function extractProperty(ReflectionProperty $property, array &$array): void
    {
        $casters = CastersSingleton::getInstance();
        $propertyName = $property->getName();
        $value = $this->reflector->getPropertyValue($property);
        if ($this->isNestedDto($value)) {
            $value = $value->toArray();
        } elseif (is_object($value)) {
            if ($casters->hasCaster($value)) {
                $caster = $casters->getCaster($value);
                $value = $caster->cast($value);
            }
        }
        $array[$propertyName] = $value;
    }

    /**
     * Check if the value provided is a data transfer object
     * or a collection of data transfer objects
     *
     * @param $value
     *
     * @return bool
     */
    private function isNestedDto($value): bool
    {
        return is_a($value, DataTransferObject::class)
            || is_a($value, DataTransferObjectCollection::class);
    }
}
