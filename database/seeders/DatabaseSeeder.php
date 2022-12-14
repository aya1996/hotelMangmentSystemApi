<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\RoomType::factory(10)->create();
        \App\Models\Facility::factory(10)->create();
        \App\Models\Room::factory(10)->create();
        \App\Models\Image::factory(10)->create();
        \App\Models\Booking::factory(10)->create();
    }
}
