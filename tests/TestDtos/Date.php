<?php

namespace DtoDragon\Test\TestDtos;

class Date
{
    public int $day;
    public int $month;
    public int $year;

    public function __construct(int $day, int $month, int $year)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }
}