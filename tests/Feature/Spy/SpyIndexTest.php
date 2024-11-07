<?php

namespace Spy;

use App\Domain\Models\Spy;
use Database\Seeders\SpySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpyIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $seeder = new SpySeeder();
        $seeder->run();
    }

    public function test_index_endpoint_retrieves_spies_paginated_sorted_and_filtered()
    {
        $response = $this->get('/api/spy?page=1&itemsPerPage=2&sortBy=full_name&sortByDesc=date_of_birth&name=bo');

        $response->assertStatus(200);
        $response->assertJsonStructure([// Testing structure
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'surname',
                    'full_name',
                    'agency',
                    'country_of_operation',
                    'date_of_birth',
                    'date_of_death'
                ]
            ],
            'links',
            'meta'
        ]);
        // Testing pagination
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('meta.current_page', 1);
        $response->assertJsonPath('meta.per_page', 2);

        $sortedDates = Spy::query()
            ->where(fn ($q) => // Applying filtering
                $q->where('name', 'like', "%bo%")->orWhere('surname', 'like', "%bo%")
            )
            ->orderBy('name')// Applying sorting
            ->orderBy('surname')
            ->orderByDesc('date_of_birth')
            ->offset(0)// Simulating pagination
            ->limit(2)
            ->pluck('id');
        $responseData = collect($response->json('data'))->pluck('id');

        $this->assertEquals($sortedDates, $responseData);
    }

    public function test_random_endpoint_retrieves_random_spies()
    {
        $response = $this->get('/api/spy/random');

        $response->assertStatus(200);
        $response->assertJsonStructure([// Testing structure
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'surname',
                    'full_name',
                    'agency',
                    'country_of_operation',
                    'date_of_birth',
                    'date_of_death'
                ]
            ]
        ]);
        $response->assertJsonCount(5, 'data');

        $responseIds = collect($response->json('data'))->pluck('id');
        $responseIdsArray = $responseIds->toArray();
        $sortedResponseIdsArray = $responseIds->sort()->toArray();

        // Testing randomness
        $this->assertFalse($responseIdsArray === $sortedResponseIdsArray);
    }
}
