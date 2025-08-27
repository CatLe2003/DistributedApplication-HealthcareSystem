<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class FollowUpController extends Controller
{
    public function create(Request $request)
    {
        try {
            // Validation phase
            $incomingFields = $request->validate([
                'visit_id' => 'required|exists:medicalvisit,id',
                'date' => 'required|date',
                'notes' => 'nullable|string',
            ]);

            // Database insert phase
            FollowUp::create($incomingFields);

            return response()->json(['message' => 'Follow up information created successfully']);
        } catch (ValidationException $e) {
            // Laravel validation error (duplicate found during validation or invalid input)
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            // Database error (e.g., race condition causing duplicate after validation)
            if ($e->errorInfo[1] == 1062) { // MySQL duplicate entry error code
                return response()->json(['message' => 'Duplicate entry detected'], 409);
            }
            return response()->json(['message' => 'Database error'], 500);
        } catch (\Exception $e) {
            // Any other error
            return response()->json(['message' => 'Unexpected error'], 500);
        }
    }  
    public function show($id)
    {
        $FollowUp = FollowUp::find($id);
        if (!$FollowUp) {
            return response()->json(['message' => 'Follow up information not found'], 404);
        }
        return response()->json($FollowUp);
    }

    public function getAll()
    {
        try {
            $followUps = FollowUp::all();
            return response()->json([
                'message' => 'Follow ups retrieved successfully',
                'data' => $followUps
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve follow ups'], 500);
        }
    }
}
