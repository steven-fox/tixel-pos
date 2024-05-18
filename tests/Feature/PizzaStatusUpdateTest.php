<?php

namespace Tests\Feature;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\Events\PizzaStateChanged;
use App\Domain\Pizza\ModelStates\Pending;
use App\Domain\Pizza\ModelStates\Started;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class PizzaStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_pizza_state_changed_event_will_broadcast(): void
    {
        Bus::fake();

        $pizza = Pizza::factory()
            ->pending()
            ->create();

        // Transition pizza status: Pending -> Started
        $pizza->status->transitionTo(Started::class);

        // Assert that a request was sent to the hypothetical customer-facing
        // website that displays the real-time pizza status.
        Bus::assertDispatched(BroadcastEvent::class, function (BroadcastEvent $broadcastEvent) use ($pizza) {
            return $broadcastEvent->event instanceof PizzaStateChanged
                && $broadcastEvent->event->model->is($pizza)
                && $broadcastEvent->event->initialState instanceof Pending
                && $broadcastEvent->event->finalState instanceof Started;
        });
    }
}
