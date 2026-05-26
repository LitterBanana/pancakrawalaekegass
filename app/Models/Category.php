<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // Mengizinkan insert data selain ID

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}