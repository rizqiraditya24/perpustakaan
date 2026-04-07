<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengembalianResource\Pages;
use App\Models\Peminjaman;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengembalianResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-circle';
    protected static ?string $navigationLabel = 'Pengembalian';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'pengembalian';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Info Peminjaman')->schema([
                Placeholder::make('kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->content(fn ($record) => $record?->kode_peminjaman ?? '-'),
                Placeholder::make('siswa')
                    ->label('Siswa')
                    ->content(fn ($record) => $record?->siswa?->user?->nama_lengkap ?? '-'),
                Placeholder::make('buku')
                    ->label('Buku')
                    ->content(fn ($record) => $record?->buku?->judul ?? '-'),
                Placeholder::make('batas_pengembalian')
                    ->label('Batas Pengembalian')
                    ->content(fn ($record) => $record?->batas_pengembalian?->format('d M Y') ?? '-'),
            ])->columns(2)->collapsible(),

            Section::make('Data Pengembalian')->schema([
                DatePicker::make('tanggal_kembali')
                    ->required()
                    ->default(now())
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get, $record) {
                        if (!$state || !$record) return;
                        $batas     = $record->batas_pengembalian;
                        $aktual    = \Carbon\Carbon::parse($state);
                        $terlambat = max(0, $batas->diffInDays($aktual, false));
                        $set('keterlambatan', $terlambat);
                        $set('denda', $terlambat * 1000);
                        $set('status', $terlambat > 0 ? 'terlambat' : 'dikembalikan');
                    }),
                TextInput::make('keterlambatan')->numeric()->default(0)->suffix('hari')->readOnly(),
                TextInput::make('denda')->numeric()->nullable()->prefix('Rp'),
                Select::make('kondisi_buku')
                    ->options(['baik' => 'Baik', 'rusak' => 'Rusak', 'hilang' => 'Hilang'])
                    ->required()->default('baik'),
                Select::make('status')
                    ->options([
                        'dikembalikan' => 'Dikembalikan',
                        'terlambat'    => 'Terlambat',
                        'hilang'       => 'Hilang',
                    ])
                    ->required()->default('dikembalikan'),
                Textarea::make('catatan_pengembalian')->nullable()->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_peminjaman')->label('Kode Pinjam')->searchable()->sortable(),
                TextColumn::make('siswa.user.nama_lengkap')->label('Siswa')->searchable(),
                TextColumn::make('buku.judul')->label('Buku')->limit(30)->searchable(),
                TextColumn::make('batas_pengembalian')->label('Batas')->date('d M Y')->sortable(),
                TextColumn::make('tanggal_kembali')->label('Tgl Kembali')->date('d M Y')->placeholder('-')->sortable(),
                TextColumn::make('keterlambatan')->suffix(' hari')->badge()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),
                TextColumn::make('denda')->money('IDR')->placeholder('Rp 0'),
                TextColumn::make('kondisi_buku')->badge()
                    ->color(fn ($state) => match($state) {
                        'baik'   => 'success',
                        'rusak'  => 'warning',
                        'hilang' => 'danger',
                        default  => 'gray',
                    }),
                TextColumn::make('status')->badge()
                    ->color(fn ($state) => match($state) {
                        'dikembalikan' => 'success',
                        'terlambat'    => 'danger',
                        'hilang'       => 'gray',
                        default        => 'warning',
                    }),
            ])
            ->modifyQueryUsing(fn ($query) => $query->whereIn('status', ['dikembalikan', 'terlambat', 'hilang'])
                ->whereNotNull('tanggal_kembali'))
            ->filters([
                SelectFilter::make('kondisi_buku')
                    ->options(['baik' => 'Baik', 'rusak' => 'Rusak', 'hilang' => 'Hilang']),
                SelectFilter::make('status')
                    ->options([
                        'dikembalikan' => 'Dikembalikan',
                        'terlambat'    => 'Terlambat',
                        'hilang'       => 'Hilang',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('tanggal_kembali', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make('Info Peminjaman')->schema([
                TextEntry::make('kode_peminjaman')->label('Kode Peminjaman'),
                TextEntry::make('status')->label('Status')->badge()
                    ->color(fn ($state) => match($state) {
                        'dikembalikan' => 'success',
                        'terlambat'    => 'danger',
                        'hilang'       => 'gray',
                        default        => 'warning',
                    }),
                TextEntry::make('siswa.user.nama_lengkap')->label('Siswa'),
                TextEntry::make('buku.judul')->label('Buku'),
                TextEntry::make('tanggal_pinjam')->label('Tgl Pinjam')->date('d M Y'),
                TextEntry::make('batas_pengembalian')->label('Batas Kembali')->date('d M Y'),
            ])->columns(2),

            InfoSection::make('Detail Pengembalian')->schema([
                TextEntry::make('tanggal_kembali')->label('Tanggal Kembali')->date('d M Y'),
                TextEntry::make('keterlambatan')->label('Keterlambatan')->suffix(' hari')->badge()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),
                TextEntry::make('denda')->label('Denda')->money('IDR')->placeholder('Rp 0'),
                TextEntry::make('kondisi_buku')->label('Kondisi Buku')->badge()
                    ->color(fn ($state) => match($state) {
                        'baik'   => 'success',
                        'rusak'  => 'warning',
                        'hilang' => 'danger',
                        default  => 'gray',
                    }),
                TextEntry::make('catatan_pengembalian')->label('Catatan')->placeholder('-')->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPengembalians::route('/'),
            'proses' => Pages\ProsesKembali::route('/proses'),
            'view'   => Pages\ViewPengembalian::route('/{record}'),
            'edit'   => Pages\EditPengembalian::route('/{record}/edit'),
        ];
    }
}
