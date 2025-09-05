<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedicalCatalogController extends Controller
{
    public function listMedicines()
    {
        $response = Http::get('http://api_gateway/medical_catalog/medicines');

        if ($response->successful()) {
            $medicines = $response->json()['data'] ?? [];
            Log::info('Fetched medicines successfully',['medicines' => $medicines]);
            return view('medicine.medicines', ['medicines' => $medicines]);
        }

        Log::error('Failed to fetch medicines', ['response' => $response->body()]);
        return redirect()->back()->withErrors(['message' => 'Failed to fetch medicines.']);
    }

    public function showAddMedicineForm()
    {
        $manufacturers = Http::get("http://api_gateway/medical_catalog/manufacturers");

        if ($manufacturers->successful()) {
            $manufacturers = $manufacturers->json() ?? [];
        }

        $forms = Http::get("http://api_gateway/medical_catalog/forms");

        if ($forms->successful()) {
            $forms = $forms->json()?? [];
        }


        $units = Http::get("http://api_gateway/medical_catalog/units");

        if ($units->successful()) {
            $units = $units->json()['original'] ?? [];
        }


        return view('medicine.add_medicine', [
            'manufacturers' => $manufacturers,
            'forms' => $forms,
            'units' => $units,
        ]);
    }

    public function addMedicine(Request $request)
    {

        $response = Http::post('http://api_gateway/medical_catalog/medicines', $request->all());

        Log::info('Add medicine request sent', ['request' => $request->all()]);

        if ($response->successful()) {
            Log::info('Add medicine response received', ['response' => $response->json()]);
            return redirect()->route('medicine_management')->with('success', 'Medicine added successfully!');
        }

        $errors = json_decode($response->body(), true);
        Log::error('Add medicine failed', ['errors' => $errors]);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }

    public function deleteMedicine(Request $request, $id)
    {
        $response = Http::delete("http://api_gateway/medical_catalog/medicines/{$id}");

        Log::info('Delete medicine request sent', ['id' => $id]);

        if ($response->successful()) {
            Log::info('Delete medicine response received', ['response' => $response->json()]);
            return redirect()->route('medicine_management')->with('success', 'Medicine deleted successfully!');
        }

        $errors = json_decode($response->body(), true);
        Log::error('Delete medicine failed', ['errors' => $errors]);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }
    public function getMedicineBeforeUpdate($id)
    {
        $response = Http::get("http://api_gateway/medical_catalog/medicines/{$id}");

        if ($response->successful()) {
            $medicine = $response->json()['data'] ?? null;

            $manufacturers = Http::get("http://api_gateway/medical_catalog/manufacturers");

            if ($manufacturers->successful()) {
                $manufacturers = $manufacturers->json() ?? [];
            }

            $forms = Http::get("http://api_gateway/medical_catalog/forms");

            if ($forms->successful()) {
                $forms = $forms->json()?? [];
            }


            $units = Http::get("http://api_gateway/medical_catalog/units");

            if ($units->successful()) {
                $units = $units->json()['original'] ?? [];
            }


            return view('medicine.update_medicine', [
                'medicine' => $medicine,
                'manufacturers' => $manufacturers,
                'forms' => $forms,
                'units' => $units,
            ]);
        }

        Log::error('Failed to fetch medicine details', ['response' => $response->body()]);
        return redirect()->back()->withErrors(['message' => 'Failed to fetch medicine details.']);
    }

    public function updateMedicine(Request $request, $id)
    {
        $response = Http::patch("http://api_gateway/medical_catalog/medicines/{$id}", $request->all());

        Log::info('Update medicine request sent', ['id' => $id, 'request' => $request->all()]);

        if ($response->successful()) {
            Log::info('Update medicine response received', ['response' => $response->json()]);
            return redirect()->route('medicine_management')->with('success', 'Medicine updated successfully!');
        }

        $errors = json_decode($response->body(), true);
        Log::error('Update medicine failed', ['errors' => $errors]);
        return redirect()->back()->withErrors($errors['errors'] ?? ['message' => $response->body()]);
    }

}
