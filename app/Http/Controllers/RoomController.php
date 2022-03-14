<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function index()
    {
        return view('index');
    }
}
