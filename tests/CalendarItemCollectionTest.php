<?php

namespace DtoDragon\Test;

use DtoDragon\Test\Dtos\CalendarItemCollection;
use DtoDragon\Test\Dtos\CalendarItemDto;

class CalendarItemCollectionTest extends DtoDragonTestCase
{
    public function testEmptyCollection(): void
    {
        $collection = new CalendarItemCollection([]);
        $this->assertEmpty($collection->items());
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
                    'date' => '1-2-1992',
                    'taxRate' => 33.33
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