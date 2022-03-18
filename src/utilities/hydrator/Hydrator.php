<?php

namespace DtoDragon\utilities\hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\interfaces\HydratorInterface;
use DtoDragon\Test\dtos\ClientDto;
use DtoDragon\utilities\DtoReflector;
use DtoDragon\utilities\DtoReflectorFactory;
use ReflectionProperty;

class Hydrator implements HydratorInterface
{
    private DtoReflector $reflector;

    public function __construct(DtoReflectorFactory $factory)
    {
        $this->reflector = $factory->create();
    }

    public function hydrate(array $data): DataTransferObject
    {
        $properties = $this->reflector->getProperties();
        foreach ($properties as $property) {
            $this->hydrateProperty($property, $data);
        }
        return $this->reflector->getDto();
    }

    private function hydrateProperty(ReflectionProperty $property, array $data)
    {
        $value = $this->getPropertyValue($property, $data);

        if (is_array($value)) {
            if ($this->reflector->propertyIsDto($property)) {
                $this->reflector->setPropertyValue($property, new ClientDto($value));
            } elseif ($this->reflector->propertyIsCollection($property)) {
                $this->hydrateCollection($property, $value);
            } elseif ($this->reflector->propertyIsArray($property)) {
                $this->reflector->setPropertyValue($property, $value);
            }
        } else {
            $this->reflector->setPropertyValue($property, $value);
        }
    }

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

    private function isPropertyValueProvided(string $propertyName, array $data): bool
    {
        if (!array_key_exists($propertyName, $data)) {
            throw new \Exception(
                'Expected property (' . $propertyName . ') to exist in ' . get_class($this->reflector->getDto())
            );
        }
        return true;
    }

    private function getPropertyValue(ReflectionProperty $property, array $data)
    {
        $propertyName = $property->getName();
        if ($this->isPropertyValueProvided($propertyName, $data)) {
            return $data[$propertyName];
        }
    }
}
