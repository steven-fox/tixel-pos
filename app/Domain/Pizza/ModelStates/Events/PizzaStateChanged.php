<?php

namespace App\Domain\Pizza\ModelStates\Events;

use App\Domain\Pizza\Models\Pizza;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Spatie\ModelStates\Events\StateChanged;

class PizzaStateChanged extends StateChanged implements ShouldBroadcast
{
    /** @var Pizza */
    public $model;

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('pizzas.'.$this->model->id);
    }

    public function broadcastAs(): string
    {
        return 'pizza.status.updated';
    }
}
