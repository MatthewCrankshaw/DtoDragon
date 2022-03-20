<?php

namespace DtoDragon\Utilities\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Interfaces\DtoHydratorInterface;
use DtoDragon\Singletons\ParsersSingleton;
use DtoDragon\Utilities\DtoReflector;
use DtoDragon\Utilities\DtoReflectorFactory;
use Exception;
use ReflectionProperty;

/**
 * A hydrator class for hydrating dto's from a given array
 *
 * @package DtoDragon\utilities\hydrator
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

    /**
     * Construct the DtoHydrator object
     *
     * @param DtoReflectorFactory $factory
     */
    public function __construct(DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create();
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
            $value = $this->getPropertyValue($property, $data);
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
        $parsers = ParsersSingleton::getInstance();
        if (is_array($value)) {
            if ($this->reflector->propertyIsDto($property)) {
                $dtoType = $property->getType()->getName();
                $this->reflector->setPropertyValue($property, new $dtoType($value));
            } elseif ($this->reflector->propertyIsCollection($property)) {
                $this->hydrateCollection($property, $value);
            } elseif ($this->reflector->propertyIsArray($property)) {
                $this->reflector->setPropertyValue($property, $value);
            }
        } else {
            $type = $property->getType()->getName();
            if (!in_array($type, ['int', 'string', 'float']) && is_string($value)) {
                if ($parsers->hasParser($type)) {
                    $parser = $parsers->getParser($type);
                    $value = $parser->parse($value);
                } else {
                    throw new Exception(
                        'Cannot implicitly convert from string to '
                        . $type . '. Define a parser and register it to the ParsersSingleton.'
                    );
                }
                $this->reflector->setPropertyValue($property, $value);
            } else {
                $this->reflector->setPropertyValue($property, $value);
            }
        }
    }

    /**
     * Hydrate a property that is a nested collection of DTOs
     *
     * @param ReflectionProperty $property
     * @param array $collectionArray
     *
     * @return void
     */
    private function hydrateCollection(ReflectionProperty $property, array $collectionArray): void
    {
        $propertyType = $property->getType();
        $collection = $propertyType->getName();
        $collectArray = [];
        foreach ($collectionArray as $item) {
            $dtoType = $collection::dtoType();
            $collectArray[] = new $dtoType($item);
        }
        $this->reflector->setPropertyValue($property, new $collection($collectArray));
    }

    /**
     * Get the value of the property from the data array based on the property name
     *
     * @param ReflectionProperty $property
     * @param array $data
     *
     * @return mixed
     */
    private function getPropertyValue(ReflectionProperty $property, array $data)
    {
        $propertyName = $property->getName();
        if ($this->validatePropertyExists($propertyName, $data)) {
            return $data[$propertyName];
        }
    }

    /**
     * Validate that the property exists in the data array
     * If the property does not exist throw an exception
     * Otherwise return true
     *
     * @param string $propertyName
     * @param array $data
     *
     * @throws Exception - If the property does not exist in the DTO
     * @return bool
     */
    private function validatePropertyExists(string $propertyName, array $data): bool
    {
        if (!array_key_exists($propertyName, $data)) {
            throw new \Exception(
                'Expected property (' . $propertyName . ') to exist in ' . get_class($this->reflector->getDto())
            );
        }
        return true;
    }
}
