<?php

namespace DtoDragon\utilities;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\interfaces\DtoReflectorInterface;
use ReflectionClass;
use ReflectionProperty;

class DtoReflector implements DtoReflectorInterface
{
    private DataTransferObject $dto;

    private ReflectionClass $dtoReflection;

    public function __construct(DataTransferObject $dto)
    {
        $this->dto = $dto;
        $this->dtoReflection = $this->createReflection();
    }

    private function createReflection(): ReflectionClass
    {
        return new ReflectionClass($this->dto);
    }

    /**
     * Get the reflection properties for the data transfer object
     *
     * @return ReflectionProperty[]
     */
    public function getProperties(): array
    {
        return $this->dtoReflection->getProperties();
    }

    /**
     * Gets the value of a reflected class regardless of accessibility
     *
     * @param ReflectionProperty $property
     *
     * @return mixed
     */
    public function getProperty(ReflectionProperty $property)
    {
        $property->setAccessible(true);
        return $property->getValue($this->dto);
    }

    /**
     * @param ReflectionProperty $property
     *
     * @param mixed $value
     */
    public function setProperty(ReflectionProperty $property, $value)
    {
        $property->setAccessible(true);
        $property->setValue($this->dto, $value);
    }

    public function propertyIsDto(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return $this->isDataTransferObject($type);
    }

    public function propertyIsCollection(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return $this->isCollection($type);
    }

    public function propertyIsArray(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return $type === 'array';
    }

    private function isDataTransferObject($object): bool
    {
        return is_subclass_of($object, DataTransferObject::class);
    }

    private function isCollection($object): bool
    {
        return is_subclass_of($object, DataTransferObjectCollection::class);
    }
}