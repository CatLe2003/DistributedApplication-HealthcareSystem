<?php

namespace App\Http\Controllers;

use App\Models\Weekday;
use Illuminate\Http\Request;
use Exception;

class WeekdayController extends Controller
{
    // GET /weekdays
    public function getAllWeekdays(Request $request)
    {
        try {
            $weekdays = Weekday::all();

            return response()->json([
                'success' => true,
                'data' => $weekdays
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch weekdays',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /weekdays/{id}
    public function getWeekdayById($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid weekday ID'
                ], 400);
            }

            $weekday = Weekday::find($id);

            if (!$weekday) {
                return response()->json([
                    'success' => false,
                    'message' => 'Weekday not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $weekday
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch weekday',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
