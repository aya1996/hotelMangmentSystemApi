<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [


            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone_No' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'check_in_date' => fake()->dateTimeBetween('now', '+1 month'),
            'check_out_date' =>fake()->dateTimeBetween('now', '+1 month'),
            'booking_date' => fake()->dateTimeBetween('now', '+1 month'),
            'booking_type' => 1,
            'guest_id' => $this->faker->numberBetween(1, 10),



        ];
    }
}
