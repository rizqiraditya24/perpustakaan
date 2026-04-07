<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku')->unique();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->string('isbn')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->string('lokasi_rak')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });

        // Pivot table buku <-> kategori (many-to-many)
        Schema::create('buku_kategori', function (Blueprint $table) {
            $table->foreignId('buku_id')->constrained('buku')->cascadeOnDelete();
            $table->foreignId('kategori_buku_id')->constrained('kategori_buku')->cascadeOnDelete();
            $table->primary(['buku_id', 'kategori_buku_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_kategori');
        Schema::dropIfExists('buku');
    }
};
