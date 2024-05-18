<?php

namespace App\Domain\Support\Broadcasting\Concerns;

use App\Domain\Support\Broadcasting\Channels\CustomerWebsiteWebhookChannel;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PrivateChannel;

trait BroadcastsToCustomerWebsite
{
    use InteractsWithBroadcasting;

    public function broadcastOn(): mixed
    {
        return match ($this->getBroadcastStrategy()) {
            'websocket' => new PrivateChannel('pizzas.'.$this->model->id),
            'webhook' => CustomerWebsiteWebhookChannel::create(),
        };
    }

    public function broadcastConnections(): array
    {
        return match ($this->getBroadcastStrategy()) {
            'websocket' => [config('broadcasting.default')],
            'webhook' => ['webhook'],
        };
    }

    public function getBroadcastStrategy(?string $default = null): string
    {
        $strategy = config('customer-website.broadcast_using', $default);

        if (! $strategy) {
            throw new BroadcastException("Unknown broadcast strategy '$strategy'.");
        }

        return $strategy;
    }
}
