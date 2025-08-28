<?php

namespace App\Http\Controllers;

use App\Models\MedicalVisit;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class MedicalVisitController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }


    public function create(Request $request)
    {
        try {
            // Validation phase
            $incomingFields = $request->validate([
                'patient_id' => 'required|exists:patient,id',
                'doctor_id' => 'required',
                'department_id' => 'required',
                'visit_date' => 'required|date',
                'diagnosis' => 'required|string|max:255',
                'symptoms' => 'required|string|max:255',
                'notes' => 'nullable|string|max:255',
            ]);
            $this->patientService->validateEntitiesMedicalVisit($incomingFields);

            // Database insert phase
            MedicalVisit::create($incomingFields);

            return response()->json(['message' => 'Medical Visit created successfully']);
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
        $medicalVisit = MedicalVisit::find($id);
        if (!$medicalVisit) {
            return response()->json(['message' => 'Medical visit not found'], 404);
        }
        return response()->json($medicalVisit);
    }

    public function findByPatient($patientId)
    {
        $visits = MedicalVisit::where('patient_id', $patientId)->get();

        if ($visits->isEmpty()) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($visits);
    }

    public function getAll()
    {
        try {
            $medicalVisits = MedicalVisit::all();
            return response()->json([
                'message' => 'Medical visits retrieved successfully',
                'data' => $medicalVisits
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve medical visits'], 500);
        }
    }
}
