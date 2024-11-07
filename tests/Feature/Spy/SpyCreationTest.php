<?php

namespace Tests\Feature\Spy;

use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use App\Domain\Events\SpyCreated;

class SpyCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_spy_and_created_event_is_fired()
    {
        $this->withoutExceptionHandling();

        Event::fake(SpyCreated::class);

        $user = User::factory()->create();
        $this->actingAs($user);

        $spyAttributes = [
            'name' => 'Test',
            'surname' => 'Tester',
            'agency' => 'CIA',
            'country_of_operation' => 'USA',
            'date_of_birth' => '1970-01-01',
            'date_of_death' => '2000-01-01'
        ];
        $response = $this->post('/api/spy', $spyAttributes);

        $response->assertStatus(201);

        $this->assertDatabaseHas('spies', $spyAttributes);

        Event::assertDispatched(SpyCreated::class);
    }

    public function test_spy_creation_requires_authentication()
    {
        // Send POST request without authentication
        $response = $this->post('/api/spy', [
            'name' => 'Test',
            'surname' => 'Tester',
            'agency' => 'CIA',
            'country_of_operation' => 'USA',
            'date_of_birth' => '1970-01-01',
            'date_of_death' => '2000-01-01'
        ]);

        $response->assertServerError();
    }
}
