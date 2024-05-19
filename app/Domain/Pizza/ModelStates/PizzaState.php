<?php

namespace App\Domain\Pizza\ModelStates;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\Events\PizzaStateChanged;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * @extends State<Pizza>
 */
abstract class PizzaState extends State
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

    public static function sequence(): array
    {
        return [
            Pending::getMorphClass(),
            Started::getMorphClass(),
            Baking::getMorphClass(),
            Finished::getMorphClass(),
        ];
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getValue(),
            'transitionable_states' => $this->transitionableStates(),
        ];
    }
}
