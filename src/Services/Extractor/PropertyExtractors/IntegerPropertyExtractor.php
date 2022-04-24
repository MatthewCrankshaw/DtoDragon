<?php

namespace DtoDragon\Services\Extractor\PropertyExtractors;

/**
 * Extractor for the integer type
 * Integers will be extracted from a dto property to an array using this extractor
 *
 * @author Matthew Crankshaw
 */
class IntegerPropertyExtractor extends AbstractPropertyExtractor
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'int';
    }
}
