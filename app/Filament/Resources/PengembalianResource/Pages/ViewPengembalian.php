<?php

namespace App\Filament\Resources\PengembalianResource\Pages;

use App\Filament\Resources\PengembalianResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPengembalian extends ViewRecord
{
    protected static string $resource = PengembalianResource::class;

    protected ?string $heading = 'Detail Pengembalian';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
