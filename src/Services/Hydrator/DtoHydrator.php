<?php

namespace DtoDragon\Services\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Services\DtoReflector;
use DtoDragon\Services\Strategies\NamingStrategyInterface;
use ReflectionProperty;

/**
 * A hydrator class for hydrating dto's from a given array
 *
 * @author Matthew Crankshaw
 */
class DtoHydrator implements DtoHydratorInterface
{
    private NamingStrategyInterface $namingStrategy;

    /**
     * Construct the DtoHydrator object
     *
     * @param NamingStrategyInterface $namingStrategy
     */
    public function __construct(NamingStrategyInterface $namingStrategy)
    {
        $this->namingStrategy = $namingStrategy;
    }

    /**
     * Hydrate the dto object with data from the provided array
     *
     * @param DataTransferObject $dto
     * @param array $data
     *
     * @return DataTransferObject
     */
    public function hydrate(DataTransferObject $dto, array $data): DataTransferObject
    {
        $reflector = new DtoReflector($dto);
        $properties = $reflector->getProperties();
        foreach ($properties as $property) {
            $key = $this->getPropertyDataArrayKey($property);
            if (!array_key_exists($key, $data)) {
                continue;
            }
            $value = $this->getPropertyValueFromDataArray($key, $data);
            $this->hydrateProperty($reflector, $property, $value);
        }
        return $reflector->getDto();
    }

    /**
     * Hydrate a single property with the data from the given value
     * If the value is an array then recursively hydrate the nested DTO's
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return void
     */
    private function hydrateProperty(DtoReflector $reflector, ReflectionProperty $property, $value)
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $type = $property->getType()->getName();

        if (is_null($value)) {
            if ($reflector->propertyIsNullable($property)) {
                $reflector->setPropertyValue($property, null);
            } else {
                throw new NonNullablePropertyException($property->getName());
            }
        } elseif ($propertyHydrators->hasPropertyHydrator($type)) {
            $hydrator = $propertyHydrators->getPropertyHydrator($type);
            $value = $hydrator->hydrate($property, $value);
            $reflector->setPropertyValue($property, $value);
        } else {
            throw new PropertyHydratorNotFoundException($type);
        }
    }

    /**
     * Get the value of the property from the data array
     *
     * @param string $key
     * @param array $data
     *
     * @return mixed
     */
    private function getPropertyValueFromDataArray(string $key, array $data)
    {
        return $data[$key];
    }

    /**
     * Get the key to access the array element for the given property
     *
     * @param ReflectionProperty $property
     *
     * @return string
     */
    protected function getPropertyDataArrayKey(ReflectionProperty $property): string
    {
        $fieldName = $property->getName();
        $key = $this->namingStrategy->fieldToArrayKey($fieldName);
        return $key;
    }
}
