<?php

namespace DtoDragon\Test\Services\Extractor;

use DtoDragon\Services\Extractor\DtoExtractor;
use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Services\Extractor\ExtractorFactory
 */
class ExtractorFactoryTest extends DtoDragonTestCase
{
    public function testInvoke(): void
    {
        $factory = new ExtractorFactory();
        $extractor = $factory();

        static::assertInstanceOf(DtoExtractor::class, $extractor);
    }
}