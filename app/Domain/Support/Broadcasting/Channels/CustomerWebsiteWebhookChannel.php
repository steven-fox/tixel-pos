<?php

namespace App\Domain\Support\Broadcasting\Channels;

use Spatie\WebhookServer\WebhookCall;

class CustomerWebsiteWebhookChannel extends WebhookChannel
{
    public static function create(): static
    {
        $config = config('customer-website.webhook');

        return new static(
            WebhookCall::create()
                ->url($config['url'])
                ->useSecret($config['secret'])
        );
    }
}
