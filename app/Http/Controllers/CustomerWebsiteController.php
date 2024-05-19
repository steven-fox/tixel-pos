<?php

namespace App\Http\Controllers;

use App\Domain\Pizza\JsonResources\PizzaJsonResource;
use App\Domain\Pizza\Models\Pizza;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerWebsiteController extends Controller
{
    public function __invoke(Request $request)
    {
        $pizza = $request->user()->pizzas()->latest('id')->first();

        if (! $pizza) {
            $pizza = Pizza::factory()
                ->pending()
                ->for($request->user(), 'customer')
                ->create();
        }

        return Inertia::render('Website', [
            'pizza' => new PizzaJsonResource($pizza),
        ]);
    }
}
