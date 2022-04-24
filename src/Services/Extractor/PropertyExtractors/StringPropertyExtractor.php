<?php

namespace DtoDragon\Services\Extractor\PropertyExtractors;

/**
 * Extractor for the string type
 * Strings will be extracted from a dto property to an array using this extractor
 *
 * @author Matthew Crankshaw
 */
class StringPropertyExtractor extends AbstractPropertyExtractor
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'string';
    }
}
