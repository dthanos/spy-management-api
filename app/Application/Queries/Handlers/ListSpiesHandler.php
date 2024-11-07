<?php

namespace App\Application\Queries\Handlers;

use App\Application\Queries\ListSpiesQuery;
use App\Domain\Services\SpyService;

class ListSpiesHandler
{

    public function __construct(private readonly SpyService $spyService){}

    public function handle(ListSpiesQuery $query): void
    {
        $result = $this->spyService->list($query);
    }
}
