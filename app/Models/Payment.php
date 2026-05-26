<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'booking_id',
        'amount',
        'payment_date',
        'payment_method',
        'bank_name',
        'proof_of_payment',
        'status',
        'notes'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}