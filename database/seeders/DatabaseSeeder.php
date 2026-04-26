<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->call([
            CurrencySeeder::class,
            CategorySeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@youqianren.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'timezone' => 'Asia/Jakarta',
            'language' => 'en',
        ]);

        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@youqianren.com',
            'password' => bcrypt('password'),
            'role' => 'free',
            'timezone' => 'Asia/Jakarta',
            'language' => 'en',
        ]);
    }
}
