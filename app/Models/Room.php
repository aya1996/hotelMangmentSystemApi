<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_No', 'price', 'capacity', 'availability', 'phone_No', 'room_type_id'];





    /**
     * Get the room type that owns the room.
     *
     * @return BelongsTo
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }


    /**
     * Get the room facilities that owns the room.
     *
     * @return belongsToMany
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class);
    }

    /**
     * Get the room facilities that owns the room.
     *
     * @return hasMany
     */
    public function roomFacilities(): HasMany
    {
        return $this->hasMany(RoomFacility::class);
    }

    /**
     * Get the room images that owns the room.
     *
     * @return hasMany
     */

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the room bookings that owns the room.
     *
     * @return hasMany
     */
    public function roomBookings(): HasMany
    {
        return $this->hasMany(RoomBooking::class);
    }

    /**
     * Get the room bookings that owns the room.
     *
     * @return hasMany
     */
    public function Bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class);
    }

    /**
     * Get the room rooms .
     *
     * 
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('room_No', 'like', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%')
            ->orWhere('capacity', 'like', '%' . $search . '%')
            ->orWhere('availability', 'like', '%' . $search . '%')
            ->orWhere('booking_type', 'like', '%' . $search . '%')
            ->orWhere('phone_No', 'like', '%' . $search . '%')
            ->orWhere('room_type_id', 'like', '%' . $search . '%');
         
    }
}
