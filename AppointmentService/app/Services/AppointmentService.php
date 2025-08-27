<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class AppointmentService
{
    protected $apiGateway;

    public function __construct()
    {
        $this->apiGateway = config('services.api_gateway.url');
    }

    public function validateEntities(array $data)
    {
        $checks = [
            "patient/get-patient/{$data['PatientID']}"       => 'Patient not found',
            "employee/doctors/{$data['DoctorID']}" => 'Doctor not found',
            "employee/rooms/{$data['RoomID']}"     => 'Room not found',
            "employee/departments/{$data['DepartmentID']}" => 'Department not found',
        ];

        if (!empty($data['WeekdayID'])) {
            $checks["employee/weekdays/{$data['WeekdayID']}"] = 'Weekday not found';
        }

        $checks["employee/shifts/{$data['TimeSlotID']}"] = 'Shift not found';

        foreach ($checks as $endpoint => $errorMessage) {
            $response = Http::get("{$this->apiGateway}/{$endpoint}");

            if ($response->failed() || empty($response->json())) {
                throw new Exception($errorMessage);
            }
        }

        return true;
    }
}
