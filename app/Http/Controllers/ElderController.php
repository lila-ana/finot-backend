<?php

namespace App\Http\Controllers;

use App\Models\Elder;
use Illuminate\Http\Request;

class ElderController extends Controller
{
    // Get all elders
    public function index()
    {
        return Elder::all();
    }

    // Create a new elder
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:elders|max:255',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:elders',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            
        ]);

        return Elder::create($validated);
    }

    // Get a specific elder
    public function show($id)
    {
         return Elder::where('elder_id', $id)->firstOrFail();
    }

    // Update an elder
    public function update(Request $request, $id)
    {
        $elder = Elder::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:elders',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:elders,email,' . $elder->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
        ]);

        $elder->update($validated);
        return $elder;
    }

    // Delete an elder
    public function destroy($id)
    {
        $elder = Elder::findOrFail($id);
        $elder->delete();
        return response()->json(['message' => 'Elder deleted successfully.']);
    }
}
