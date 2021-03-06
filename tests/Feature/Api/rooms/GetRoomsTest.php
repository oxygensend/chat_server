<?php

namespace Tests\Feature\Api\rooms;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GetRoomsTest extends TestCase {

    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }


    public function test_if_status_200_is_returned()
    {
        $response = $this->actingAs($this->user, 'api')->get('/api/rooms');
        $response->assertStatus(200);
    }

    public function test_if_returned_empty_body()
    {
        $response = $this->actingAs($this->user, 'api')->get('/api/rooms');
        $response->assertJson([]);

    }

    public function test_if_all_existing_rooms_are_returned()
    {

        Room::factory(2)->create();
        $response = $this->actingAs($this->user, 'api')->get('/api/rooms');
        $this->assertEquals(2, count($response->getOriginalContent()));
    }
}
