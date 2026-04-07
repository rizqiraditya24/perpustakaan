<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeminjaman extends EditRecord
{
    protected static string $resource = PeminjamanResource::class;

    private string $statusSebelum;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->statusSebelum = $data['status'];
        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $statusLama = $record->status;
        $statusBaru = $data['status'];

        $record->update($data);

        // Kembalikan stok jika status berubah jadi dikembalikan/hilang
        if (in_array($statusLama, ['dipinjam', 'terlambat']) && in_array($statusBaru, ['dikembalikan', 'hilang'])) {
            $record->buku->increment('stok');
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
