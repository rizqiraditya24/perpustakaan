<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('buku_id')->constrained('buku')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_pinjam');
            $table->date('batas_pengembalian');
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat', 'hilang'])->default('dipinjam');
            $table->text('catatan')->nullable();

            // Kolom pengembalian (diisi saat buku dikembalikan)
            $table->date('tanggal_kembali')->nullable();
            $table->integer('keterlambatan')->default(0); // hari
            $table->decimal('denda', 10, 2)->nullable();
            $table->enum('kondisi_buku', ['baik', 'rusak', 'hilang'])->nullable();
            $table->text('catatan_pengembalian')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
