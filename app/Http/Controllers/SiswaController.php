<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $siswa = auth()->user()->siswa;
        return view('siswa.dashboard', compact('siswa'));
    }

    public function koleksiBuku(Request $request)
    {
        $query = Buku::with('kategoris')->where('stok', '>', 0);

        if ($request->kategori_id) {
            $query->whereHas('kategoris', fn ($q) => $q->where('kategori_buku.id', $request->kategori_id));
        }

        $bukus     = $query->get();
        $kategoris = KategoriBuku::all();

        return view('siswa.koleksi-buku', compact('bukus', 'kategoris'));
    }

    public function riwayatPeminjaman()
    {
        $siswa      = auth()->user()->siswa;
        $peminjaman = $siswa->peminjaman()->with('buku')->latest()->get();

        return view('siswa.riwayat-peminjaman', compact('peminjaman'));
    }

    public function pinjam(Buku $buku)
    {
        $siswa = auth()->user()->siswa;

        // Cek apakah siswa masih punya pinjaman aktif untuk buku ini
        $aktif = Peminjaman::where('siswa_id', $siswa->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($aktif) {
            return back()->with('error', 'Kamu masih meminjam buku ini.');
        }

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        Peminjaman::create([
            'kode_peminjaman'  => 'PMJ-' . strtoupper(Str::random(8)),
            'siswa_id'         => $siswa->id,
            'buku_id'          => $buku->id,
            'admin_id'         => 1, // default admin
            'tanggal_pinjam'   => now(),
            'batas_pengembalian' => now()->addDays(7),
            'status'           => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjam.');
    }
}
