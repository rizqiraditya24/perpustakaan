<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Siswa;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';
    protected static ?string $navigationLabel = 'Peminjaman';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                TextInput::make('kode_peminjaman')
                    ->default(fn () => 'PMJ-' . strtoupper(Str::random(8)))
                    ->required()->unique(ignoreRecord: true)->maxLength(50),
                Select::make('siswa_id')->label('Siswa')
                    ->options(fn () => Siswa::with('user')->get()->pluck('user.nama_lengkap', 'id'))
                    ->searchable()->required(),
                Select::make('buku_id')->label('Buku')
                    ->options(fn () => Buku::where('stok', '>', 0)->pluck('judul', 'id'))
                    ->searchable()->required(),
                DatePicker::make('tanggal_pinjam')->required()->default(now()),
                DatePicker::make('batas_pengembalian')->required()->default(now()->addDays(7)),
                Select::make('status')
                    ->options([
                        'dipinjam'  => 'Dipinjam',
                        'terlambat' => 'Terlambat',
                        'hilang'    => 'Hilang',
                    ])
                    ->default('dipinjam')->required(),
                Textarea::make('catatan')->nullable()->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_peminjaman')->searchable()->sortable(),
                TextColumn::make('siswa.user.nama_lengkap')->label('Nama Siswa')->searchable(),
                TextColumn::make('buku.judul')->label('Buku')->limit(30)->searchable(),
                TextColumn::make('tanggal_pinjam')->date('d M Y')->sortable(),
                TextColumn::make('batas_pengembalian')->label('Batas Kembali')->date('d M Y')->sortable(),
                TextColumn::make('status')->badge()
                    ->color(fn ($state) => match($state) {
                        'dipinjam'  => 'warning',
                        'terlambat' => 'danger',
                        'hilang'    => 'gray',
                        default     => 'success',
                    }),
            ])
            ->modifyQueryUsing(fn ($query) => $query->whereIn('status', ['dipinjam', 'terlambat', 'hilang']))
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'dipinjam'  => 'Dipinjam',
                        'terlambat' => 'Terlambat',
                        'hilang'    => 'Hilang',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPeminjamans::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'view'   => Pages\ViewPeminjaman::route('/{record}'),
            'edit'   => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
