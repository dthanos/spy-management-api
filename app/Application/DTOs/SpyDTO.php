<?php

namespace App\Application\DTOs;

class SpyDTO
{
    public function __construct(
        public string $name,
        public string $surname,
        public string $agency,
        public ?string $country_of_operation,
        public string $dateOfBirth,
        public ?string $dateOfDeath = null
    ) {}
}
