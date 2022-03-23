<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model {

    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'users_rooms',
            'room_id',
            'user_id'
        )->withTimestamps();
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
