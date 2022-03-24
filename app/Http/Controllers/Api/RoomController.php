<?php

namespace App\Http\Controllers\Api;

use App\Events\UserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomConnectRequest;
use App\Http\Requests\RoomStoreRequest;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomUserResource;
use App\Http\Resources\UserResource;
use App\Http\Services\RoomService;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Collection;

class RoomController extends Controller {

    //

    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return RoomResource::collection(Room::all());
    }

    /**
     * @param RoomStoreRequest $request
     * @return RoomResource
     *
     */
    public function store(RoomStoreRequest $request)
    {
        $room = Room::create([
            'id' => uniqid(),
            'name' => $request->get('name'),
            'password' => Hash::make($request->get('password')) ?? null,
            'require_password' => (bool)$request->get('password'),
            'user_id' => Auth::id()]);

        DB::table('users_rooms')->insert([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'online' => true,
        ]);

        return new RoomResource($room);
    }

    /**
     * @param Room $room
     * @param RoomConnectRequest $request
     * @return array
     */
    public function connect(Room $room, RoomConnectRequest $request, RoomService $roomService)
    {

        $roomService->checkPassword($room, $request->get('password'));



        if (!$room->users->contains('id', Auth::id()))
            DB::table('users_rooms')->insert([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'online' => true,
            ]);
        else {
            DB::table('users_rooms')
                ->where('user_id', Auth::id())
                ->where('room_id', $room->id)
                ->update(['online' => true]);

        }

        event(new UserEvent( new RoomUserResource(Auth::user(), $room->id)));
        return ['redirect' => route('show', $room->id)];

    }

    /**
     * @param Room $room
     * @return array
     */
    public function disconnect(Room $room, RoomService $roomService)
    {

        // tutaj jakies usuniecie tokenu i wyslanie eventu
        DB::table('users_rooms')
            ->where('user_id', Auth::id())
            ->where('room_id', $room->id)
            ->update(['online' => false]);

        $roomService->disconnect($room);

        return ['redirect' => route('home')];
    }
}
