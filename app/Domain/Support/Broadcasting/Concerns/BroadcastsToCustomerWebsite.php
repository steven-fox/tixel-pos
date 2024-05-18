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
        return match ($strategy = $this->getBroadcastStrategy()) {
            'websocket' => new PrivateChannel('pizzas.'.$this->model->id),
            'webhook' => CustomerWebsiteWebhookChannel::create(),
            default => throw new BroadcastException("Unknown broadcast strategy '$strategy'.")
        };
    }

    public function broadcastConnections(): array
    {
        return match ($strategy = $this->getBroadcastStrategy()) {
            'websocket' => [config('broadcasting.default')],
            'webhook' => ['webhook'],
            default => throw new BroadcastException("Unknown broadcast strategy '$strategy'.")
        };
    }

    public function getBroadcastStrategy(?string $default = null): string
    {
        $strategy = config('customer-website.broadcast_using', $default);

        if (! $strategy) {
            throw new BroadcastException('Please configure a broadcasting strategy for the customer website.');
        }

        return $strategy;
    }
}
