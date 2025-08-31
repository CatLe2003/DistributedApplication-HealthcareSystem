<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    public function listDepartments()
    {
        $response = Http::get('http://api_gateway/employee/departments');

        if ($response->successful()) {
            $departments = $response->json()['data'] ?? [];
            return view('department.list_departments', ['departments' => $departments]);
        }

        return view('department.list_departments', [
            'departments' => [],
            'error' => 'Failed to fetch departments. Please try again later.'
        ]);
    }

    public function listDepartmentsHome()
    {
        $response = Http::get('http://api_gateway/employee/departments');

        if ($response->successful()) {
            $departments = $response->json()['data'] ?? [];
            return view('dashboard.homepage', ['departments' => $departments]);
        }

        return view('dashboard.homepage', [
            'departments' => [],
            'error' => 'Failed to fetch departments. Please try again later.'
        ]);
    }
}
