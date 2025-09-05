<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Services\AppointmentService;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\ScheduledReminder;

class AppointmentController extends Controller
{

    protected $appointmentService;

    private function mapTimeSlot($timeSlotId)
    {
        $map = [
            1 => '09:00:00',
            2 => '09:30:00',
            3 => '10:00:00',
            4 => '10:30:00',
            5 => '11:00:00',
            6 => '13:00:00',
            7 => '13:30:00',
            8 => '14:00:00',
            9 => '14:30:00',
            10 => '15:00:00',
            11 => '15:30:00',
            12 => '16:00:00',
            13 => '16:30:00',
            14 => '17:00:00',
            15 => '17:30:00',
        ];

        return $map[$timeSlotId] ?? '09:00:00';
    }
    
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

            $this->appointmentService->validateEntities($data);

            $appointment = Appointment::create($data);

            $appointmentTime = $data['AppointmentDate'] . ' ' . $this->mapTimeSlot($data['TimeSlotID']);

            // Gọi Reminder Service
            $reminder = new ScheduledReminder();
            $reminder->publishDelayedNotification($data['PatientID'], $appointmentTime);


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

    // GEt /appointments/is-slot-available?date=YYYY-MM-DD&timeslot=1&doctorId=1
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
