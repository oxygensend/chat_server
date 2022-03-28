<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class RoomUserResource extends JsonResource {


    private  $room_id;

    public function __construct($resource, $room_id)
    {
        parent::__construct($resource);
        $this->room_id = $room_id;
    }

    /**
     * @param $resource
     * @param $room_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'online' => DB::table('users_rooms')
                ->where('user_id', $this->id)
                ->where('room_id',$this->getOriginal()['pivot_room_id'] ?? $this->room_id)
                ->value('online'),
            'room' => $this->room_id
        ];
    }
}
