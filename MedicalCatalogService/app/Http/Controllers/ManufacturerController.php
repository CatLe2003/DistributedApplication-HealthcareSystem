<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index() {
        return response()->json(Manufacturer::all());
    }

    public function store(Request $request) {
        $manufacturer = Manufacturer::create($request->all());
        return response()->json($manufacturer, 201);
    }

    public function show($id) {
        return response()->json(Manufacturer::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->update($request->all());
        return response()->json($manufacturer);
    }

    public function destroy($id) {
        Manufacturer::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
