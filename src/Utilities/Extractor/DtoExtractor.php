<?php

namespace DtoDragon\Utilities\Extractor;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Utilities\DtoReflector;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Extractor\PropertyExtractors\PropertyExtractorInterface;
use DtoDragon\Utilities\ReflectorInterface;
use ReflectionProperty;

/**
 * An extractor class for extracting data from a DTO and presenting it as an array
 *
 * @package DtoDragon\Utilities\Extractor
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
            $propertyName = $property->getName();
            $array[$propertyName] = $this->extractProperty($property);
        }
        return $array;
    }

    /**
     * Extract a single property to the array
     * If the property is a nested object it will recursively extract that object to an array
     *
     * @param ReflectionProperty $property
     *
     * @return mixed
     */
    private function extractProperty(ReflectionProperty $property)
    {
        /** @var PropertyExtractorsSingleton $propertyExtractors */
        $propertyExtractors = PropertyExtractorsSingleton::getInstance();
        $type = $property->getType()->getName();

        if ($propertyExtractors->hasPropertyExtractor($type)) {
            $extractor = $propertyExtractors->getPropertyExtractor($type);
            $value = $extractor->extract($this->reflector->getDto(), $property);
        } else {
            throw new \Exception('A Property Extractor does not exist for type ' . $type);
        }

        return $value;
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
