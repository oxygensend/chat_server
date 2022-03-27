<?php

namespace Tests\Feature\Api\rooms;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DisconnectRoomTest extends TestCase {

    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);
        $this->room = Room::factory()->create([
            'id' => uniqid(),
            'name' => 'test_room',
            'password' => hash::make("test_password"),
            'require_password' => true,
            'user_id' => auth::id(),
        ]);
        DB::table('users_rooms')->insert([
            'user_id' => Auth::id(),
            'room_id' => $this->room->id,
            'online' => true,
        ]);
    }

    public function test_if_redirection_route_is_returned()
    {

        $response = $this->actingAs($this->user, 'api')
            ->deleteJson('api/rooms/' . $this->room->id);

        $this->assertArrayHasKey('redirect', (array)json_decode($response->content()));
    }

    public function test_if_data_is_updated_in_db()
    {
        $this->assertDatabaseHas('users_rooms', [
            'user_id' => Auth::id(),
            'room_id' => $this->room->id,
            'online' => true,
        ]);

        $this->actingAs($this->user, 'api')
            ->deleteJson('api/rooms/' . $this->room->id);

        $this->assertDatabaseHas('users_rooms', [
            'user_id' => Auth::id(),
            'room_id' => $this->room->id,
            'online' => false,
        ]);
    }


}
