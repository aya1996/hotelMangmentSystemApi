<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'transaction_id' => $this->transaction_id,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'payment_amount' => $this->payment_amount,
            'payment_currency' => $this->payment_currency,
            'payment_date' => $this->payment_date,
            'is_refund' => $this->is_refund,

        ];
    }
}
