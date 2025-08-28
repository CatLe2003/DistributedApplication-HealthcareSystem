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

        if ($response->successful()) {
            return view('medical_record.profile', ['profile' => $response->json()]);
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
}
