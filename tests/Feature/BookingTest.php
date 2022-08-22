<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookingTest extends TestCase
{

    use WithFaker;
    public function test_user_can_store_booking()
    {
        DB::beginTransaction();
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $response = $this->actingAs($user)->post('/api/bookings', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone_No' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'check_in_date' => $this->faker->dateTimeBetween(now(), '+1 days'),
            'check_out_date' => $this->faker->dateTimeBetween(now(), '+2 days'),
            'booking_date' => $this->faker->dateTimeBetween(now(), '+2 days'),
            'booking_type' => 1,
            'room_id' => [Room::where('availability', '1')->first()->id, Room::where('availability', '1')->first()->id],
            'guest_id' => $user->id,

        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.your_booking_is_successfully_created')]);

        DB::rollback();
    }


    public function test_user_can_update_booking()
    {

        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $booking = Booking::factory()->create();
  
        $response = $this->actingAs($user)->put('/api/bookings/' . $booking->id, [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone_No' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'check_in_date' => $this->faker->date,
            'check_out_date' => $this->faker->date,
            'booking_date' => $this->faker->date,
            'booking_type' => 1,
            //  'room_id' => [Room::where('availability', '1')->first()->id],
            'guest_id' => $user->id,


        ]);
        // dd($response->json());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.booking_updated_successfully')]);
        DB::rollback();
    }


    public function test_user_can_delete_booking()
    {
        DB::beginTransaction();
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $booking = Booking::factory()->create();
        $response = $this->actingAs($user)->delete('/api/bookings/' . $booking->id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.booking_deleted_successfully')]);
    }
    public function test_user_can_show_booking()
    {
        DB::beginTransaction();
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $booking = Booking::factory()->create();
        $response = $this->actingAs($user)->get('/api/bookings/' . $booking->id);
        $response->assertStatus(Response::HTTP_OK);
        
    }
    public function test_user_can_list_all_booking()
    {
        DB::beginTransaction();
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/api/bookings');
        $response->assertStatus(Response::HTTP_OK);
    }
 public function test_user_can_list_available_dates()
    {
        DB::beginTransaction();
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $response = $this->actingAs($user)->get('/api/booking/available-dates');
        $response->assertStatus(Response::HTTP_OK);
    }
    

}
