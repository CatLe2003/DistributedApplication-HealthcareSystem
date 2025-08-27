<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Services\AppointmentService;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppointmentController extends Controller
{

    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }


    // GET /appointments
    public function index()
    {
        try {
            $appointments = Appointment::all();
            return response()->json([
                'message' => 'Appointments fetched successfully',
                'data' => $appointments
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /appointments
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'PatientID' => 'required|integer',
                'DoctorID' => 'required|integer',
                'AppointmentDate' => 'required|date',
                'TimeSlotID' => 'required|integer',
                'RoomID' => 'required|integer',
                'DepartmentID' => 'required|integer',
                'WeekdayID' => 'nullable|integer',
            ]);

            // // Check với các service khác qua API Gateway
            // $apiGateway = config('services.api_gateway.url');

            // $checks = [
            //     "patient/get-patient/{$data['PatientID']}" => 'Patient not found',
            //     "employee/employee/doctors/{$data['DoctorID']}" => 'Doctor not found',
            //     "employee/employee/rooms/{$data['RoomID']}" => 'Room not found',
            //     "employee/employee/departments/{$data['DepartmentID']}" => 'Department not found',
            // ];

            // if (!empty($data['WeekdayID'])) {
            //     $checks["employee/employee/weekdays/{$data['WeekdayID']}"] = 'Weekday not found';
            // }

            // // Map TimeSlotID với ShiftID (Employee service)
            // $checks["employee/employee/shifts/{$data['TimeSlotID']}"] = 'Shift not found';

            // foreach ($checks as $endpoint => $errorMessage) {
            //     $response = Http::get("{$apiGateway}/{$endpoint}");
            //     if ($response->failed() || empty($response->json())) {
            //         return response()->json(['error' => $errorMessage], 422);
            //     }
            // }
            $this->appointmentService->validateEntities($data);

            $appointment = Appointment::create($data);

            return response()->json([
                'message' => 'Appointment created successfully',
                'data' => $appointment
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /appointments/{id}
    public function show($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            return response()->json([
                'message' => 'Appointment fetched successfully',
                'data' => $appointment
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Appointment not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /appointments/{id}
    public function update(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->update($request->all());

            return response()->json([
                'message' => 'Appointment updated successfully',
                'data' => $appointment
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Appointment not found',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /appointments/{id}
    public function destroy($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            return response()->json([
                'message' => 'Appointment deleted successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Appointment not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /appointments/patient/{patientId}
    public function getByPatient($patientId)    
    {
        try {
            $appointments = Appointment::where('PatientID', $patientId)->get();
            return response()->json([
                'message' => 'Appointments fetched successfully',
                'data' => $appointments
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // GET /appointments/doctor/{doctorId}
    public function getByDoctor($doctorId)
    {
        try {
            $appointments = Appointment::where('DoctorID', $doctorId)->get();
            return response()->json([
                'message' => 'Appointments fetched successfully',
                'data' => $appointments
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // GET /appointments/date/{date}
    public function getByDate($date)
    {
        try {
            $appointments = Appointment::where('AppointmentDate', $date)->get();
            return response()->json([
                'message' => 'Appointments fetched successfully',
                'data' => $appointments
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // GET /appointments/doctor/search?date=YYYY-MM-DD&doctorId=1
    public function searchByDateAndDoctor(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'doctorId' => 'required|integer',
            ]);

            $date = $request->query('date');
            $doctorId = $request->query('doctorId');

            $appointments = Appointment::where('AppointmentDate', $date)
                ->where('DoctorID', $doctorId)
                ->get();

            return response()->json([
                'message' => 'Appointments fetched successfully',
                'data' => $appointments
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // GET /appointments/patient/search?date=YYYY-MM-DD&patientId=1
    public function searchByDateAndPatient(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'patientId' => 'required|integer',
            ]);

            $date = $request->query('date');
            $patientId = $request->query('patientId');

            $appointments = Appointment::where('AppointmentDate', $date)
                ->where('PatientID', $patientId)
                ->get();

            return response()->json([
                'message' => 'Appointments fetched successfully',
                'data' => $appointments
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function isSlotAvailable(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'timeslot' => 'required|integer',
                'doctorId' => 'required|integer',
            ]);

            $exists = Appointment::whereDate('AppointmentDate', $request->date)
                ->where('TimeSlotID', $request->timeslot)
                ->where('DoctorID', $request->doctorId)
                ->exists();

            return response()->json([
                'date' => $request->date,
                'timeslot' => $request->timeslot,
                'doctorId' => $request->doctorId,
                'isAvailable' => !$exists  // true nếu chưa có lịch, false nếu đã có
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to check slot availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
