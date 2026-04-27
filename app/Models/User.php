<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Pastikan semua kolom yang diperlukan sudah terdaftar di sini
#[Fillable(['name', 'email', 'password', 'auth_provider', 'provider_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    // Gabungkan semua trait di satu baris ini
    use HasApiTokens, HasFactory, Notifiable;

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

    /**
     * Relasi ke UserProfile (One-to-One)
     */
    public function profile() 
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Relasi ke CyclePeriod (One-to-Many)
     */
    public function periods()
    {
        return $this->hasMany(CyclePeriod::class);
    }

    /**
     * Relasi ke DailyLog (One-to-Many)
     */
    public function dailyLogs()
    {
        return $this->hasMany(DailyLog::class);
    }
}