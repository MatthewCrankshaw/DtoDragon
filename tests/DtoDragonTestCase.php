<?php

namespace DtoDragon\Test;

use DtoDragon\Singletons\CastersSingleton;
use DtoDragon\Singletons\ParsersSingleton;
use DtoDragon\Test\Caster\DateCaster;
use DtoDragon\Test\Parser\DateParser;
use PHPUnit\Framework\TestCase;

class DtoDragonTestCase extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        ParsersSingleton::getInstance()->register(new DateParser());
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
