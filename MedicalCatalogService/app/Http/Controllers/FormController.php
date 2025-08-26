<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index() {
        return response()->json(Form::all());
    }

    public function store(Request $request) {
        $form = Form::create($request->all());
        return response()->json($form, 201);
    }

    public function show($id) {
        return response()->json(Form::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $form = Form::findOrFail($id);
        $form->update($request->all());
        return response()->json($form);
    }

    public function destroy($id) {
        Form::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
