<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'booking_id' => 'required|integer|exists:bookings,id',
            'hours_duration' => 'integer | sometimes',
            'days_duration' => 'integer | sometimes',
            'discount' => 'integer',
            'guest_id' => 'required|integer|exists:users,id',
            'invoiceDate' => 'date | date_format:Y-m-d',

        ];
    }
}
