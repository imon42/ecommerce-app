<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //user login;
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'invalid credentials']);
        }

        $token = $user->createToken('sunctum-token')->plainTextToken;

        return response()->json([
            'message' => 'login successfull',
            'token' => $token,
        ]);
    }

    //user register;

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:3'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'user created successfull']);
    }

    //get profile;
    public function getProfile($id)
    {
        $profile = User::findOrFail($id);
        return response()->json([
            'profile' => $profile,
        ]);
    }

    //update profile;
    public function updateProfile(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email|exists:users',
            'password' => 'nullable|string|confirmed',

        ]);

        $profile = User::findOrFail($id);

        $profile->update($validatedData);

        return response()->json([
            'message' => 'profile updated successfull',
            'profile' => $profile,
        ]);
    }

    //user logout;
    public function logout(Request $request, User $user)
    {
        $user->tokens()->delete();
        return response()->json(['message' => 'user logout successfull']);
    }
}
