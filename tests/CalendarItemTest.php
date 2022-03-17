<?php

namespace DtoDragon\Test;

use DtoDragon\Test\dtos\CalendarItemDto;
use DtoDragon\Test\dtos\Date;
use Exception;

class CalendarItemTest extends DtoDragonTestCase
{
    public function providerCalenderItemDto(): array
    {
        return [
            'minimum calendar item' => [
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => null,
                    'services' => null,
                    'tags' => null,
                    'date' => null,
                ],
                [
                    'id' => 10,
                    'name' => 'hello world',
                    'client' => null,
                    'services' => null,
                    'tags' => null,
                    'date' => null,
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
                        [
                            'id' => 3,
                            'type' => 'travel',
                        ]
                    ],
                    'tags' => [
                        'test 1',
                        'test 2',
                    ],
                    'date' => new Date(11, 11, 2022),
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
                        [
                            'id' => 3,
                            'type' => 'travel',
                        ]
                    ],
                    'tags' => [
                        'test 1',
                        'test 2',
                    ],
                    'date' => '11-11-2022',
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

        $this->assertIsArray($expected);
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
        $this->expectException(Exception::class);
        $calendarItem = new CalendarItemDto(['nonexist' => 'hello']);
    }
}