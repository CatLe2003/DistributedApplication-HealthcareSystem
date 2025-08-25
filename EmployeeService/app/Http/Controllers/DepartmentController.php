<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Exception;

class DepartmentController extends Controller
{
    public function getAllDepartments(Request $request)
    {
        try {
            $departments = Department::all();
            return response()->json([
                'success' => true,
                'data' => $departments
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch departments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDepartmentById($id)
    {
        try {

            if(!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid department ID'
                ], 400);
            }
            
            $department = Department::find($id);

            if (!$department) {
                return response()->json([
                    'success' => false,
                    'message' => 'Department not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $department
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch department',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
