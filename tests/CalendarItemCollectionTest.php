<?php

namespace DtoDragon\Test;

use DtoDragon\Test\dtos\CalendarItemCollection;
use DtoDragon\Test\dtos\CalendarItemDto;

class CalendarItemCollectionTest extends DtoDragonTestCase
{
    public function testEmptyCollection(): void
    {
        $collection = new CalendarItemCollection([]);
        $this->assertEmpty($collection->items());
    }

    public function testIsNotAnArrayOfDtos(): void
    {
        $this->expectException(\Exception::class);
        $collection = new CalendarItemCollection([1, 2, 3]);
    }

    public function provideCalendarItemCollection(): array
    {
        return [
            'simple' => [
                new CalendarItemDto([
                    'id' => 1,
                    'name' => 'test 1',
                    'client' => null,
                    'services' => null,
                    'tags' => null,
                ]),
            ],
        ];
    }

    /**
     * @dataProvider provideCalendarItemCollection
     */
    public function testIsAnArrayOfCalendarItems(CalendarItemDto $calendarItem): void
    {
        $calendarItems = [
            $calendarItem,
            $calendarItem,
            $calendarItem,
        ];

        $collection = new CalendarItemCollection($calendarItems);

        $this->assertCount(3, $collection->items());
    }
}