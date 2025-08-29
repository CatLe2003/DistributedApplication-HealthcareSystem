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

        // Fetch all doctors from default department (e.g., department ID 1)
        $doctorResponse = Http::get('http://api_gateway/employee/departments/1/doctors');
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

    public function getAppointmentsByDoctor(Request $request)
    {
        $userId = session('user_id');

        // 2. Fetch the doctor data for this user
        $doctorResponse = Http::get("http://api_gateway/employee/doctors/by-userid/{$userId}");

        $appointments = [];

        if ($doctorResponse->successful()) {
            $doctorData = $doctorResponse->json()['data'] ?? null;

            if ($doctorData) {
                // Assuming API returns a single doctor object
                $doctorId = $doctorData['EmployeeID'];

                // 3. Fetch appointments for this doctor
                $appointmentResponse = Http::get("http://api_gateway/appointment/appointments/doctor/{$doctorId}");

                if ($appointmentResponse->successful()) {
                    $appointments = $appointmentResponse->json()['data'] ?? [];
                }
            }
        }

        return view('appointment.list_appts_staff', [
            'appointments' => $appointments,
            'title' => 'View Appointments - LifeCare'
        ]);
    }
}
