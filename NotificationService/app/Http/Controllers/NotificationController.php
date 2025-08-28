<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
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

        // TODO: Trigger email sending here if needed

        return response()->json(['success' => true, 'notification' => $notification], 201);
    }

    public function show($id)
    {
    $notification = \App\Models\Notification::find($id);

    if (!$notification) {
        return response()->json(['message' => 'Notification not found'], 404);
    }

    return response()->json($notification);
    }
}       