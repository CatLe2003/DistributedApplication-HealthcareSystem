<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Exception;

class DoctorController extends Controller
{
    // GET /doctors
    public function getAllDoctors(Request $request)
    {
        try {
            $doctors = Doctor::with(['speciality', 'department', 'room'])->get();
            return response()->json([
                'success' => true,
                'data' => $doctors
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // GET /doctors/{id}
    public function getDoctorById($id)
    {
        try {
            $doctor = Doctor::with(['speciality', 'department', 'room', 'schedules'])->find($id);
            if (!$doctor) {
                return response()->json(['success' => false, 'message' => 'Doctor not found'], 404);
            }
            return response()->json(['success' => true, 'data' => $doctor], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
    // GET /specialities/{id}/doctors
    public function getDoctorsBySpecialityId($id)
    {
        try {
            $doctors = Doctor::where('SpecialityID', $id)->with(['speciality', 'room'])->get();
            return response()->json(['success' => true, 'data' => $doctors], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // GET /rooms/{id}/doctors
    public function getDoctorsByRoomId($id)
    {
        try {
            $doctors = Doctor::where('RoomID', $id)->with(['speciality', 'room'])->get();
            return response()->json(['success' => true, 'data' => $doctors], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // GET /shifts/{id}/doctors
    public function getDoctorsByShiftId($id)
    {
        try {
            $doctors = Doctor::whereHas('schedules', function($q) use ($id) {
                $q->where('ShiftID', $id);
            })->with(['speciality', 'room', 'schedules'])->get();

            return response()->json(['success' => true, 'data' => $doctors], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}


