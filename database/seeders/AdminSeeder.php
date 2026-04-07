<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@perpustakaan.com'],
            [
                'username'     => 'admin',
                'nama_lengkap' => 'Administrator',
                'email'        => 'admin@example.com',
                'password'     => Hash::make('123456789'),
                'role'            => 'admin',
                'alamat'          => 'Jl. Contoh No. 1',
                'telepon'         => '08123456789',
                'approval_status' => 'disetujui',
            ]
        );
    }
}
