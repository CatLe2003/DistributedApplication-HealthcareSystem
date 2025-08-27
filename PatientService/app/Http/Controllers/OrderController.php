<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\PatientService;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
     protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }


    public function create(Request $request)
    {
        try {
            // Validation phase
            $incomingFields = $request->validate([
                'visit_id' => 'required|exists:medicalvisit,id',
                'test_id' => 'required',
                'employee_id' => 'required',
                'order_date' => 'required|date',
                'status' => 'required|string',
                'result' => 'nullable|string',
                'detailsURL' => 'required|url'
            ]);
            
            $this->patientService->validateEntitiesOrder($incomingFields);

            // Database insert phase
            Order::create($incomingFields);

            return response()->json(['message' => 'Order created successfully']);
        } catch (ValidationException $e) {
            // Laravel validation error (duplicate found during validation or invalid input)
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            // Database error (e.g., race condition causing duplicate after validation)
            if ($e->errorInfo[1] == 1062) { // MySQL duplicate entry error code
                return response()->json(['message' => 'Duplicate entry detected'], 409);
            }
            return response()->json(['message' => 'Database error'], 500);
        } catch (\Exception $e) {
            // Any other error
            return response()->json(['message' => 'Unexpected error'], 500);
        }
    }  
    public function show($id)
    {
        $Order = Order::find($id);
        if (!$Order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($Order);
    }

    public function getAll()
    {
        try {
            $orders = Order::all();
            return response()->json([
                'message' => 'Orders retrieved successfully',
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve orders'], 500);
        }
    }
}
