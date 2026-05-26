<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'name',
        'phone',
        'notes',
        'status', // TAMBAHKAN INI AGAR STATUS BISA DIUBAH DARI DASHBOARD
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}