<x-filament-panels::page>
    <form wire:submit="simpan">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit" size="lg">
                Simpan Pengembalian
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
