<?php

namespace App\Http\Controllers;
use App\Helpers\RabbitMQHelper;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index() {

        try {
            $units = response()->json(Unit::all());
            return response()->json($units);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve units'], 500);
        }
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
