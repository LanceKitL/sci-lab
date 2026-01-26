<?php
namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Needed for image uploads later

class LaboratoryController extends Controller
{
    public function show($slug)
    {
        $lab = Laboratory::where('slug', $slug)->firstOrFail();
        
        // Change .get() to .paginate(12)
        $equipment = $lab->equipment()->paginate(12); 

        return view('laboratories.show', compact('lab', 'equipment'));
    }
    
   public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'size'          => 'nullable|string|max:100',
            'quantity'      => 'required|integer|min:0',
            // 'lte' means Less Than or Equal. Available cannot be more than Quantity.
            'available'     => 'required|integer|min:0|lte:quantity', 
            'location'      => 'nullable|string|max:100',
            'hazard_code'   => 'nullable|string|max:50',
            'image_path'    => 'nullable|image|max:2048', // Max 2MB
            'status'        => 'nullable|string|max:50',
        ]);

        // 2. Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image_path')) {
            // Fixed the typo here: removed the space in 'image_path'
            $imagePath = $request->file('image_path')->store('equipment_images', 'public');
        }

        // 3. Create the Equipment
        \App\Models\Equipment::create([
            'laboratory_id' => $request->laboratory_id,
            'name'          => $request->name,
            'description'   => $request->description,
            'size'          => $request->size,
            'quantity'      => $request->quantity,
            'available'     => $request->available,
            'location'      => $request->location,
            // Default status to usable if not provided, or calculate based on avail
            'status'        => $request->status ?? 'status_unknown', 
            'hazard_code'   => $request->hazard_code,
            'image_path'    => $imagePath,
        ]);

        return back()->with('success', 'Equipment added successfully!');
    }
}