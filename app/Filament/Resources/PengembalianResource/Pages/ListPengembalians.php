<?php

namespace App\Filament\Resources\PengembalianResource\Pages;

use App\Filament\Resources\PengembalianResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListPengembalians extends ListRecords
{
    protected static string $resource = PengembalianResource::class;

    protected ?string $heading = 'Pengembalian';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('proses_pengembalian')
                ->label('Proses Pengembalian')
                ->icon('heroicon-o-arrow-left-circle')
                ->color('primary')
                ->url(PengembalianResource::getUrl('proses')),
        ];
    }
}
