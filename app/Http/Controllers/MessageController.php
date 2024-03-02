<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    // Method to save a new message.
    public function save_message(Request $request)
    {
        // Validate the request.
        $request->validate([
            'message' => ['required'],
            'binnacle' => ['required'],
        ]);

        // Create a new message.
        $new_message = Message::create([
            'user_id' => auth()->user()->id,
            'binnacle_id' => $request->input('binnacle'),
            'message' => $request->input('message'),
        ]);

        // Get the updated messages.
        $messages = Message::where('active', true)
            ->where('binnacle_id', $new_message->binnacle_id)    
            ->orderBy('created_at', 'desc')
            ->get();

        // Prepare the response.
        $response = ['messages' => $messages];

        // Return the response as JSON.
        return response()->json($response);
    }

    // Method to get messages by binnacle ID.
    public function get_messages($id)
    {
        try {
            // Get the messages of the binnacle.
            $messages = Message::where('active', true)
                ->where('binnacle_id', $id)    
                ->orderBy('created_at', 'asc')
                ->with('user')
                ->get();

            // Return the messages as JSON.
            return response()->json(['messages' => $messages]);
        } catch (\Exception $e) {
            // Handle internal server error.
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
