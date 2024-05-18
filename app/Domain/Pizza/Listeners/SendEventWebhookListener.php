<?php

namespace App\Domain\Pizza\Listeners;

use App\Domain\Pizza\ModelStates\Events\PizzaStateChanged;
use Illuminate\Support\Facades\Http;

class SendEventWebhookListener
{
    public function __construct()
    {
    }

    public function handle(PizzaStateChanged $event): void
    {
        Http::post('https://tixel-pizza.com/api/webhook', [
            'event' => $event,
            'occurred_at' => now(),
        ]);
    }
}
