<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomConnectRequest;
use App\Http\Requests\RoomStoreRequest;
use App\Http\Resources\RoomResource;
use App\Http\Services\RoomService;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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
     * @param RoomService $roomService
     * @return RoomResource
     */
    public function store(RoomStoreRequest $request, RoomService $roomService)
    {
        $room = Room::create([
            'id' => uniqid(),
            'name' => $request->get('name'),
            'password' => Hash::make($request->get('password')) ?? null,
            'require_password' => (bool)$request->get('password'),
            'user_id' => Auth::id()]);

        Auth::user()->createUserRoomRelation($room->id);
        $roomService->setToken($room, $request);

        return new RoomResource($room);
    }

    /**
     * @param Room $room
     * @param RoomConnectRequest $request
     * @param RoomService $roomService
     * @return array
     */
    public function connect(Room $room, RoomConnectRequest $request, RoomService $roomService)
    {
        $roomService->connect($room, $request, $request->get('password'));

        return ['redirect' => route('show', $room->id)];

    }

    /**
     * @param Room $room
     * @param RoomService $roomService
     * @return array
     */
    public function disconnect(Room $room, RoomService $roomService)
    {
        Auth::user()->setOnline($room->id, false);
        $roomService->disconnect($room);

        return ['redirect' => route('home')];
    }
}
