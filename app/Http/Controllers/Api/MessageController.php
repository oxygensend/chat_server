<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller {

    //
    public function index(Room $room)
    {
        return MessageResource::collection(Message::where('room_id', $room->id)->latest()->paginate(10));
    }

    public function store(Room $room, Request $request)
    {
        $request->validate([
            'text' => ['String', 'required'],
        ]);
        event(new MessageEvent($request->text, new UserResource(Auth::user()),  $room->id, 'now'));

        return Message::create([
            'text' => $request->text,
            'user_id' => Auth::id(),
            'room_id' => $room->id,
        ]);
    }

}
