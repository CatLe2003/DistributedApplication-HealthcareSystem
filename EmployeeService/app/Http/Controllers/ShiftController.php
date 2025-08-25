<?php

namespace App\Http\Controllers;
use App\Models\Shift;
use Illuminate\Http\Request;
use Exception;


class ShiftController extends Controller
{
    // GET /shifts
    public function getAllShifts(Request $request)
    {
        try {
            $shifts = Shift::all();

            return response()->json([
                'success' => true,
                'data' => $shifts
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch shifts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // GET /shifts/{id}
    public function getShiftById($id)
    {
       try {

            if(!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid shift ID'
                ], 400);
            }
            
            $shift = Shift::find($id);

            if (!$shift) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shift not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $shift
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch shift',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
