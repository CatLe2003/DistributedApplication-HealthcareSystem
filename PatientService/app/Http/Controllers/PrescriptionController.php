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
            // 1. Validate the request
            $validated = $request->validate([
                'visit_id' => 'required|exists:medicalvisit,id',
                'status' => 'required|string|in:printed, not printed',
                'date' => 'required|date',
                'notes' => 'nullable|string',

                'details' => 'required|array|min:1',
                'details.*.medicine_id' => 'required|integer',
                'details.*.dosage' => 'required|string',
                'details.*.duration' => 'required|string'
            ]);

            // 2. Create the prescription (parent)
            $prescription = Prescription::create([
                'visit_id' => $validated['visit_id'],
                'status' => $validated['status'],
                'date' => $validated['date'],
                'notes' => $validated['notes'] ?? null
            ]);

            // 3. Create multiple prescription details (children)
            foreach ($validated['details'] as $detail) {
                $prescription->details()->create([
                    'medicine_id' => $detail['medicine_id'],
                    'dosage' => $detail['dosage'],
                    'duration' => $detail['duration']
                ]);
            }
            return response()->json($prescription->load('details'));
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
        $prescription = Prescription::with('details')->find($id);
        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }
        return response()->json($prescription);
    }

    public function getAll()
    {
        try {
            $prescriptions = Prescription::with('details')->get();
            return response()->json([
                'message' => 'Prescriptions retrieved successfully',
                'data' => $prescriptions
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve prescriptions'], 500);
        }
    }

    public function findByPatient($patientId)
    {
        $prescriptions = Prescription::where('patient_id', $patientId)->get();

        if ($prescriptions->isEmpty()) {
            return response()->json(['message' => 'Prescriptions not found'], 404);
        }

        return response()->json($prescriptions);
    }

    public function getByPatientAndDate(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'nullable|integer',
                'date' => 'nullable|date'
            ]);

            $query = Prescription::with('details');

            // Apply patient filter if provided
            if ($request->has('patient_id')) {
                $query->whereHas('medicalVisit', function($q) use ($request) {
                    $q->where('patient_id', $request->patient_id);
                });
            }

            // Apply date filter if provided
            if ($request->has('date')) {
                $query->whereDate('date', $request->date);
            }

            $prescriptions = $query->get();

            return response()->json([
                'message' => 'Prescriptions retrieved successfully',
                'data' => $prescriptions
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve prescriptions'], 500);
        }
    }
}
