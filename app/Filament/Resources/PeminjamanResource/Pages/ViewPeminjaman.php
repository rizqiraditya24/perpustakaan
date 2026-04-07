<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewPeminjaman extends ViewRecord
{
    protected static string $resource = PeminjamanResource::class;

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
            Section::make('Data Peminjaman')->schema([
                TextEntry::make('kode_peminjaman')->label('Kode Peminjaman'),
                TextEntry::make('status')->label('Status')->badge()
                    ->color(fn ($state) => match($state) {
                        'dipinjam'  => 'warning',
                        'terlambat' => 'danger',
                        'hilang'    => 'gray',
                        default     => 'success',
                    }),
                TextEntry::make('siswa.user.nama_lengkap')->label('Nama Siswa'),
                TextEntry::make('siswa.nis')->label('NIS'),
                TextEntry::make('buku.judul')->label('Judul Buku'),
                TextEntry::make('buku.kode_buku')->label('Kode Buku'),
                TextEntry::make('tanggal_pinjam')->label('Tanggal Pinjam')->date('d M Y'),
                TextEntry::make('batas_pengembalian')->label('Batas Pengembalian')->date('d M Y'),
                TextEntry::make('catatan')->label('Catatan')->placeholder('-')->columnSpanFull(),
            ])->columns(2),

            Section::make('Data Pengembalian')
                ->schema([
                    TextEntry::make('tanggal_kembali')->label('Tanggal Kembali')->date('d M Y')->placeholder('Belum dikembalikan'),
                    TextEntry::make('keterlambatan')->label('Keterlambatan')->suffix(' hari')->badge()
                        ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),
                    TextEntry::make('denda')->label('Denda')->money('IDR')->placeholder('Rp 0'),
                    TextEntry::make('kondisi_buku')->label('Kondisi Buku')->placeholder('-')->badge()
                        ->color(fn ($state) => match($state) {
                            'baik'   => 'success',
                            'rusak'  => 'warning',
                            'hilang' => 'danger',
                            default  => 'gray',
                        }),
                    TextEntry::make('catatan_pengembalian')->label('Catatan Pengembalian')->placeholder('-')->columnSpanFull(),
                ])->columns(2),
        ]);
    }
}
