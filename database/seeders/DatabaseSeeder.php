<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        $users = User::factory(10)->create();

        // Create 20 products
        $products = Product::factory(20)->create();

        // Attach random products to each user's library (many-to-many relationship)
        foreach ($users as $user) {
            // Each user gets between 0 and 10 random products in their library
            $userProducts = $products->random(rand(0, 10))->pluck('id');
            $user->products()->attach($userProducts);
        }
    }
}