<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect('/admin');
        }
        return redirect()->route('siswa.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Siswa routes
    Route::middleware('siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/koleksi-buku', [SiswaController::class, 'koleksiBuku'])->name('koleksi-buku');
        Route::get('/riwayat-peminjaman', [SiswaController::class, 'riwayatPeminjaman'])->name('riwayat-peminjaman');
        Route::post('/pinjam/{buku}', [SiswaController::class, 'pinjam'])->name('pinjam');
    });
});

require __DIR__.'/auth.php';
