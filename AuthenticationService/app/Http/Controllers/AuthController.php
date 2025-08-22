<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT; 
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            if(User::where('login_key', $request->login_key)->exists()) {
                return response()->json(['message' => 'Login key already exists'], 400);
            }
            $request->validate([
            'password' => 'required|max:255',
            'login_key' => 'required|string|max:50',
            'role' => 'required|string',
            ]);

            $user = new User();
            $user->login_key = $request->login_key;
            $user->role = $request->role;
            $user->is_active = true; 
            $user->referend_id = -1; 
            $user->password_hash = Hash::make($request->password);
            $user->save();

            return response()->json([
                'message' => 'Registered successfully',
                'user' => $user,     
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'login_key' => 'required|string|max:50',
                'password' => 'required|string|max:255',
            ]);

            $user = User::where('login_key', $request->login_key)->first();

            if (!$user || !Hash::check($request->password, $user->password_hash)) {
                return response()->json(['message' => 'Login failed. Wrong username or password'], 401);
            }

            $payload = [
                'userid' => $user->userid,
                'role' => $user->role,
                'exp' => time() + (60 * 60), 
            ];

            $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

            return response()->json([
                'message' => 'Login successfully',
                'token' => $jwt,
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 500);
        }        
    }
}
