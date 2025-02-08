<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'ulasan';

    /**
     * Primary key yang digunakan pada tabel.
     *
     * @var string
     */
    protected $primaryKey = 'ulasan_id';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'warung_id',
        'rating',
        'komentar',
        'tanggal_ulasan',
    ];

    /**
     * Relasi dengan model User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi dengan model Warung.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warung()
    {
        return $this->belongsTo(Warung::class, 'warung_id', 'warung_id');
    }
}
