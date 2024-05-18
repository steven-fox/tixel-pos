<?php

namespace App\Domain\Support\Broadcasting\Channels;

use Spatie\WebhookServer\WebhookCall;

class WebhookChannel
{
    final public function __construct(
        public WebhookCall $webhook,
    ) {
    }
}
