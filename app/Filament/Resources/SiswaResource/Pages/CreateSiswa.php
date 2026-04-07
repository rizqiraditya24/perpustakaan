<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $userData = [
            'nama_lengkap' => $data['user']['nama_lengkap'],
            'username'     => $data['user']['username'],
            'email'        => $data['user']['email'],
            'password'     => $data['user']['password'],
            'telepon'      => $data['user']['telepon'] ?? null,
            'alamat'       => $data['user']['alamat'] ?? null,
            'role'         => 'siswa',
        ];

        $user = User::create($userData);

        return $this->getModel()::create([
            'user_id'       => $user->id,
            'nis'           => $data['nis'],
            'kelas'         => $data['kelas'],
            'jurusan'       => $data['jurusan'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'status'        => $data['status'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
