<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function registerAccount(Request $request)
    {
        $response = Http::post('http://api_gateway/authentication/register', $request->all());

        if ($response->successful()) {
            return redirect()->route('profile.register')->with('success', 'Account registered successfully!');
        }

        $errors = json_decode($response->body(), true);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }

    public function login(Request $request)
    {
        $response = Http::post('http://api_gateway/authentication/login', $request->all());

        if ($response->successful()) {
            $data = $response->json();

            //use the login_key to find in patient's phone
            if (!empty($data['user']['login_key'])) {
                $phone = $data['user']['login_key'];
                $url = "http://api_gateway/patient/get-patient-phone/{$phone}";
                $patientResponse = Http::get($url);
                Log::info('Patient Response:', ['response' => $patientResponse->body()]);
                Log::info($url);
                if ($patientResponse->successful()) {
                    $patientData = $patientResponse->json();
                }
            }
            // Store user data and token in session
            session([
                'user' => $data['user'] ?? null,
                'token' => $data['token'] ?? null,
                'user_id' => $data['user']['userid'] ?? null,  // changed to match API response
                'user_role' => $data['user']['role'] ?? null,
                'login_key' => $data['user']['login_key'] ?? null,
                'patient_id' => $patientData['id'] ?? null
            ]);

            // //use the login_key to find in patient's phone
            // if (!empty($data['user']['login_key'])) {
            //     $patientResponse = Http::get("http://api_gateway/patient/get-patient-phone/" . $data['user']['login_key']);

            //     if ($patientResponse->successful()) {
            //         $patientData = $patientResponse->json();
            //         session(['patient_id' => $patientData['id'] ?? null]);
            //     }
            // }


            Log::info('Session data:', session()->all());

            return redirect()->route('home')->with('success', 'Welcome back!');
        }

        $errors = json_decode($response->body(), true);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }
    public function logout()
    {
        session()->forget(['user', 'token']);
        return redirect()->route('login')->with('status', 'You have been logged out.');
    }
}
