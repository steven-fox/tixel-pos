<?php

namespace App\Domain\Pizza\ModelStates;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\Events\PizzaStateChanged;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * @extends State<Pizza>
 */
class PizzaState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Started::class)
            ->allowTransition(Started::class, Baking::class)
            ->allowTransition(Baking::class, Finished::class)
            ->stateChangedEvent(PizzaStateChanged::class);
    }
}
