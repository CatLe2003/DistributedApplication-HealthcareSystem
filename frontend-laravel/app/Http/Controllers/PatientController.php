<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{
    public function updateProfile(Request $request)
    {
        $response = Http::post('http://api_gateway/patient/register-patient', $request->all());

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Profile updated successfully!');
        }

        $errors = json_decode($response->body(), true);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }
}
