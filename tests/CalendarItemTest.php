<?php

namespace DtoDragon\Test;

use DtoDragon\Test\dtos\CalendarItemDto;
use Exception;

class CalendarItemTest extends DtoDragonTestCase
{
    public function providerCalenderItemDto(): array
    {
        return [
            'minimum calendar item' => [[
                'id' => 10,
                'name' => 'hello world',
                'client' => null,
                'services' => null,
                'tags' => null
            ]],
            'full calendar item' => [[
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
                ]
            ]],
        ];
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testCalendarItemDtoToArray(array $data): void
    {
        $calendarItem = new CalendarItemDto($data);

        $array = $calendarItem->toArray();

        $this->assertIsArray($array);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testCalendarItemDtoToArraySame(array $data): void
    {
        $calendarItem = new CalendarItemDto($data);
        $actual = $calendarItem->toArray();

        $this->assertSame($data, $actual);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testCalendarItemHydrate(array $data): void
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