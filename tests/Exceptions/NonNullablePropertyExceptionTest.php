<?php

namespace DtoDragon\Test\Exceptions;

use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Exceptions\NonNullablePropertyException
 */
class NonNullablePropertyExceptionTest extends DtoDragonTestCase
{
    public function testConstruct(): void
    {
        $expectedMessage = 'Trying to fill property (property name) with a null value when it is not nullable.';
        $expectedCode = 500;
        $exception = new NonNullablePropertyException('property name');

        static::assertSame($expectedMessage, $exception->getMessage());
        static::assertSame($expectedCode, $exception->getCode());
    }
}