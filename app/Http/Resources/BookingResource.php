<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone_No' => $this->phone_No,
            'address' => $this->address,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'booking_date' => $this->booking_date,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at->format('Y-m-d'),
         
        ];
    }
}
