<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KategoriBuku extends Model
{
    use HasFactory;

    protected $table = 'kategori_buku';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function bukus(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'buku_kategori', 'kategori_buku_id', 'buku_id');
    }
}
