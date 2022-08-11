<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room_No' => $this->room_No,
            'price_per_day' => $this->price_per_day,
            'price_per_hour' => $this->price_per_hour,
            'capacity' => $this->capacity,
            'availability' => $this->availability,
            'phone_No' => $this->phone_No,
            'room_type' => $this->roomType()->get(),
            'images' =>  $this->images()->get(),
            'facilities' => $this->facilities()->get(),
            'created_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}
