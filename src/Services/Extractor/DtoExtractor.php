<?php

namespace DtoDragon\Services\Extractor;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Singletons\NamingStrategySingleton;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Services\DtoReflector;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\ReflectorInterface;
use DtoDragon\Services\Strategies\MatchNameStrategy;
use DtoDragon\Services\Strategies\NamingStrategyInterface;
use JetBrains\PhpStorm\Pure;
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

    private NamingStrategyInterface $namingStrategy;

    public function __construct(DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create();
        $this->namingStrategy = NamingStrategySingleton::getInstance()->get();
    }

    #[Pure]
    protected function createNamingStrategy(): NamingStrategyInterface
    {
        return new MatchNameStrategy();
    }

    /**
     * @inheritDoc
     */
    public function extract(): array
    {
        $array = [];
        foreach ($this->reflector->getProperties() as $property) {
            $fieldName = $property->getName();
            $key = $this->namingStrategy->fieldToArrayKey($fieldName);
            $array[$key] = $this->extractProperty($property);
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
            throw new PropertyExtractorNotFoundException($type);
        }

        return $value;
    }
}
