<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Booking extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'address', 'phone_No', 'check_in_date', 'check_out_date', 'booking_date', 'payment_status'];
    /**
     * The attributes that are mass translatable.
     *
     * @var array
     */
    public $translatable = ['name', 'address'];


    

    /**
     * Get the room that owns the room booking.
     *
     * @return HasMany
     */

    public function roomBookings(): HasMany
    {
        return $this->hasMany(RoomBooking::class);
    }

    /**
     * Get the booking that owns the room booking.
     *
     * @return belongsToMany
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }



}
