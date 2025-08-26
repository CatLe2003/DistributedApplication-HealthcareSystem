<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::with(['form', 'unit', 'manufacturer']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('form_id')) {
            $query->where('form_id', $request->form_id);
        }
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }
        if ($request->filled('manufacturer_id')) {
            $query->where('manufacturer_id', $request->manufacturer_id);
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
                $query->where('name', 'like', "%$q%")
                      ->orWhere('description', 'like', "%$q%")
                      ->orWhereHas('manufacturer', fn($sub) => 
                          $sub->where('name', 'like', "%$q%"));
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
        $medicine = Medicine::with(['form', 'unit', 'manufacturer'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $medicine]);
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->all());
        return response()->json(['success' => true, 'data' => $medicine]);
    }

    public function destroy($id)
    {
        Medicine::destroy($id);
        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }
}
