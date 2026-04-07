<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-6">
        <x-filament::card>
            <div class="flex items-center gap-4">
                <div class="p-3 bg-warning-100 rounded-lg">
                    <x-heroicon-o-arrow-right-circle class="w-8 h-8 text-warning-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">TOTAL PINJAMAN</p>
                    <p class="text-3xl font-bold">{{ \App\Models\Peminjaman::count() }}</p>
                </div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="flex items-center gap-4">
                <div class="p-3 bg-danger-100 rounded-lg">
                    <x-heroicon-o-exclamation-circle class="w-8 h-8 text-danger-600" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">TOTAL TERLAMBAT</p>
                    <p class="text-3xl font-bold">{{ \App\Models\Peminjaman::where('status', 'terlambat')->count() }}</p>
                </div>
            </div>
        </x-filament::card>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
