<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    /**
     * Nama tabel yang terkait dengan model
     *
     * @var string
     */
    protected $table = 'menu';

    /**
     * Primary key yang digunakan pada tabel
     *
     * @var string
     */
    protected $primaryKey = 'menu_id';

    /**
     * Atribut yang dapat diisi secara massal
     *
     * @var array
     */
    protected $fillable = [
        'warung_id',
        'user_id',  // Menambahkan user_id yang sesuai dengan relasi
        'nama_menu',
        'harga',
        'ketersediaan',
    ];

    /**
     * Atribut yang memiliki nilai default
     *
     * @var array
     */
    protected $attributes = [
        'ketersediaan' => 'tersedia',
    ];

    /**
     * Aturan casting atribut
     *
     * @var array
     */
    protected $casts = [
        'harga' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'ketersediaan' => 'string',
    ];

    /**
     * Relasi dengan model Warung
     *
     * @return BelongsTo
     */
    public function warung(): BelongsTo
    {
        return $this->belongsTo(Warung::class, 'warung_id', 'warung_id');
    }

    /**
     * Relasi dengan model User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
