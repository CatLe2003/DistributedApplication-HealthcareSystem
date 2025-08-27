<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    public function updateProfile(Request $request)
    {
        $response = Http::post('http://api_gateway/authentication/register', $request->all());

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Account registered successfully!');
        }

        $errors = json_decode($response->body(), true);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }
}
