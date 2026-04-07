<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Buku';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                TextInput::make('kode_buku')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                TextInput::make('penulis')->required()->maxLength(255),
                TextInput::make('penerbit')->required()->maxLength(255),
                TextInput::make('tahun_terbit')->required()->numeric()->minValue(1900)->maxValue(2099),
                Select::make('kategoris')
                    ->label('Kategori')
                    ->relationship('kategoris', 'nama_kategori')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('isbn')->nullable()->maxLength(20),
                TextInput::make('jumlah_halaman')->numeric()->nullable(),
                TextInput::make('stok')->numeric()->default(0)->required(),
                TextInput::make('lokasi_rak')->nullable()->maxLength(50),
                Textarea::make('deskripsi')->nullable()->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->image()
                    ->disk('public')
                    ->directory('covers')
                    ->visibility('public')
                    ->nullable()
                    ->columnSpanFull(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Buku&background=random'),
                TextColumn::make('kode_buku')->searchable()->sortable(),
                TextColumn::make('judul')->searchable()->sortable()->limit(30),
                TextColumn::make('penulis')->searchable()->limit(25),
                TextColumn::make('kategoris.nama_kategori')
                    ->label('Kategori')
                    ->badge()
                    ->separator(','),
                TextColumn::make('penerbit')->limit(20)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tahun_terbit')->sortable(),
                TextColumn::make('stok')->sortable()
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger'),
                TextColumn::make('lokasi_rak')->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('kategoris')
                    ->relationship('kategoris', 'nama_kategori')
                    ->multiple(),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Informasi Utama')
                    ->schema([
                        \Filament\Infolists\Components\Split::make([
                            \Filament\Infolists\Components\Group::make([
                                ImageEntry::make('cover_image')
                                    ->hiddenLabel()
                                    ->disk('public')
                                    ->height(280)
                                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Buku&background=random'),
                            ])->grow(false),

                            \Filament\Infolists\Components\Group::make([
                                TextEntry::make('judul')
                                    ->hiddenLabel()
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                                
                                \Filament\Infolists\Components\Grid::make(2)
                                    ->schema([
                                        TextEntry::make('penulis')
                                            ->label('Penulis')
                                            ->icon('heroicon-m-pencil-square'),
                                            
                                        TextEntry::make('penerbit')
                                            ->label('Penerbit')
                                            ->icon('heroicon-m-building-office'),
                                            
                                        TextEntry::make('tahun_terbit')
                                            ->label('Tahun Terbit')
                                            ->icon('heroicon-m-calendar'),
                                            
                                        TextEntry::make('kategoris.nama_kategori')
                                            ->label('Kategori')
                                            ->badge()
                                            ->color('primary'),
                                    ]),
                            ])->grow(),
                        ])->from('md'),
                    ]),

                \Filament\Infolists\Components\Section::make('Detail Fisik & Inventaris')
                    ->schema([
                        \Filament\Infolists\Components\Grid::make(3)
                            ->schema([
                                TextEntry::make('kode_buku')
                                    ->label('Kode Buku')
                                    ->badge()
                                    ->color('gray')
                                    ->copyable()
                                    ->icon('heroicon-m-qr-code'),
                                    
                                TextEntry::make('isbn')
                                    ->label('ISBN')
                                    ->placeholder('Tidak tersedia')
                                    ->copyable()
                                    ->icon('heroicon-m-hashtag'),
                                    
                                TextEntry::make('jumlah_halaman')
                                    ->label('Jumlah Halaman')
                                    ->placeholder('-')
                                    ->icon('heroicon-m-document'),
                                    
                                TextEntry::make('lokasi_rak')
                                    ->label('Lokasi Rak')
                                    ->placeholder('-')
                                    ->badge()
                                    ->color('warning')
                                    ->icon('heroicon-m-archive-box'),
                                    
                                TextEntry::make('stok')
                                    ->label('Stok Tersedia')
                                    ->badge()
                                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                                    ->icon('heroicon-m-cube'),
                            ]),
                    ]),

                \Filament\Infolists\Components\Section::make('Sinopsis / Deskripsi')
                    ->schema([
                        TextEntry::make('deskripsi')
                            ->hiddenLabel()
                            ->prose()
                            ->placeholder('Deskripsi belum tersedia.'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'view'   => Pages\ViewBuku::route('/{record}'),
            'edit'   => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}
