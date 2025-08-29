<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppointmentController extends Controller
{

    private function getDoctorName($doctorId)
    {
        if (!$doctorId)
            return 'N/A';

        $response = Http::get("http://api_gateway/employee/employees/{$doctorId}");
        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['FullName'] ?? 'N/A';
        }

        return 'N/A';
    }

    private function getDepartmentName($departmentId)
    {
        if (!$departmentId)
            return 'N/A';

        $response = Http::get("http://api_gateway/employee/departments/{$departmentId}");
        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['DepartmentName'] ?? 'N/A';
        }

        return 'N/A';
    }
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

    public function createAppointment(Request $request)
    {
        $validatedData = $request->validate([
            'department' => 'required|integer',
            'doctor' => 'required|integer',
            'date' => 'required|date',
            'time-slot' => 'required|string',
            'weekday_id' => 'required|integer'
        ]);

        $patient_id = session('patient_id');
        $validatedData['patient'] = $patient_id; // Use patient_id from session

        $doctorId = $validatedData['doctor'];
        $doctorInfo = Http::get("http://api_gateway/employee/doctors/{$doctorId}");
        // Prepare data for the API request
        $postData = [
            'PatientID' => $validatedData['patient'],
            'DepartmentID' => $validatedData['department'],
            'DoctorID' => $doctorId,
            'AppointmentDate' => $validatedData['date'],
            'TimeSlotID' => $validatedData['time-slot'],
            'WeekdayID' => $validatedData['weekday_id'],
            'RoomID' => $doctorInfo['data']['RoomID']
        ];

        // Send POST request to Appointment Service
        $response = Http::post('http://api_gateway/appointment/appointments', $postData);

        if ($response->successful()) {
            return redirect()->route('appointment.list')->with('success', 'Appointment booked successfully!');
        } else {
            return back()->withErrors(['error' => 'Failed to book appointment. Please try again.'])->withInput();
        }
    }
}
