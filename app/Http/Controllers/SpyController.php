<?php

namespace App\Http\Controllers;

use App\Application\Actions\CreateSpyAction;
use App\Application\DTOs\SpyDTO;
use App\Application\Queries\ListSpiesQuery;
use App\Application\Requests\SpyCreateRequest;
use App\Application\Resources\SpyResource;
use App\Domain\Models\Spy;
use App\Domain\Services\SpyService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SpyController extends Controller
{
    public function __construct(private readonly SpyService $spyService){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check for unsupported filters - excluding sort parameters
        if (!empty(
            $unsupportedFilters = array_filter(array_diff(
                array_keys($request->query()),
                array_merge(array_keys(Spy::$sortableFields), Spy::$supportedFilters)
            ), fn ($key) => !str_contains($key, 'sortBy') && $key !== 'itemsPerPage' && $key !== 'page')
        ))
            throw new BadRequestHttpException('Unsupported filters: ' . implode(', ', $unsupportedFilters));

        $result = $this->spyService->list(new ListSpiesQuery(
            $request->query('age'),
            $request->query('name'),
            $request->query('sortBy'),
            $request->query('sortByDesc'),
            $request->query('itemsPerPage')
        ));

        return SpyResource::collection($result);
    }

    /**
     * Display the specified resource.
     */
    public function random(Request $request)
    {
        return SpyResource::collection(Spy::query()->limit(5)->inRandomOrder()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpyCreateRequest $request, CreateSpyAction $createSpyAction): SpyResource
    {
        $spyDTO = new SpyDTO(
            $request->validated('name'),
            $request->validated('surname'),
            $request->validated('agency'),
            $request->validated('country_of_operation'),
            $request->validated('date_of_birth'),
            $request->validated('date_of_death')
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
