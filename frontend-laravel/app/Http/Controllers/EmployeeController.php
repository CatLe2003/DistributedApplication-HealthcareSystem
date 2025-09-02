<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    public function listDepartments()
    {
        $response = Http::get('http://api_gateway/employee/departments');

        if ($response->successful()) {
            $departments = $response->json()['data'] ?? [];
            return view('department.list_departments', ['departments' => $departments]);
        }

        return view('department.list_departments', [
            'departments' => [],
            'error' => 'Failed to fetch departments. Please try again later.'
        ]);
    }

    public function listDepartmentsHome()
    {
        $response = Http::get('http://api_gateway/employee/departments');

        if ($response->successful()) {
            $departments = $response->json()['data'] ?? [];
            return view('dashboard.homepage', ['departments' => $departments]);
        }

        return view('dashboard.homepage', [
            'departments' => [],
            'error' => 'Failed to fetch departments. Please try again later.'
        ]);
    }

    public function getSchedulesByDoctor(Request $request)
    {
        $userId = session('user_id');

        $doctorResponse = Http::get("http://api_gateway/employee/doctors/by-userid/{$userId}");

        if ($doctorResponse->successful()) {
            $doctorData = $doctorResponse->json()['data'] ?? null;

            if ($doctorData) {
                $doctorId = $doctorData['EmployeeID'];

                $scheduleResponse = Http::get("http://api_gateway/employee/doctors/{$doctorId}/schedules");

                if ($scheduleResponse->successful()) {
                    $schedules = $scheduleResponse->json()['data'] ?? [];
                }
            }
        }

        return view('employee.schedule_management', [
            'schedules' => $schedules,
        ]);
    }
}
