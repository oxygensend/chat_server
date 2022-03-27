<?php

namespace App\Http\Services;

use App\Events\UserEvent;
use App\Http\Resources\RoomUserResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RoomService {

    function checkPassword($room, $password): void
    {
        if ($room->require_password) {
            if (!password_verify($password, $room->password)) {
                throw ValidationException::withMessages(['password' => 'Invalid password']);
            }
        }
    }

    function disconnect(Room $room): void
    {

        setcookie("room_token", "", time() - 3600, "/");
        event(new UserEvent(new RoomUserResource(Auth::user(), $room->id)));
    }

    function setToken(Room $room, Request $request): void
    {
        if (!$request->cookie('room_token')) {
            setcookie('room_token', Hash::make($request->get('room_id')), path: '/');
        }
    }

    function connect(Room $room, Request $request, $password): void
    {

        $this->checkPassword($room, $password);
        $this->setToken($room, $request);

        (!$room->users->contains('id', Auth::id())) ?
            Auth::user()->createUserRoomRelation($room->id) :
            Auth::user()->setOnline($room->id, true);

        event(new UserEvent(new RoomUserResource(Auth::user(), $room->id)));
    }


}
