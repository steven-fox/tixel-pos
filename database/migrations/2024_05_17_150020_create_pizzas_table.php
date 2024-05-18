<?php

use App\Domain\User\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pizzas', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('status');

            /**
             * In a real scenario, we'd also consider:
             *  - relating the pizza to a product definition and order/order item
             *  - pizza toppings, perhaps as a hasMany relationship (so we could also record the extra pricing, how much of the pizza it goes on, etc)
             *  - etc
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzas');
    }
};
