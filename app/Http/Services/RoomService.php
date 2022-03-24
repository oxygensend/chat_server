<?php

namespace App\Http\Services;

use App\Events\UserEvent;
use App\Http\Resources\RoomUserResource;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RoomService {

    function checkPassword($room, $password) {
        if ($room->require_password) {
            if (!password_verify($password, $room->password)) {
                throw ValidationException::withMessages(['password' => 'Invalid password']);
            }
        }
    }

    function disconnect(Room $room){

        setcookie("room_token", "", time() - 3600);
        event(new UserEvent( new RoomUserResource(Auth::user(), $room->id)));
    }
}
