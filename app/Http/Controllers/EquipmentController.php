<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function show($id)
    {
        // Fetch the specific item with its laboratory details
        $equipment = Equipment::with('laboratory')->findOrFail($id);
        
        // Return the "Beaker" detail view
        return view('equipment.show', compact('equipment'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search in 'name' or 'description'
        $equipment = \App\Models\Equipment::with('laboratory')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('hazard_code', 'LIKE', "%{$query}%")
            ->get();

        // Return a view to display results
        return view('equipment.search_results', compact('equipment', 'query'));
    }

    // 1. Show the Edit Form
    public function edit($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);
        // Pass labs for the dropdown in case they want to move the item
        $labs = \App\Models\Laboratory::all(); 
        return view('equipment.edit', compact('equipment', 'labs'));
    }

    // 2. Handle the Update
    public function update(Request $request, $id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'laboratory_id' => 'required|exists:laboratories,id',
            'description' => 'nullable|string',
            'size' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            // Ensure available doesn't exceed total quantity
            'available' => 'required|integer|min:0|lte:quantity', 
            'hazard_code' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        // Handle Image Update
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists
            if ($equipment->image_path) {
                Storage::disk('public')->delete($equipment->image_path);
            }
            // Store new image
            $equipment->image_path = $request->file('image_path')->store('equipment_images', 'public');
        }

        $equipment->update([
            'name' => $request->name,
            'laboratory_id' => $request->laboratory_id,
            'description' => $request->description,
            'size' => $request->size,
            'quantity' => $request->quantity,
            'available' => $request->available,
            'hazard_code' => $request->hazard_code,
            // Only update image path if a new one was uploaded
            'image_path' => $equipment->image_path, 
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return redirect()->route('equipment.show', $id)->with('success', 'Equipment updated successfully!');
    }

    // 3. Handle Delete
    public function destroy($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);

        // Delete the image file to save space
        if ($equipment->image_path) {
            Storage::disk('public')->delete($equipment->image_path);
        }

        $equipment->delete();

        // Redirect back to the Lab page
        return redirect()->route('laboratories.show', $equipment->laboratory->slug)
                         ->with('success', 'Item deleted successfully.');
    }
}