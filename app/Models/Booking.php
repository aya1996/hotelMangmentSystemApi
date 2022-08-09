<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    

    
}
