<?php

namespace App\ValueObjects;

use InvalidArgumentException;

final class Agency
{
    private const VALID_AGENCIES = ['CIA', 'MI6', 'KGB'];

    private string $agency;

    public function __construct(string $agency)
    {
        if (!in_array($agency, self::VALID_AGENCIES)) {
            throw new InvalidArgumentException("Invalid agency: {$agency}");
        }
        $this->agency = $agency;
    }

    public function getAgency(): string
    {
        return $this->agency;
    }

    public function equals(Agency $other): bool
    {
        return $this->agency === $other->agency;
    }
}
