<?php

namespace DtoDragon\Test;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;

/**
 * @covers \DtoDragon\DataTransferObjectCollection
 */
class DataTransferObjectCollectionTest extends DtoDragonTestCase
{
    /**
     * @return void
     */
    public function testConstructEmptyCollection(): void
    {
        $collection = $this->createTestDtoCollection();

        static::assertInstanceOf(DataTransferObjectCollection::class, $collection);
        static::assertEmpty($collection->items());
        static::assertSame($collection->key(), 0);
    }

    /**
     * @return void
     */
    public function testCurrentItem(): void
    {
        $dtos = [];
        for ($i = 1; $i < 3; $i++) {
            $dto = $this->createTestDto();
            $dto->setId($i);
            $dtos[] = $dto;
        }

        $collection = $this->createTestDtoCollection($dtos);

        $dto1 = $collection->current();
        $collection->next();
        $dto2 = $collection->current();

        static::assertSame(1, $dto1->getId());
        static::assertSame(2, $dto2->getId());
    }

    /**
     *
     * @return void
     */
    public function testNextItem(): void
    {
        $dtos = [];
        for ($i = 1; $i < 3; $i++) {
            $dto = $this->createTestDto();
            $dto->setId($i);
            $dtos[] = $dto;
        }

        $collection = $this->createTestDtoCollection($dtos);

        $actual = $this->getProtectedProperty($collection, 'position');
        $this->assertSame(0, $actual);

        $collection->next();

        $actual = $this->getProtectedProperty($collection, 'position');
        $this->assertSame(1, $actual);

        $collection->next();

        $actual = $this->getProtectedProperty($collection, 'position');
        $this->assertSame(2, $actual);
    }

    /**
     *
     * @return void
     */
    public function testKey(): void
    {
        $dtos = [];
        for ($i = 1; $i < 3; $i++) {
            $dto = $this->createTestDto();
            $dto->setId($i);
            $dtos[] = $dto;
        }

        $collection = $this->createTestDtoCollection($dtos);

        $this->assertSame(0, $collection->key());

        $collection->next();

        $this->assertSame(1, $collection->key());

        $collection->next();

        $this->assertSame(2, $collection->key());
    }

    /**
     * @return void
     */
    public function testValid(): void
    {
        $dtos = [];
        for ($i = 1; $i < 4; $i++) {
            $dto = $this->createTestDto();
            $dto->setId($i);
            $dtos[] = $dto;
        }

        $collection = $this->createTestDtoCollection($dtos);

        $this->assertTrue($collection->valid());
        $collection->next();
        $this->assertTrue($collection->valid());
        $collection->next();
        $this->assertTrue($collection->valid());
        $collection->next();
        $this->assertFalse($collection->valid());
    }

    /**
     * @return void
     */
    public function testRewind(): void
    {
        $dtos = [];
        for ($i = 1; $i < 4; $i++) {
            $dto = $this->createTestDto();
            $dto->setId($i);
            $dtos[] = $dto;
        }

        $collection = $this->createTestDtoCollection($dtos);

        $collection->rewind();
        $actual = $this->getProtectedProperty($collection, 'position');
        $this->assertSame(0, $actual);

        $collection->next();
        $collection->next();
        $collection->rewind();
        $actual = $this->getProtectedProperty($collection, 'position');
        $this->assertSame(0, $actual);
    }

    /**
     * @return void
     */
    public function testItems(): void
    {
        $dtos = [];
        for ($i = 1; $i < 4; $i++) {
            $dto = $this->createTestDto();
            $dto->setId($i);
            $dtos[] = $dto;
        }

        $collection = $this->createTestDtoCollection($dtos);

        $actual = $collection->items();

        $this->assertIsArray($actual);
        $this->assertInstanceOf(DataTransferObject::class, $actual[0]);
        $this->assertCount(3, $actual);
    }
}