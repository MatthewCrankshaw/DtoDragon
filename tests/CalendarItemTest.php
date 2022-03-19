<?php

namespace DtoDragon\Test;

use DtoDragon\Singletons\CastersSingleton;
use DtoDragon\Test\Caster\DateCaster;
use DtoDragon\Test\Dtos\CalendarItemDto;
use DtoDragon\Test\Dtos\Date;
use Exception;

class CalendarItemTest extends DtoDragonTestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        CastersSingleton::getInstance()->register(new DateCaster());
    }

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
                        $serviceA
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
                        $serviceA
                    ],
                    'tags' => [
                        'test 1',
                        'test 2',
                    ],
                    'date' => '11-11-2022',
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
                    'date' => new Date(14, 12, 2019),
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
        $this->expectException(Exception::class);
        $calendarItem = new CalendarItemDto(['nonexist' => 'hello']);
    }
}