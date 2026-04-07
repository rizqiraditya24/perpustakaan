<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriBukuResource\Pages;
use App\Models\KategoriBuku;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KategoriBukuResource extends Resource
{
    protected static ?string $model = KategoriBuku::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Kategori Buku';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                TextInput::make('nama_kategori')
                    ->required()
                    ->maxLength(255),
                Textarea::make('deskripsi')
                    ->nullable(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kategori')->searchable()->sortable(),
                TextColumn::make('deskripsi')->limit(50)->placeholder('-'),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
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
        return $infolist->schema([
            InfoSection::make()->schema([
                TextEntry::make('nama_kategori')->label('Nama Kategori'),
                TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y'),
                TextEntry::make('deskripsi')->label('Deskripsi')->placeholder('-')->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKategoriBukus::route('/'),
            'create' => Pages\CreateKategoriBuku::route('/create'),
            'edit'   => Pages\EditKategoriBuku::route('/{record}/edit'),
        ];
    }
}
