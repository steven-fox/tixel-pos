<?php

namespace App\Http\Controllers;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\PizzaState;
use Illuminate\Http\Request;
use Spatie\ModelStates\Validation\ValidStateRule;

class PizzaStatusController extends Controller
{
    /**
     * Update the status of the pizza.
     */
    public function __invoke(Request $request, Pizza $pizza)
    {
        $request->validate([
            'status' => [
                ValidStateRule::make(PizzaState::class)->required(),
            ],
        ]);

        $pizza->status->transitionTo($request->json('status'));

        return to_route('pos');
    }
}
