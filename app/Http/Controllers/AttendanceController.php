<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
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

    // Store a new attendance (or update if already exists for today)
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'elder_id' => 'exists:elders,elder_id',
            'class_id' => 'exists:classes,class_id', // Ensure the correct column name
            'member_id' => 'required|exists:members,member_id', // Ensure the correct column name
            'attended' => 'required|boolean',
        ]);

        // Get today's date
        $today = Carbon::today()->toDateString();

        // Check if the attendance record for the member exists for today
        $attendance = Attendance::where('member_id', $validated['member_id'])
                                 ->whereDate('created_at', $today)
                                 ->first();

        if ($attendance) {
            // If it exists, update the 'attended' status
            $attendance->update([
                'attended' => $validated['attended'],
            ]);

            return response()->json($attendance, 200); // Return the updated record
        } else {
            // If no attendance record exists for today, create a new one
            $validated['created_at'] = $today; // Ensure the created_at date is today
            $attendance = Attendance::create($validated);

            return response()->json($attendance, 201); // Return the newly created record
        }
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
