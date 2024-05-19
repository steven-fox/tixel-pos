<?php

namespace Tests\Feature;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\Events\PizzaStateChanged;
use App\Domain\Pizza\ModelStates\Pending;
use App\Domain\Pizza\ModelStates\Started;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Spatie\WebhookServer\CallWebhookJob;
use Tests\TestCase;

class PizzaStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_pizza_state_changed_event_can_be_broadcast_by_a_websocket_connection(): void
    {
        Bus::fake();
        config()->set('customer-website.broadcast_using', 'websocket');

        $pizza = Pizza::factory()
            ->pending()
            ->create();

        // Transition pizza status: Pending -> Started
        $pizza->status->transitionTo(Started::class);

        Bus::assertDispatched(BroadcastEvent::class, function (BroadcastEvent $broadcastEvent) use ($pizza) {
            return $broadcastEvent->event instanceof PizzaStateChanged
                && $broadcastEvent->event->model->is($pizza)
                && $broadcastEvent->event->initialState instanceof Pending
                && $broadcastEvent->event->finalState instanceof Started
                && $broadcastEvent->event->broadcastOn() instanceof PrivateChannel
                && $broadcastEvent->event->broadcastConnections() === ['reverb'];
        });
    }

    public function test_the_pizza_state_changed_event_can_be_broadcast_by_a_webhook_connection(): void
    {
        Bus::fake([CallWebhookJob::class]);
        config()->set('customer-website.broadcast_using', 'webhook');

        $pizza = Pizza::factory()
            ->pending()
            ->create();

        // Transition pizza status: Pending -> Started
        $pizza->status->transitionTo(Started::class);

        Bus::assertDispatched(CallWebhookJob::class, function (CallWebhookJob $job) use ($pizza) {
            return $job->webhookUrl === config('customer-website.webhook.url')
               && $job->payload['event_type'] === 'pizza.status.updated'
               && $job->payload['model']['id'] === $pizza->id
               && $job->payload['model']['status']['name'] === Started::getMorphClass();
        });
    }
}
