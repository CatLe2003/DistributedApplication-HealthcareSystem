<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlacklistToken;
use Illuminate\Http\Request;
use Firebase\JWT\JWT; 
use Firebase\JWT\Key;
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
    public function logout(Request $request)
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
                return response()->json(['message' => 'Token not provided'], 400);
            }

            $token = substr($authHeader, 7);

            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            BlacklistToken::create([
                'token' => $token,
                'expired_at' => date('Y-m-d H:i:s', $decoded->exp),
            ]);

            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function verifyToken(Request $request)
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
                return response()->json(['message' => 'Token not provided'], 400);
            }

            $token = substr($authHeader, 7);

            if (BlacklistToken::where('token', $token)->exists()) {
                return response()->json(['message' => 'Token is blacklisted'], 401);
            }

            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            return response()->json([
                'valid' => true,
                'userid' => $decoded->userid,
                'role' => $decoded->role,
                'exp' => $decoded->exp,
            ]);
        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json(['message' => 'Token expired'], 401);
        } catch (Exception $e) {
            return response()->json(['message' => 'Invalid token', 'error' => $e->getMessage()], 401);
        }
    }

    public function getAllUsers()
    {
        try {
            $users = User::all();
            return response()->json(['users' => $users]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUserById($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            return response()->json(['user' => $user]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateUserById(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Validate input
            $request->validate([
                'password' => 'nullable|string|max:255',
                'is_active' => 'nullable|boolean',
                'referend_id' => 'nullable|integer',
            ]);

            // Update các field
            if ($request->has('password')) {
                $user->password_hash = Hash::make($request->password);
            }
            if ($request->has('is_active')) {
                $user->is_active = $request->is_active;
            }
            if ($request->has('referend_id')) {
                $user->referend_id = $request->referend_id;
            }

            $user->save();

            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
