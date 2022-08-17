<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'room_No' => $this->faker->unique()->numberBetween(1, 10),
            'price_per_day' => $this->faker->numberBetween(100, 1000),
            'price_per_hour' => $this->faker->numberBetween(100, 1000),
            'capacity' => $this->faker->numberBetween(1, 10),
            'availability' => $this->faker->numberBetween(0, 1),
            'phone_No' => $this->faker->phoneNumber,
            'room_type_id' => $this->faker->numberBetween(1, 10),
           
        ];
    }
}
