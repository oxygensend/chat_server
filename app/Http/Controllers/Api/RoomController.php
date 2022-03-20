<?php

namespace App\Http\Controllers\Api;

use App\Events\UserEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomUserResource;
use App\Http\Resources\UserResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller {

    //
    public function index(){
        return RoomResource::collection(Room::all());
    }
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['string', 'min:5', 'max:20', 'required'],
            'password' => ['string', 'min:5'],
        ]);

        if(isset($attributes['password']))
            $password = Hash::make($attributes['password']);
        else
            $password = null;

        $room = Room::create([
            'id' => uniqid(),
            'name' => $attributes['name'],
            'password' => $password,
            'require_password' => (bool)$password,
            'user_id' => Auth::id()]);

        DB::table('users_rooms')->insert([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'online' => true,
        ]);

        return $room;
    }


    public function connect(Room $room, Request $request){
        $attributes = $request->validate([
            'password' => ['string', 'min:5'],
        ]);

        if($room->require_password){
            if(!password_verify($attributes['password'], $room->password)){
                throw ValidationException::withMessages(['password' => 'Invalid password']);
            }
        }

        if(!Session::get('room_token'))
            Session::put('room_token', 'test');
        else{
            throw ValidationException::withMessages(['password' => 'helo']);
        }

        if(!$room->users->contains('id', Auth::id()))
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



        event(new UserEvent( new RoomUserResource(Auth::user())));

        return [ 'redirect' => route('show', $room->id)];

    }

    public function disconnect(Room $room){
        // tutaj jakies usuniecie tokenu i wyslanie eventu
        DB::table('users_rooms')
            ->where('user_id', Auth::id())
            ->where('room_id', $room->id)
            ->update(['online' => false]);

        event(new UserEvent( new RoomUserResource(Auth::user())));

        Session::forget('room_token');
        return[ 'redirect' => route('home')];
    }
}
