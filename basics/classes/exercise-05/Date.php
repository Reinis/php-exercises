<?php

namespace Date;

use InvalidArgumentException;

class Date
{
    private int $year;
    private int $month;
    private int $day;

    public function __construct(int $year, int $month, int $day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public function displayDate(): string
    {
        return sprintf("%02d/%02d/%4d", $this->getMonth(), $this->getDay(), $this->getYear());
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setMonth(int $month): void
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException("Invalid month: {$month}");
        }

        $this->month = $month;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function setDay(int $day): void
    {
        if ($day < 1 || $day > 31) {
            throw new InvalidArgumentException("Invalid day: {$day}");
        }

        $this->day = $day;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}
