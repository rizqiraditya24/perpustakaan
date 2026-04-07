<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $siswa = $this->getRecord()->load('user');
        $data['user'] = [
            'nama_lengkap' => $siswa->user->nama_lengkap,
            'username'     => $siswa->user->username,
            'email'        => $siswa->user->email,
            'telepon'      => $siswa->user->telepon,
            'alamat'       => $siswa->user->alamat,
        ];
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->user->update([
            'nama_lengkap' => $data['user']['nama_lengkap'],
            'username'     => $data['user']['username'],
            'email'        => $data['user']['email'],
            'telepon'      => $data['user']['telepon'] ?? null,
            'alamat'       => $data['user']['alamat'] ?? null,
        ]);

        if (!empty($data['user']['password'])) {
            $record->user->update(['password' => $data['user']['password']]);
        }

        $record->update([
            'nis'           => $data['nis'],
            'kelas'         => $data['kelas'],
            'jurusan'       => $data['jurusan'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'status'        => $data['status'],
        ]);

        return $record;
    }
}
