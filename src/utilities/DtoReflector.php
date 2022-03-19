<?php

namespace DtoDragon\utilities;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\interfaces\ReflectorInterface;
use ReflectionClass;
use ReflectionProperty;

/**
 * Class that reports information about the data transfer object class and properties
 *
 * @package DtoDragon\utilities
 *
 * @author Matthew Crankshaw
 */
class DtoReflector implements ReflectorInterface
{
    /**
     * The data transfer object being reported and acted upon
     *
     * @var DataTransferObject
     */
    private DataTransferObject $dto;

    /**
     * The reflection of the data transfer object
     *
     * @var ReflectionClass
     */
    private ReflectionClass $dtoReflection;

    /**
     * Construct the data transfer object reflector
     *
     * @param DataTransferObject $dto
     */
    public function __construct(DataTransferObject $dto)
    {
        $this->dto = $dto;
        $this->dtoReflection = new ReflectionClass($dto);
    }

    /**
     * Get the data transfer object that this reflector is reporting on
     *
     * @return DataTransferObject
     */
    public function getDto(): DataTransferObject
    {
        return $this->dto;
    }

    /**
     * @inheritDoc
     */
    public function getProperties(): array
    {
        return $this->dtoReflection->getProperties();
    }

    /**
     * @inheritDoc
     */
    public function getPropertyValue(ReflectionProperty $property)
    {
        $property->setAccessible(true);
        return $property->getValue($this->dto);
    }

    /**
     * @inheritDoc
     */
    public function setPropertyValue(ReflectionProperty $property, $value): void
    {
        $property->setAccessible(true);
        $property->setValue($this->dto, $value);
    }

    /**
     * Returns true if the reflection property provided is a DTO
     * Otherwise false
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    public function propertyIsDto(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return is_subclass_of($type, DataTransferObject::class);
    }

    /**
     * Returns true if the reflection property provided is a collection
     * Otherwise false
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    public function propertyIsCollection(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return is_subclass_of($type, DataTransferObjectCollection::class);
    }

    /**
     * Returns true if the reflection property provided is an array
     * Otherwise false
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    public function propertyIsArray(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return $type === 'array';
    }
}
