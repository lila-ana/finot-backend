<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Events::all();
        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
        'event_name' => 'required|string|max:255|unique:events',
        'event_date' => 'required|date', 
        'event_time' => 'required|date_format:H:i', 
        'location' => 'required|string|max:255',
        'description' => 'nullable|string',
        'event_type' => 'nullable|string|max:255',
        'capacity' => 'nullable|integer', 
        'organizer_name' => 'nullable|string|max:255',
        'contact_info' => 'nullable|string|max:255',
        'status' => 'nullable|in:scheduled,completed,cancelled', 
    ]);

        $event = Events::create($validated);

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Events::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        return response()->json($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Events::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validated = $request->validate([
            'event_name' => 'required|string|max:255|unique:events',
            'event_date' => 'required|date', 
            'event_time' => 'required|date_format:H:i', 
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer', 
            'organizer_name' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'status' => 'nullable|in:scheduled,completed,cancelled', 
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Events::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
