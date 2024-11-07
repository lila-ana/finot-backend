<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // List all attendances
    public function index()
    {
        $attendances = Attendance::with(['elder', 'class', 'member'])->get();
        return response()->json($attendances);
    }

    // Show a specific attendance
    public function show($id)
    {
        $attendance = Attendance::with(['elder', 'class', 'member'])->find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }
        return response()->json($attendance);
    }

    // Store a new attendance
    public function store(Request $request)
    {
        

        $validated = $request->validate([
            'elder_id' => 'required|exists:elders,elder_id',
            'class_id' => 'required|exists:classes,class_id', // Change to the correct column name if needed
            'member_id' => 'required|exists:members,member_id', // Change to the correct column name if needed
            'attended' => 'required|boolean',
        ]);


        $attendance = Attendance::create($validated);

        return response()->json($attendance, 201);
    }

    // Update an existing attendance
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        $validated = $request->validate([
            'attended' => 'required|boolean',
        ]);

        $attendance->update($validated);

        return response()->json($attendance);
    }

    // Delete an attendance record
    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted successfully']);
    }
}
