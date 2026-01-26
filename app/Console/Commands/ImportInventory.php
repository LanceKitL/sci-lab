<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipment;
use App\Models\Laboratory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ImportInventory extends Command
{
    protected $signature = 'inventory:import';
    protected $description = 'Import Inventory with Smart Image Matching';

    public function handle()
    {
        $this->info('Starting Smart Inventory Import...');

        // Check if storage is linked
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }

        $xlsxPath = storage_path('app/public/import_data/inventory.xlsx');

        if (!file_exists($xlsxPath)) {
            $this->error("File not found: $xlsxPath");
            return;
        }

        // Configuration
        $sheetConfig = [
            0 => ['slug' => 'chemistry-lab',     'folder' => 'B. Chemistry Lab',     'prefix' => 'B-'],
            1 => ['slug' => 'biology-lab',       'folder' => 'A. Biology Lab',       'prefix' => 'A-'],
            2 => ['slug' => 'earth-science-lab', 'folder' => 'C. Earth Science Lab', 'prefix' => 'C-'],
            3 => ['slug' => 'physics-lab', 'folder' => 'D. Physics Lab',       'prefix' => 'D-'],
        ];

        $this->info("Reading Excel...");
        $sheets = Excel::toArray([], $xlsxPath);

        foreach ($sheets as $index => $rows) {
            
            if (!isset($sheetConfig[$index])) continue;

            $config = $sheetConfig[$index];
            $lab = Laboratory::where('slug', $config['slug'])->first();

            if (!$lab) {
                $this->error("Lab not found: {$config['slug']}");
                continue;
            }

            $this->info("Processing {$lab->name}...");
            $imported = 0;
            $missingImages = 0;

            foreach ($rows as $rowIndex => $row) {
                if ($rowIndex === 0) continue; // Skip Header

                $name = trim($row[0] ?? '');
                if (empty($name)) continue;

                // --- DATA MAPPING ---
                $size = trim($row[1] ?? '');
                $desc = trim($row[2] ?? '');
                $qty  = (int) ($row[3] ?? 0);
                $loc  = trim($row[4] ?? '');
                $stat = trim($row[5] ?? '');
                $haz  = trim($row[6] ?? 'Safe');

                if ($size === 'N/A') $size = null;

                // --- SMART IMAGE FINDER ---
                $imagePath = $this->findImageSmart($name, $config['folder']);

                if (!$imagePath) {
                    $this->warn("   [No Image] $name");
                    $missingImages++;
                }
                $statusSlug = trim($stat);

                Equipment::create([
                    'laboratory_id' => $lab->id,
                    'name'          => $name,
                    'size'          => $size,
                    'description'   => $desc,
                    'quantity'      => $qty,
                    'available'     => $qty,
                    'location'      => $loc,
                    'status'        => $statusSlug,
                    'hazard_code'   => $haz,
                    'image_path'    => $imagePath,
                ]);

                $imported++;
            }
            $this->info("   -> Imported $imported items ($missingImages missing images).");
        }

        $this->info('Done!');
    }

    private function findImageSmart($itemName, $folder)
    {
        $baseDir = storage_path('app/public/import_data/' . $folder);
        if (!is_dir($baseDir)) return null;

        $files = scandir($baseDir);

        // 1. CLEAN THE ITEM NAME
        // Remove text in parentheses: "Beaker (250ml)" -> "Beaker"
        $cleanName = preg_replace('/\s*\(.*?\)\s*/', '', $itemName);
        // Remove special chars & lowercase: "Beaker" -> "beaker"
        $targetSlug = Str::slug($cleanName, ''); 

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            // 2. CLEAN THE FILENAME
            // Get name without extension: "A-Beaker_v2.jpg" -> "A-Beaker_v2"
            $filenameNoExt = pathinfo($file, PATHINFO_FILENAME);
            
            // Normalize: "A-Beaker_v2" -> "abeakerv2"
            $fileSlug = Str::slug($filenameNoExt, '');

            // 3. COMPARE
            // Check if the file contains the item name (e.g. does "abeakerv2" contain "beaker"?)
            if (str_contains($fileSlug, $targetSlug)) {
                return $this->storeImage($baseDir . '/' . $file, $file);
            }
        }

        return null;
    }

    private function storeImage($sourcePath, $filename)
    {
        // Avoid duplicates by hashing content, or just randomizing
        $newFilename = Str::random(10) . '_' . $filename;
        $destinationPath = 'equipment_images/' . $newFilename;
        
        Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
        
        return $destinationPath;
    }
}