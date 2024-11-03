<?php

namespace App\Domain\Services;

use App\Application\DTOs\SpyDTO;
use App\Domain\Models\Spy;
use App\Domain\ValueObjects\FullName;
use App\Domain\Enums\Agency;
use App\Infrastructure\Repositories\SpyRepository;

readonly class SpyService
{
    public function __construct(private SpyRepository $spyRepository) {}

    public function create(SpyDTO $spyData): Spy
    {
        // Convert DTO properties to value objects if needed
//        $fullName = new FullName($spyData->name, $spyData->surname);
//        $agency = Agency::from($spyData->agency);

        // Create Spy instance and save it to the database
        return $this->spyRepository->create([
            'name' => $spyData->name,
            'surname' => $spyData->surname,
            'agency' => $spyData->agency,
            'date_of_birth' => $spyData->dateOfBirth,
            'date_of_death' => $spyData->dateOfDeath,
        ]);
    }
}
