<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warung extends Model
{
    use HasFactory;

    protected $table = 'warung';
    protected $primaryKey = 'warung_id';

    protected $fillable = [
        'nama_warung',
        'slug',
        'alamat',
        'no_wa',
        'status_pengantaran',
        'latitude',
        'longitude',
        'image',
        'user_id', // Tambahkan 'user_id' agar dapat diisi secara massal
    ];

    protected $attributes = [
        'status_pengantaran' => 'aktif',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan model Menu
    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class, 'warung_id', 'warung_id');
    }

    // Relasi dengan model Ulasan
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'warung_id', 'warung_id');
    }

    // Relasi dengan model User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
