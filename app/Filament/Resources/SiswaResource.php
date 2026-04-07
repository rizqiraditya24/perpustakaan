<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Models\Siswa;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;
    protected static ?string $slug = 'siswa';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Data Akun')->schema([
                TextInput::make('user.nama_lengkap')->label('Nama Lengkap')->required()->maxLength(255),
                TextInput::make('user.username')->label('Username')->required()
                    ->unique('users', 'username', modifyRuleUsing: function ($rule, $get, $livewire) {
                        if (isset($livewire->record)) {
                            $rule->ignore($livewire->record->user_id);
                        }
                        return $rule;
                    })->maxLength(50),
                TextInput::make('user.email')->label('Email')->email()->required()
                    ->unique('users', 'email', modifyRuleUsing: function ($rule, $get, $livewire) {
                        if (isset($livewire->record)) {
                            $rule->ignore($livewire->record->user_id);
                        }
                        return $rule;
                    }),
                TextInput::make('user.password')->label('Password')->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation) => $operation === 'create'),
                TextInput::make('user.telepon')->label('Telepon')->nullable(),
                TextInput::make('user.alamat')->label('Alamat')->nullable(),
            ])->columns(2),
            Section::make('Data Siswa')->schema([
                TextInput::make('nis')->label('NIS')->required()->unique(ignoreRecord: true),
                TextInput::make('kelas')->required()->maxLength(20),
                TextInput::make('jurusan')->nullable()->maxLength(50),
                DatePicker::make('tanggal_lahir')->nullable(),
                Select::make('status')
                    ->options(['aktif' => 'Aktif', 'lulus' => 'Lulus', 'keluar' => 'Keluar'])
                    ->default('aktif')
                    ->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nama_lengkap')->label('Nama')->searchable()->sortable(),
                TextColumn::make('nis')->label('NIS')->searchable(),
                TextColumn::make('kelas')->sortable(),
                TextColumn::make('jurusan')->placeholder('-'),
                TextColumn::make('tanggal_lahir')->date('d M Y')->placeholder('-'),
                TextColumn::make('status')->badge()
                    ->color(fn ($state) => match($state) {
                        'aktif'  => 'success',
                        'lulus'  => 'info',
                        'keluar' => 'danger',
                    }),
                SelectColumn::make('approval_status')
                    ->label('Persetujuan')
                    ->options([
                        'menunggu'  => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak'   => 'Ditolak',
                    ])
                    ->selectablePlaceholder(false),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(['aktif' => 'Aktif', 'lulus' => 'Lulus', 'keluar' => 'Keluar']),
                SelectFilter::make('approval_status')
                    ->label('Status Persetujuan')
                    ->options([
                        'menunggu'  => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak'   => 'Ditolak',
                    ])
                    ->query(fn ($query, $data) => $data['value']
                        ? $query->whereHas('user', fn ($q) => $q->where('approval_status', $data['value']))
                        : $query
                    ),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'view'   => Pages\ViewSiswa::route('/{record}'),
            'edit'   => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
