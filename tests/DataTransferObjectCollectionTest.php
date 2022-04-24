<?php

namespace DtoDragon\Test;

use DtoDragon\Test\TestDtos\ServiceCollection;
use DtoDragon\Test\TestDtos\ServiceDto;

/**
 * @covers \DtoDragon\DataTransferObjectCollection
 */
class DataTransferObjectCollectionTest extends DtoDragonTestCase
{
    public function provideCollectionData(): array
    {
        return [
            'simple dto data' => [
                'dto data' => [
                    [
                        'id' => 1,
                        'type' => 'tax',
                        'price' => null,
                    ],
                    [
                        'id' => 2,
                        'type' => 'tax',
                        'price' => 10.0,
                    ],
                    [
                        'id' => 3,
                        'type' => 'tax',
                        'price' => 0.11,
                    ],
                ]
            ],
        ];
    }

    /**
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testCreateCollection(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

        $this->assertInstanceOf(ServiceCollection::class, $collection);
    }

    /**
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testCurrentItem(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

        /** @var ServiceDto $service */
        $service = $collection->current();
        $collection->next();
        $service2 = $collection->current();

        $this->assertSame(1, $service->getId());
        $this->assertSame(2, $service2->getId());
    }

    /**
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testNextItem(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

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
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testKey(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

        $this->assertSame(0, $collection->key());

        $collection->next();

        $this->assertSame(1, $collection->key());

        $collection->next();

        $this->assertSame(2, $collection->key());
    }

    /**
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testValid(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

        $this->assertTrue($collection->valid());
        $collection->next();
        $this->assertTrue($collection->valid());
        $collection->next();
        $this->assertTrue($collection->valid());
        $collection->next();
        $this->assertFalse($collection->valid());
    }

    /**
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testRewind(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

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
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testItems(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

        $actual = $collection->items();

        $this->assertIsArray($actual);
        $this->assertInstanceOf(ServiceDto::class, $actual[0]);
        $this->assertCount(3, $actual);
    }

    /**
     * @dataProvider provideCollectionData
     *
     * @param array $arrayData
     *
     * @return void
     */
    public function testToArray(array $arrayData): void
    {
        $dtos = [];
        foreach ($arrayData as $data) {
            $dtos[] = new ServiceDto($data);
        }
        $collection = new ServiceCollection($dtos);

        $actual = $collection->toArray();

        $this->assertIsArray($actual);
        $this->assertIsArray($actual[0]);
        $this->assertSame($arrayData, $actual);
        $this->assertCount(3, $actual);
    }
}