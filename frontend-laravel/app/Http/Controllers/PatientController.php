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
        $patientsResponse = Http::get('http://api_gateway/patient/get-patients');
        $prescriptionsResponse = Http::get("http://api_gateway/patient/get-prescriptions");
        $doctorsResponse = Http::get("http://api_gateway/employee/employees");

        if ($patientsResponse->successful() && $prescriptionsResponse->successful() && $doctorsResponse->successful()) {
            $patients = $patientsResponse->json()['data'] ?? [];
            $prescriptions = $prescriptionsResponse->json()['data'] ?? [];
            $doctors = $doctorsResponse->json()['data'] ?? [];

            // // Build doctor id => name map
            // $doctorMap = [];
            // foreach ($doctors as $doctor) {
            //     if (isset($doctor['EmployeeID']) && isset($doctor['FullName'])) {
            //         $doctorMap[$doctor['EmployeeID']] = $doctor['FullName'];
            //     }
            // }

            // // Build patient id => name map
            // $patientMap = [];
            // foreach ($patients as $patient) {
            //     if (isset($patient['PatientID']) && isset($patient['FullName'])) {
            //         $patientMap[$patient['PatientID']] = $patient['FullName'];
            //     }
            // }

            return view('dashboard.statistical_report', compact('patients', 'prescriptions', 'doctors'));
        }

        $errorMsg = [];
        if (!$patientsResponse->successful()) {
            $errorMsg[] = $patientsResponse->body();
        }
        if (!$prescriptionsResponse->successful()) {
            $errorMsg[] = $prescriptionsResponse->body();
        }
        if (!$doctorsResponse->successful()) {
            $errorMsg[] = $doctorsResponse->body();
        }
        return redirect()->back()->withErrors(['message' => implode(' ', $errorMsg)]);
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

        // Get user_id from session
        $userId = session('user_id');
        $doctor = null;
        $department = null;

        if ($userId) {
            // Fetch doctor by user_id
            $doctorResponse = Http::get("http://api_gateway/employee/doctors/by-userid/{$userId}");
            if ($doctorResponse->successful()) {
                $doctorData = $doctorResponse->json()['data'] ?? null;

                if ($doctorData) {
                    $doctor = $doctorData;

                    // Fetch department info
                    $deptResponse = Http::get("http://api_gateway/employee/departments/{$doctorData['DepartmentID']}");
                    if ($deptResponse->successful()) {
                        $department = $deptResponse->json()['data'] ?? null;
                    }
                }
            }
        }

        return view('medical_record.add_medvisit', [
            'patients' => $patients,
            'doctor' => $doctor,
            'department' => $department,
        ]);
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
}
