<?php

namespace Tests\Feature;

use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RoomTypeTest extends TestCase
{
    public function test_user_can_store_roomType()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/api/room-types', [
            'name' => 'roomType',

        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.roomType_created_successfully')]);
    }
    public function test_user_can_update_roomType()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $roomType = RoomType::factory()->create();
        $response = $this->actingAs($user)->put('/api/room-types/' . $roomType->id, [
            'name' => 'roomType',

        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.roomType_updated_successfully')]);
    }
    public function test_user_can_delete_roomType()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $roomType = RoomType::factory()->create();
        $response = $this->actingAs($user)->delete('/api/room-types/' . $roomType->id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.roomType_deleted_successfully')]);
    }
    public function test_user_can_show_roomType()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $roomType = RoomType::factory()->create();
        $response = $this->actingAs($user)->get('/api/room-types/' . $roomType->id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.roomType_retrieved_successfully')]);
    }
    public function test_user_can_list_roomTypes()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/api/room-types');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.roomTypes_retrieved_successfully')]);
    }
}
