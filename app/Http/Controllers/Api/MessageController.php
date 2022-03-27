<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller {

    /**
     * @param Room $room
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Room $room)
    {
        return MessageResource::collection(Message::where('room_id', $room->id)->latest()->paginate(10)->reverse());
    }

    /**
     * @param Room $room
     * @param MessageRequest $request
     * @return mixed
     */
    public function store(Room $room, MessageRequest $request)
    {
        event(new MessageEvent($request->get('text'), new UserResource(Auth::user()),  $room->id, 'now'));

        return Message::create([
            'text' => $request->get('text'),
            'user_id' => Auth::id(),
            'room_id' => $room->id,
        ]);
    }

}
