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
    // you can use the User factory to create a user with specific attributes
        // User::factory()->create([
        //     'name' => 'Era Ramos',
        //     'email' => 'eraathriszah@gmail.com',
        //     'password' => bcrypt('r@moser@'),
        //     'role' => 'admin',
        //     'department' => 'IT',
        // ]);

        $this->call([
            LaboratorySeeder::class,
        ]);

    }
}
