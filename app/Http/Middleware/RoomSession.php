<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\RoomController;
use App\Http\Services\RoomService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class RoomSession {

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $room = $request->route('room');
        if (!isset($_COOKIE['room_token'])) {
            (new RoomService())->abort( $room);
            return redirect('/');
        }
        return $next($request);
    }
}
