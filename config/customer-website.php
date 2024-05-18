<?php

return [
    // The broadcast strategy for pizza status updates.
    // Accepted values: websocket, webhook.
    'broadcast_using' => 'websocket',

    // Define the webhook settings when broadcasting updates
    // via a webhook call.
    'webhook' => [
        'url' => 'https://tixel-pizza.com/api/webhook',
        'secret' => 'super-secure-secret',
    ],
];
