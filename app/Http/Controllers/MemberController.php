<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with(['elder', 'class'])->whereNull('deleted_at')->get();

        return response()->json([
            'message' => 'Members retrieved successfully.',
            'count' => $members->count(),
            'items' => $members,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'message' => 'Ready to create a new member.',
            'data' => [],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:50',
            'email_address' => 'required|email|unique:members',
            'date_of_baptism' => 'nullable|date',
            'membership_status' => 'required|in:active,inactive',
            'previous_church_affiliation' => 'nullable|string|max:255',
            'family_members' => 'nullable|string',
            'children_info' => 'nullable|string',
            'areas_of_interest' => 'nullable|string',
            'spiritual_gifts' => 'nullable|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:50',
            'profile_picture' => 'nullable|file|image|max:2048',
            'notes_comments' => 'nullable|string',
           'data_protection_consent' => 'nullable|boolean',
            'media_release_consent' => 'nullable|boolean',
            'profession_detail' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'elder_id' => 'nullable|string|exists:elders,elder_id',
            'class_id' => 'nullable|string|exists:classes,class_id',
        ]);

        // Handle file upload if there's a profile picture
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $member = Member::create([
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email_address' => $request->email_address,
            'date_of_baptism' => $request->date_of_baptism,
            'membership_status' => $request->membership_status,
            'previous_church_affiliation' => $request->previous_church_affiliation,
            'family_members' => $request->family_members,
            'children_info' => $request->children_info,
            'areas_of_interest' => $request->areas_of_interest,
            'spiritual_gifts' => $request->spiritual_gifts,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'profile_picture' => $profilePicturePath,
            'notes_comments' => $request->notes_comments,
            'data_protection_consent' => $request->data_protection_consent,
            'media_release_consent' => $request->media_release_consent,
            'profession_detail' => $request->profession_detail,
            'blood_type' => $request->blood_type,
            'elder_id' => $request->elder_id,
            'class_id' => $request->class_id,
        ]);

        return response()->json([
            'message' => 'Member created successfully.',
            'member' => $member,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $member = Member::with(['elder', 'class'])->withTrashed()->findOrFail($id);

            if ($member->trashed()) {
                return response()->json(['message' => 'Member is deleted.'], 404);
            }

            return response()->json([
                "message" => "Single member fetched successfully.",
                "member" => $member,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Member not found.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $member = Member::find($id);
        
        if (!$member) {
            return response()->json(['message' => 'Member not found.'], 404);
        }

        return response()->json([
            'message' => 'Ready to edit member.',
            'member' => $member,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:50',
            'email_address' => 'required|email',
            'date_of_baptism' => 'nullable|date',
            'membership_status' => 'required|in:active,inactive',
            'previous_church_affiliation' => 'nullable|string|max:255',
            'family_members' => 'nullable|string',
            'children_info' => 'nullable|string',
            'areas_of_interest' => 'nullable|string',
            'spiritual_gifts' => 'nullable|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:50',
            'profile_picture' => 'nullable|file|image|max:2048',
            'notes_comments' => 'nullable|string',
            'data_protection_consent' => 'nullable|boolean',
            'media_release_consent' => 'nullable|boolean',
            'profession_detail' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'elder_id' => 'nullable|string|exists:elders,elder_id',
            'class_id' => 'nullable|string|exists:classes,class_id',
        ]);
        
        // Handle the profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            // Delete the old picture if it exists
            if ($member->profile_picture) {
                Storage::disk('public')->delete($member->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $member->profile_picture = $path;
        }

        // Update the member's attributes
        $member->update($request->only([
            'full_name',
            'date_of_birth',
            'gender',
            'marital_status',
            'address',
            'phone_number',
            'email_address',
            'date_of_baptism',
            'membership_status',
            'previous_church_affiliation',
            'family_members',
            'children_info',
            'areas_of_interest',
            'spiritual_gifts',
            'emergency_contact_name',
            'emergency_contact_phone',
            'notes_comments',
            'data_protection_consent',
            'media_release_consent',
            'profession_detail',
            'blood_type',
            'elder_id',
            'class_id',
        ]));

        return response()->json([
            'message' => 'Member updated successfully.',
            'member' => $member,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $member = Member::findOrFail($request->id);

            if (!is_null($member->deleted_at)) {
                return response()->json(['message' => 'Member is already deleted.'], 400);
            }

            $member->delete();

            return response()->json(['message' => 'Member deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Member not found.'], 404);
        }
    }
}
