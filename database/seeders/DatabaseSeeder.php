<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('admins')->insert(
            [
                ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' =>bcrypt('admin2020'), 'role' => 'admin']
            ]
        );
        DB::table('users')->insert(
            [
                ['name' => 'dosen1', 'email' => 'dosen@gmail.com', 'password' =>bcrypt('user2020')]
            ]
        );
    }
}
