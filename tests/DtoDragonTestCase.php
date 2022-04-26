<?php

namespace DtoDragon\Test;

use DtoDragon\Singletons\DtoServiceProviderSingleton;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DtoDragon\DataTransferObject
 */
class DtoDragonTestCase extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        DtoServiceProviderSingleton::getInstance()->clear();
        DtoServiceProviderSingleton::getInstance()->boot();
    }

    public function callProtectedMethod($object, string $name, array $args)
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    public function getProtectedProperty($object, string $property)
    {
        $class = new \ReflectionClass($object);
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    public function setReflectionPropertyValue($object, string $property, $value): void
    {
        $class = new \ReflectionClass($object);
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
