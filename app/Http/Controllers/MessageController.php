<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function save_message(Request $request)
    {
        // Validate the request.
        $request->validate([
            'message' => ['required'],
            'binnacle' => ['required'],
        ]);

        $new_message = Message::create([
            'user_id' => auth()->user()->id,
            'binnacle_id' => $request->input('binnacle'),
            'message' => $request->input('message'),
        ]);

        // Obtener los mensajes actualizados
        $messages = Message::where('active' , true)
            ->where('binnacle_id', $new_message->binnacle_id)    
            ->orderBy('created_at', 'desc')
            ->get();

        $response = ['messages' => $messages];

        Log::debug($response);

        // Devolver los mensajes actualizados como respuesta
        return response()->json($response);
    }
}
