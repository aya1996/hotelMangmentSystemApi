<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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

            'room_No'  => 'required|numeric|max:255',
            'price_per_day' => 'required|numeric|max:255',
            'price_per_hour' => 'required|numeric|max:255',
            'capacity' => 'required|numeric|max:255',
            'availability' => 'required|boolean|between:0,1',
            'phone_No' => 'required|numeric',
            'room_type_id' => 'required|numeric|exists:room_types,id',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facilities' => 'required|array',
            'facilities.*' => 'required|numeric|exists:facilities,id',



        ];
    }
}
