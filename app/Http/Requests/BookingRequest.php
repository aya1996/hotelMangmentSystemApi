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
            'email' => 'required|string|email|max:255|unique:bookings',
            'phone_No' => 'required|integer|unique:bookings',
            'address' => 'required|string|max:255',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'booking_date' => 'required|date',
            'payment_status' => 'required|boolean|between:0,1',
    
    
        ];
    }
}
