<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Avoid running seeders in production
        if (app()->environment() === 'production') {
            return;
        }

        $this->call([
            BookSeeder::class,
            MemberSeeder::class,
        ]);
    }
}
