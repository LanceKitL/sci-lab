<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use App\Models\Laboratory;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get the Chemistry Lab ID
        $chemLab = Laboratory::where('slug', 'chemistry-lab')->first();

        // 2. Add the Beaker (Only if Chem Lab exists)
        if ($chemLab) {
            Equipment::create([
                'laboratory_id' => $chemLab->id,
                'name' => 'BEAKER',
                'description' => 'A cylindrical, flat-bottomed container with a lip for pouring.',
                'size' => '250ml',
                'quantity' => 154,
                'available' => 150, // 4 borrowed
                'status' => 'usable',
                'hazard_code' => 'Safe',
                'location' => 'Shelf A3',
                // Make sure this file exists in public/storage/equipment_images/
                'image_path' => 'equipment_images/beaker.png', 
            ]);

            Equipment::create([
                'laboratory_id' => $chemLab->id,
                'name' => 'Bunsen Burner',
                'description' => 'Produces a single open gas flame.',
                'size' => 'Standard',
                'quantity' => 50,
                'available' => 50,
                'location' => 'Shelf B1',
                'status' => 'usable',
                'hazard_code' => 'Flammable',
                'image_path' => null,
            ]);
        }
    }
}