<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'invoice_number' => $this->invoice_number,
            'total_amount' => $this->total_amount,
            'guest_id' => $this->guest_id,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'invoiceDate' => $this->invoiceDate,
            'created_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}
