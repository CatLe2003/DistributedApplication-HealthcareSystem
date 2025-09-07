<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{

    private function getDoctorName($doctorId)
    {
        if (!$doctorId)
            return 'N/A';

        $response = Http::get("http://api_gateway/employee/employees/{$doctorId}");
        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['FullName'] ?? 'N/A';
        }

        return 'N/A';
    }

    private function getDepartmentName($departmentId)
    {
        if (!$departmentId)
            return 'N/A';

        $response = Http::get("http://api_gateway/employee/departments/{$departmentId}");
        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['DepartmentName'] ?? 'N/A';
        }

        return 'N/A';
    }

    private function getPatientNamePhone($patientId)
    {
        if (!$patientId)
            return ['name' => 'N/A', 'phone' => 'N/A'];
        $response = Http::get("http://api_gateway/patient/get-patient/{$patientId}");
        if ($response->successful()) {
            $data = $response->json();
            return ['name' => $data['full_name'] ?? 'N/A', 'phone' => $data['phone_number'] ?? 'N/A',];
        }
        return ['name' => 'N/A', 'phone' => 'N/A'];
    }

    private function getMedicineName($medicineId)
    {
        if (!$medicineId)
            return 'N/A';

        $response = Http::get("http://api_gateway/medical_catalog/medicines/{$medicineId}");
        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['MedicineName'] ?? 'N/A';
        }

        return 'N/A';
    }

    private function getPrescriptionsByVisit($visitId)
    {
        $response = Http::get("http://api_gateway/patient/get-prescription-by-visit/{$visitId}");

        if (!$response->successful()) {
            return [];
        }

        $prescriptions = $response->json();

        // Loop through prescriptions safely using indexes
        foreach ($prescriptions as $pIndex => $prescription) {
            if (!isset($prescription['details']) || !is_array($prescription['details'])) {
                $prescriptions[$pIndex]['details'] = [];
                continue;
            }

            foreach ($prescription['details'] as $dIndex => $detail) {
                // Safely get medicine_name for each detail
                $medicineId = $detail['medicine_id'] ?? null;
                $prescriptions[$pIndex]['details'][$dIndex]['medicine_name'] = $this->getMedicineName($medicineId);
            }
        }

        return $prescriptions;
    }

    private function getOrdersByVisit($visitId)
    {
        $response = Http::get("http://api_gateway/patient/get-order-by-visit/{$visitId}");
        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    private function getFollowupsByVisit($visitId)
    {
        $response = Http::get("http://api_gateway/patient/get-followup-by-visit/{$visitId}");
        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    public function registerProfile(Request $request)
    {
        $response = Http::post('http://api_gateway/patient/register-patient', $request->all());

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Profile registered successfully!');
        }

        $errors = json_decode($response->body(), true);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }

    public function getProfile(Request $request)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::get("http://api_gateway/patient/get-patient/{$patientId}");

        $appointmentResponse = Http::get("http://api_gateway/appointment/appointments/patient/{$patientId}");

        $appointments = [];
        if ($appointmentResponse->successful()) {
            $appointments = $appointmentResponse->json()['data'] ?? [];
        }

        // Enrich appointments with doctor and department names
        foreach ($appointments as &$appointment) {
            $appointment['DoctorName'] = $this->getDoctorName($appointment['DoctorID']);
            $appointment['DepartmentName'] = $this->getDepartmentName($appointment['DepartmentID']);
        }


        if ($response->successful()) {
            return view('medical_record.profile', ['profile' => $response->json(), 'appointments' => $appointments]);
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function getProfileBeforeUpdate(Request $request)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::get("http://api_gateway/patient/get-patient/{$patientId}");

        if ($response->successful()) {
            return view('medical_record.update_profile', ['profile' => $response->json()]);
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function updateProfile(Request $request)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::put("http://api_gateway/patient/update-patient/{$patientId}", $request->all());

        if ($response->successful()) {
            return redirect()->route('medical_record.profile')->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function getMedicalVisits(Request $request)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $response = Http::get("http://api_gateway/patient/get-medicalvisit-patient/{$patientId}");

        if (!$response->successful()) {
            return redirect()->back()->withErrors(['message' => $response->body()]);
        }

        $medicalVisits = $response->json();

        $medicalVisits = collect($medicalVisits)->map(function ($visit) {
            // Get doctor name
            // Doctor
            $doctorName = 'N/A';
            $doctorResponse = Http::get("http://api_gateway/employee/employees/{$visit['doctor_id']}");
            if ($doctorResponse->successful()) {
                $doctorData = $doctorResponse->json();
                // Adjust here to access the 'data' key if API wraps it
                $doctorName = $doctorData['data']['FullName'] ?? 'N/A';
            }
            $visit['doctor_name'] = $doctorName;

            // Department
            $departmentName = 'N/A';
            $departmentResponse = Http::get("http://api_gateway/employee/departments/{$visit['department_id']}");
            if ($departmentResponse->successful()) {
                $departmentData = $departmentResponse->json();
                // Adjust here to access the 'data' key
                $departmentName = $departmentData['data']['DepartmentName'] ?? 'N/A';
            }
            $visit['department_name'] = $departmentName;

            return $visit;
        })->toArray();

        return view('medical_record.medical_records', ['medical_visits' => $medicalVisits]);
    }

    public function getMedicalVisitDetail($id)
    {
        $patientId = session('patient_id'); // get patient_id from session
        if (!$patientId) {
            return redirect()->back()->withErrors(['message' => 'Patient ID not found in session. Please log in again.']);
        }

        $visitResponse = Http::get("http://api_gateway/patient/get-medicalvisit/{$id}");
        if (!$visitResponse->successful()) {
            return redirect()->back()->withErrors(['message' => $visitResponse->body()]);
        }

        $medicalVisit = $visitResponse->json();

        // Enrich visit with doctor and department names
        $medicalVisit['doctor_name'] = $this->getDoctorName($medicalVisit['doctor_id'] ?? null);
        $medicalVisit['department_name'] = $this->getDepartmentName($medicalVisit['department_id'] ?? null);

        // Get related data
        $prescriptions = $this->getPrescriptionsByVisit($id);
        $orders = $this->getOrdersByVisit($id);
        $followups = $this->getFollowupsByVisit($id);

        return view('medical_record.detail_medrecord', compact('medicalVisit', 'prescriptions', 'orders', 'followups'));
    }

    public function getMedicalVisitDetailStaff($id)
    {
        $visitResponse = Http::get("http://api_gateway/patient/get-medicalvisit/{$id}");
        if (!$visitResponse->successful()) {
            return redirect()->back()->withErrors(['message' => $visitResponse->body()]);
        }

        $medicalVisit = $visitResponse->json();

        // Enrich visit with doctor and department names
        $medicalVisit['doctor_name'] = $this->getDoctorName($medicalVisit['doctor_id'] ?? null);
        $medicalVisit['department_name'] = $this->getDepartmentName($medicalVisit['department_id'] ?? null);

        // // Get related data
        // $prescriptions = $this->getPrescriptionsByVisit($id);
        // $orders = $this->getOrdersByVisit($id);
        // $followups = $this->getFollowupsByVisit($id);

        return view('medical_record.detail_medvisit_staff', compact('medicalVisit'));
    }

    public function getAll(Request $request)
    {
        $response = Http::get('http://api_gateway/patient/get-patients');

        if ($response->successful()) {
            $patients = $response->json()['data']; // Access 'data' key
            return view('patient.list_patients', compact('patients'));
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function getAllPrescriptions(Request $request)
    {
        $response = Http::get("http://api_gateway/patient/get-prescriptions");

        if ($response->successful()) {
            $prescriptions = $response->json()['data']; // Access 'data' key
            return view('patient.prescriptions', compact('prescriptions'));
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function getStatisticalReport(Request $request)
    {
        // Validate filter input for prescriptions
        $filterData = $request->validate([
            'month_year' => 'nullable|date_format:Y-m',
            'patient' => 'nullable',
            'from' => 'nullable|date_format:Y-m',
            'to' => 'nullable|date_format:Y-m',
        ]);

        // Get filter values
        $monthYear = $filterData['month_year'] ?? null;
        $patientId = $filterData['patient'] ?? null;
        $from = $filterData['from'] ?? null;
        $to = $filterData['to'] ?? null;

        // Always fetch all patients and doctors for dropdowns
        $patientsResponse = Http::get('http://api_gateway/patient/get-patients');
        $doctorsResponse = Http::get("http://api_gateway/employee/employees");

        // Fetch all prescriptions by default
        $prescriptionsResponse = Http::get("http://api_gateway/patient/get-prescriptions");

        $medicinesResponse = Http::get('http://api_gateway/medical_catalog/medicines');
        // Filter prescriptions if filter button is pressed
        $prescriptions = [];
        if ($request->has('btn-add-prescfilter')) {
            // Prepare filter params
            $params = [];
            if ($monthYear) {
                $params['date'] = $monthYear;
            }
            if ($patientId && $patientId !== 'all') {
                $params['patient_id'] = $patientId;
            }
            $prescriptionsFilter = Http::get("http://api_gateway/patient/get-prescriptions/filter", $params);
            if ($prescriptionsFilter->successful()) {
                $prescriptions = $prescriptionsFilter->json()['data'] ?? [];
            }
        } else {
            if ($prescriptionsResponse->successful()) {
                $prescriptions = $prescriptionsResponse->json()['data'] ?? [];
            }
        }

        // Patients for patient statistics (filtered by from/to if provided)
        $patients = [];
        if ($patientsResponse->successful()) {
            $patients = $patientsResponse->json()['data'] ?? [];
        }

        // Doctors for dropdown
        $doctors = [];
        if ($doctorsResponse->successful()) {
            $doctors = $doctorsResponse->json()['data'] ?? [];
        }
        // Medicines for medicine statistics
        $medicines = [];
        if ($medicinesResponse->successful()) {
            $medicines = $medicinesResponse->json()['data'] ?? [];
        }
        // Pass all data to view
        return view('dashboard.statistical_report', compact('patients', 'prescriptions', 'doctors', 'medicines'));
    }


    public function getAllMedicalVisits(Request $request)
    {
        $response = Http::get("http://api_gateway/patient/get-medicalvisits");

        if ($response->successful()) {
            $medicalVisits = $response->json()['data'] ?? [];
            return view('medical_record.medvisit_staff', compact('medicalVisits'));
        }
        return redirect()->back()->withErrors(['message' => $response->body()]);
    }

    public function showAddForm($visit_id)
    {
        // Fetch medicines for dropdown
        $response = Http::get("http://api_gateway/medical_catalog/medicines/");
        $medicines = [];

        if ($response->successful()) {
            $medicines = $response->json()['data'] ?? [];
        }

        return view('patient.add_prescription', [
            'visit_id' => $visit_id,
            'medicines' => $medicines,
        ]);
    }

    public function createPrescription(Request $request)
    {
        $payload = [
            "visit_id" => $request->input('visit_id'),
            "notes" => $request->input('notes'),
            "status" => "NEW",
            "date" => $request->input('date'),
            "details" => [],
        ];

        // Collect prescription details (multiple rows)
        $medicineIds = $request->input('medicine_id', []);
        $dosages = $request->input('dosage', []);
        $durations = $request->input('duration', []);

        foreach ($medicineIds as $index => $medicineId) {
            if (!empty($medicineId)) {
                $payload['details'][] = [
                    "medicine_id" => $medicineId,
                    "dosage" => $dosages[$index] ?? "",
                    "duration" => $durations[$index] ?? "",
                ];
            }
        }
        Log::info("Sending prescription payload", $payload);
        // Send POST request to API Gateway
        $response = Http::post("http://api_gateway/patient/create-prescription", $payload);
        Log::info("Prescription API response", [
            'status' => $response->status(),
            'body' => $response->body()
        ]);
        if ($response->successful()) {
            return redirect()->route('prescriptions', ['id' => $request->input('visit_id')])
                ->with('success', 'Prescription created successfully!');
        } else {
            //return back()->with('error', 'Failed to create prescription.');
            return back()->withErrors(['message' => $response->body()]);
        }
    }

    public function showAddMedVisitForm()
    {
        // Fetch patients for dropdown
        $patients = [];
        $response = Http::get("http://api_gateway/patient/get-patients");
        if ($response->successful()) {
            $patients = $response->json()['data'] ?? [];
        }

        // Get user role and ID from session
        $userRole = session('user_role');
        $userId = session('user_id');
        $doctors = [];
        $doctor = null;
        $department = null;

        if ($userRole === 'STAFF') {
            // Staff can choose from all doctors
            $doctorsResponse = Http::get("http://api_gateway/employee/doctors");
            if ($doctorsResponse->successful()) {
                $doctors = $doctorsResponse->json()['data'] ?? [];
            }
        } elseif ($userRole === 'DOCTOR' && $userId) {
            // Doctor role - fetch current doctor's info (readonly)
            $doctorResponse = Http::get("http://api_gateway/employee/doctors/by-userid/{$userId}");
            if ($doctorResponse->successful()) {
                $doctorData = $doctorResponse->json()['data'] ?? null;

                if ($doctorData) {
                    $doctor = $doctorData;

                    // Fetch department info for the doctor
                    $deptResponse = Http::get("http://api_gateway/employee/departments/{$doctorData['DepartmentID']}");
                    if ($deptResponse->successful()) {
                        $department = $deptResponse->json()['data'] ?? null;
                    }
                }
            }
        }

        return view('medical_record.add_medvisit', [
            'patients' => $patients,
            'doctors' => $doctors,
            'doctor' => $doctor,
            'department' => $department,
            'userRole' => $userRole,
        ]);
    }

    public function getDepartmentByDoctor($doctorId)
    {
        try {
            // First get doctor info to get department ID
            $doctorResponse = Http::get("http://api_gateway/employee/doctors/{$doctorId}");
            if (!$doctorResponse->successful()) {
                return response()->json(['error' => 'Doctor not found'], 404);
            }

            $doctorData = $doctorResponse->json()['data']['speciality'] ?? null;
            if (!$doctorData || !isset($doctorData['DepartmentID'])) {
                return response()->json(['error' => 'Department ID not found'], 404);
            }

            // Get department info
            $deptResponse = Http::get("http://api_gateway/employee/departments/{$doctorData['DepartmentID']}");
            if (!$deptResponse->successful()) {
                return response()->json(['error' => 'Department not found'], 404);
            }

            $department = $deptResponse->json()['data'] ?? null;

            return response()->json([
                'success' => true,
                'department' => $department
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function createMedVisit(Request $request)
    {
        $formattedDate = null;
        if ($request->filled('visit_date')) {
            $formattedDate = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->visit_date)
                ->format('Y-m-d H:i:s');
        }
        $payload = [
            "patient_id" => $request->input('patient_id'),
            "doctor_id" => $request->input('doctor_id'),
            "department_id" => $request->input('department_id'),
            "visit_date" => $formattedDate,
            "diagnosis" => $request->input('diagnosis'),
            "symptoms" => $request->input('symptoms'),
            "notes" => $request->input('notes'),
        ];

        Log::info("Sending medical visit payload", $payload);

        // Send POST request to API Gateway
        $response = Http::post("http://api_gateway/patient/create-medicalvisit", $payload);
        Log::info("Medical visit API response", [
            'status' => $response->status(),
            'body' => $response->body()
        ]);
        if ($response->successful()) {
            return redirect()->route('medvisit_staff')
                ->with('success', 'Medical visit created successfully!');
        } else {
            return back()->withErrors(['message' => $response->body()]);
        }
    }

    public function getDetailPatient($patient_id)
    {
        $patientResponse = Http::get("http://api_gateway/patient/get-patient/{$patient_id}");
        if (!$patientResponse->successful()) {
            return redirect()->back()->withErrors(['message' => $patientResponse->body()]);
        }

        $patient = $patientResponse->json();

        $medicalVisits = Http::get("http://api_gateway/patient/get-medicalvisit-patient/{$patient_id}");

        if (!$medicalVisits->successful()) {
            return redirect()->back()->withErrors(['message' => $medicalVisits->body()]);
        }

        $medicalVisits = $medicalVisits->json() ?? [];

        return view('patient.detail_patient', ['patient' => $patient, 'medicalVisits' => $medicalVisits]);
    }

    public function getPrescriptionDetail($prescription_id)
    {
        try {
            $prescriptionResponse = Http::get("http://api_gateway/patient/get-prescription/{$prescription_id}");

            if (!$prescriptionResponse->successful()) {
                return redirect()->back()->withErrors(['message' => 'Failed to fetch prescription details.']);
            }

            $prescriptionData = $prescriptionResponse->json();

            // Create prescription object (main info)
            $prescription = [
                'prescription_id' => $prescriptionData['id'] ?? $prescription_id,
                'visit_id' => $prescriptionData['visit_id'] ?? 'N/A',
                'date' => $prescriptionData['date'] ?? 'N/A',
                'notes' => $prescriptionData['notes'] ?? 'No notes',
                'status' => $prescriptionData['status'] ?? 'N/A'
            ];

            // Process prescription details and fetch medicine names
            $prescriptionDetails = [];
            if (isset($prescriptionData['details']) && is_array($prescriptionData['details'])) {
                foreach ($prescriptionData['details'] as $detail) {
                    $medicineId = $detail['medicine_id'] ?? null;
                    $medicineName = 'Unknown Medicine';

                    // Fetch medicine name if medicine_id exists
                    if ($medicineId) {
                        try {
                            $medicineResponse = Http::get("http://api_gateway/medical_catalog/medicines/{$medicineId}");

                            if ($medicineResponse->successful()) {
                                $medicineData = $medicineResponse->json();
                                $medicineName = $medicineData['data']['MedicineName'];
                            }
                        } catch (\Exception $e) {
                            // Log the error using Laravel's logging
                            \Log::warning("Failed to fetch medicine name for ID {$medicineId}", [
                                'error' => $e->getMessage(),
                                'prescription_id' => $prescription_id
                            ]);
                        }
                    }

                    $prescriptionDetails[] = [
                        'id' => $detail['id'] ?? null,
                        'medicine_id' => $medicineId,
                        'medicine_name' => $medicineName,
                        'dosage' => $detail['dosage'] ?? 'N/A',
                        'duration' => $detail['duration'] ?? 'N/A'
                    ];
                }
            }

            // Add details back to prescription array for the view
            $prescription['details'] = $prescriptionDetails;

            return view('patient.detail_prescription', compact('prescription', 'prescriptionDetails'));

        } catch (\Exception $e) {
            \Log::error("Error fetching prescription details", [
                'prescription_id' => $prescription_id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withErrors(['message' => 'An error occurred while loading prescription details.']);
        }
    }

    public function updateDetailPatient(Request $request, $id)
    {

        $response = Http::put("http://api_gateway/patient/update-patient/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->withErrors(['message' => $response->body()]);
    }
}
