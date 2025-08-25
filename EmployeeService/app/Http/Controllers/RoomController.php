<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;
use Exception;

class RoomController extends Controller
{
    // GET /rooms
    public function getAllRooms (Request $request)
    {
        try {
            $rooms = Room::all();

            return response()->json([
                'success' => true,
                'data' => $rooms
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch rooms',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // GET /rooms/{id}
    public function getRoomById ($id)
    {
       try {

            if(!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid room ID'
                ], 400);
            }
            
            $room = Room::find($id);

            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $room
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch room',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

