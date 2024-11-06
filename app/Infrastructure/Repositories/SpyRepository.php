<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Spy;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class SpyRepository
{
    public function create(array $data): Spy
    {
        return Spy::create($data);
    }
    public function list(?string $age, ?string $name, ?string $sortBy, ?string $sortByDesc, ?int $itemsPerPage): LengthAwarePaginator|JsonResponse
    {
        $sortableFields = Spy::$sortableFields;

        $query = Spy::query();

        // Multi-field sorting
        if ($sortBy) {
            foreach (explode(',', $sortBy) as $sortField) {
                if (array_key_exists($sortField, $sortableFields))
                    if ($sortField === 'full_name')
                        $query->orderBy('name')->orderBy('surname');
                    else
                        $query->orderBy($sortableFields[$sortField]);
            }
        }
        if ($sortByDesc) {
            foreach (explode(',', $sortByDesc) as $sortField) {
                if (array_key_exists($sortField, $sortableFields))
                    if ($sortField === 'full_name')
                        $query->orderByDesc('name')->orderByDesc('surname');
                    else
                        $query->orderByDesc($sortableFields[$sortField]);
            }
        }
        // Filters
        if ($age) {
            if (is_numeric($age)) {
                $fromDate = now()->subYears($age + 1)->addDay();
                $toDate = now()->subYears($age);
                $query->whereBetween('date_of_birth', [$fromDate, $toDate]);
            } elseif (str_contains($age, '-')) {
                [$minAge, $maxAge] = explode('-', $age);
                $fromDate = now()->subYears($maxAge + 1)->addDay();
                $toDate = now()->subYears($minAge);
                $query->whereBetween('date_of_birth', [$fromDate, $toDate]);
            } else
                return response()->json(['error' => 'Invalid age filter format. Use a number or range (e.g., 25 or 20-30).'], 400);
        }
        if ($name) {
            $query->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                    ->orWhere('surname', 'like', "%{$name}%");
            });
        }

        return $query->paginate($itemsPerPage ?? 5);
    }
}
