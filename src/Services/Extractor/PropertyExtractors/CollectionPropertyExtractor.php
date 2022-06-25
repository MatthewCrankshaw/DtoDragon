<?php

namespace DtoDragon\Services\Extractor\PropertyExtractors;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Services\Extractor\DtoExtractor;
use ReflectionProperty;

/**
 * Extractor for the dto collection property type
 * Subclasses of collection dto's will be extracted from a parent dto to an array using this extractor
 *
 * @author Matthew Crankshaw
 */
class CollectionPropertyExtractor extends AbstractPropertyExtractor
{
    protected DtoExtractor $extractor;

    public function __construct(DtoExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return DataTransferObjectCollection::class;
    }

    /**
     * Extract the values from a given dto collection to an array
     *
     * @param DataTransferObject $dto
     * @param ReflectionProperty $property
     *
     * @return array
     */
    public function extract(DataTransferObject $dto, ReflectionProperty $property)
    {
        /** @var DataTransferObjectCollection|null $collection */
        $collection = $property->getValue($dto);
        if (is_null($collection)) {
            return null;
        }

        $data = [];
        foreach ($collection->items() as $dto) {
            $data[] = $this->extractor->extract($dto);
        }

        return $data;
    }
}
