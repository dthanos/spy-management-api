<?php

namespace App\Domain\ValueObjects;

use app\Domain\Enums\Agency as AgencyEnum;
use InvalidArgumentException;

final class Agency
{
    private string $agency;

    public function __construct(string $agency)
    {
        if (!in_array($agency, array_column(AgencyEnum::cases(), 'value'))) {
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
