<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create($request->all());

        return response()->json([
            'message' => 'User registered successfully. Please, save your Access Token: ' . $user->createToken('Access Token')->plainTextToken,
            'user' => $user,
        ], 201);
    }
}
