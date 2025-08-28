<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppointmentController extends Controller
{
    public function showBookingForm()
    {
        // Fetch departments from Employee Service
        $departmentResponse = Http::get('http://api_gateway/employee/departments');
        $departments = [];
        if ($departmentResponse->successful()) {
            $departments = $departmentResponse->json()['data'] ?? [];
        }

        // Fetch all doctors from Employee Service
        $doctorResponse = Http::get('http://api_gateway/employee/doctors');
        $doctors = [];
        if ($doctorResponse->successful()) {
            $doctors = $doctorResponse->json()['data'] ?? [];
        }

        return view('appointment.add_appt', [
            'departments' => $departments,
            'doctors' => $doctors,
            'title' => 'Book An Appointment - LifeCare'
        ]);
    }
}
