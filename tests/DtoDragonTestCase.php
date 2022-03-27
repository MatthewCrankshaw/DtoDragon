<?php

namespace DtoDragon\Test;

use DtoDragon\Singletons\CastersSingleton;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\Caster\DateCaster;
use DtoDragon\Test\PropertyHydrator\DatePropertyHydrator;
use PHPUnit\Framework\TestCase;

class DtoDragonTestCase extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        PropertyHydratorsSingleton::getInstance()->register(new DatePropertyHydrator());
        CastersSingleton::getInstance()->register(new DateCaster());
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
}
