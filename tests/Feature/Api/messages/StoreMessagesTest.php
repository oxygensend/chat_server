<?php

namespace Tests\Feature\Api\messages;

use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Carbon\Traits\Date;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StoreMessagesTest extends TestCase {

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

        $this->room = Room::factory()->create();

    }

    public function test_if_status_is_201()
    {

        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/rooms/' . $this->room->id . '/messages', [
                "text" => "Test message",
            ]);

        $response->assertStatus(201);
    }

    public function test_if_proper_content_is_returned_in_response()
    {

        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/rooms/' . $this->room->id . '/messages', [
                "text" => "Test message",
            ]);

        $response->assertJson([
            "text" => "Test message",
            "user_id" => Auth::id(),
            "created_at" => \Illuminate\Support\Facades\Date::now()->diffForHumans(),
        ]);
    }

    public function test_if_content_is_inserted_into_db()
    {

        $this->actingAs($this->user, 'api')
            ->postJson('/api/rooms/' . $this->room->id . '/messages', [
                "text" => "Test message",
            ]);


        $this->assertDatabaseHas('messages', ['text' => 'Test message',
            'room_id' => $this->room->id,
            'user_id' => Auth::id()]);
    }

    public function test_if_422_status_is_returned_if_message_is_missing(){
        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/rooms/' . $this->room->id . '/messages');

        $response->assertStatus(422);
    }

}
