<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\BlogSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\McqSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed a base user for related records.
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            CategorySeeder::class,
            McqSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
