<?php

namespace DtoDragon\Test\Services\Extractor\PropertyExtractors;

use DtoDragon\Services\Extractor\PropertyExtractors\PrimitivePropertyExtractor;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Services\Extractor\PropertyExtractors\PrimitivePropertyExtractor
 */
class PrimitivePropertyExtractorTest extends DtoDragonTestCase
{
    public function testRegisterType(): void
    {
        $extractor = new PrimitivePropertyExtractor();
        static::assertSame('primitive', $extractor->registeredType());
    }
}