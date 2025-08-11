<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class PrescriptionController extends Controller
{
     public function create(Request $request)
    {
        try {
            // Validation phase
            $incomingFields = $request->validate([
                'visit_id' => 'required|exists:medicalvisit,id',
                'notes' => 'nullable|string|max:255',
                'status' => 'required|string|max:255',
                'date' => 'required|date',
            ]);

            // Database insert phase
            Prescription::create($incomingFields);

            return response()->json(['message' => 'Prescription created successfully']);
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
        $prescription = Prescription::find($id);
        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }
        return response()->json($prescription);
    }
}
