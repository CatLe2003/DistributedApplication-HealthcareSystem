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

        if (!$userId) {
            return redirect()->back()->withErrors(['message' => 'User ID not found in session. Please log in again.']);
        }

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

    public function getAllShifts()
    {
        $response = Http::get('http://api_gateway/employee/shifts');

        if ($response->successful()) {
            $shifts = $response->json()['data'] ?? [];
            return view('employee.add_schedule', ['shifts' => $shifts]);
        }

        return view('employee.add_schedule', [
            'shifts' => [],
            'error' => 'Failed to fetch shifts. Please try again later.'
        ]);
    }

    public function addSchedule(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->back()->withErrors(['message' => 'User ID not found in session. Please log in again.']);
        }

        $doctorResponse = Http::get("http://api_gateway/employee/doctors/by-userid/{$userId}");

        if ($doctorResponse->successful()) {
            $doctorData = $doctorResponse->json()['data'] ?? null;

            if ($doctorData) {
                $doctorId = $doctorData['EmployeeID'];

                $validated = $request->validate([
                    'WeekdayID' => 'required|integer',
                    'ShiftID' => 'required|integer',
                ]);

                $validated['DoctorID'] = $doctorId;

                $response = Http::post('http://api_gateway/employee/doctor-schedules', $validated);

                if ($response->successful()) {
                    return redirect()->route('employee.schedule_management')->with('success', 'Schedule added successfully.');
                }
                $errors = json_decode($response->body(), true);
                return redirect()->back()->withErrors($errors);

            }
            return redirect()->back()->with('error', 'Failed to retrieve doctor information.');
        }
        return redirect()->back()->with('error', 'Failed to add schedule. Please try again later.');
    }

    public function deleteSchedule($id)
    {
        $response = Http::delete("http://api_gateway/employee/doctor-schedules/{$id}");

        if ($response->successful()) {
            return redirect()->route('employee.schedule_management')->with('success', 'Schedule deleted successfully.');
        }

        return redirect()->back()->with('error', 'Failed to delete schedule. Please try again later.');
    }
}
