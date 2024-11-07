<?php

namespace App\Application\Commands\Handlers;

use App\Application\Actions\CreateSpyAction;
use App\Application\Commands\CreateSpyCommand;
use App\Application\DTOs\SpyDTO;

class CreateSpyHandler
{
    public function __construct(private readonly CreateSpyAction $createSpyAction)
    {
        parent::__construct();
    }

    public function handle(CreateSpyCommand $command): void
    {
        $spyDTO = new SpyDTO(
            $command->name,
            $command->surname,
            $command->agency,
            $command->country_of_operation,
            $command->date_of_birth,
            $command->date_of_death
        );

        $spy = $this->createSpyAction->execute($spyDTO);
    }
}
