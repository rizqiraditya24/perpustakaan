<?php

namespace App\Filament\Widgets;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Buku', Buku::count())
                ->icon('heroicon-o-book-open')
                ->color('primary'),
            Stat::make('Total Siswa', Siswa::where('status', 'aktif')->count())
                ->icon('heroicon-o-academic-cap')
                ->color('success'),
            Stat::make('Total Pinjaman', Peminjaman::where('status', 'dipinjam')->count())
                ->icon('heroicon-o-arrow-right-circle')
                ->color('warning'),
        ];
    }
}
