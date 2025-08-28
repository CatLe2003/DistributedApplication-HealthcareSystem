<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon; 
use App\Models\Shift;
use App\Models\Doctor;
use App\Models\Weekday;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DoctorScheduleController extends Controller
{
    // GET /doctor-schedules
    public function getAllSchedules()
    {
        try {
            $schedules = DoctorSchedule::with(['doctor', 'weekday', 'shift'])->get();

            return response()->json([
                'success' => true,
                'data' => $schedules
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch schedules',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /doctor-schedules/{id}
    public function getScheduleById($id)
    {
        try {
            $schedule = DoctorSchedule::with(['doctor', 'weekday', 'shift'])->find($id);

            if (!$schedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Schedule not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $schedule
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /doctor-schedules
    public function createSchedule(Request $request)
    {
        try {
            $request->validate([
                'DoctorID' => 'required|exists:doctors,DoctorID',
                'WeekdayID' => 'required|exists:weekdays,WeekdayID',
                'ShiftID' => 'required|exists:shifts,ShiftID'
            ]);

            $schedule = DoctorSchedule::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Schedule created successfully',
                'data' => $schedule
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /doctor-schedules/{id}
    public function updateSchedule(Request $request, $id)
    {
        try {
            $schedule = DoctorSchedule::find($id);

            if (!$schedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Schedule not found'
                ], 404);
            }

            $request->validate([
                'DoctorID' => 'sometimes|exists:doctors,DoctorID',
                'WeekdayID' => 'sometimes|exists:weekdays,WeekdayID',
                'ShiftID' => 'sometimes|exists:shifts,ShiftID'
            ]);

            $schedule->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Schedule updated successfully',
                'data' => $schedule
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /doctor-schedules/{id}
    public function deleteSchedule($id)
    {
        try {
            $schedule = DoctorSchedule::find($id);

            if (!$schedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Schedule not found'
                ], 404);
            }

            $schedule->delete();

            return response()->json([
                'success' => true,
                'message' => 'Schedule deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /doctors/{doctorId}/schedules
    public function getSchedulesByDoctor($doctorId)
    {
        try {
            $schedules = DoctorSchedule::with(['weekday', 'shift'])
                ->where('DoctorID', $doctorId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $schedules
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch doctor schedules',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /doctor-schedules/by-weekday/{weekdayId}
    public function getSchedulesByWeekday($weekdayId)
    {
        try {
            $schedules = DoctorSchedule::with(['doctor', 'shift'])
                ->where('WeekdayID', $weekdayId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $schedules
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch schedules',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /doctor-schedules/by-shift/{shiftId}
    public function getSchedulesByShift($shiftId)
    {
        try {
            $schedules = DoctorSchedule::with(['doctor', 'weekday'])
                ->where('ShiftID', $shiftId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $schedules
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch schedules',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /doctor-schedules/available?date=YYYY-MM-DD&shift=1
    public function getAvailableDoctors(Request $request)
    {
        try {
            
            $request->validate([
                'date' => 'required|date',
                'shift' => 'required|integer'
            ]);
            
            $date = $request->query('date');
            $shiftId = $request->query('shift'); 

            $weekdayName = date('l', strtotime($date));
            $weekday = Weekday::where('WeekdayName', $weekdayName)->first();

            Log::info("Finding available doctors for date: {$date}, which is a {$weekdayName}, shift ID: {$shiftId}");

            if (!$weekday) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid weekday'
                ], 400);
            }

            $doctorIds = DoctorSchedule::where('WeekdayID', $weekday->WeekdayID)
                ->where('ShiftID', $shiftId)
                ->pluck('DoctorID');

            $availableDoctors = Doctor::whereIn('EmployeeID', $doctorIds)->get();

            return response()->json([
                'success' => true,
                'data' => $availableDoctors
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch available doctors',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // POST /doctor-schedules/check-availability
    public function checkDoctorAvailability(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',       // Ngày cần check
                'doctorId' => 'required|integer',
                'shiftId' => 'required|integer',
            ]);

            $date = Carbon::parse($request->date);
            $weekdayName = $date->format('l'); // Monday, Tuesday,...
            
            // Lấy weekdayId từ bảng weekdays
            $weekday = DB::table('weekdays')
                ->where('WeekdayName', $weekdayName)
                ->first();

            if (!$weekday) {
                return response()->json([
                    'available' => false,
                    'message' => 'Invalid weekday mapping'
                ]);
            }

            $weekdayId = $weekday->WeekdayID;

            // Check trong doctor_schedules có tồn tại không
            $exists = DB::table('doctor_schedules')
                ->where('DoctorID', $request->doctorId)
                ->where('WeekdayID', $weekdayId)
                ->where('ShiftID', $request->shiftId)
                ->exists();

            return response()->json([
                'isAvailable' => $exists,
                'doctorId' => $request->doctorId,
                'shiftId' => $request->shiftId,
                'date' => $request->date,
                'weekdayId' => $weekdayId,
                'weekdayName' => $weekdayName
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to check availability',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
