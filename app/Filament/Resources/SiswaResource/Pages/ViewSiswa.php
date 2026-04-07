<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewSiswa extends ViewRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Data Akun')->schema([
                TextEntry::make('user.nama_lengkap')->label('Nama Lengkap'),
                TextEntry::make('user.username')->label('Username'),
                TextEntry::make('user.email')->label('Email'),
                TextEntry::make('user.telepon')->label('Telepon')->placeholder('-'),
                TextEntry::make('user.alamat')->label('Alamat')->placeholder('-'),
            ])->columns(2),

            Section::make('Data Siswa')->schema([
                TextEntry::make('nis')->label('NIS'),
                TextEntry::make('kelas')->label('Kelas'),
                TextEntry::make('jurusan')->label('Jurusan')->placeholder('-'),
                TextEntry::make('tanggal_lahir')->label('Tanggal Lahir')->date('d M Y')->placeholder('-'),
                TextEntry::make('status')->label('Status')->badge()
                    ->color(fn ($state) => match($state) {
                        'aktif'  => 'success',
                        'lulus'  => 'info',
                        'keluar' => 'danger',
                    }),
                TextEntry::make('created_at')->label('Terdaftar')->dateTime('d M Y'),
            ])->columns(2),

            Section::make('Riwayat Peminjaman')->schema([
                TextEntry::make('peminjaman_count')
                    ->label('Total Peminjaman')
                    ->state(fn ($record) => $record->peminjaman()->count()),
                TextEntry::make('peminjaman_aktif')
                    ->label('Sedang Dipinjam')
                    ->state(fn ($record) => $record->peminjaman()->whereIn('status', ['dipinjam', 'terlambat'])->count()),
            ])->columns(2),
        ]);
    }
}
