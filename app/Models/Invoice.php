<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Get the room that owns the room booking.
     *
     * @return BelongsTo
     */
    public function booking(): BelongsTo
    {

        return $this->BelongsTo(Booking::class);
    }

     /**
     * Get the room rooms .
     *
     * 
     */
    public function scopeSearch($query, $search)
    {
        return $query->orWhere('invoice_number', 'like', '%' . $search . '%')
            ->orWhere('guest_id', 'like', '%' . $search . '%')
            ->orWhere('invoiceDate', 'like', '%' . $search . '%');
           
    }

}
