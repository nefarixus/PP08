<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class UserProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();
        $products = Product::all();
        
        // If you need to create user-product relationships, uncomment and modify as needed:
        // foreach ($users as $user) {
        //     $user->products()->attach(
        //         $products->random(rand(1, 5))->pluck('id')->toArray()
        //     );
        // }
    }
}