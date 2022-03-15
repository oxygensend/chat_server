<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function choose()
    {
        return view('home');
    }

    public function create()
    {

        return view('create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['string', 'min:5', 'max:20', 'required'],
            'password' => [ 'required','string', 'min:5'],
        ]);

        $room = Room::create([
            'name' => $attributes['name'],
            'password' => $attributes['password'] ?? '' ,
            'user_id' => Auth::id(),
        ]);

        $room->users()->attach(Auth::id());

        return redirect(route('index'));

    }

    public function show(Room $room)
    {

    return view('show', [ 'room' => $room]);
    }
}
