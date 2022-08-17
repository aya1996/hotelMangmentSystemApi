<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Facility extends Model
{
    use HasFactory , HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'details'];

    /**
     * The attributes that are mass translatable.
     *
     * @var array
     */
    public $translatable = ['name', 'details'];


    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function roomFacilities()
    {
        return $this->hasMany(RoomFacility::class);
    }

    
}
