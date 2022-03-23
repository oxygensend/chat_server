<?php

namespace App\Observers;

use App\Events\UserEvent;
use App\Http\Requests\RoomConnectRequest;
use App\Http\Resources\RoomUserResource;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RoomObserver {

    /**
     * Handle the Room "created" event.
     *
     * @param \App\Models\Room $room
     * @return void
     */
    public function created(Room $room)
    {
        //
    }

    /**
     * Handle the Room "updated" event.
     *
     * @param \App\Models\Room $room
     * @return void
     */
    public function updated(Room $room, RoomConnectRequest $request)
    {
        if ($room->require_password) {
            if (!password_verify($request->get('password'), $room->password)) {
                throw ValidationException::withMessages(['password' => 'Invalid password']);
            }
        }

        event(new UserEvent( new RoomUserResource(Auth::user())));
    }

    /**
     * Handle the Room "deleted" event.
     *
     * @param \App\Models\Room $room
     * @return void
     */
    public function deleted(Room $room)
    {
        event(new UserEvent( new RoomUserResource(Auth::user())));
    }

    /**
     * Handle the Room "restored" event.
     *
     * @param \App\Models\Room $room
     * @return void
     */
    public function restored(Room $room)
    {
        //
    }

    /**
     * Handle the Room "force deleted" event.
     *
     * @param \App\Models\Room $room
     * @return void
     */
    public function forceDeleted(Room $room)
    {

        //
    }
}
