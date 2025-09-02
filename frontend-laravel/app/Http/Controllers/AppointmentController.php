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

    public function getAppointmentsByPatient(Request $request)
    {
        $patientId = session('patient_id');

        // Fetch appointments for this patient
        $appointmentResponse = Http::get("http://api_gateway/appointment/appointments/patient/{$patientId}");

        $appointments = [];
        if ($appointmentResponse->successful()) {
            $appointments = $appointmentResponse->json()['data'] ?? [];
        }

        // Enrich appointments with doctor and department names
        foreach ($appointments as &$appointment) {
            $appointment['DoctorName'] = $this->getDoctorName($appointment['DoctorID']);
            $appointment['DepartmentName'] = $this->getDepartmentName($appointment['DepartmentID']);
        }

        return view('appointment.list_appts', [
            'appointments' => $appointments,
        ]);
    }

    public function createAppointment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                    'department' => 'required|integer',
                    'doctor' => 'required|integer',
                    'date' => 'required|date',
                    'time-slot' => 'required|string',
                    'weekday_id' => 'required|integer'
                ]);

                $dateString = $validatedData['date'];

                // Check if the date is in the past
                $currentDate = date('Y-m-d');
                if ($dateString < $currentDate) {
                    return back()->withErrors(['error' => 'The selected date is in the past. Please choose a valid date.'])->withInput();
                }
                
                // Check slot availability
                $availabilityResponse = Http::get("http://api_gateway/appointment/appointments/is-slot-available?date={$dateString}&timeslot={$validatedData['time-slot']}&doctorId={$validatedData['doctor']}");

                if ($availabilityResponse->failed() || !$availabilityResponse->json('isAvailable')) {
                    return back()->withErrors(['error' => 'The selected time slot is not available. Please choose another slot.'])->withInput();
                }

                // Get patient ID from session
                $patient_id = session('patient_id');
                $validatedData['patient'] = $patient_id; 

                // Fetch doctor info to get RoomID
                $doctorId = $validatedData['doctor'];
                $doctorInfo = Http::get("http://api_gateway/employee/doctors/{$doctorId}");
                // Prepare data for the API request
                $postData = [
                    'PatientID' => $validatedData['patient'],
                    'DepartmentID' => $validatedData['department'],
                    'DoctorID' => $doctorId,
                    'AppointmentDate' => $dateString,
                    'TimeSlotID' => $validatedData['time-slot'],
                    'WeekdayID' => $validatedData['weekday_id'],
                    'RoomID' => $doctorInfo['data']['RoomID']
                ];

                // Send POST request to Appointment Service
                $response = Http::post('http://api_gateway/appointment/appointments', $postData);

                if ($response->successful()) {
                    return redirect()->route('appointment.list_appts')->with('success', 'Appointment booked successfully!');
                } else {
                    return back()->withErrors(['error' => 'Failed to book appointment. Please try again.'])->withInput();
                }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.'])->withInput();
        }
  
    }
}
