<?php

namespace App\Http\Controllers;

use App\Domain\Pizza\JsonResources\PizzaJsonResource;
use App\Domain\Pizza\Models\Pizza;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PosController extends Controller
{
    /**
     * Render the home page for the POS system.
     */
    public function __invoke(Request $request)
    {
        $currentPizza = $request->user()->pizzas()->latest('id')->first();

        if (! $currentPizza) {
            $currentPizza = Pizza::factory()
                ->pending()
                ->for($request->user(), 'customer')
                ->create();
        }

        $finishedPizzas = Pizza::query()
            ->with('customer')
            ->latest('id')
            ->get();

        return Inertia::render('Pos', [
            'currentPizza' => new PizzaJsonResource($currentPizza->load('customer')),
            'recentPizzas' => PizzaJsonResource::collection($finishedPizzas),
        ]);
    }
}
