<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class PatientService
{
    protected $apiGateway;

    public function __construct()
    {
        $this->apiGateway = config('services.api_gateway.url');
    }

    public function validateEntitiesMedicalVisit(array $incomingFields)
    {
        $checks = [
            "employee/doctors/{$incomingFields['doctor_id']}" => 'Doctor not found',
            "employee/departments/{$incomingFields['department_id']}" => 'Department not found',
        ];

        foreach ($checks as $endpoint => $errorMessage) {
            $response = Http::get("{$this->apiGateway}/{$endpoint}");

            if ($response->failed() || empty($response->json())) {
                throw new Exception($errorMessage);
            }
        }

        return true;
    }

    public function validateEntitiesPrescription(array $incomingFields)
    {
        $checks = [
            "employee/employees/{$incomingFields['employee_id']}" => 'Employee not found',
            //"employee/departments/{$incomingFields['department_id']}" => 'Department not found',
        ];

        foreach ($checks as $endpoint => $errorMessage) {
            $response = Http::get("{$this->apiGateway}/{$endpoint}");

            if ($response->failed() || empty($response->json())) {
                throw new Exception($errorMessage);
            }
        }

        return true;
    }

    public function validateEntitiesOrder(array $incomingFields)
    {
        $checks = [
            "employee/employees/{$incomingFields['employee_id']}" => 'Employee not found',
            //"employee/departments/{$incomingFields['department_id']}" => 'Department not found',
        ];

        foreach ($checks as $endpoint => $errorMessage) {
            $response = Http::get("{$this->apiGateway}/{$endpoint}");

            if ($response->failed() || empty($response->json())) {
                throw new Exception($errorMessage);
            }
        }

        return true;
    }
}
