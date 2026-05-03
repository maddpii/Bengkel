<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_photo_path',
        'email_otp_code',
        'email_otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasVerifiedEmail(): bool
    {
        if (! is_null($this->email_verified_at)) {
            return true;
        }

        // Akun lama sebelum fitur OTP dianggap sudah aktif
        // selama belum punya data OTP verifikasi.
        return is_null($this->email_otp_code) && is_null($this->email_otp_expires_at);
    }

    // RELASI 

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function mekanikTransactions(){
        return $this->hasMany(Transaction::class, 'mekanik_id');
    }

    public function kasirTransactions(){
        return $this->hasMany(Transaction::class, 'kasir_id');
    }

    public function serviceReviews()
    {
        return $this->hasMany(ServiceReview::class);
    }

    public function isRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', trim((string) $this->name)))
            ->filter()
            ->take(2)
            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
            ->implode('') ?: 'U';
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo_path
            ? asset('storage/' . ltrim($this->profile_photo_path, '/'))
            : null;
    }
}
