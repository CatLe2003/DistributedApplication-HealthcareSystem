<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $query = Test::query();

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $test = Test::create($request->all());
        return response()->json($test, 201);
    }

    public function show($id)
    {
        return response()->json(Test::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        $test->update($request->all());
        return response()->json($test);
    }

    public function destroy($id)
    {
        Test::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
