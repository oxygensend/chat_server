<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rooms()
    {
        return $this->belongsToMany(
            Room::class,
            'users_rooms',
            'user_id',
            'room_id'
        )->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function setOnline($room, $online)
    {
        DB::table('users_rooms')
            ->where('user_id', $this->id)
            ->where('room_id', $room)
            ->update(['online' => $online]);
    }

    public function createUserRoomRelation($room)
    {
        DB::table('users_rooms')->insert([
            'user_id' => $this->id,
            'room_id' => $room,
            'online' => true,
        ]);
    }
}
