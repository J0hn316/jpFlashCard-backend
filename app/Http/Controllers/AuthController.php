<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register a new user and issue a token
    public function register(Request $request)
    {
        $fields = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|unique:users,email",
            "password" => "required|string|confirmed|min:8"
        ]);

        $user = User::create([
            "name" => $fields['name'],
            "email" => $fields['email'],
            "password" => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            "user" => $user,
            "token" => $token
        ], 201);
    }

    // Login an existing user and issue a token
    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string|email",
            "password" => "required|string"
        ]);

        $user = User::where("email", $fields['email'])->first();

        if (! $user || !Hash::check($fields["password"], $user->password)) {
            throw ValidationException::withMessages(["email" => ["The provided credentials are incorrect. "]]);
        };

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            "user" => $user,
            "token" => $token
        ]);
    }

    // Return the authenticated user
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Revoke the token that was used to authenticate the current request
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => "logged out"]);
    }
}
