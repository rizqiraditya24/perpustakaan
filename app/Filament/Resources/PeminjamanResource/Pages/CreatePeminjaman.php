<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use App\Models\Buku;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePeminjaman extends CreateRecord
{
    protected static string $resource = PeminjamanResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data['admin_id'] = auth()->id();

        $peminjaman = parent::handleRecordCreation($data);

        // Kurangi stok buku
        Buku::find($data['buku_id'])?->decrement('stok');

        return $peminjaman;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
