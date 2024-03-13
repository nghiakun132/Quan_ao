<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\WhiteList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(AdminSedder::class);
        $this->call(CategorySeeder::class);
        $this->call(SizeSeeder::class);
        // Cart::create([
        //     'user_id' => 1,
        //     'product_id' => 1,
        //     'quantity' => 5,
        //     'size_id' => 1,
        // ]);

        // WhiteList::create([
        //     'user_id' => 1,
        //     'product_id' => 1,
        // ]);
    }
}
