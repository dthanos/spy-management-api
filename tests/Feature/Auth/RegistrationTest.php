<?php

namespace Tests\Feature\Auth;

use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/auth/register', [
            'username' => 'test',
            'email' => 'tester1@tester.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::query()->find($response->json('user')['id']);

        $this->assertDatabaseHas('users', $user->toArray());
    }
}
