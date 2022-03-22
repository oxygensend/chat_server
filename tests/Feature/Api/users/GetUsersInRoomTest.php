<?php

namespace Tests\Feature\Api\users;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GetUsersInRoomTest extends TestCase {

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

        $this->room = Room::factory()->create();
        DB::table('users_rooms')->insert([
            'user_id' => Auth::id(),
            'room_id' => $this->room->id,
            'online' => true,
        ]);
    }

    public function test_if_status_200_is_returned()
    {
        $response = $this->actingAs($this->user, 'api')
            ->get('/api/rooms/' . $this->room->id . '/users');
        $response->assertStatus(200);
    }


    public function test_if_all_existing_rooms_are_returned()
    {

        $user = User::factory()->create();

        DB::table('users_rooms')->insert([
            'user_id' => $user->id,
            'room_id' => $this->room->id,
            'online' => true,
        ]);
        $response = $this->actingAs($this->user, 'api')
            ->get('/api/rooms/' . $this->room->id . '/users');
        $this->assertEquals(2, count($response->getOriginalContent()));
    }

    public function test_content_of_response()
    {

        $response = $this->actingAs($this->user, 'api')
            ->get('/api/rooms/' . $this->room->id . '/users');

        $response->assertJsonFragment([
            'id' => Auth::id(),
            'name' => Auth::user()->name,
            'online' => 1,
        ]);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'online',
                ],
            ],
        ]);
    }
}
