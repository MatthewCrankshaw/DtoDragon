<?php

namespace DtoDragon\Test\Exceptions;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Exceptions\PropertyExtractorNotFoundException
 */
class PropertyExtractorNotFoundExceptionTest extends DtoDragonTestCase
{
    public function testConstruct(): void
    {
        $expectedMessage = 'Expected a property extractor for type (type). '
            . 'Define a new property extractor and register it to the PropertyExtractorSingleton.';
        $expectedCode = 500;
        $exception = new PropertyExtractorNotFoundException('type');

        static::assertSame($expectedMessage, $exception->getMessage());
        static::assertSame($expectedCode, $exception->getCode());
    }
}