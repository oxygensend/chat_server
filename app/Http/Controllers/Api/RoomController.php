<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'name' => $attributes['name'],
            'password' => $password,
            'require_password' => (bool)$password,
            'user_id' => Auth::id()]);

        $room->users()->attach(Auth::id());

        return $room;
    }


    public function connect(Request $request){
        $attributes = $request->validate([
            'password' => ['string', 'min:5'],
        ]);

        $room = Room::findorFail($request->room_id);

        if($room->require_password){
            if(password_verify($attributes['password'], $room->password)){

            }
        }



    }
}
