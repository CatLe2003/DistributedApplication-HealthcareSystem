<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

use Exception;

class EmployeeController extends Controller
{
    // GET /employees
    public function getAllEmployees (Request $request)
    {
       try {
        $employees =  Employee::with(['department'])->get();
        return response()->json([
                'success' => true,
                'data' => $employees
            ], 200);
       } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch employees',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /employees/{id}
    public function getEmployeeById($id)
    {
        try {

            if(!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid employee ID'
                ], 400);
            }
            
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $employee
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch employee',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAllStaff (Request $request)
    {
        try {
            $staff = Employee::where('Role', 'Staff')->get();

            return response()->json([
                'success' => true,
                'data' => $staff
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch staff',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEmployeesByDepartmentId($departmentId)
    {
        try {
            if (!is_numeric($departmentId) || $departmentId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid department ID'
                ], 400);
            }

            $employees = Employee::where('DepartmentID', $departmentId)->get();

            if ($employees->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No employees found for this department'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $employees
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch employees by department',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getDoctorsByDepartmentId($departmentId)
    {
        try {
            if (!is_numeric($departmentId) || $departmentId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid department ID'
                ], 400);
            }

            $doctors = Employee::where('DepartmentID', $departmentId)
                               ->where('Role', 'DOCTOR')
                               ->get();

            if ($doctors->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No doctors found for this department'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $doctors
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch doctors by department',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getDoctorByUserId($userId)
    {
        try {
            if (!is_numeric($userId) || $userId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid user ID'
                ], 400);
            }

            $doctor = Employee::where('UserID', $userId)
                               ->where('Role', 'DOCTOR')
                               ->first();

            if (!$doctor) {
                return response()->json([
                    'success' => false,
                    'message' => 'No doctor found for this user ID'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $doctor
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch doctor by user ID',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}

