<?php

namespace DtoDragon\Test;

use PHPUnit\Framework\TestCase;

class DtoDragonTestCase extends TestCase
{
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
}