<?php

namespace App\Domain\ValueObjects;

use DateTime;
use InvalidArgumentException;

final class Date
{
    private DateTime $date;

    public function __construct(string $date)
    {
        $parsedDate = DateTime::createFromFormat('Y-m-d', $date);

        if ($parsedDate === false) {
            throw new InvalidArgumentException("Invalid date format: {$date}");
        }

        $this->date = $parsedDate;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function isBefore(Date $other): bool
    {
        return $this->date < $other->date;
    }

    public function isAfter(Date $other): bool
    {
        return $this->date > $other->date;
    }

    public function equals(Date $other): bool
    {
        return $this->date == $other->date;
    }

    public function toString(): ?string
    {
        return $this?->date->format('Y-m-d') ?? null;
    }
}
