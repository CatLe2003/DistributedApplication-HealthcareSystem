<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{
    public function registerProfile(Request $request)
    {
        $response = Http::post('http://api_gateway/patient/register-patient', $request->all());

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Profile registered successfully!');
        }

        $errors = json_decode($response->body(), true);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }

    public function getProfile(Request $request)
    {
        $response = Http::get('http://api_gateway/patient/profile', $request->all());

        if ($response->successful()) {
            return view('patient.profile', ['profile' => $response->json()]);
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }
}
