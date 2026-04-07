<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'siswa_id',
        'buku_id',
        'admin_id',
        'tanggal_pinjam',
        'batas_pengembalian',
        'status',
        'catatan',
        'tanggal_kembali',
        'keterlambatan',
        'denda',
        'kondisi_buku',
        'catatan_pengembalian',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'     => 'date',
            'batas_pengembalian' => 'date',
            'tanggal_kembali'    => 'date',
            'denda'              => 'decimal:2',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
