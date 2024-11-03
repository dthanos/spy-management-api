<?php

namespace App\Http\Controllers;

use App\Application\Actions\CreateSpyAction;
use App\Application\DTOs\SpyDTO;
use App\Http\Requests\SpyCreateRequest;
use App\Http\Resources\SpyResource;
use App\Domain\Models\Spy;
use Illuminate\Http\Request;

class SpyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $requestData = $request->all();


        // Define allowed sortable fields
        $sortableFields = [
            'full_name' => ['name', 'surname'],
            'date_of_birth' => 'date_of_birth',
            'date_of_death' => 'date_of_death',
        ];
        $supportedFilters = ['age', 'name'];

        $query = Spy::query();

        // Multi-field sorting
        if ($request->has('sortBy')) {
            foreach (explode(',', $request->input('sortBy')) as $sortField) {
                if (array_key_exists($sortField, $sortableFields)) {
                    if ($sortField === 'full_name') {
                        $query->orderBy('name')->orderBy('surname');
                    } else {
                        $query->orderBy($sortableFields[$sortField]);
                    }
                }
            }
        }
        if ($request->has('sortByDesc')) {
            foreach (explode(',', $request->input('sortByDesc')) as $sortField) {
                if (array_key_exists($sortField, $sortableFields)) {
                    if ($sortField === 'full_name') {
                        $query->orderByDesc('name')->orderByDesc('surname');
                    } else {
                        $query->orderByDesc($sortableFields[$sortField]);
                    }
                }
            }
        }
        // Filters
        if ($request->has('age')) {
            $age = $request->input('age');

            if (is_numeric($age)) {
                $fromDate = now()->subYears($age + 1)->addDay();
                $toDate = now()->subYears($age);

                $query->whereBetween('date_of_birth', [$fromDate, $toDate]);
            } elseif (strpos($age, '-') !== false) {
                [$minAge, $maxAge] = explode('-', $age);
                $fromDate = now()->subYears($maxAge + 1)->addDay();
                $toDate = now()->subYears($minAge);

                $query->whereBetween('date_of_birth', [$fromDate, $toDate]);
            } else {
                return response()->json(['error' => 'Invalid age filter format. Use a number or range (e.g., 25 or 20-30).'], 400);
            }
        }
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                    ->orWhere('surname', 'like', "%{$name}%");
            });
        }
        // Check for unsupported filters - excluding sort parameters
        $unsupportedFilters = array_filter(array_diff(
            array_keys($request->query()),
            array_merge(array_keys($sortableFields), $supportedFilters)
        ), fn ($key) => !str_contains($key, 'sortBy') && $key !== 'itemsPerPage');
        if (!empty($unsupportedFilters)) {
            return response()->json([
                'error' => 'Unsupported filters: ' . implode(', ', $unsupportedFilters)
            ], 400);
        }

        $result = $query->paginate($request->has('itemsPerPage') ? $request->itemsPerPage : 5);

        return SpyResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpyCreateRequest $request, CreateSpyAction $createSpyAction): SpyResource
    {
        $spyDTO = new SpyDTO(
            $request->input('name'),
            $request->input('surname'),
            $request->input('agency'),
            $request->input('country_of_operation'),
            $request->input('date_of_birth'),
            $request->input('date_of_death')
        );

        $spy = $createSpyAction->execute($spyDTO);

        return SpyResource::make($spy);
    }

    /**
     * Display the specified resource.
     */
    public function show(Spy $spy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spy $spy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spy $spy)
    {
        //
    }
}
