<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
     * @return Application|Factory|View
     */
    public function choose()
    {
        return view('home');
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {

        return view('create');
    }

    /**
     * @param Room $room
     * @return Application|Factory|View
     */
    public function show(Room $room)
    {
    return view('show', [ 'room' => $room]);
    }
}
