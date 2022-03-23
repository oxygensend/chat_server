<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomUserResource;
use App\Http\Resources\UserResource;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @param Room $room
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Room $room){
        return RoomUserResource::collection($room->users()->orderBy('online', 'desc')->get());
    }
}
