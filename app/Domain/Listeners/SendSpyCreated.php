<?php

namespace App\Domain\Listeners;

use App\Domain\Events\SpyCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSpyCreated implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SpyCreated $event): void
    {
        $spy = $event->spy;
        logger("A new spy was created: {$spy->full_name->toString()}");
    }
}
