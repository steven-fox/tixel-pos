<?php

namespace Database\Factories;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\Baking;
use App\Domain\Pizza\ModelStates\Finished;
use App\Domain\Pizza\ModelStates\Pending;
use App\Domain\Pizza\ModelStates\Started;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pizza>
 */
class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    public function definition(): array
    {
        return [
            'customer_id' => User::factory(),
            'status' => $this->faker->randomElement(Pizza::getStatesFor('status')),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Pending::class,
        ]);
    }

    public function started(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Started::class,
        ]);
    }

    public function baking(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Baking::class,
        ]);
    }

    public function finished(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Finished::class,
        ]);
    }
}
