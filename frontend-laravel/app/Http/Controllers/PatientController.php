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
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::get("http://api_gateway/patient/get-patient/{$patientId}");

        if ($response->successful()) {
            return view('medical_record.profile', ['profile' => $response->json()]);
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function getProfileBeforeUpdate(Request $request)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::get("http://api_gateway/patient/get-patient/{$patientId}");

        if ($response->successful()) {
            return view('medical_record.update_profile', ['profile' => $response->json()]);
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function updateProfile(Request $request)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::put("http://api_gateway/patient/update-patient/{$patientId}", $request->all());

        if ($response->successful()) {
            return redirect()->route('medical_record.profile')->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function getMedicalVisits(Request $request)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::get("http://api_gateway/patient/medical-visits/{$patientId}");

        if ($response->successful()) {
            return view('medical_record.medical_records', ['medical_visits' => $response->json()]);
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }
}