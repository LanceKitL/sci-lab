<?php

namespace Database\Seeders;

use App\Models\Laboratory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labs = [
            ['name' => 'Biology Lab', 'slug' => 'biology-lab'],
            ['name' => 'Chemistry Lab', 'slug' => 'chemistry-lab'],
            ['name' => 'Earth Science Lab', 'slug' => 'earth-science-lab'],
            ['name' => 'Physics Lab', 'slug' => 'physics-lab'],
        ];

        foreach ($labs as $lab) {
            Laboratory::create($lab);
        }
    }
}
