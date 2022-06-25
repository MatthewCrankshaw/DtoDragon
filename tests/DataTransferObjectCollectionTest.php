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
        static::assertSame(0, $actual);

        $collection->next();

        $actual = $this->getProtectedProperty($collection, 'position');
        static::assertSame(1, $actual);

        $collection->next();

        $actual = $this->getProtectedProperty($collection, 'position');
        static::assertSame(2, $actual);
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

        static::assertSame(0, $collection->key());

        $collection->next();

        static::assertSame(1, $collection->key());

        $collection->next();

        static::assertSame(2, $collection->key());
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

        static::assertTrue($collection->valid());
        $collection->next();
        static::assertTrue($collection->valid());
        $collection->next();
        static::assertTrue($collection->valid());
        $collection->next();
        static::assertFalse($collection->valid());
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
        static::assertSame(0, $actual);

        $collection->next();
        $collection->next();
        $collection->rewind();
        $actual = $this->getProtectedProperty($collection, 'position');
        static::assertSame(0, $actual);
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

        static::assertIsArray($actual);
        static::assertInstanceOf(DataTransferObject::class, $actual[0]);
        static::assertCount(3, $actual);
    }

    public function testAppend(): void
    {
        $dto = $this->createTestDto();
        $collection = $this->createTestDtoCollection();

        static::assertEmpty($collection->items());
        $collection->append($dto);
        static::assertCount(1, $collection->items());

        $actual = $collection->items();
        static::assertSame([$dto], $actual);
    }
}