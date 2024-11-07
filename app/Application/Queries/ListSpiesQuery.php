<?php

namespace App\Application\Queries;

readonly class ListSpiesQuery
{
    public function __construct(
        public ?string $age = null,
        public ?string $name = null,
        public ?string $sortBy = null,
        public ?string $sortByDesc = null,
        public ?int $itemsPerPage = null
    ){}
}
