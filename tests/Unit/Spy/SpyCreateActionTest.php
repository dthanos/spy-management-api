<?php

namespace Tests\Unit\Spy;

use App\Application\Actions\CreateSpyAction;
use App\Application\Commands\CreateSpyCommand;
use App\Application\Commands\Handlers\CreateSpyHandler;
use App\Domain\Services\SpyService;
use App\Infrastructure\Repositories\SpyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpyCreateActionTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_spy_action_creates_spy()
    {
        $repository = new SpyRepository();
        $service = new SpyService($repository);
        $action = new CreateSpyAction($service);
        $handler = new CreateSpyHandler($action);

        $command = new CreateSpyCommand(
            'John',
            'Doe',
            'CIA',
            'USA',
            '1970-01-01',
            '2000-01-01'
        );

        $handler->handle($command);

        $this->assertDatabaseHas('spies', [
            'name' => 'John',
            'surname' => 'Doe',
            'agency' => 'CIA',
            'country_of_operation' => 'USA',
            'date_of_birth' => '1970-01-01',
            'date_of_death' => '2000-01-01'
        ]);
    }
}
