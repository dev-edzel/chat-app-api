<?php

namespace App\Http\Controllers;

use App\Events\MessageBroadcasted;
use App\Http\Requests\MessageRequest;
use App\Models\Message;

class MessageController extends Controller
{
    public function send(MessageRequest $request)
    {
        $validated = $request->validated();

        $message = Message::create($validated);

        broadcast(new MessageBroadcasted($message))->toOthers();

        return response()->json(['message' => $message]);
    }
}
