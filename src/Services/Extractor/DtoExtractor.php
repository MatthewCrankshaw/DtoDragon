<?php

namespace DtoDragon\Services\Extractor;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Services\DtoReflector;
use DtoDragon\Services\Strategies\NamingStrategyInterface;
use ReflectionProperty;

/**
 * An extractor class for extracting data from a DTO and presenting it as an array
 *
 * @author Matthew Crankshaw
 */
class DtoExtractor implements DtoExtractorInterface
{
    /**
     * The strategy used when converting extracting data in order to have the
     * keys extracted to the correct naming format
     *
     * @var NamingStrategyInterface
     */
    protected NamingStrategyInterface $namingStrategy;

    protected PropertyOmitterInterface $propertyOmitter;

    public function __construct(
        NamingStrategyInterface $namingStrategy,
        PropertyOmitterInterface $propertyOmitter
    ) {
        $this->namingStrategy = $namingStrategy;
        $this->propertyOmitter = $propertyOmitter;
    }

    /**
     * @inheritDoc
     */
    public function extract(DataTransferObject $dto): array
    {
        $reflector = new DtoReflector($dto);
        $array = [];
        foreach ($reflector->getProperties() as $property) {
            $fieldName = $property->getName();
            if (in_array($fieldName, $this->propertyOmitter->omitted())) {
                continue;
            }
            $key = $this->namingStrategy->fieldToArrayKey($fieldName);
            $array[$key] = $this->extractProperty($reflector, $property);
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
    private function extractProperty(DtoReflector $reflector, ReflectionProperty $property)
    {
        /** @var PropertyExtractorsSingleton $propertyExtractors */
        $propertyExtractors = PropertyExtractorsSingleton::getInstance();
        $type = $property->getType()->getName();

        if ($propertyExtractors->hasPropertyExtractor($type)) {
            $extractor = $propertyExtractors->getPropertyExtractor($type);
            $value = $extractor->extract($reflector->getDto(), $property);
        } else {
            throw new PropertyExtractorNotFoundException($type);
        }

        return $value;
    }
}
