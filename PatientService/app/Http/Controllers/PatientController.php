<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validation phase
            $incomingFields = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:patient,email',
                'phone_number' => 'required|string|max:15',
                'gender' => 'required|string|max:10',
                'date_of_birth' => 'required|date',
                'citizen_id' => 'required|string|max:15|unique:patient,citizen_id',
                'address' => 'required|string|max:255',
                'nationality' => 'required|string|max:255',
                'ethnicity' => 'required|string|max:255',
                'occupation' => 'required|string|max:255',
                'allergy' => 'required|string|max:255',
            ]);

            // Database insert phase
            Patient::create($incomingFields);

            return response()->json(['message' => 'Patient registered successfully']);
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
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }
        return response()->json($patient);
    }

    public function findByPhone($phone_number)
    {
        $patient = Patient::where('phone_number', $phone_number)->first();

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }


    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        try {
            // Validation rules (email & citizen_id must ignore current patient)
            $incomingFields = $request->validate([
                'full_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:patient,email,' . $id,
                'phone_number' => 'sometimes|string|max:15',
                'gender' => 'sometimes|string|max:10',
                'date_of_birth' => 'sometimes|date',
                'citizen_id' => 'sometimes|string|max:15|unique:patient,citizen_id,' . $id,
                'address' => 'sometimes|string|max:255',
                'nationality' => 'sometimes|string|max:255',
                'ethnicity' => 'sometimes|string|max:255',
                'occupation' => 'sometimes|string|max:255',
                'allergy' => 'sometimes|string|max:255',
            ]);

            $patient->update($incomingFields);

            return response()->json([
                'message' => 'Patient updated successfully',
                'data' => $patient
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected error'], 500);
        }
    }

    public function delete($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        try {
            $patient->delete();

            return response()->json(['message' => 'Patient deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected error'], 500);
        }
    }

    public function getAll()
    {
        try {
            $patients = Patient::all();
            return response()->json([
                'message' => 'Patients retrieved successfully',
                'data' => $patients
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve patients'], 500);
        }
    }

}
