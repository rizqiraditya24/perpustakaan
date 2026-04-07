<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBuku extends ViewRecord
{
    protected static string $resource = BukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
