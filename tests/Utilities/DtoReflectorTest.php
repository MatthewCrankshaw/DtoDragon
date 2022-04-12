<?php

namespace DtoDragon\Test\Utilities;

use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\CalendarItemDto;
use DtoDragon\Test\Dtos\ServiceDto;
use DtoDragon\Test\PropertyHydrator\DatePropertyHydrator;
use DtoDragon\Utilities\DtoReflector;

/**
 * @covers \DtoDragon\Utilities\DtoReflector
 * @package DtoDragon\Test\Utilities
 */
class DtoReflectorTest extends DtoDragonTestCase
{
    public function providerCalenderItemDto(): array
    {
        return [
            'basic calendar item' => [[
                'id' => 10,
                'name' => 'hello world',
                'client' => [
                    'id' => 1,
                    'firstName' => 'Romana',
                    'lastName' => 'Petrie',
                ],
                'services' => [
                    [
                        'id' => 3,
                        'type' => 'travel',
                        'price' => 10.0
                    ]
                ],
                'tags' => [
                    'test 1',
                    'test 2',
                ],
                'date' => '1-1-2000',
                'taxRate' => 77.345
            ]],
        ];
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testGetPropertiesIsArray(array $array): void
    {
        PropertyHydratorsSingleton::getInstance()->register(new DatePropertyHydrator());
        $dto = new CalendarItemDto($array);
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        $this->assertIsArray($properties);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testGetPropertiesCount(array $array): void
    {
        $dto = new CalendarItemDto($array);
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        $this->assertCount(7, $properties);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testGetPropertiesPrivate(array $array): void
    {
        $dto = new CalendarItemDto($array);
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        foreach ($properties as $property) {
            $this->assertTrue($property->isPrivate());
        }
    }

    public function testGetPropertyValue(): void
    {
        $service = new ServiceDto([
            'id' => 1,
            'type' => 'tax',
            'price' => 0.0123,
        ]);
        $reflector = new DtoReflector($service);
        $properties = $reflector->getProperties();
        $id = $reflector->getPropertyValue($properties[0]);
        $type = $reflector->getPropertyValue($properties[1]);

        $this->assertSame(1, $id);
        $this->assertSame('tax', $type);
    }

    public function testSetPropertyValue(): void
    {
        $service = new ServiceDto([
            'id' => 1,
            'type' => 'tax',
            'price' => null,
        ]);

        $reflector = new DtoReflector($service);
        $properties = $reflector->getProperties();
        $reflector->setPropertyValue($properties[0], 10);
        $reflector->setPropertyValue($properties[1], 'service');
        $id = $reflector->getPropertyValue($properties[0]);
        $type = $reflector->getPropertyValue($properties[1]);

        $this->assertSame(10, $id);
        $this->assertSame('service', $type);
    }

    public function providePropertyIsNullable() {
        return [
            'null property' => [
                [
                    'id' => 1,
                    'type' => 'tax',
                    'price' => null,
                ],
                2,
                true
            ],
            'non-null property' => [
                [
                    'id' => 1,
                    'type' => 'tax',
                    'price' => 10,
                ],
                1,
                false
            ]
        ];
    }

    /**
     * @dataProvider providePropertyIsNullable
     *
     * @return void
     */
    public function testPropertyIsNullable(array $data, int $propertyIndex, bool $expected) {
        $service = new ServiceDto($data);

        $reflector = new DtoReflector($service);
        $property = $reflector->getProperties()[$propertyIndex];
        $actual = $reflector->propertyIsNullable($property);

        $this->assertSame($expected, $actual);
    }
}