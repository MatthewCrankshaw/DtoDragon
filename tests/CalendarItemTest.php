<?php

namespace DtoDragon\Test;

use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyDataNotProvidedException;
use DtoDragon\Test\Dtos\CalendarItemDto;

class CalendarItemTest extends DtoDragonTestCase
{
    public function providerCalenderItemDto(): array
    {
        $serviceA = [
            'id' => 1,
            'type' => 'travel',
        ];
        $serviceB = [
            'id' => 2,
            'type' => 'a given service',
        ];
        $serviceC = [
            'id' => 3,
            'type' => 'additional charges',
        ];

        return [
            'minimum calendar item' => [
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => null,
                    'services' => null,
                    'tags' => null,
                    'date' => null,
                    'taxRate' => 1.1234
                ],
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => null,
                    'services' => null,
                    'tags' => null,
                    'date' => null,
                    'taxRate' => 1.1234
                ],
            ],
            'full calendar item' => [
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => [
                        'id' => 1,
                        'firstName' => 'Romana',
                        'lastName' => 'Petrie',
                    ],
                    'services' => [
                        $serviceA
                    ],
                    'tags' => [
                        'test 1',
                        'test 2',
                    ],
                    'date' => '11-11-2022',
                    'taxRate' => 12324.999
                ],
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => [
                        'id' => 1,
                        'firstName' => 'Romana',
                        'lastName' => 'Petrie',
                    ],
                    'services' => [
                        $serviceA
                    ],
                    'tags' => [
                        'test 1',
                        'test 2',
                    ],
                    'date' => '11-11-2022',
                    'taxRate' => 12324.999
                ],
            ],
            'calendar item many services' => [
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => null,
                    'services' => [
                        $serviceA,
                        $serviceB,
                        $serviceC,
                    ],
                    'tags' => null,
                    'date' => '14-12-2019',
                    'taxRate' => 33.33
                ],
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => null,
                    'services' => [
                        $serviceA,
                        $serviceB,
                        $serviceC,
                    ],
                    'tags' => null,
                    'date' => '14-12-2019',
                    'taxRate' => 33.33
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testCalendarItemDtoToArray(array $data, array $expected): void
    {
        $calendarItem = new CalendarItemDto($data);

        $array = $calendarItem->toArray();

        $this->assertIsArray($array);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testCalendarItemDtoToArraySame(array $data, array $expected): void
    {
        $calendarItem = new CalendarItemDto($data);
        $actual = $calendarItem->toArray();

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testCalendarItemHydrate(array $data, array $expected): void
    {
        $calendarItem = new CalendarItemDto($data);
        $this->assertInstanceOf(CalendarItemDto::class, $calendarItem);
    }

    public function testCalendarItemHydrateNonExistantProperty(): void
    {
        $this->expectException(PropertyDataNotProvidedException::class);
        $calendarItem = new CalendarItemDto(['nonexist' => 'hello']);
    }

    public function testCalendarItemNonNullableProperty(): void
    {
        $this->expectException(NonNullablePropertyException::class);
        $calendarItem = new CalendarItemDto([
            'id' => null,
            'name' => 'hello world',
            'client' => null,
            'services' => null,
            'tags' => null,
            'date' => null,
            'taxRate' => 1.1234
        ]);
    }
}