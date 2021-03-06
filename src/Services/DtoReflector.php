<?php

namespace DtoDragon\Services;

use DtoDragon\DataTransferObject;
use ReflectionClass;
use ReflectionProperty;

/**
 * Class that reports information about the data transfer object class and properties\utilities
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
        return $this->dtoReflection->getProperties(
            ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED
        );
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
     * Check to see if a given property is nullable
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    public function propertyIsNullable(ReflectionProperty $property): bool
    {
        return $property->getType()->allowsNull();
    }
}
