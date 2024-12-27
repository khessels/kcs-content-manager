<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $seeds = [
            PermissionsSeeder::class,
            UserSeeder::class,
            ContentSeeder::class,
            AppsSeeder::class,
        ];
        array_map(fn($s) => $this->call($s), $seeds);
    }
}
