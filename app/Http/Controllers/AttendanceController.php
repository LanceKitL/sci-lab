<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::latest('visit_time')->get();
        $equipmentList = \App\Models\Equipment::where('available', '>', 0)->get(); 
        $laboratories = \App\Models\Laboratory::all();
        return view('attendance.index', compact('attendances', 'equipmentList', 'laboratories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'visit_date' => 'required|date',
            'laboratory' => 'required|string|max:255',
            'visit_time' => 'required', // We merge these two in the controller
        ]);

        // Merge Date and Time inputs into one timestamp
        $fullDateTime = $request->visit_date . ' ' . $request->visit_time;

        Attendance::create([
            'name' => $request->name,
            'section' => $request->section,
            'visit_time' => $fullDateTime,
            'laboratory' => $request->laboratory,
        ]);

        return back()->with('success', 'Visitor logged successfully!');
    }
}