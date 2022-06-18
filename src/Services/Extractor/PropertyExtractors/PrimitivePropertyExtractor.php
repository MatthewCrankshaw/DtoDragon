<?php

namespace DtoDragon\Services\Extractor\PropertyExtractors;

/**
 * Extractor for the primitive types
 * Primitives will be extracted from a dto property to an array using this extractor
 *
 * @author Matthew Crankshaw
 */
class PrimitivePropertyExtractor extends AbstractPropertyExtractor
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'primitive';
    }
}
