<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'referral_code',
        'referred_by',
    ];

    /**
     * Cek apakah user memiliki role admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Relasi ke leader yang mereferensikan user ini.
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Relasi ke users yang direferensikan oleh user ini.
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Relasi ke daftar booking milik user ini.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi ke riwayat pembayaran user ini.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Generate kode referral unik.
     * Format: HMI + bulan(2 digit) + tanggal(2 digit) + 6 huruf kapital random (A-Z)
     * Contoh: HMI0419XKBRTM (19 April + 6 huruf acak)
     */
    public static function generateReferralCode(): string
    {
        do {
            $randomLetters = '';
            for ($i = 0; $i < 6; $i++) {
                $randomLetters .= chr(random_int(65, 90)); // A(65) - Z(90)
            }

            $code = 'HMI' . now()->format('md') . $randomLetters;
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}