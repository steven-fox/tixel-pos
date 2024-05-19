<?php

use App\Domain\Pizza\Models\Pizza;
use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('pizzas.{pizza}', function (User $user, Pizza $pizza) {
    return $pizza->customer_id === $user->id;
});
