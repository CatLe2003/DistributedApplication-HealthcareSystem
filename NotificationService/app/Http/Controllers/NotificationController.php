<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $notifications = Notification::all();
            return response()->json(['success' => true, 'data' => $notifications], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve notifications'], 500);
        }
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipientId' => 'required|string',
            'type' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
            'metadata' => 'required|array',
            'status' => 'required|string',
            'sentAt' => 'nullable|date',
        ]);

        $notification = Notification::create([
            'recipientId' => $validated['recipientId'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'metadata' => $validated['metadata'],
            'status' => $validated['status'],
            'sentAt' => $validated['sentAt'] ?? null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        return response()->json(['success' => true, 'notification' => $notification], 201);
    }

    //GET /notifications/{id}
    public function show($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            return response()->json(['success' => true, 'data' => $notification], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Notification not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve notification'], 500);
        }
    }

    //GET /notifications/patient?id={patientId}
    public function getNotificationsByPatientId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);

            $patientId = (int) $request->query('id');

            $notifications = Notification::where('recipientId', $patientId)->get();

            return response()->json([
                'success' => true,
                'message' => 'Notifications fetched successfully',
                'data' => $notifications
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch appointments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}       