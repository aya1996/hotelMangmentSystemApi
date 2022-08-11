<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookingTest extends TestCase
{

    use WithFaker;
    public function test_user_can_store_booking()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/api/bookings', [
            'room_type_id' => 1,
            'check_in' => '2020-01-01',
            'check_out' => '2020-01-01',
            'guests' => 1,
            'price' => 1,
            'status' => 'pending',
            'user_id' => 1,
            'room_id' => 1,
        ]);
    }
}
