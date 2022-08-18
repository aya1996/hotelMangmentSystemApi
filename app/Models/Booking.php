<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Booking extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'address', 'phone_No', 'check_in_date', 'check_out_date', 'booking_date', 'hour_booking', 'day_booking', 'payment_status', 'guest_id', 'room_id'];
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

    /**
     * Get the invoice that owns the room booking.
     *
     * @return HasOne
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the guest that owns the room booking.
     *
     * @return belongsTo
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function scopeAvailableDays($query)
    {
        return $query->whereMonth('check_in_date', Carbon::now()->month)
            ->whereMonth('check_out_date', Carbon::now()->month)
            ->get(['check_in_date', 'check_out_date']);
    }


    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('name->ar', 'like', '%' . $search . '%')
            ->orWhere('check_in_date', 'like', '%' . $search . '%')
            ->orWhere('check_out_date', 'like', '%' . $search . '%')
            ->orWhere('booking_date', 'like', '%' . $search . '%')
            ->orWhere('booking_type', 'like', '%' . $search . '%')
            ->orWhere('guest_id', 'like', '%' . $search . '%')
            ->orWhere('room_id', 'like', '%' . $search . '%')
            ->orWhere('booking_type', 'like', '%' . $search . '%');
    }
}
