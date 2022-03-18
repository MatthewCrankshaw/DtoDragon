<?php

namespace DtoDragon\utilities;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\interfaces\ReflectorInterface;
use ReflectionClass;
use ReflectionProperty;

class DtoReflector implements ReflectorInterface
{
    private DataTransferObject $dto;

    private ReflectionClass $dtoReflection;

    public function __construct(DataTransferObject $dto)
    {
        $this->dto = $dto;
        $this->dtoReflection = $this->createClassReflection();
    }

    private function createClassReflection(): ReflectionClass
    {
        return new ReflectionClass($this->dto);
    }

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

    public function propertyIsDto(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return is_subclass_of($type, DataTransferObject::class);
    }

    public function propertyIsCollection(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return is_subclass_of($type, DataTransferObjectCollection::class);
    }

    public function propertyIsArray(ReflectionProperty $property): bool
    {
        $type = $property->getType()->getName();
        return $type === 'array';
    }
}