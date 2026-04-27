<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    // Ini adalah 'izin' agar kolom-kolom ini bisa diisi dari API
    protected $fillable = [
        'user_id',
        'age',
        'average_cycle_length',
        'average_period_length',
        'theme_mode',
        'language',
    ];

    /**
     * Relasi balik ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}