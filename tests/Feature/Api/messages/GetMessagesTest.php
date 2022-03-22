<?php

namespace Tests\Feature\Api\messages;

use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GetMessagesTest extends TestCase {

    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp(); //

        $this->user = User::factory()->create();
        Auth::login($this->user);

        $this->room = Room::factory()->create([
            'id' => uniqid(),
            'name' => 'test_room',
            'password' => hash::make("test_password"),
            'require_password' => true,
            'user_id' => Auth::id(),
        ]);

    }


    public function test_if_status_200_is_returned()
    {
        $response = $this->actingAs($this->user, 'api')
            ->get('/api/rooms/' . $this->room->id . '/messages');

        $response->assertStatus(200);
    }

    public function test_if_returned_empty_body()
    {
        $response = $this->actingAs($this->user, 'api')
            ->get('/api/rooms/' . $this->room->id . '/messages');

        $response->assertJson([]);

    }

    public function test_if_all_existing_messages_are_returned()
    {
        Message::factory(2)->create(
            ['text' => 'test_message',
                'user_id' => Auth::id(),
                'room_id' => $this->room->id,
            ]);

        $response = $this->actingAs($this->user, 'api')
            ->get('/api/rooms/' . $this->room->id . '/messages');

        $this->assertEquals(2, count($response->getOriginalContent()));

    }

    public function test_if_only_10_messages_are_on_one_page()
    {
        Message::factory(11)->create(
            ['text' => 'test_message2',
                'user_id' => Auth::id(),
                'room_id' => $this->room->id,
            ]);

        $response = $this->actingAs($this->user, 'api')
            ->get('/api/rooms/' . $this->room->id . '/messages');

        $this->assertEquals(10, count($response->getOriginalContent()));

    }
}
