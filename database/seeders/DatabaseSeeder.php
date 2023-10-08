<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'techtok7@gmail.com'
        ], [
            'name' => 'TechTok7',
            'username' => 'techtok7',
            'password' => bcrypt('password'),
            'is_verified' => true
        ]);
    }
}
