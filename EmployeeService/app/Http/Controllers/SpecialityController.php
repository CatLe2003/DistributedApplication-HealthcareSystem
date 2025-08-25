<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
use Exception;

class SpecialityController extends Controller
{
    // GET /specialities
    public function getAllSpecialities(Request $request)
    {
        try {
            $specialities = Speciality::all();

            return response()->json([
                'success' => true,
                'data' => $specialities
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch specialities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /specialities/{id}
    public function getSpecialityById($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid speciality ID'
                ], 400);
            }

            $speciality = Speciality::find($id);

            if (!$speciality) {
                return response()->json([
                    'success' => false,
                    'message' => 'Speciality not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $speciality
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch speciality',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
