<?php

namespace App\Http\Controllers;

use App\Models\ClassModel; // Adjust the namespace if your Class model name is different
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Get all classes
    public function index()
    {
        $classes= ClassModel::all();
        return response()->json([
            'classes' => $classes,
            'message' => "All classes fetched successfully"
        ]);
    }

    // Create a new class
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255|unique:classes',
            'description' => 'nullable|string',
            'max_capacity' => 'nullable|integer',
            'class_type' => 'nullable|string|in:adult,youth,children,bible_study',
            'schedule' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $class = ClassModel::create($validated);
        return response()-> json([
            'items' => $class,
           'message' => 'Class created successfully.',
        ]);
    }

    // Get a specific class
    public function show($id)
    {
        $class= ClassModel::findOrFail($id);
        return response()->json([
            'classes' => $class,
            'message' => "Class by Id fetched successfully"
        ]);
    }

    // Update a class
    public function update(Request $request, $id)
    {
        $class = ClassModel::findOrFail($id);

        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_capacity' => 'nullable|integer',
            'class_type' => 'nullable|string|in:adult,youth,children,bible_study',
            'schedule' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $class->update($validated);
        return response()->json([
            'classes' => $class,
            'message' => "Class updated successfully"
        ]);
    }

    // Delete a class
    public function destroy($id)
    {
        try {
            $class = ClassModel::findOrFail($id);
            $class->delete();
            return response()->json(['message' => 'Class deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Failed to delete class.'], 404);
        }
    }
}
