<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel pengembalian sudah digabung ke tabel peminjaman.
// Migration ini dikosongkan agar tidak membuat tabel terpisah.
return new class extends Migration
{
    public function up(): void
    {
        // intentionally empty - pengembalian merged into peminjaman table
    }

    public function down(): void
    {
        // intentionally empty
    }
};
