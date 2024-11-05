<?php

namespace App\Domain\Services;

use App\Application\DTOs\SpyDTO;
use App\Domain\Models\Spy;
use App\Infrastructure\Repositories\SpyRepository;

readonly class SpyService
{
    public function __construct(private SpyRepository $spyRepository) {}

    public function create(SpyDTO $spyData): Spy
    {
        return $this->spyRepository->create([
            'name' => $spyData->name,
            'surname' => $spyData->surname,
            'agency' => $spyData->agency,
            'date_of_birth' => $spyData->dateOfBirth,
            'date_of_death' => $spyData->dateOfDeath,
        ]);
    }
}
