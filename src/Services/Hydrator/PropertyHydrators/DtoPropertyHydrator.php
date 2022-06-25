<?php

namespace DtoDragon\Services\Hydrator\PropertyHydrators;

use DtoDragon\DataTransferObject;
use DtoDragon\Services\Hydrator\DtoHydratorInterface;
use ReflectionProperty;

/**
 * Property hydrator that converts array data to a data transfer object
 *
 * @author Matthew Crankshaw
 */
class DtoPropertyHydrator implements PropertyHydratorInterface
{
    protected DtoHydratorInterface $hydrator;

    public function __construct(DtoHydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return DataTransferObject::class;
    }

    /**
     * Hydrate DataTransferObject property from an array of data
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return DataTransferObject
     */
    public function hydrate(ReflectionProperty $property, $value): DataTransferObject
    {
        $dtoType = $property->getType()->getName();
        $dto = $this->createDto($dtoType);
        return $this->hydrator->hydrate($dto, $value);
    }

    protected function createDto(string $dtoClass): DataTransferObject
    {
        return new $dtoClass();
    }
}
