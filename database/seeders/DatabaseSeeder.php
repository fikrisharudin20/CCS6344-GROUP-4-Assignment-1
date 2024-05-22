<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(3)->create();

        // Event::factory(3)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'emsys.noreply@gmail.com',
            'role' => 'admin',
            'password' => 'admin2024',
        ]);
    }
}
