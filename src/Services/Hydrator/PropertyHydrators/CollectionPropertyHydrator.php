<?php

namespace DtoDragon\Services\Hydrator\PropertyHydrators;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Services\Hydrator\DtoHydratorInterface;
use ReflectionProperty;

/**
 * Property hydrator that converts array data to a data transfer object collection
 *
 * @author Matthew Crankshaw
 */
class CollectionPropertyHydrator implements PropertyHydratorInterface
{
    public DtoHydratorInterface $dtoHydrator;

    public function __construct(DtoHydratorInterface $dtoHydrator)
    {
        $this->dtoHydrator = $dtoHydrator;
    }

    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return DataTransferObjectCollection::class;
    }

    /**
     * Parse an array of data to a DataTransferObjectCollection
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return DataTransferObjectCollection
     */
    public function hydrate(ReflectionProperty $property, $value)
    {
        $collection = $this->newCollection($property);
        foreach ($value as $item) {
            $dto = $this->hydrateDto($collection, $item);
            $collection->append($dto);
        }
        return $collection;
    }

    protected function newCollection(ReflectionProperty $property): DataTransferObjectCollection
    {
        $propertyType = $property->getType();
        $collectionClass = $propertyType->getName();
        return new $collectionClass();
    }

    protected function hydrateDto(DataTransferObjectCollection $collection, array $data): DataTransferObject
    {
        $dtoType = $collection->dtoType();
        return $this->dtoHydrator->hydrate(new $dtoType(), $data);
    }
}
