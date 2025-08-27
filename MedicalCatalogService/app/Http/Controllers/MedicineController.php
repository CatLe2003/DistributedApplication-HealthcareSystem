<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::with(['form', 'unit', 'manufacturer']);

        if ($request->filled('MedicineName')) {
            $query->where('MedicineName', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('FormID')) {
            $query->where('FormID', $request->form_id);
        }
        if ($request->filled('UnitID')) {
            $query->where('UnitID', $request->unit_id);
        }
        if ($request->filled('ManufacturerID')) {
            $query->where('ManufacturerID', $request->manufacturer_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        if (!$q) {
            return response()->json([
                'success' => false,
                'message' => 'Missing search query (q)'
            ], 400);
        }

        $medicines = Medicine::with(['form', 'unit', 'manufacturer'])
            ->where(function ($query) use ($q) {
                $query->where('MedicineName', 'like', "%$q%")
                        ->orWhereHas('form', fn($sub) => 
                            $sub->where('FormName', 'like', "%$q%"))
                      ->orWhereHas('manufacturer', fn($sub) => 
                          $sub->where('ManufacturerName', 'like', "%$q%"));
            })
            ->get();

        return response()->json(['success' => true, 'data' => $medicines]);
    }

    public function store(Request $request)
    {
        $medicine = Medicine::create($request->all());
        return response()->json(['success' => true, 'data' => $medicine], 201);
    }

    public function show($id)
    {
        try {
            
            $medicine = Medicine::with(['form', 'unit', 'manufacturer'])->findOrFail($id);
            return response()->json(['success' => true, 'data' => $medicine]);
        
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Medicine not found'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->update($request->all());
            return response()->json(['success' => true, 'data' => $medicine]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Medicine not found'], 400);
        }
    }

    public function destroy($id)
    {
        try {
            Medicine::destroy($id);
            return response()->json(['success' => true, 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Medicine not found'], 400);
        }
    }
}
