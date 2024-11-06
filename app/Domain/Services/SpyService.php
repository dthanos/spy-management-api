<?php

namespace App\Domain\Services;

use App\Application\DTOs\SpyDTO;
use App\Application\Queries\ListSpiesQuery;
use App\Domain\Models\Spy;
use App\Infrastructure\Repositories\SpyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class SpyService
{
    public function __construct(private SpyRepository $spyRepository) {}

    public function create(SpyDTO $spyData): Spy
    {
        return $this->spyRepository->create([
            'name' => $spyData->name,
            'surname' => $spyData->surname,
            'agency' => $spyData->agency,
            'date_of_birth' => $spyData->date_of_birth,
            'date_of_death' => $spyData->date_of_death,
        ]);
    }
    public function list(ListSpiesQuery $query): JsonResponse|LengthAwarePaginator
    {
        return $this->spyRepository->list(
            $query->age,
            $query->name,
            $query->sortBy,
            $query->sortByDesc,
            $query->itemsPerPage,
        );
    }
}
