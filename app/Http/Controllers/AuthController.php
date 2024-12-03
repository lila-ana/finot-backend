<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|exists:roles,name', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        // Generate a longer, more secure token with an expiration date
        $token = $user->createToken('auth_token', ['*'], now()->addHours(8))->plainTextToken;

        // Return the token and user data
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => now()->addHours(8)->toDateTimeString(),
            'user' => $user,
        ]);
    }

    // Login a user
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check credentials
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Generate a more secure token with an expiration and bind it to the user's IP
        $token = $user->createToken(
            'auth_token', 
            ['*'], 
            now()->addHours(8)
        )->plainTextToken;

        // Include roles and permissions
    $roles = $user->getRoleNames(); // Returns a collection of role names
    $permissions = $user->getAllPermissions()->pluck('name'); // Returns a collection of permission names

        // Return the token, expiration, and user data
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => now()->addHours(8)->toDateTimeString(),
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}
