<?php

namespace DtoDragon\Services\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Singletons\NamingStrategySingleton;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Services\DtoReflector;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\Strategies\NamingStrategyInterface;
use ReflectionProperty;

/**
 * A hydrator class for hydrating dto's from a given array
 *
 * @author Matthew Crankshaw
 */
class DtoHydrator implements DtoHydratorInterface
{
    /**
     * The class reflector for the given dto
     * Hydration occurs through the reflector
     *
     * @var DtoReflector
     */
    private DtoReflector $reflector;

    private NamingStrategyInterface $namingStrategy;

    /**
     * Construct the DtoHydrator object
     *
     * @param DtoReflectorFactory $factory
     */
    public function __construct(DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create();
        $this->namingStrategy = NamingStrategySingleton::getInstance()->get();
    }

    /**
     * Hydrate the dto object with data from the provided array
     *
     * @param array $data
     *
     * @return DataTransferObject
     */
    public function hydrate(array $data): DataTransferObject
    {
        $properties = $this->reflector->getProperties();
        foreach ($properties as $property) {
            $key = $this->getPropertyDataArrayKey($property);
            if (!array_key_exists($key, $data)) {
                continue;
            }
            $value = $this->getPropertyValueFromDataArray($key, $data);
            $this->hydrateProperty($property, $value);
        }
        return $this->reflector->getDto();
    }

    /**
     * Hydrate a single property with the data from the given value
     * If the value is an array then recursively hydrate the nested DTO's
     *
     * @param ReflectionProperty $property
     * @param mixed $data
     *
     * @return void
     */
    private function hydrateProperty(ReflectionProperty $property, $value)
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $type = $property->getType()->getName();

        if (is_null($value)) {
            if ($this->reflector->propertyIsNullable($property)) {
                $this->reflector->setPropertyValue($property, null);
            } else {
                throw new NonNullablePropertyException($property->getName());
            }
        } elseif ($propertyHydrators->hasPropertyHydrator($type)) {
            $hydrator = $propertyHydrators->getPropertyHydrator($type);
            $value = $hydrator->hydrate($property, $value);
            $this->reflector->setPropertyValue($property, $value);
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
