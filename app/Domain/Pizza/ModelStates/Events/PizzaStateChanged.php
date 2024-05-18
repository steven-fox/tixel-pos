<?php

namespace App\Domain\Pizza\ModelStates\Events;

use App\Domain\Pizza\Models\Pizza;
use Spatie\ModelStates\Events\StateChanged;

class PizzaStateChanged extends StateChanged
{
    /** @var Pizza */
    public $model;
}
