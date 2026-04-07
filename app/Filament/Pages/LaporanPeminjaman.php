<?php

namespace App\Filament\Pages;

use App\Models\Peminjaman;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LaporanPeminjaman extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?string $navigationGroup = 'Laporan';
    protected static string $view = 'filament.pages.laporan-peminjaman';

    public function table(Table $table): Table
    {
        return $table
            ->query(Peminjaman::query()->with(['siswa.user', 'buku']))
            ->columns([
                TextColumn::make('kode_peminjaman')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('siswa.user.nama_lengkap')->label('Nama Siswa')->searchable(),
                TextColumn::make('buku.judul')->label('Buku')->limit(30),
                TextColumn::make('batas_pengembalian')->label('Tgl Kembali')->date('d/m/Y'),
                TextColumn::make('status')->badge()
                    ->color(fn ($state) => match($state) {
                        'dipinjam'     => 'warning',
                        'dikembalikan' => 'success',
                        'terlambat'    => 'danger',
                        'hilang'       => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'dipinjam'     => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'terlambat'    => 'Terlambat',
                        'hilang'       => 'Hilang',
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
