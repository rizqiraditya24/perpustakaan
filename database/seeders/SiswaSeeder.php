<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaData = [
            [
                'user' => [
                    'username'     => 'siswa01',
                    'nama_lengkap' => 'Budi Santoso',
                    'email'        => 'budi@siswa.com',
                    'password'     => Hash::make('password'),
                    'role'         => 'siswa',
                    'telepon'      => '08111111111',
                ],
                'siswa' => [
                    'nis'           => '2024001',
                    'kelas'         => 'X',
                    'jurusan'       => 'IPA',
                    'tanggal_lahir' => '2008-05-10',
                    'status'        => 'aktif',
                ],
            ],
            [
                'user' => [
                    'username'     => 'siswa02',
                    'nama_lengkap' => 'Siti Rahayu',
                    'email'        => 'siti@siswa.com',
                    'password'     => Hash::make('password'),
                    'role'         => 'siswa',
                    'telepon'      => '08222222222',
                ],
                'siswa' => [
                    'nis'           => '2024002',
                    'kelas'         => 'XI',
                    'jurusan'       => 'IPS',
                    'tanggal_lahir' => '2007-08-20',
                    'status'        => 'aktif',
                ],
            ],
        ];

        foreach ($siswaData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['user']['email']],
                $data['user']
            );

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                array_merge($data['siswa'], ['user_id' => $user->id])
            );
        }
    }
}
