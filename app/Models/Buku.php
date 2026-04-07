<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'jumlah_halaman',
        'deskripsi',
        'stok',
        'lokasi_rak',
        'cover_image',
    ];

    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(KategoriBuku::class, 'buku_kategori', 'buku_id', 'kategori_buku_id');
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
