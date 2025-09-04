<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use database\seeders\AdminTableSeeder; // ✅ add this line

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminTableSeeder::class,
        ]);


        
    }
}
