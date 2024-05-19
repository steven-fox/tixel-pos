<?php

namespace App\Http\Controllers;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\Pending;
use Illuminate\Http\Request;

class PizzaResetController extends Controller
{
    /**
     * Reset a pizza.
     */
    public function __invoke(Request $request, Pizza $pizza)
    {
        $pizza->status = Pending::class;
        $pizza->save();

        return to_route('pos');
    }
}
