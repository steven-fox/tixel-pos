<?php

namespace Tests\Feature;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\Pizza\ModelStates\Started;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PizzaStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_webhook_is_sent_to_the_website_when_the_status_of_a_pizza_changes(): void
    {
        Http::fake();

        $pizza = Pizza::factory()
            ->pending()
            ->create();

        // Transition pizza status: Pending -> Started
        $pizza->status->transitionTo(Started::class);

        // Assert that a request was sent to the hypothetical customer-facing
        // website that displays the real-time pizza status.
        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://tixel-pizza.com/api/webhook'
            && $request->method() === 'POST';
            // TODO: Add event properties
        });
    }
}
