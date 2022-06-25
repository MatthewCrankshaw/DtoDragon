<?php

namespace DtoDragon\Test\Exceptions;

use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Exceptions\PropertyHydratorNotFoundException
 */
class PropertyHydratorNotFoundExceptionTest extends DtoDragonTestCase
{
    public function testConstruct(): void
    {
        $expectedMessage = 'Expected a property hydrator for type (type). '
            . 'Define a new property hydrator and register it to the PropertyHydratorSingleton.';
        $expectedCode = 500;
        $exception = new PropertyHydratorNotFoundException('type');

        static::assertSame($expectedMessage, $exception->getMessage());
        static::assertSame($expectedCode, $exception->getCode());
    }
}