<?php

namespace App\Domain\Support\Broadcasting\Broadcasters;

use App\Domain\Support\Broadcasting\Channels\WebhookChannel;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use InvalidArgumentException;

class WebhookBroadcaster extends Broadcaster
{
    public function __construct(array $config)
    {
    }

    public function broadcast(array $channels, $event, array $payload = []): void
    {
        foreach ($channels as $channel) {
            if (! is_a($channel, WebhookChannel::class)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'The channels used for the %s must be instances of %s.',
                        static::class,
                        WebhookChannel::class
                    )
                );
            }

            $payload['event_type'] = $event;

            /** @var WebhookChannel $channel */
            $channel->webhook
                ->payload($payload)
                ->dispatch();
        }
    }

    public function auth($request): void
    {
        //
    }

    public function validAuthenticationResponse($request, $result): void
    {
        //
    }
}
