<?php

namespace App\Domain\Pizza\ModelStates\Events;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Support\Broadcasting\Concerns\BroadcastsToCustomerWebsite;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Spatie\ModelStates\Events\StateChanged;

class PizzaStateChanged extends StateChanged implements ShouldBroadcast
{
    use BroadcastsToCustomerWebsite;

    /** @var Pizza */
    public $model;

    public function broadcastAs(): string
    {
        return 'pizza.status.updated';
    }
}
