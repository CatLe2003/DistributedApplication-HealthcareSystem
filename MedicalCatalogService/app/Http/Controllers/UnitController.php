<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index() {
        return response()->json(Unit::all());
    }

    public function store(Request $request) {
        $unit = Unit::create($request->all());
        return response()->json($unit, 201);
    }

    public function show($id) {
        return response()->json(Unit::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());
        return response()->json($unit);
    }

    public function destroy($id) {
        Unit::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
