<?php

namespace DtoDragon\Singletons;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Services\Extractor\PropertyExtractors\PropertyExtractorInterface;
use Exception;

/**
 * Singleton to manage an array of property extractors
 * The property extractors will be responsible for extracting properties from a DTO to an array item
 *
 * @package DtoDragon\Singletons
 *
 * @author Matthew Crankshaw
 */
class PropertyExtractorsSingleton extends Singleton
{
    /**
     * The array of property extractors
     *
     * @var PropertyExtractorInterface[] $propertyExtractors
     */
    private array $propertyExtractors = [];

    /**
     * Clear all the extractors managed by this singleton
     *
     * @return void
     */
    public function clear(): void
    {
        $this->propertyExtractors = [];
        DtoServiceProviderSingleton::getInstance()->setBooted(false);
    }

    /**
     * Registers a new property extractor for this singleton to manage
     *
     * @param PropertyExtractorInterface $propertyExtractor
     *
     * @return void
     */
    public function register(PropertyExtractorInterface $propertyExtractor): void
    {
        $this->propertyExtractors[$propertyExtractor->registeredType()] = $propertyExtractor;
    }

    /**
     * Returns true if there is a property extractor for the provided type
     *
     * @param string $type
     *
     * @return bool
     */
    public function hasPropertyExtractor(string $type): bool
    {
        if ($this->isDto($type)) {
            return isset($this->propertyExtractors[DataTransferObject::class]);
        } elseif ($this->isCollection($type)) {
            return isset($this->propertyExtractors[DataTransferObjectCollection::class]);
        }

        if (isset($this->propertyExtractors[$type])) {
            return true;
        }
        return false;
    }

    /**
     * Get the property extractor based on the provided type
     *
     * @param string $type
     *
     * @throws Exception - If a property extractor for the type provided does not exist
     * @return PropertyExtractorInterface
     */
    public function getPropertyExtractor(string $type): PropertyExtractorInterface
    {
        if ($this->isDto($type)) {
            return $this->propertyExtractors[DataTransferObject::class];
        } elseif ($this->isCollection($type)) {
            return $this->propertyExtractors[DataTransferObjectCollection::class];
        }

        if ($this->hasPropertyExtractor($type)) {
            return $this->propertyExtractors[$type];
        }

        throw new Exception('Property extractor was not found for ' . $type . '!');
    }

    /**
     * Check to see if the provided class name is a type of DataTransferObject
     *
     * @param string $type
     *
     * @return bool
     */
    private function isDto(string $type): bool
    {
        return is_subclass_of($type, DataTransferObject::class);
    }

    /**
     * Check to see if the provided class name is a type of DataTransferObjectCollection
     *
     * @param string $type
     *
     * @return bool
     */
    private function isCollection(string $type): bool
    {
        return is_subclass_of($type, DataTransferObjectCollection::class);
    }
}
