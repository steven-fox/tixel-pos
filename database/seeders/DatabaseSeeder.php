<?php

namespace Database\Seeders;

use App\Domain\Pizza\Models\Pizza;
use App\Domain\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Pizza::factory()
            ->finished()
            ->createMany(3);

        // "Current" pizza for our default user.
        Pizza::factory()
            ->pending()
            ->for($user, 'customer')
            ->create();
    }
}
