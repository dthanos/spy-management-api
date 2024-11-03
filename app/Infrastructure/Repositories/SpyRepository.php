<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Spy;

class SpyRepository
{
    public function create(array $data): Spy
    {
        return Spy::create($data);
    }
}
