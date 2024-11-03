<?php

namespace App\Application\Actions;

use App\Application\DTOs\SpyDTO;
use App\Domain\Models\Spy;
use App\Domain\Services\SpyService;

readonly class CreateSpyAction
{
    public function __construct(private SpyService $spyService) {}

    public function execute(SpyDTO $spyData): Spy
    {
        return $this->spyService->create($spyData);
    }
}
