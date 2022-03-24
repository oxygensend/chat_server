<?php

namespace App\Http\Middleware;

use App\Models\Room;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RoomToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request,Closure $next)
    {

        if (!$request->cookie('room_token')) {
            setcookie('room_token', Hash::make($request->get('room_id')));
        } else if (!password_verify($request->get('room_id'),$request->cookie('room_token'))) {
            throw ValidationException::withMessages(['room' => 'You are already connected to room.']);
        }
        return $next($request);
    }
}
