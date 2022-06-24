<?php

namespace DtoDragon\Test;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Singletons\DtoServiceProviderSingleton;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

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
        $class = new ReflectionClass($object);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    public function getProtectedProperty($object, string $property)
    {
        $class = new ReflectionClass($object);
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    public function setReflectionPropertyValue($object, string $property, $value): void
    {
        $class = new ReflectionClass($object);
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    public function createTestDto(): DataTransferObject
    {
        return new class extends DataTransferObject {
            protected int $id;

            protected ?string $type;

            public function getId(): int
            {
                return $this->id;
            }

            public function setId(int $id): self
            {
                $this->id = $id;
                return $this;
            }

            public function getType(): ?string
            {
                return $this->type;
            }

            public function setType(?string $type): self
            {
                $this->type = $type;
                return $this;
            }
        };
    }

    public function createTestDtoCollection(array $items = []): DataTransferObjectCollection
    {
        return new class($items) extends DataTransferObjectCollection {
            public static function dtoType(): string
            {
                return 'type';
            }
        };
    }
}
