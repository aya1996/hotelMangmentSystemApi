<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_No' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'booking_date' => 'required|date',
            'hour_booking' => 'sometimes|boolean',
            'day_booking' => 'sometimes|boolean',
            'room_id' => 'required|array',
            'room_id.*' => 'required|integer|exists:rooms,id',
            'guest_id' => 'required|integer|exists:guests,id',


        ];
    }
}
