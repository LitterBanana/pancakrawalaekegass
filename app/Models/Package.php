<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function prices()
    {
        return $this->hasMany(PackagePrice::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function hotelMakkah()
    {
        return $this->belongsTo(Hotel::class, 'hotel_makkah_id');
    }

    public function hotelMadinah()
    {
        return $this->belongsTo(Hotel::class, 'hotel_madinah_id');
    }
}