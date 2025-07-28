<?php

namespace App\Http\Controllers;

use App\Events\MessageBroadcasted;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function send(MessageRequest $request)
    {
        Auth::loginUsingId(1);

        $validated = $request->validated();

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'body' => $validated['body'],
        ]);

        broadcast(new MessageBroadcasted($message))->toOthers();

        return response()->json(['message' => $message]);
    }
}
